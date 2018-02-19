<?php

error_reporting(E_ALL ^ E_NOTICE);
include('../../../ws/colmena/db.php');
include('../../../ws/colmena/tokenColmena.php');

//require 'clientPrueba.php';
//require 'db.php';
//require 'tokenColmena.php';
/*ejemplo
 * data={
 "pacRut":"16932633-9",
 "lccIdn":"2-50083973",
 "horRutMedico":"16932633-9",
 "horNomMedico":"Dra. Isabel Barros Walker",
 "horEspMedico":"PSIQUIATRA",
 "iorIdn":3,
 "comuna":13108,
 "horFecha":"2016-12-12 14:00", 
 "horEst":3,
 "horDireccion":"Doctor Torres Boonen 636",
 "horExtId":0,
 "horExtIdNueva":247620,
 "token":"autenticacion_Q0VURVBfUVVGRFFrRTVSa0k0TXpFMU1rUkJNalpHTVVKRk9EY3lPRFEzUkVNMlF6aEdPVFl5TmpKQ01qUkJSVUk0TWpKRU9ERXlPVU14UTBZME9URkZNVGc0T0E9PQ=="
}
 * 
 */

IF ($idIsapre === 4 || $idIsapre === '4')
{ 


        $sql = "SELECT hora,prestador,ciudad,numerolicencia,paciente FROM cetepcl_agenda.horas WHERE horas.id = $idHora and usuario=161";
        $db = getConnection();
        $stmt = $db->prepare($sql);
        $stmt->execute();
        $lista = $stmt->fetchAll(PDO::FETCH_OBJ);
        
        IF(!empty($lista)){
            $prestador  = $lista[0]->prestador;
            $ciudad     = $lista[0]->ciudad;
            $hora       = $lista[0]->hora;
            $licencia   = $lista[0]->numerolicencia;
            $pac        = $lista[0]->paciente;
// the message
$msg = "Se ha anulado la hora ID= $idHora, HORA= $hora, PACIENTE= $pac, PRESTADOR= $prestador, CIUDAD= $ciudad";
// use wordwrap() if lines are longer than 70 characters
$msg = wordwrap($msg,70);
// send email
mail("griedel@cetep.cl","ANULACION CETEP",$msg);
        
//
//                            
//                        //die($lista[0]->hora);
//                        $sql1 = "SELECT id FROM horas_prestadores where ciudad=$ciudad AND prestador=$prestador AND hora = '$hora'";
//                        $stmt = $db->prepare($sql1);
//                        $stmt->execute();
//                        $lista = $stmt->fetchAll(PDO::FETCH_OBJ);
//                        $idHoraPrestador = $lista[0]->id;
//                        //die(var_dump($lista));
//                        /**
//                        * @api {post} /ReagendarHora/ Reagendamiento de un usuario asignandole una nueva hora de atención.
//                        * @apiName /postReagendarHora
//                        * @apiGroup metodos
//                        * @apiDescription Reagendamiento de un usuario asignandole una nueva hora de atención.
//                        *
//                        * @apiParam {Integer} pacRut Rut del paciente
//                        * @apiParam {date} horExtId id de la hora a anular desde la tabla HORAS
//                        * @apiParam {date} horExtIdNueva id de la hora asignar desde la tabla HORAS_PRESTADORES
//                        * 
//                        * @apiError (304) {String} status Id de Hora no existe
//                        * @apiError (305) {String} status Nueva hora ya agendada previamente
//                        */  
//
//
//                                        $data = array(
//                                            "token"=> $result,
//                                            "iorIdn"=> 3,
//                                            "horExtId"=> $idHoraPrestador,
//                                            "lccIdn"=> $licencia,
//                                            //"token"=>"autenticacion_Q0VURVBfTUVVeFJFTTBOREpDUmpJd1FUQTBNa0kyTTBWRE5UVXdOa0pGT0RoRk56bEJOa1UxTnpsRVFqaEVRelJCTkVJNVJUSkdPRFZDTVRCQk9EWkZNa0V5TlE9PQ=="
//                                            );
//                                        $json = json_encode($data);
//                                        $json = 'data='.$json;
//                                        //echo $json;
//
//                                        //die;
//
//
//
//
//
//
//                                //$ch = curl_init('https://www.colmena.cl/wsAgendaColmenaRest/SHA_256/AnularHora');
//                                ////$api_request_url = 'http://190.96.77.22:8180/wsAgendaColmenaRest/Common/Q0VURVBfMjAxNl9QZXJpdGFqZQ/getToken';
//                                ////$data = array("" => "");  
//                                ////$ch = curl_init('ejemplo.com');  
//                                ////$ch = curl_init('http://190.96.77.22:8180/');
//                                ////$data = array();
//                                ////file_get_contents('http://190.96.77.22:8180/wsAgendaColmenaRest/Common/Q0VURVBfMjAxNl9QZXJpdGFqZQ/getToken');  
//                                //
//                                //curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//                                ////establecemos el verbo http que queremos utilizar para la petición
//                                //curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
//                                ////enviamos el array data
//                                //curl_setopt($ch, CURLOPT_POSTFIELDS,http_build_query($data));
//                                ////obtenemos la respuesta
//                                //curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
//                                //curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
//                                //$response = curl_exec($ch);
//                                //// Se cierra el recurso CURL y se liberan los recursos del sistema
//                                //curl_close($ch);
//
//                            $ch = curl_init('https://www.colmena.cl/wsAgendaColmenaRest/SHA_256/AnularHora');                                                                      
//                            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");                                                                     
//                            curl_setopt($ch, CURLOPT_POSTFIELDS, $json);                                                                  
//                            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                                                                      
//                            curl_setopt($ch, CURLOPT_HEADER, false);                                                                                                               
//
//                            $result = curl_exec($ch);
//
//                                if(!$result) {
//                                    echo '{"status":false}';
//                                }
//                                elseif ( $result === '{"status":true}')
//                                {}
//                                else{
//                                    //echo $result;
//                                }
//                
        }
}         
?>
