<?php
error_reporting(E_ALL ^ E_NOTICE);


IF ($isapre === 4 || $isapre === '4' || $isapre === 'Colmena')
{  
    $dbhost="www.cetep.cl";
    $dbuser="cetepcl";
    $dbpass="rootsecurity626";
    $dbname="cetepcl_agenda";
    $conectar = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname); 
 
        
        $idHoraNueva = $idHora;
include_once ('../../../ws/colmena/db.php');
include_once ('../../../ws/tokenColmena.php');
 try {
        date_default_timezone_set('America/Santiago');
        $date = date('Y-m-d H:i:s');

        $s = "INSERT INTO cetepcl_agenda.logColmena (logQuery,logUsuario,logDate,logProceso)
            VALUES ('INICIO REAGENDAMIENTO',161,'$date','P')";
            mysqli_query($conectar,$s);

} catch(PDOException $e) {}
          
       
        
    $row='';
    $hoy = strtotime('-10 day',strtotime(date('Y-m-d H:i:s')));
    $hoy = date('Y-m-d H:i:s',$hoy);
    //$hoy = date('Y-m-d 07:00:00');
    
        
    $sql = mysqli_query($conectar,"
	SELECT 
		horas.numerolicencia,horas.id,horas.prestador,horas.ciudad,horas.hora,horas.urlExpedienteColmena,horas.idHoraPrestador,horas.numerolicencia
	FROM 
		cetepcl_agenda.horas
	WHERE 
		(horas.paciente = $idpaciente AND horas.isapre = '4' AND horas.hora >= '$hoy' AND horas.id != $idHoraNueva)
	");
    //////////////DESECHADO PARA PRUEVAS///////////////
    	//$row = mysql_fetch_array($sql);
$row = mysqli_fetch_array($sql);
//$row='';
IF(!empty($row)){
    
        $idHoraPrestador = $row['idHoraPrestador'];
        $urlColmena  = $row['urlExpedienteColmena'];
        $idHoraVieja = $row['idHoraPrestador'];
        $prestador   = $row['prestador'];
        $ciudad      = $row['ciudad'];
        $hora        = $row['hora'];
        $LicenciaVIEJA = $row['numerolicencia'];
        
        $msg = "Entrando sin anular hora .... horas.paciente = ".$idpaciente." horas.id !=".$idHoraNueva;
        $msg = wordwrap($msg,70);
        mail("griedel@cetep.cl","REAGENDAMIENTO-ANULACION CETEP CON HORAS",$msg);
}ELSEIF(empty($row)){
        //$manana = date('Y-m-d 23:00:00');
        $sql = mysqli_query($conectar,"
        SELECT 
                idHora id,hora,ciudad,paciente,prestador,licencia,idHoraPrestador,urlColmena
        FROM 
                cetepcl_agenda.horas_eliminadas
        WHERE 
                paciente = $idpaciente AND isapre = '4' AND hora >= '$hoy' 	" );

        $row = mysqli_fetch_array($sql);
        $LicenciaVIEJA = $row['licencia'];
        $idHoraPrestador = $row['idHoraPrestador'];
        $urlColmena = $row['urlColmena'];
        $idHoraVieja = $row['idHoraPrestador'];
        $prestador   = $row['prestador'];
        $ciudad      = $row['ciudad'];
        $hora        = $row['hora'];

}
    
    
    
    
        
IF(!empty($row)){
        
        mysqli_query($conectar,"UPDATE cetepcl_agenda.`horas` SET numerolicencia='$LicenciaVIEJA', urlExpedienteColmena='$urlColmena', numeroLicenciaCheck='$LicenciaVIEJA' WHERE (`horas`.`id` = $idHoraNueva )" );
        
        $sql1 = mysqli_query($conectar,"
            SELECT 
            `f_datospaciente`(`horas`.`paciente`,9) AS pacRut
            ,`horas`.`id`
            ,`horas`.`numerolicencia` AS lccIdn
            ,`f_perito`( `horas`.`prestador` ,10) AS horRutMedico
            ,`f_perito`( `horas`.`prestador` ,7) AS horNomMedico
            ,IF ( `f_perito`( `horas`.`prestador` ,8) = 1 ,'Psiquiatria','Traumatologia' ) AS horEspMedico
            ,ciudades.comunaIne AS comuna
            ,horas.ciudad
            ,horas.prestador
            ,horas.hora
            ,`horas`.`hora` AS horFecha
            ,IF ( `horas`.`confirmada` = 'no',0,1 ) AS horEst	
            ,`f_dirPeritaje`(`horas`.`ciudad`) AS horDireccion
            FROM cetepcl_agenda.`horas`
            LEFT JOIN `pacientes` ON (`horas`.`paciente` = `pacientes`.`id`)
            INNER JOIN cetepcl_agenda.`ciudades` ON (`ciudades`.`id` = `horas`.`ciudad`)
            LEFT JOIN cetepcl_agenda.`comunaine` ON (`horas`.`comunaIne` = `comunaine`.`codcomuna`)
            WHERE (`horas`.`id` = $idHoraNueva )
        ");
           
                        
        $row = mysqli_fetch_array($sql1);
        $largo = $row['pacRut'];
        IF(strlen($largo) ===10)$pacRut='0'.$largo; ELSEIF(strlen($largo) ===9)$pacRut='00'.$largo;ELSE $pacRut=$largo;
                //$pacRut         = '0'.$row['pacRut'];
        $lccIdn         = $LicenciaVIEJA;
        $horRutMedico   = $row['horRutMedico'];
        $horNomMedico   = $row['horNomMedico']; $horNomMedico = str_replace("[\n|\r|\n\r|\t|\0|\x0B]"," ",$horNomMedico);//$horNomMedico='Isabel_Barros';
        $horEspMedico   = $row['horEspMedico'];
        $comuna         = $row['comuna'];
        $horFecha       = $row['horFecha'];
        $horDireccion   = $row['horDireccion'];
        $horEst         = $row['horEst'];
        $ciudadNueva    = $row['ciudad'];
        $prestadorNueva = $row['prestador'];
        $horaNueva      = $row['hora'];
        $idHoraNueva    = $row['id'];
        $horNomMedico = str_replace('í','i',$horNomMedico);$horNomMedico = str_replace('ó','o',$horNomMedico);$horNomMedico = str_replace('ñ','n',$horNomMedico);
        //$horNomMedico = ' '.$horNomMedico;

        $horDireccion = str_replace('Ó','o',$horDireccion);$horDireccion = str_replace('Í','i',$horDireccion);$horDireccion = str_replace('Ñ','n',$horDireccion);
        $horDireccion = str_replace('í','i',$horDireccion);$horDireccion = str_replace('ó','o',$horDireccion);$horDireccion = str_replace('ñ','n',$horDireccion);
        $horDireccion = str_replace("'",'',$horDireccion);$horDireccion = str_replace('é','e',$horDireccion);$horDireccion = str_replace('ú','u',$horDireccion);
                 
                       

        $sqlNueva = mysqli_query($conectar,"SELECT id FROM cetepcl_agenda.horas_prestadores where ciudad=$ciudadNueva AND prestador=$prestadorNueva AND hora = '$horaNueva' ");
        $rowN = mysqli_fetch_array($sqlNueva);
        $HoraNUEVAId         = $rowN['id'];
        IF(empty($HoraNUEVAId)){
            $msg = "ERROR HORANUEVA VACIA!!!!  HORA NUEVA = '$HoraNUEVAId', CIUDAD = '$ciudadNueva', PRESTADOR NUEVO = '$prestadorNueva', hoiraNueva = '$horaNueva'";
            $msg = wordwrap($msg,70);
            mail("griedel@cetep.cl"," ERROR REAGENDAMIENTO CETEP",$msg);
        }
            
        mysqli_query($conectar,"UPDATE cetepcl_agenda.`horas` SET idHoraPrestador='$HoraNUEVAId',reagendadocolmena='1',fechaCambio='$hoy', usuarioCambio=$usuario WHERE (`horas`.`id` = $idHoraNueva ) ");

        
        $data = [
            "token"         => $result,
            "pacRut"        => $pacRut,
            "lccIdn"        => $lccIdn,
            "horRutMedico"  => $horRutMedico,
            "horNomMedico"  => $horNomMedico,
            "horEspMedico"  => $horEspMedico,
            "iorIdn"        => 3,
            "comuna"        => $comuna,
            "horFecha"      => $horFecha,
            "horEst"        => $horEst,
            "horDireccion"  => $horDireccion,
            "horExtId"      => $idHoraVieja,
            "horExtIdNueva" => $HoraNUEVAId,
            ];
        //$data = json_encode($data);
        //$json = 'data='.$json;
                IF(empty($data)){
                            $msg = "ERROR DATA EMPTY!!!!  PACIENTE = $idpaciente, HORA VIEJA = $idHoraVieja, CIUDAD = $ciudad, PRESTADOR = $prestador, data = $data";
                            $msg = wordwrap($msg,70);
                            mail("griedel@cetep.cl"," ERROR  REAGENDAMIENTO CETEP",$msg);
                }

                $data_string = json_encode($data); 
                IF(empty($data_string)){
                            //$data = array();
                            $data = array(
                                "token"         => $result,
                                "pacRut"        => $pacRut,
                                "lccIdn"        => $lccIdn,
                                "horRutMedico"  => $horRutMedico,
                                "horNomMedico"  => "$horNomMedico",
                                "horEspMedico"  => $horEspMedico,
                                "iorIdn"        => 3,
                                "comuna"        => $comuna,
                                "horFecha"      => $horFecha,
                                "horEst"        => $horEst,
                                "horDireccion"  => "$horDireccion",
                                "horExtId"      => $idHoraVieja,
                                "horExtIdNueva" => $HoraNUEVAId,
                                );
                            $data_string = json_encode($data); 
                            $data = var_dump($data);
                            $msg = "ERROR DATA EMPTY!!!!  "
                                    . "PACIENTE = $idpaciente, "
                                    . "TOKEN = $result, "
                                    . "PACRUT = $pacRut, "
                                    . "LCCIDN = $lccIdn, "
                                    . "HORRUTMEDICO = $horRutMedico, "
                                    . "HORNOMMEDICO = $horNomMedico, "
                                    . "HORESPMEDICO = $horEspMedico, "
                                    . "IORIDN = 3, "
                                    . "COMUNA = $comuna, "
                                    . "HORFECHA = $horFecha, "
                                    . "HOREST = $horEst, "
                                    . "DIRECCION = $horDireccion, "
                                    . "HOREXTID = $idHoraVieja, "
                                    . "HOREXTIDNUEVA = $HoraNUEVAId, "
                                    . "HORA VIEJA = $idHoraVieja, "
                                    . "CIUDAD = $ciudad, "
                                    . "PRESTADOR = $prestador, "
                                    . "data = $data, "
                                    . "data_string = $data_string";
                            $msg = wordwrap($msg,70);
                            mail("griedel@cetep.cl"," ERROR  REAGENDAMIENTO CETEP",$msg);
                }
                $data_string = 'data='.$data_string;
                
            //echo $data_string;      

            $ch = curl_init('http://190.96.77.22:8180/wsAgendaColmenaRest/SHA_256/ReagendamientoHora');                       
            $ch = curl_init('https://www.colmena.cl/wsAgendaColmenaRest/SHA_256/ReagendamientoHora');    
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");                                                                     
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);                                                                  
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                                                                      
            curl_setopt($ch, CURLOPT_HEADER, false);                                                                                                               

            $result = curl_exec($ch);

            
            IF($result === '{"status":true,"glosa":"Peritaje reagendado correctamente"}' || $result === '{"status":true}' ) {
                date_default_timezone_set('America/Santiago');
                $date = date('Y-m-d H:i:s');
                $logQuery = 'OK'.$data_string;
                
                $msg = "Se ha reagendado la hora; PACIENTE = $idpaciente, HORA VIEJA = $idHoraVieja, CIUDAD = $ciudad, PRESTADOR = $prestador, QUERY = $data_string";
                $msg = wordwrap($msg,70);
                $est = 'OK';
            }ELSE{
                date_default_timezone_set('America/Santiago');
                $date = date('Y-m-d H:i:s');
                $logQuery = 'ERROR '.$data_string;
              //  $s = "INSERT INTO cetepcl_agenda.logColmena (logQuery,logUsuario,logDate,logProceso)
              //      VALUES ('$logQuery ',161,'$date','ReAgendar')";
              //  mysqli_query($conectar,$s);

                $msg = $result. "Se ha reagendado la hora; RESPUESTA====$result, PACIENTE = $idpaciente, HORA VIEJA = $idHoraVieja, CIUDAD = $ciudad, HORA = '$hora', PRESTADOR = $prestador, PACRUT = $pacRut, LCCIDN = $lccIdn, HORRUTMEDICO = $horRutMedico, HORNOMMEDICO = $horNomMedico, HORESPMEDICO = $horEspMedico, IORIDN = 3, COMUNA = $comuna, HORFECHA = $horFecha, HOREST = $horEst, HORDIRECCION = $horDireccion, HOREXTID = $idHoraVieja, HOREXTIDNUEVA = $HoraNUEVAId, DATA = $data, QUERY = $data_string";
                $msg = wordwrap($msg,70);
                $est = 'ERROR';
               // mail("griedel@cetep.cl"," ERROR   REAGENDAMIENTO CETEP",$msg);
            }
            mail("griedel@cetep.cl",$est."   REAGENDAMIENTO CETEP",$msg);
            $s = "INSERT INTO cetepcl_agenda.logColmena (logQuery,logUsuario,logDate,logProceso) VALUES ('$logQuery',161,'$date','ReAgendar')";
            mysqli_query($conectar,$s);
            

}ELSEIF(!empty($idCiudad) ){
    IF($idCiudad ==='73' || $idCiudad==='66' || $usuario='282'){}
    ELSE {
        $msg = "Row vacio - agendamiento con ciudad=".$idCiudad."   USUARIO:".$usuario;
        $msg = wordwrap($msg,70);
        mail("griedel@cetep.cl","REAGENDAMIENTO-ANULACION CETEPPP",$msg);
    }
}ELSE {
    $msg = "Row vacio - Error en reagendamiento";
    $msg = wordwrap($msg,70);
    mail("griedel@cetep.cl","REAGENDAMIENTO-ANULACION CETEP",$msg);
}
mysqli_close($conectar);
}

?>
