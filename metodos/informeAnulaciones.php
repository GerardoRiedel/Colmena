<?php 


require 'db.php'; 
$db = getConnection();


date_default_timezone_set('America/Santiago');
$date = date('Y-m-d H:i:s');
//$date = date('Y-m-d 23:00:00',strtotime('-5 day'));
$dateF = date('Y-m-d 23:00:00',strtotime('+5 day'));

                    
                    
$sql = "SELECT p.id,p.hora,p.ciudad,p.prestador,c.ciudad as nomCiudad FROM cetepcl_agenda.horas_prestadores p JOIN cetepcl_agenda.ciudades c ON (c.id=p.ciudad) WHERE p.hora>='$date' and p.hora <='$dateF'  " ;
$stmt = $db->prepare($sql);
$stmt->execute();
$lista = $stmt->fetchAll(PDO::FETCH_OBJ);
$correo = $enviar = '';
//die(var_dump($lista));
      
FOREACH($lista as $lis)  {
    $horaPrestador = $lis->id;
    $prestador = $lis->prestador;
    $ciudad = $lis->ciudad;
    $nomCiudad = $lis->nomCiudad;
    $hora = $lis->hora;
    
    $sql = "SELECT id FROM cetepcl_agenda.horas WHERE hora='$hora' AND prestador = $prestador AND ciudad = $ciudad AND paciente != 'null'  " ;
    $stmt = $db->prepare($sql);
    $stmt->execute();
    $check = $stmt->fetchAll(PDO::FETCH_OBJ);
    
    IF(empty($check[0]->id)){
        $sql = "SELECT id,isapre FROM cetepcl_agenda.isapres_hora WHERE hora=$horaPrestador" ;
        $stmt = $db->prepare($sql);
        $stmt->execute();
        $dentro = $stmt->fetchAll(PDO::FETCH_OBJ);
        
        FOREACH($dentro as $den){
            $reservaColmena = $reservaIsa = 'no';
            IF($den->isapre === '4'){
                $reservaColmena = 'si';
            }ELSE {
                $reservaIsa = 'si';
            }
    
            IF($reservaIsa==='no' && $reservaColmena==='si'){
                $correo = $correo.'<br>Ciudad: '.$nomCiudad.'<br>Hora: '.$hora.'<br>';
                $enviar = 'si';
            }
        }
    }
}      

IF($enviar === 'si'){
    $mensaje = "Estimados,<br><br>Junto con saludar, se les recuerda que cuentan con las siguientes horas reservadas sin agendar.<br><br>".$correo." <br><br>Cetep";
    
    //$destinatario = "gerardo.riedel.c@gmail.com";
    $destinatario = "pbarrales@colmena.cl,kbarahona@colmena.cl";
    $asunto = 'Horas reservadas sin agendar';
    $headers = "MIME-Version: 1.0\r\n"; 
    $headers .= "Content-type: text/html; charset=utf-8\r\n"; 
    $headers .= "From: Cetep <cetep@cetep.cl>\r\n"; //dirección del remitente 
    $headers .= "cc: dtoro@cetep.cl\r\n";
    $headers .= "bcc: griedel@cetep.cl";
    mail($destinatario,$asunto,$mensaje,$headers) ;
    $mj='envio de horas sin agendar exitoso';
}else $mj='sin horas sin agendar para enviar';
        


 
////////ENVIA INFORME MENSUAL DE HORAS RESERVADAS SIN AGENDAR///////////
IF(date('d')==='1' && date('H')<'9'){
    $primerDia = date('Y-m-d 00:00:00', strtotime('first day of -1 month'));
    $ultimoDia = date('Y-m-d 00:00:00', strtotime('last day of -1 month'));
    $mes = date('F', strtotime('-1 month'));
    
$sql = "SELECT p.id,p.hora,p.ciudad,p.prestador,c.ciudad as nomCiudad FROM cetepcl_agenda.horas_prestadores p JOIN cetepcl_agenda.ciudades c ON (c.id=p.ciudad) WHERE p.hora>='$primerDia' and p.hora <='$ultimoDia'" ;
$stmt = $db->prepare($sql);
$stmt->execute();
$lista = $stmt->fetchAll(PDO::FETCH_OBJ);
$correo2 = '';
//die(var_dump($lista));
      
FOREACH($lista as $lis)  {
    $horaPrestador = $lis->id;
    $prestador = $lis->prestador;
    $ciudad = $lis->ciudad;
    $nomCiudad = $lis->nomCiudad;
    $hora = $lis->hora;
    
    $sql = "SELECT id FROM cetepcl_agenda.horas WHERE hora='$hora' AND prestador = $prestador AND ciudad = $ciudad AND paciente != 'null'  " ;
    $stmt = $db->prepare($sql);
    $stmt->execute();
    $check = $stmt->fetchAll(PDO::FETCH_OBJ);
    
    IF(empty($check[0]->id)){
        $sql = "SELECT id,isapre FROM cetepcl_agenda.isapres_hora WHERE hora=$horaPrestador" ;
        $stmt = $db->prepare($sql);
        $stmt->execute();
        $dentro = $stmt->fetchAll(PDO::FETCH_OBJ);
        
        FOREACH($dentro as $den){
            $reservaColmena2 = $reservaIsa2 = 'no';
            IF($den->isapre === '4'){
                $reservaColmena2 = 'si';
            }ELSE {
                $reservaIsa2 = 'si';
            }
    
            IF($reservaIsa2==='no' && $reservaColmena2==='si'){
                $correo2 = $correo2.'<br>Ciudad: '.$nomCiudad.'<br>Hora: '.$hora.'<br>';
            }
        }
    }
}      
    IF(empty($correo2))$correo2='Sin datos para enviar';
    $mensaje = "Estimadas,<br><br>Junto con saludar, <br>Adjunto listado de horas reservadas sin agendar de Colmena durante el mes de ".$mes.".<br><br>".$correo2." <br><br>Cetep";
    
    //$destinatario = "gerardo.riedel.c@gmail.com";
    $destinatario = "dtoro@cetep.cl,mgalvez@cetep.cl";
    $asunto = 'Horas reservadas sin agendar';
    $headers = "MIME-Version: 1.0\r\n"; 
    $headers .= "Content-type: text/html; charset=utf-8\r\n"; 
    $headers .= "From: Cetep <cetep@cetep.cl>\r\n"; //dirección del remitente 
    $headers .= "bcc: griedel@cetep.cl";
    mail($destinatario,$asunto,$mensaje,$headers) ;




}
   
return $mj;
die;
        
        
        
        
        
        
        function getDiasHabiles($fechainicio, $fechafin, $diasferiados = array()) {
	// Convirtiendo en timestamp las fechas
        //die($fechafin.'fin');
      //      
	$fechainicio = strtotime($fechainicio);
                   $fechac= explode(' ', $fechafin);//die($fechafin[0].'fin');
	$fechafin = strtotime($fechac[0]);
	//die('inicio'.$fechainicio.'    fin'.$fechafin);
	// Incremento en 1 dia
	$diainc = 24*60*60;
	$diasferiados = array(
       //FORMATO Y-m-d   
        '1-1', // Año Nuevo (irrenunciable) 
        '30-3', // Viernes Santo (feriado religioso) 
        '31-3', // Sábado Santo (feriado religioso) 
        '1-5', // Día Nacional del Trabajo (irrenunciable) 
        '21-5', // Día de las Glorias Navales 
        '2-7', // San Pedro y San Pablo (feriado religioso) 
        '16-7', // Virgen del Carmen (feriado religioso) 
        '15-8', // Asunción de la Virgen (feriado religioso) 
        '17-9', // Dia Festivo De Prueba EN EL EJEMPLO <-----
        '18-9', // Dia Festivo De Prueba EN EL EJEMPLO <-----
        '19-9', // Dia Festivo De Prueba EN EL EJEMPLO <-----
        '15-10', // Aniversario del Descubrimiento de América 
        '2-11', // Día Nacional de las Iglesias Evangélicas y Protestantes (feriado religioso) 
        '1-11', // Día de Todos los Santos (feriado religioso) 
        '8-12', // Inmaculada Concepción de la Virgen (feriado religioso) 
       // '13-12', // elecciones presidencial y parlamentarias (puede que se traslade al domingo 13) 
        '25-12', // Natividad del Señor (feriado religioso) (irrenunciable) 
        );
	// Arreglo de dias habiles, inicianlizacion
	$diashabiles = array();
	$sumatoria=0;
	// Se recorre desde la fecha de inicio a la fecha fin, incrementando en 1 dia
	for ($midia = $fechainicio; $midia <= $fechafin; $midia += $diainc) {
		// Si el dia indicado, no es sabado o domingo es habil
		if (!in_array(date('N', $midia), array(5,6,7))) { 
			// Si no es un dia feriado entonces es habil
			if (!in_array(date('Y-m-d', $midia), $diasferiados)) {
                                //EL ARRAY MUESTRA EL DÍA
				array_push($diashabiles, date('Y-m-d', $midia));
                                $sumatoria += 1;
			}
		}
	}//die($sumatoria.'s');
	return $sumatoria;
    }
           
?>