<?php

date_default_timezone_set('America/Santiago');

require 'db.php';

require_once 'tokenColmena.php';



include_once 'informes/informe_entrevista/funciones.php';

require 'informes/funciones.php';

include_once('informes/fpdf/fpdf.php');

include_once('informes/html2pdf/html2pdf.class.php');



try {

    //$filepdfInasistencia  = funcionInformeInasistencia($idHora=173588);

    //die(var_dump($filepdfInasistencia));

                

        $ok = $sin = $fin = $sinP = $sinPIna = '';

        $date = date('Y-m-d H:i:s',strtotime ( '+1 day' ));

        $sqlInfo = "SELECT id,numerolicencia,ciudad,prestador,hora,numeroLicenciaCheck FROM horas WHERE isapre = 4 AND usuario != 282 AND ciudad != 73 AND ciudad != 71 AND ciudad != 69 AND ciudad != 66 AND ciudad != 65 AND ciudad != 64 AND ciudad != 62 AND ciudad != 57 AND ciudad != 53 AND ciudad != 48 AND ciudad != 66 AND urlEstadoEnvioColmena = 0 AND hora >= '2018-01-01 08:00:00' AND hora <= '$date' ";

        $db = getConnection();

        $stmt = $db->prepare($sqlInfo) ;

        $stmt->execute();

        $informes = $stmt->fetchAll(PDO::FETCH_OBJ);



        

try {

    date_default_timezone_set('America/Santiago');

    foreach ($informes as $list){

            $info['hora'] = $list;

            $infos[] = $info;

        }

    $info = json_encode($infos);

    $date = date('Y-m-d H:i:s');

$s = "INSERT INTO cetepcl_agenda.logColmena (logQuery,logUsuario,logDate,logProceso)

        VALUES ('$info',161,'$date','Cron Entrada')";

        $stmt = $db->prepare($s);

        $stmt->execute();

} catch(PDOException $e) {}









        IF(!empty($informes)){
$hoy = date('Y-m-d H:i:s');
            //echo var_dump($informes);
$informesEnviados = '';
            foreach ($informes as $info){



                $idHora           = $info->id;

                //$licencia         = $info->numerolicencia;

                $licencia         = $info->numeroLicenciaCheck;
		IF(empty($licencia) || $licencia === 0){$licencia = $info->numerolicencia;}
//echo $licencia;

                $hora             = $info->hora;

                $ciudad           = $info->ciudad;

                $prestador        = $info->prestador;



            ////CONSULTA SI TIENE INFORME PUBLICADO

                    $sql = "SELECT i.id,i.publicado,i.hora,i.fecha,p.nombres nomPac,p.apellidoPaterno apePac,e.nombres nomMedico,e.apellidoPaterno apeMedico FROM informe_entrevista i JOIN pacientes p ON (i.paciente=p.id) JOIN prestadores e ON (i.prestador=e.id) WHERE hora = $idHora";

                    $db = getConnection();

                    $stmt = $db->prepare($sql);

                    $stmt->execute();

                    $check = $stmt->fetchAll(PDO::FETCH_OBJ);

                    //$check='';

                    IF(!empty($check)){

                        $fechaPublicacion = date('Y-m-d',strtotime ( '-4 day' ));

                        IF($check[0]->publicado === 'SI'){

                            $sql1 = "SELECT id FROM horas_prestadores WHERE ciudad=$ciudad AND prestador=$prestador AND hora = '$hora'";

                            $stmt = $db->prepare($sql1);

                            $stmt->execute();

                            $hora = $stmt->fetchAll(PDO::FETCH_OBJ);

                            $idHoraColmena = $hora[0]->id;



                            $filepdfEntrevista  = crearInformeNuevoEntrevista($idHora, $tipoSalida='F', $carpetaSalida='');

                            //$filepdfTrauma      = crearInformeNuevoTrauma($idHora, $tipoSalida='F', $carpetaSalida='');

                            $filepdf            = $filepdfEntrevista;



                                    //$urlExpediente = "https://www.colmena.cl/Peritaje/PeritajeAlfrescoServlet?idExpediente=575&tipoDocumento=99&idDocumento=21391";

                                    $url    = "https://www.colmena.cl/wsAgendaColmenaRest/SHA_256/RecepcionInforme";



                                    $data='';

                                    $data = array(

                                        "iorIdn"=> 3,

                                        "horExtId"=> $idHoraColmena,

                                        "lccIdn"=> $licencia,

                                        "expUrl"=> $filepdf,

                                        "token"=> $result,

                                        );



                                    $json = json_encode($data);

                                    $json = 'data='.$json;

                                    $json = str_replace("\\", "", $json);

//echo $json;

                                   // echo $json;

                                    $context_options = array (

                                                'http' => array (

                                                'method' => 'POST',

                                                'header'=> "Content-type: application/x-www-form-urlencoded\r\n"

                                                    . "Content-Length: " . strlen($json) . "\r\n",

                                                'content' => $json

                                                )

                                            );

                                    $context  = stream_context_create($context_options);
//die($context);
                                    //$result = file_get_contents($urlExpediente, true, $context);

                                    $respuesta = @file_get_contents($url, true, $context);
//echo $respuesta;die;
                                    $context_options = '';

                                        IF($respuesta === '{"status":true,"glosa":"OK"}'){

                                                $hoy = date('Y-m-d H:i:s');



                                                $sql11 = "UPDATE horas SET urlEstadoEnvioColmena=1,urlFechaEnvioColmena='$hoy' WHERE id=$idHora";

                                                $stmt = $db->prepare($sql11);

                                                $stmt->execute();



                                                $ok = '{"EnvioPeritaje":"OK"}';
                                                $informesEnviados = $informesEnviados.'{"status":true,"glosa":"OK","horExtId":"'.$idHoraColmena.'","lccIdn":"'.$licencia.'"}<br>';

                                        }ELSE {
                                                $sql11 = "UPDATE horas SET urlEstadoEnvioColmena=2,urlFechaEnvioColmena='$hoy' WHERE id=$idHora";
                                                $stmt = $db->prepare($sql11);
                                                $stmt->execute();
                                                
                                                $ok = '{"EnvioPeritaje":"FALSE"}';
                                                $informesEnviados = $informesEnviados.'{"status":false,"horExtId":"'.$idHoraColmena.'","lccIdn":"'.$licencia.'","respuesta":"'.$respuesta.'","json":"'.$json.'"}<br><br>';
                                                
                                                        
                                        }

                        }
                        ELSEIF($check[0]->fecha <= $fechaPublicacion){
                            
                            $mensaje = 'Estimadas,<br><br>Informe diario de peritajes no publicados con mas de 5 días:<br><br>Ciudad: '.$ciudad.'<br>Prestador: '.strtoupper($check[0]->nomMedico).' '.strtoupper($check[0]->apeMedico).'<br>Paciente: '.strtoupper($check[0]->nomPac).' '.strtoupper($check[0]->apePac).'<br>Hora: '.$hora;
                            $destinatario= 'griedel@cetep.cl';
                            $asunto = 'Informes sin publicar Colmena';
                            $headers = "MIME-Version: 1.0\r\n"; 
                            $headers .= "Content-type: text/html; charset=utf-8\r\n"; 
                            $headers .= "From: Cetep <cetep@cetep.cl>\r\n"; 
                            $headers .= "bcc: griedel@cetep.cl";
                            mail($destinatario,$asunto,$mensaje,$headers) ;
                        }

                        ELSE {$sinP = '{"EnvioPeritaje":"Sin Informes publicados para enviar"}';
                            //$mensaje = 'Estimadas,<br><br>Informe diario de peritajes no publicados con mas de 5 días:<br><br>Fecha: '.$check[0]->fecha.'<br>Fecha Publicación: '.$fechaPublicacion.'<br>Hora: '.$hora;
                            //$destinatario= 'griedel@cetep.cl';
                            //$asunto = 'Fecha';
                            //$headers = "MIME-Version: 1.0\r\n"; 
                            //$headers .= "Content-type: text/html; charset=utf-8\r\n"; 
                            //$headers .= "From: Cetep <cetep@cetep.cl>\r\n"; 
                            //$headers .= "bcc: griedel@cetep.cl";
                            //mail($destinatario,$asunto,$mensaje,$headers) ;die;
                        }

                    }

                    ELSE {$sin = '{"EnvioPeritaje":"Horas Sin Informes Generados"}';}

            ////FIN CONSULTA SI TIENE INFORME PUBLICADO    

                    

                    

            ////CONSULTA INASISTENCIA Y ATRASO       

                    $sql = "SELECT id,hora,asiste FROM horas WHERE id = $idHora";

                    $db = getConnection();

                    $stmt = $db->prepare($sql);

                    $stmt->execute();

                    $checkIna = $stmt->fetchAll(PDO::FETCH_OBJ);

                    

                    IF(!empty($checkIna)){

                        $date = date('Y-m-d H:i:s',strtotime ( '-3 day' ));

		


                        IF($checkIna[0]->asiste === 'no' && $checkIna[0]->hora < $date){

                            $sql1 = "SELECT id FROM horas_prestadores WHERE ciudad=$ciudad AND prestador=$prestador AND hora = '$hora'";

                            $stmt = $db->prepare($sql1);

                            $stmt->execute();

                            $hora = $stmt->fetchAll(PDO::FETCH_OBJ);
if(!empty($hora)){
                            $idHoraColmena = $hora[0]->id;
}

                            //$filepdfEntrevista  = crearInformeNuevoEntrevista($idHora, $tipoSalida='F', $carpetaSalida='');

                            $filepdfInasistencia  = funcionInformeInasistencia($idHora);

                            $filepdf              = $filepdfInasistencia;



                                    //$urlExpediente = "https://www.colmena.cl/Peritaje/PeritajeAlfrescoServlet?idExpediente=575&tipoDocumento=99&idDocumento=21391";

                                    $url    = "https://www.colmena.cl/wsAgendaColmenaRest/SHA_256/RecepcionInforme";



                                    $data='';

                                    $data = array(

                                        "iorIdn"=> 3,

                                        "horExtId"=> $idHoraColmena,

                                        "lccIdn"  => $licencia,

                                        "expUrl"  => $filepdf,

                                        "token"   => $result,

                                        );



                                    $json = json_encode($data);

                                    $json = 'data='.$json;

                                    $json = str_replace("\\", "", $json);



                                   // echo $json;

                                    $context_options = array (

                                                'http' => array (

                                                'method' => 'POST',

                                                'header'=> "Content-type: application/x-www-form-urlencoded\r\n"

                                                    . "Content-Length: " . strlen($json) . "\r\n",

                                                'content' => $json

                                                )

                                            );
//die('aca');
                                    $context  = stream_context_create($context_options);
//die($context);
                                    $respuesta = @file_get_contents($url, true, $context);

                                    $context_options = '';
//echo $respuesta;die;

                                        IF($respuesta === '{"status":true,"glosa":"OK"}'){

                                                $hoy = date('Y-m-d H:i:s');



                                                $sql11 = "UPDATE horas SET urlEstadoEnvioColmena=1,urlFechaEnvioColmena='$hoy' WHERE id=$idHora";

                                                $stmt = $db->prepare($sql11);

                                                $stmt->execute();



                                                $ok = '{"EnvioPeritaje":"OK"}';
                                                $informesEnviados = $informesEnviados.'{"status":true,"glosa":"OK","horExtId":"'.$idHoraColmena.'","lccIdn":"'.$licencia.'"}<br>';

                                        }ELSE {
                                                $sql11 = "UPDATE horas SET urlEstadoEnvioColmena=2,urlFechaEnvioColmena='$hoy' WHERE id=$idHora";
                                                $stmt = $db->prepare($sql11);
                                                $stmt->execute();
                                                
                                                $ok = '{"EnvioPeritaje":"FALSE"}';
                                                $informesEnviados = $informesEnviados.'{"status":false,"horExtId":"'.$idHoraColmena.'","lccIdn":"'.$licencia.'","respuesta":"'.$respuesta.'","json":"'.$json.'"}<br><br>';
                                                
                                                        
                                            
                                        }

                        }

                        //////

                        //////

                        //////

                        ////// ENVIO INFORME DE ATRASO

                        ELSEIF($checkIna[0]->asiste === 'atrasado' && $checkIna[0]->hora < $date){

                            

                            $sql1 = "SELECT id FROM horas_prestadores WHERE ciudad=$ciudad AND prestador=$prestador AND hora = '$hora'";

                            $stmt = $db->prepare($sql1);

                            $stmt->execute();

                            $hora = $stmt->fetchAll(PDO::FETCH_OBJ);
if(!empty($hora)){
                            $idHoraColmena = $hora[0]->id;
}

                            //$filepdfEntrevista  = crearInformeNuevoEntrevista($idHora, $tipoSalida='F', $carpetaSalida='');

                            $filepdfAtraso  = funcionInformeAtraso($idHora);

                            $filepdf        = $filepdfAtraso;



                                    //$urlExpediente = "https://www.colmena.cl/Peritaje/PeritajeAlfrescoServlet?idExpediente=575&tipoDocumento=99&idDocumento=21391";

                                    $url    = "https://www.colmena.cl/wsAgendaColmenaRest/SHA_256/RecepcionInforme";



                                    $data='';

                                    $data = array(

                                        "iorIdn"=> 3,

                                        "horExtId"=> $idHoraColmena,

                                        "lccIdn"  => $licencia,

                                        "expUrl"  => $filepdf,

                                        "token"   => $result,

                                        );



                                    $json = json_encode($data);

                                    $json = 'data='.$json;

                                    $json = str_replace("\\", "", $json);



                                    //echo $json;die;

                                    $context_options = array (

                                                'http' => array (

                                                'method' => 'POST',

                                                'header'=> "Content-type: application/x-www-form-urlencoded\r\n"

                                                    . "Content-Length: " . strlen($json) . "\r\n",

                                                'content' => $json

                                                )

                                            );

                                    $context  = stream_context_create($context_options);

                                    $respuesta = @file_get_contents($url, true, $context);

                                    $context_options = '';

                                        IF($respuesta === '{"status":true,"glosa":"OK"}'){

                                                $hoy = date('Y-m-d H:i:s');



                                                $sql11 = "UPDATE horas SET urlEstadoEnvioColmena=1,urlFechaEnvioColmena='$hoy' WHERE id=$idHora";

                                                $stmt = $db->prepare($sql11);

                                                $stmt->execute();



                                                $ok = '{"EnvioPeritaje":"OK"}';
                                               $informesEnviados = $informesEnviados.'{"status":true,"glosa":"OK","horExtId":"'.$idHoraColmena.'","lccIdn":"'.$licencia.'"}<br>';


                                        }ELSE {
                                            $sql11 = "UPDATE horas SET urlEstadoEnvioColmena=2,urlFechaEnvioColmena='$hoy' WHERE id=$idHora";
                                                $stmt = $db->prepare($sql11);
                                                $stmt->execute();
                                                
                                                $ok = '{"EnvioPeritaje":"FALSE"}';
                                                $informesEnviados = $informesEnviados.'{"status":false,"horExtId":"'.$idHoraColmena.'","lccIdn":"'.$licencia.'","respuesta":"'.$respuesta.'","json":"'.$json.'"}<br><br>';

                                                
                                                        
                                            
                                        }

                        }

                        ELSE {$sinPIna = '{"EnvioPeritaje":"Sin Informes de INASISTENCIA para enviar"}';}

                    }

            ////FIN CONSULTA INASISTENCIA        

          

            } 
                        // die($mensaje);
                        IF(!empty($informesEnviados)){
                        $informesEnviados = $informesEnviados.'<br><br>Atentamente<br><br>&nbsp;&nbsp;<img style="width: 20%;" src="www.cetep.cl/ws/logo_cetep.png"><b>&nbsp;&nbsp;Cetep';
                        $mensaje = 'Estimados,<br><br>Informe diario de peritajes enviados:<br><br>'.$informesEnviados;
                        $destinatario= 'dperez@colmena.cl,jochoa@colmena.cl';
                        // $destinatario= 'gerardo.riedel.c@gmail.com';
                        $asunto = 'Informe de Peritajes Enviados';
                        $headers = "MIME-Version: 1.0\r\n"; 
                        $headers .= "Content-type: text/html; charset=utf-8\r\n"; 
                        $headers .= "From: Cetep <cetep@cetep.cl>\r\n"; //dirección del remitente 
			//$headers .= "cc: griedel@cetep.cl\r\n";

                        $headers .= "bcc: dti@cetep.cl";
                        //die($mensaje);
                       mail($destinatario,$asunto,$mensaje,$headers) ;
                        }
}  ELSE {

                        $fin = '{"EnvioPeritaje": "Error, Sin Horas con peritajes pendientes para consultar"}';
                        $asunto = 'Informe de Peritajes Enviados';
                        $headers = "MIME-Version: 1.0\r\n"; 
                        $headers .= "Content-type: text/html; charset=utf-8\r\n"; 
                        $headers .= "From: Cetep <cetep@cetep.cl>\r\n"; //dirección del remitente 
                        //$headers .= "cc: griedel@cetep.cl\r\n";

                        $headers .= "bcc: griedel@cetep.cl";
                        $mensaje=$fin;
                        mail('gerardo.riedel.c@gmail.com',$asunto,$mensaje,$headers) ;

};



        IF($fin !== '')echo $fin;

        ELSEIF($ok !== '')echo $ok;

        ELSEIF($sinPIna !== '')echo $sinPIna;

        ELSEIF($sinP !== '')echo $sinP;

        ELSE echo $sin;

        

        try {

            date_default_timezone_set('America/Santiago');

            $info = $fin.$ok.$sinPIna.$sinP.$sin;

            $date = date('Y-m-d H:i:s');

        $s = "INSERT INTO cetepcl_agenda.logColmena (logQuery,logUsuario,logDate,logProceso)

                VALUES ('$info',161,'$date','Cron Salida')";

                $stmt = $db->prepare($s);

                $stmt->execute();

        } catch(PDOException $e) {}





} catch(PDOException $e) {

    echo '{"error":{"text":'. $e->getMessage() .'}}';

}

?>

