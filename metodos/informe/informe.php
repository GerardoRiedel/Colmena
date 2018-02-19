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

        $sqlInfo = "SELECT id,numerolicencia,ciudad,prestador,hora FROM horas WHERE isapre = 4 AND urlEstadoEnvioColmena = 99 AND hora >= '2017-01-01 08:00:00' AND hora <= '$date' ";

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









        IF(!empty($informes)):

            echo var_dump($informes);

            foreach ($informes as $info){



                $idHora           = $info->id;

                $licencia         = $info->numerolicencia;

                $hora             = $info->hora;

                $ciudad           = $info->ciudad;

                $prestador        = $info->prestador;



            ////CONSULTA SI TIENE INFORME PUBLICADO

                    $sql = "SELECT id,publicado,hora FROM informe_entrevista WHERE hora = $idHora";

                    $db = getConnection();

                    $stmt = $db->prepare($sql);

                    $stmt->execute();

                    $check = $stmt->fetchAll(PDO::FETCH_OBJ);

                    //$check='';

                    IF(!empty($check)){



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



                                    //echo $json;die;

                                //    $context_options = array (

                                //                'http' => array (

                                //                'method' => 'POST',

                                //                'header'=> "Content-type: application/x-www-form-urlencoded\r\n"

                                //                    . "Content-Length: " . strlen($json) . "\r\n",

                                //                'content' => $json

                                //                )

                                //            );

                                //    $context  = stream_context_create($context_options);

                                //    //$result = file_get_contents($urlExpediente, true, $context);

                                //    $respuesta = file_get_contents($url, true, $context);

                                //    $context_options = '';

                                        IF($respuesta === '{"status":true}'){

                                                $hoy = date('Y-m-d H:i:s');



                                                $sql11 = "UPDATE horas SET urlEstadoEnvioColmena=1,urlFechaEnvioColmena='$hoy' WHERE id=$idHora";

                                                $stmt = $db->prepare($sql11);

                                                $stmt->execute();



                                                $ok = '{"EnvioPeritaje":"OK"}';

                                        }

                                        ELSE {echo 'ERROR..::JSON:'.$json.'...RESPUESTA:'.$respuesta.'::..';$ok = ' ';}

                        }

                        ELSE {$sinP = '{"EnvioPeritaje":"Sin Informes publicados para enviar"}';}

                    }

                    ELSE {$sin = '{"EnvioPeritaje":"Horas Sin Informes Generados"}';}

            ////FIN CONSULTA SI TIENE INFORME PUBLICADO    

                    

                    

            ////CONSULTA INASISTENCIA        

                    $sql = "SELECT id,hora,asiste FROM horas WHERE id = $idHora";

                    $db = getConnection();

                    $stmt = $db->prepare($sql);

                    $stmt->execute();

                    $checkIna = $stmt->fetchAll(PDO::FETCH_OBJ);

                    

                    IF(!empty($checkIna)){

                        $date = date('Y-m-d H:i:s',strtotime ( '-4 day' ));

                        IF($checkIna[0]->asiste === 'no' && $checkIna[0]->hora < $date){

                            

                            $sql1 = "SELECT id FROM horas_prestadores WHERE ciudad=$ciudad AND prestador=$prestador AND hora = '$hora'";

                            $stmt = $db->prepare($sql1);

                            $stmt->execute();

                            $hora = $stmt->fetchAll(PDO::FETCH_OBJ);

                            $idHoraColmena = $hora[0]->id;



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



                                    echo $json;die;

                                    //$context_options = array (

                                    //            'http' => array (

                                    //            'method' => 'POST',

                                    //            'header'=> "Content-type: application/x-www-form-urlencoded\r\n"

                                    //                . "Content-Length: " . strlen($json) . "\r\n",

                                    //            'content' => $json

                                    //            )

                                    //        );

                                    //$context  = stream_context_create($context_options);

                                    //$respuesta = file_get_contents($url, true, $context);

                                    $context_options = '';

                                        IF($respuesta === '{"status":true}'){

                                                $hoy = date('Y-m-d H:i:s');



                                                $sql11 = "UPDATE horas SET urlEstadoEnvioColmena=1,urlFechaEnvioColmena='$hoy' WHERE id=$idHora";

                                                $stmt = $db->prepare($sql11);

                                                $stmt->execute();



                                                $ok = '{"EnvioPeritaje":"OK"}';

                                        }

                                        ELSE {echo 'ERROR..::JSON:'.$json.'...RESPUESTA:'.$respuesta.'::..';$ok = ' ';}

                        }

                        ELSE {$sinPIna = '{"EnvioPeritaje":"Sin Informes de INASISTENCIA para enviar"}';}

                    }

            ////FIN CONSULTA INASISTENCIA        

          

            }

        ELSE:

            $fin = '{"EnvioPeritaje": "Error, Sin Horas con peritajes pendientes para consultar"}';

        ENDIF;



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

