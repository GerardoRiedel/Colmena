<?php
$cuerpo = file_get_contents('php://input');
$cuerpo = str_replace("%22", '"',$cuerpo);
$cuerpo = str_replace("%3A", ':',$cuerpo);
$cuerpo = str_replace("%2C", ',',$cuerpo);
$cuerpo = str_replace("%7B", '{',$cuerpo);

$cuerpo = str_replace("%5B", '[',$cuerpo);
$cuerpo = str_replace("%5D", ']',$cuerpo);
$cuerpo = str_replace("%7D", '}',$cuerpo);
$cuerpo = str_replace("%40", '@',$cuerpo);
IF(empty($cuerpo))$cuerpo='vacio - ';
//echo 'Cuerpo: '.$cuerpo.' - ';


$app = new \Slim\Slim();
$application = new \Slim\Slim();

$body = $app->request()->post('data');

//$body = $application->request->getBody();
$body = str_replace("%22", '"',$body);
$body = str_replace("%3A", ':',$body);
$body = str_replace("%2C", ',',$body);
$body = str_replace("%7B", '{',$body);

$body = str_replace("%5B", '[',$body);
$body = str_replace("%5D", ']',$body);
$body = str_replace("%7D", '}',$body);
$body = str_replace("%40", '@',$body);
//$body = str_replace(" ", '',$body);
$json = json_decode($body);


$token = $json->token;
$idHora = $json->horExtId;
$reserva = $json->reserva;
//die($token.'            '.$idHora);
require 'clientPrueba.php';
require 'db.php'; 
$db = getConnection();

try {
    date_default_timezone_set('America/Santiago');
    $date = date('Y-m-d H:i:s');
    $fecha = date('Y-m-d H:i:s');     
 //  $atras6 = strtotime('-6 day',strtotime(date('Y-m-d H:i:s')));
  //  $atras6 = date('Y-m-d H:i:s',$atras6);
$s = "INSERT INTO cetepcl_agenda.logColmena (logQuery,logUsuario,logDate,logProceso)
        VALUES ('$body',161,'$date','Anular')";
        $stmt = $db->prepare($s);
        $stmt->execute();
} catch(PDOException $e) {}

        session_start();
        IF ($_SESSION['estado'] != 1){
            echo '{"anularHora": ' . json_encode(array('error'=>400)) . '}';
            die();
        }

        $sql3 = "SELECT p.hora,p.ciudad,p.prestador,c.ciudad as nomCiudad,d.nombres,d.apellidoPaterno FROM cetepcl_agenda.horas_prestadores p JOIN cetepcl_agenda.ciudades c ON (c.id=p.ciudad)JOIN cetepcl_agenda.prestadores d ON (d.id=p.prestador) WHERE p.id=$idHora  " ;
        $stmt = $db->prepare($sql3);
        $stmt->execute();
        $lista = $stmt->fetchAll(PDO::FETCH_OBJ);
        
        IF(empty($lista)){
            echo '{"anularHora": ' . json_encode(array('status' => 'false - Identificador no valido o fecha vencida')) . '}';
            $s = "INSERT INTO cetepcl_agenda.logColmena (logQuery,logUsuario,logDate,logProceso)
            VALUES ('Anular FALSE',161,'$date','Anular')";
            $stmt = $db->prepare($s);
            $stmt->execute();
            die;
        }
        
        $prestador = $lista[0]->prestador;
        $ciudad = $lista[0]->ciudad;
        $nomCiudad = $lista[0]->nomCiudad;
        $nomPrestador = $lista[0]->nombres.' '.$lista[0]->apellidoPaterno;
        $hora = $lista[0]->hora;
        
        $sql = "SELECT id,paciente,numeroLicenciaCheck,numerolicencia,urlExpedienteColmena FROM cetepcl_agenda.horas WHERE hora='$hora' AND prestador = $prestador AND ciudad = $ciudad AND paciente != 'null' and isapre='4' " ;
        $stmt = $db->prepare($sql);
        $stmt->execute();
        $check = $stmt->fetchAll(PDO::FETCH_OBJ);
        $id = $check[0]->id;
        $paciente = $check[0]->paciente;
        $licenciaCheck = $check[0]->numeroLicenciaCheck;
        $expediente = $check[0]->urlExpedienteColmena;
       
        IF(!empty($check)){
            
                $msg = "Inicio de anulacion desde Colmena";
                $msg = wordwrap($msg,70);
                mail("griedel@cetep.cl","ANULACION DESDE COLMENA",$msg);
                            
            IF(!empty($licenciaCheck))$licencia = $licenciaCheck;
            ELSE  $licencia = $check[0]->numerolicencia;
            //die($hora);
            try {
                    $inicio = strtotime($fecha);
                    $fin = strtotime($hora);
                    $dif = $fin - $inicio;
                    $dif = (( ( $dif / 60 ) / 60 ) / 24);
                    
                    $fechaR     = date('Y-m-d');////ESTA ES LA FECHA DE HOY
                    $fechaE     = $hora;
                    $difDias = getDiasHabiles($fechaR,$fechaE); 
            
            
                    IF($difDias >= 6){
                        $sq = "SELECT * FROM cetepcl_agenda.`isapres_hora` WHERE isapres_hora.hora = $idHora";
                        $stmt = $db->prepare($sq) ;
                        $stmt->execute();
                        $listaDeHora = $stmt->fetchAll(PDO::FETCH_OBJ);
                        //////////////////LIMPIA LA LISTA DE HORAS ASOCIADAS A LA ISAPRE///////////////////////
                        IF(!empty($listaDeHora)){
                            FOREACH($listaDeHora as $li){
                                                $sqlDelete = "DELETE FROM cetepcl_agenda.`isapres_hora` WHERE id=$li->id";
                                                $stmt = $db->prepare($sqlDelete);
                                                $stmt->execute(); 
                            }
                        }
                        

                        $sqlInsert = "INSERT INTO cetepcl_agenda.horas_eliminadas (usuario, fecha, idHora, hora, ciudad, paciente, prestador, licencia, urlColmena, idHoraPrestador, isapre)
                        VALUES ('161', '$fecha', '$id', '$hora','$ciudad', '$paciente', '$prestador', '$licencia', '$expediente', '$idHora', '4')";	
                        $stmt = $db->prepare($sqlInsert);
                        $stmt->execute();        

                        $sqlDelete = "DELETE FROM cetepcl_agenda.horas WHERE id=$id";
                        $stmt = $db->prepare($sqlDelete);
                        $stmt->execute(); 
                        echo '{"anularHora": ' . json_encode(array('status' => true)) . '}';
                                    $s = "INSERT INTO cetepcl_agenda.logColmena (logQuery,logUsuario,logDate,logProceso)
                                    VALUES ('Anular OK',161,'$date','Anular')";
                                    $stmt = $db->prepare($s);
                                    $stmt->execute();
                                    $estado='liberada';
                    } 
                    ELSEIF($difDias <= 5)  { 
                        $sq = "SELECT * FROM cetepcl_agenda.`isapres_hora` WHERE isapres_hora.hora = $idHora";
                        $stmt = $db->prepare($sq) ;
                        $stmt->execute();
                        $listaDeHora = $stmt->fetchAll(PDO::FETCH_OBJ);
                        //////////////////LIMPIA LA LISTA DE HORAS ASOCIADAS A LA ISAPRE///////////////////////
                        IF(!empty($listaDeHora)){
                            FOREACH($listaDeHora as $li){
                                                $sqlDelete = "DELETE FROM cetepcl_agenda.`isapres_hora` WHERE id=$li->id";
                                                $stmt = $db->prepare($sqlDelete);
                                                $stmt->execute(); 
                            }
                        }
                        //////////////////VERIFICA LOS DÍAS///////////////////////
                        /////////////////DEJA HORA RESERVADA PARA COLMENA//////////////////////////
                        $sqlInsertisa = "INSERT INTO cetepcl_agenda.`isapres_hora`  (isapre, hora) VALUES ('4',$idHora)";	
                        $stmt = $db->prepare($sqlInsertisa);
                        $stmt->execute();    
                        

                        $sqlInsert = "INSERT INTO cetepcl_agenda.horas_eliminadas (usuario, fecha, idHora, hora, ciudad, paciente, prestador, licencia, urlColmena, idHoraPrestador, isapre)
                        VALUES ('161', '$fecha', '$id', '$hora','$ciudad', '$paciente', '$prestador', '$licencia', '$expediente', '$idHora', '4')";	
                        $stmt = $db->prepare($sqlInsert);
                        $stmt->execute();        

                        $sqlDelete = "DELETE FROM cetepcl_agenda.horas WHERE id=$id";
                        $stmt = $db->prepare($sqlDelete);
                        $stmt->execute(); 
                                    echo '{"anularHora": ' . json_encode(array('status' => true)) . '}';
                                    $s = "INSERT INTO cetepcl_agenda.logColmena (logQuery,logUsuario,logDate,logProceso)
                                    VALUES ('Anular OK',161,'$date','Anular')";
                                    $stmt = $db->prepare($s);
                                    $stmt->execute();
                                    
                                    $estado='reservada';
                        
                        
                        
                      
                        
                        
                    }ELSE{
                        echo '{"anularHora": ' . json_encode(array('status' => false)) . '}';
                        $s = "INSERT INTO cetepcl_agenda.logColmena (logQuery,logUsuario,logDate,logProceso)
                        VALUES ('Anular mas de 7 días',161,'$date','Anular')";
                        $stmt = $db->prepare($s);
                        $stmt->execute();
                        
                        $estado='sin proceso';
                    }
                    
                    $mensaje = "Se ha anulado un agendamiento desde Colmena, con una diferencia de ".$difDias." días hábiles.<br>Quedando la hora<b>, ".$estado."</b>.<br>ID: ".$id.".<br>HORA: ".$hora.".<br>CIUDAD: ".$nomCiudad.".<br>PRESTADOR: ".$nomPrestador.".<br>PACIENTE: ".$paciente.".<br><br>Cetep";
                    $destinatario = "dtoro@cetep.cl,cgomez@cetep.cl,earanis@cetep.cl";
                    $asunto = 'ANULACION DESDE COLMENA';
                    $headers = "MIME-Version: 1.0\r\n"; 
                    $headers .= "Content-type: text/html; charset=utf-8\r\n"; 
                    $headers .= "From: Cetep <cetep@cetep.cl>\r\n"; //dirección del remitente 

                    $headers .= "bcc: griedel@cetep.cl";
                    mail($destinatario,$asunto,$mensaje,$headers) ;
                    
                }
                catch(PDOException $e) 
                {
                    echo '{"error":{"text":'. $e->getMessage() .'}}';
                }
        }
        ELSE { 
            echo '{"anularHora": ' . json_encode(array('status' => false)) . '}';
            $s = "INSERT INTO cetepcl_agenda.logColmena (logQuery,logUsuario,logDate,logProceso)
            VALUES ('Anular FALSE',161,'$date','Anular')";
            $stmt = $db->prepare($s);
            $stmt->execute();
        }
        
        
        
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