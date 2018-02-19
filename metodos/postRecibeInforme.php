<?php
date_default_timezone_set('America/Santiago');
require 'db.php';
require_once 'tokenColmena.php';

include 'informes/informe_entrevista/funciones.php';
require 'informes/funciones.php';
include_once('informes/fpdf/fpdf.php');

try {
        $ok = $sin = $fin = $sinP = '';
        $sqlInfo = "SELECT id,numerolicencia,urlExpedienteColmena,ciudad,prestador,hora FROM horas WHERE isapre = 4 AND urlEstadoEnvioColmena = 0 AND hora >= '2016-12-28 08:00:00'";
        $db = getConnection();
        $stmt = $db->prepare($sqlInfo) ;
        $stmt->execute();
        $informes = $stmt->fetchAll(PDO::FETCH_OBJ);
        IF(!empty($informes)):

            foreach ($informes as $info){

                $idHora           = $info->id;
                $licencia         = $info->numerolicencia;
                //$urlExpediente    = $info->urlExpedienteColmena;
                $hora             = $info->hora;
                $ciudad           = $info->ciudad;
                $prestador        = $info->prestador;

                    $sql = "SELECT id,publicado FROM informe_entrevista WHERE hora = $idHora";
                    $db = getConnection();
                    $stmt = $db->prepare($sql);
                    $stmt->execute();
                    $check = $stmt->fetchAll(PDO::FETCH_OBJ);

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

                                    //echo $json;
                                    $context_options = array (
                                                'http' => array (
                                                'method' => 'POST',
                                                'header'=> "Content-type: application/x-www-form-urlencoded\r\n"
                                                    . "Content-Length: " . strlen($json) . "\r\n",
                                                'content' => $json
                                                )
                                            );
                                    $context  = stream_context_create($context_options);
                                    //$result = file_get_contents($urlExpediente, true, $context);
                                    $respuesta = file_get_contents($url, true, $context);
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
                        ELSE {$sinP = '{"EnvioPeritaje":"Sin Informes publicados para enviar"}';}
                    }
                    ELSE {$sin = '{"EnvioPeritaje":"Horas Sin Informes Generados"}';}
            }
        ELSE:
            $fin = '{"EnvioPeritaje": "Error, Sin Horas con peritajes pendientes para consultar"}';
        ENDIF;

        IF($fin !== '')echo $fin;
        ELSEIF($ok !== '')echo $ok;
        ELSEIF($sinP !== '')echo $sinP;
        ELSE echo $sin;

} catch(PDOException $e) {
    echo '{"error":{"text":'. $e->getMessage() .'}}';
}
?>
