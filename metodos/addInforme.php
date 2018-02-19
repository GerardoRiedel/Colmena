<?php
//$cuerpo = file_get_contents('php://input');
//$cuerpo = str_replace("%22", '"',$cuerpo);
//$cuerpo = str_replace("%3A", ':',$cuerpo);
//$cuerpo = str_replace("%2C", ',',$cuerpo);
//$cuerpo = str_replace("%7B", '{',$cuerpo);
//
//$cuerpo = str_replace("%5B", '[',$cuerpo);
//$cuerpo = str_replace("%5D", ']',$cuerpo);
//$cuerpo = str_replace("%7D", '}',$cuerpo);
//$cuerpo = str_replace("%40", '@',$cuerpo);
//IF(empty($cuerpo))$cuerpo='vacio - ';
////echo 'Cuerpo: '.$cuerpo.' - ';
//
//
//$app = new \Slim\Slim();
//$application = new \Slim\Slim();
//
//$body = $app->request()->post('data');
//
////$body = $application->request->getBody();
//$body = str_replace("%22", '"',$body);
//$body = str_replace("%3A", ':',$body);
//$body = str_replace("%2C", ',',$body);
//$body = str_replace("%7B", '{',$body);
//
//$body = str_replace("%5B", '[',$body);
//$body = str_replace("%5D", ']',$body);
//$body = str_replace("%7D", '}',$body);
//$body = str_replace("%40", '@',$body);
////$body = str_replace(" ", '',$body);
//$json = json_decode($body);
//
//$token = $json->token;
//$idHora = $json->horExtId;
//$iorIdn = $json->iorIdn;
//$lccIdn = $json->lccInd;

//require 'clientPrueba.php';
require 'db.php';


session_start();
IF ($_SESSION['estado'] != 1){
    echo '{"consultaExpediente": ' . json_encode(array('error'=>400)) . '}';
    die();
}

            include 'informes/informe_entrevista/funciones.php';
            require 'informes/funciones.php';
            include_once('informes/fpdf/fpdf.php');
            
            try {
                
                $sqlInfo = "SELECT id,numerolicencia FROM horas WHERE urlEstadoEnvioColmena = 0 AND isapre = 4 AND hora>='2016-05-01 00:00:00'";
                    $db = getConnection();
                    $stmt = $db->prepare($sqlInfo) ;
                    $stmt->execute();
                    $informes = $stmt->fetchAll(PDO::FETCH_OBJ);
                    foreach ($informes as $info){
                        $idHora = $info[0]->id;
                        $licencia = $info[0]->numerolicencia;
                        
                    
                            $sql = "SELECT id FROM informe_entrevista WHERE hora = $idHora";
                            $db = getConnection();
                            $stmt = $db->prepare($sql);
                            $stmt->execute();
                            $check = $stmt->fetchAll(PDO::FETCH_OBJ);
                            
                            IF(!empty($check)){
                                //$sql = "SELECT id FROM horas WHERE idHoraPrestador = $idHora";
                                //$db = getConnection();
                                //$stmt = $db->prepare($sql);
                                //$stmt->execute();
                                //$hora = $stmt->fetchAll(PDO::FETCH_OBJ);
                                //$idHora = $hora[0]->id;
                                //IF(empty($idHora)){
                                //    echo '{"ConsultarExpediente": "Sin Hora Asociada a Expediente"}';
                                //    die;
                                //}

                                $filepdfEntrevista  = crearInformeNuevoEntrevista($idHora, $tipoSalida='F', $carpetaSalida='');
                                //$filepdfTrauma      = crearInformeNuevoTrauma($idHora, $tipoSalida='F', $carpetaSalida='');
                                $filepdf            = $filepdfEntrevista.$filepdfTrauma;


                                //$resp = array('expUrl' => $filepdf);
                                //$resp = json_encode($resp);
                                //$resp = str_replace('\\',"",$resp);
                                
                                        require 'tokenColmena.php';

                                        $url    = "http://190.96.77.22:8180/wsAgendaColmenaRest/SHA_256/RecepcionInforme";


                                        $data = array(
                                            "iorIdn"=> 3,
                                            "horExtId"=> $idHora,
                                            "lccIdn"=> $licencia,
                                            "informe"=> $filepdf,
                                            "token"=> $result
                                            //"token"=>"autenticacion_Q0VURVBfTUVVeFJFTTBOREpDUmpJd1FUQTBNa0kyTTBWRE5UVXdOa0pGT0RoRk56bEJOa1UxTnpsRVFqaEVRelJCTkVJNVJUSkdPRFZDTVRCQk9EWkZNa0V5TlE9PQ=="
                                            );
                                        $json = json_encode($data);
                                        $json = 'data='.$json;
                                        echo $json;
                                        $context_options = array (
                                                    'http' => array (
                                                    'method' => 'POST',
                                                    'header'=> "Content-type: application/x-www-form-urlencoded\r\n"
                                                        . "Content-Length: " . strlen($json) . "\r\n",
                                                    'content' => $json
                                                    )
                                                );
                                        $context  = stream_context_create($context_options);
                                        $result = file_get_contents($url, true, $context);
                                        //echo $result;




                                echo '{"consultaExpediente": '.$resp.'}';
                            }
                            ELSE {
                                echo '{"consultaExpediente": "Sin Informe Generado}';
                            }
                    }
                mysql_stmt_close;
                
            } catch(PDOException $e) {
                echo '{"error":{"text":'. $e->getMessage() .'}}';
            }
?>
