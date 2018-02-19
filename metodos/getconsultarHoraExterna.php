<?php
require 'clientPrueba.php';
require 'db.php';
$db = getConnection();
try {
    date_default_timezone_set('America/Santiago');
    $date = date('Y-m-d H:i:s');
$s = "INSERT INTO cetepcl_agenda.logColmena (logQuery,logUsuario,logDate,logProceso)
        VALUES ('{Comuna:$comuna,Fecha Termino:$fecha,Fuera de Plazo:$expFueraLic}',161,'$date','Query Consulta de Horas')";
        $stmt = $db->prepare($s);
        $stmt->execute();
} catch(PDOException $e) {}

session_start();
IF ($_SESSION['estado'] != 1){
    echo '{"sincronizarHoraExterna": ' . json_encode(array('error'=>400)) . '}';
    die();
}

IF (!empty($fecha) ){
    //$fecha = str_replace('-','',$fecha);

    IF(!empty($expFueraLic)){
       
    
        IF($expFueraLic=='1'){
            $fecha = '';
        }
        ELSE {
            $fecha = "AND DATE(`horas_prestadores`.`hora`) <= DATE ($fecha)";
        }
    }
    ELSE {
        $fecha = "AND DATE(`horas_prestadores`.`hora`) <= DATE ($fecha)";
    }
}
ELSE {$fecha = '';}



$comuna = "select codCiudad FROM  cetepcl_agenda.`comunaine` WHERE codcomuna=$comuna";
        $stmt = $db->prepare($comuna) ;
        $stmt->execute();
        $comuna = $stmt->fetchAll(PDO::FETCH_OBJ);
        
        IF(empty($comuna)){
            //CIUDAD NO EXISTE
            echo '{"consultarHora": ' . json_encode(array('error' => 'Codigo INE invalido')) . '}';
            die;
        }
        //die($comuna[0]->codCiudad);
        $com = $comuna[0]->codCiudad;
        //die($com);
        $ciudad = "select id FROM cetepcl_agenda.`ciudades` WHERE regionIne=$com";
        $stmt = $db->prepare($ciudad) ;
        $stmt->execute();
        $ciudad = $stmt->fetchAll(PDO::FETCH_OBJ);
        
        IF(empty($ciudad[0]->id)){
            //CIUDAD NO EXISTE
            echo '{"consultarHora": ' . json_encode(array('error' => 200)) . '}';
            die;
        }
        //die(var_dump($ciudad));
        $sinHoras = 0;
        $uno = 0;
        FOREACH ($ciudad as $ci[0]):
            IF($uno === 1){$ciudad = $ciudad.' OR `horas_prestadores`.ciudad = '.$ci[0]->id;}
            ELSE {$ciudad = $ci[0]->id;}
                        $uno =1;
         ENDFOREACH;
                        //$dia = date('d');
                        //$dia = $dia+5; 
                        //$hoy =date('Y-m-d H:i:s');
                        $hoy = strtotime('+2 day',strtotime(date('Y-m-d H:i:s')));
                        $hoy = date('Y-m-d H:i:s',$hoy);
                     
                        //die($ciudad);
                        $sql ="SELECT 3 AS iorIdn
                            ,`horas_prestadores`.`id` AS horExtId
                            ,`horas_prestadores`.`hora` AS horFecha
                            ,`f_dirPeritaje`(`horas_prestadores`.`ciudad`) AS direccion
                            ,comunaINE AS comuna
                            ,`f_perito`( `prestadores`.`id` ,0) AS horRutMedico
                            ,`f_perito`( `prestadores`.`id` ,7) AS horNomMedico
                            ,IF ( `prestadores`.`especialidad` = 1 ,'Psiquiatria','Traumatologia' ) AS horEspMedico
                        FROM cetepcl_agenda.`horas_prestadores`
                        INNER JOIN cetepcl_agenda.`prestadores` ON (`prestadores`.`id` = `horas_prestadores`.`prestador`)
                        INNER JOIN cetepcl_agenda.`ciudades` ON (`ciudades`.`id` = `horas_prestadores`.`ciudad`)
                        WHERE ((`horas_prestadores`.ciudad = $ciudad) AND DATE(`horas_prestadores`.hora) >= DATE('$hoy') AND (`f_horatomada2`(horas_prestadores.hora,horas_prestadores.prestador,horas_prestadores.ciudad) = 0) AND `prestadores`.`especialidad` = 1 $fecha)
                        ORDER BY `horas_prestadores`.hora ASC";

//INNER JOIN cetepcl_agenda.`ciudades2` ON (`ciudades2`.`id` = `horas_prestadores`.`ciudad`)
//LEFT JOIN cetepcl_agenda.`isapres_hora` ON (`horas_prestadores`.`id` = `isapres_hora`.`hora`)
//AND (isapres_hora.isapre = 4 OR (isapres_hora.isapre is null)) 
                        
		try {
			$db = getConnection();
                        
			$stmt = $db->prepare($sql) ;
			$stmt->execute();
			$lista = $stmt->fetchAll(PDO::FETCH_OBJ);
                      //echo $ciudad;
                      //echo var_dump($lista);
                      //echo 'OTRRAAAAAAAAAAAAAA';
                        IF(empty($lista)){
                            $sinHoras = 1;
                        }
                        ELSE{
                            $horas[] = array('status'=>true);
                                foreach ($lista as $list){
                                    $IdDeHora = $list->horExtId;
//echo ($IdDeHora);
                                    $sq = "SELECT * FROM cetepcl_agenda.`isapres_hora` WHERE isapres_hora.hora = $IdDeHora";
//$sq = "SELECT * FROM cetepcl_agenda.`isapres_hora` WHERE isapres_hora.hora =262919";
                                    $stmt = $db->prepare($sq) ;
                                    $stmt->execute();
                                    $listaDeHora = $stmt->fetchAll(PDO::FETCH_OBJ);
//die($listaDeHora[0]->isapre);
                                    //echo $listaDeHora[0]->isapre;
                                    IF($listaDeHora[0]->isapre === '4' || empty($listaDeHora[0]->isapre))
                                        {
                                            $hora['hora'] = $list;
                                            $horas[] = $hora;
                                        }
                                        //echo var_dump($horas);
                                    //$hora['hora'] = $list;
                                    //$horas[] = $hora;
                                }
                                IF(!empty($horas)){
                                    $sinHoras += 1;
                                    $hr = json_encode($horas);
                                    echo json_encode($horas) ;
                                        try {
                                                date_default_timezone_set('America/Santiago');
                                                $date = date('Y-m-d H:i:s');
                                                $s = "INSERT INTO cetepcl_agenda.logColmena (logQuery,logUsuario,logDate,logProceso)
                                                    VALUES ('$hr',161,'$date','Respuesta Consulta de Horas')";
                                                    $stmt = $db->prepare($s);
                                                    $stmt->execute();
                                            } catch(PDOException $e) {}
                                    die;
                                }
			
                        }
		} catch(PDOException $e) {
			echo '{"error":{"text":'. $e->getMessage() .'}}';
		}
                
       
        
        IF($sinHoras <= 1){
            $horas[] = array('status'=>true);
$hr = json_encode($horas);
            echo json_encode($horas) ;
            try {
                date_default_timezone_set('America/Santiago');
                $date = date('Y-m-d H:i:s');
                $s = "INSERT INTO cetepcl_agenda.logColmena (logQuery,logUsuario,logDate,logProceso)
                    VALUES ('$hr',161,'$date','Respuesta Consulta de Horas')";
                    $stmt = $db->prepare($s);
                    $stmt->execute();
            } catch(PDOException $e) {}
        }
        //ERROR NO EXISTEN HORAS
        //echo '{"sincronizarHoraExterna": ' . json_encode(array('error' => 202)) . '}';
?>