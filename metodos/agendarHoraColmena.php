<?php
error_reporting(E_ALL ^ E_NOTICE);

//require 'Slim/Slim.php';
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
 * $idHora = $inicio['id'];
        $idHoraNueva = $destino['id'];

        include('../../../ws/colmena/metodos/reagendamientoHoraColmena.php');

 */
IF ($isapre === 4 || $isapre === '4')
{   $idHoraNueva = $idHora;//die('ENTR');
include_once('../../../ws/colmena/db.php');
include_once('../../../ws/colmena/tokenColmena.php');
            $sql1 = mysql_query("
                        SELECT 
                            `f_datospaciente`(`horas`.`paciente`,9) AS pacRut
                            ,pacientes.nombres
                            ,pacientes.apellidoPaterno
                            ,pacientes.apellidoMaterno
                            ,pacientes.fechaNacimiento
                            ,pacientes.direccion
                            ,pacientes.telefono
                            ,pacientes.celular
                            ,pacientes.email
                            ,ciudades.comunaIne AS comuna

                            ,`horas`.`id`
                            ,`horas`.`numerolicencia` AS lccIdn
                            ,`f_perito`( `horas`.`prestador` ,10) AS horRutMedico
                            ,`f_perito`( `horas`.`prestador` ,7) AS horNomMedico
                            ,IF ( `f_perito`( `horas`.`prestador` ,8) = 1 ,'Psiquiatria','Traumatologia' ) AS horEspMedico
                            
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
                    ", $conectar);
            //
                        //$stmt = $db->prepare($sql5);
                        //$stmt->execute();
                        
                    $row = mysql_fetch_array($sql1);
                    
                            $pacRut         = $row['pacRut'];
                            $pacNombre      = $row['nombres'];
                            $apellidoPaterno= $row['apellidoPaterno'];
                            $apellidoMaterno= $row['apellidoMaterno'];
                            $fechaNacimiento= $row['fechaNacimiento'];
                            $direccion      = $row['direccion'];
                            $telefono       = $row['telefono'];
                            $celular        = $row['celular'];
                            $email          = $row['email'];
                            
                            $lccIdn         = $row['lccIdn'];
                            $horRutMedico   = $row['horRutMedico'];
                            $horNomMedico   = $row['horNomMedico'];
                            $horEspMedico   = $row['horEspMedico'];
                            $comuna         = $row['comuna'];
                            $horFecha       = $row['horFecha'];
                            $horDireccion   = $row['horDireccion'];
                            $horEst         = $row['horEst'];
                            $ciudadNueva    = $row['ciudad'];
                            $prestadorNueva = $row['prestador'];
                            $horaNueva      = $row['hora'];
                            $idHoraNueva    = $row['id'];
                            
                        //$resp = $stmt->fetchAll(PDO::FETCH_OBJ);
                            //$pacRut         = $resp[0]->pacRut;
                            //$lccIdn         = $resp[0]->lccIdn;
                            //$horRutMedico   = $resp[0]->horRutMedico;
                            //$horNomMedico   = $resp[0]->horNomMedico;
                            //$horEspMedico   = $resp[0]->horEspMedico;
                            //$comuna         = $resp[0]->comuna;
                            //$horFecha       = $resp[0]->horFecha;
                            //$horDireccion   = $resp[0]->horDireccion;
                            //$horEst         = $resp[0]->horEst;
                            //$ciudadNueva    = $resp[0]->ciudad;
                            //$prestadorNueva = $resp[0]->prestador;
                            //$horaNueva      = $resp[0]->hora;

            //$sql1 = "SELECT id FROM horas_prestadores where ciudad=$ciudad AND prestador=$prestador AND hora = '$hora'";
            //$stmt = $db->prepare($sql1);
            //$stmt->execute();
            //$lista = $stmt->fetchAll(PDO::FETCH_OBJ);
            //$idHora = $lista[0]->id;

            //$sql1 = "SELECT id FROM horas_prestadores where ciudad=$ciudadNueva AND prestador=$prestadorNueva AND hora = '$horaNueva'";
            //$stmt = $db->prepare($sql1);
            //$stmt->execute();
            //$lista = $stmt->fetchAll(PDO::FETCH_OBJ);
            //$idHoraNueva = $lista[0]->id;
            //die(var_dump($lista));

                $data = array(
                    //"token"=>"autenticacion_Q0VURVBfTUVVeFJFTTBOREpDUmpJd1FUQTBNa0kyTTBWRE5UVXdOa0pGT0RoRk56bEJOa1UxTnpsRVFqaEVRelJCTkVJNVJUSkdPRFZDTVRCQk9EWkZNa0V5TlE9PQ==",
                    "token"         => $result,
                    "horExtId"      => $idHoraNueva,
                    "pacRut"        => $pacRut,
                    "pacNombre"     => $pacNombre,
                    "pacApePat"     => $apellidoPaterno,
                    "pacApeMat"     => $apellidoMaterno,
                    "pacFechaNac"   => $fechaNacimiento,
                    "pacDireccion"  => $direccion,
                    "pacComuna"     => $comuna,
                    "pacTelFijo"    => $telefono,
                    "pacTelCelular" => $celular,
                    "pacMail"       => $email,
                    "lccIdn"        => $lccIdn,
                    
                    "horRutMedico"  => $horRutMedico,
                    "horNomMedico"  => $horNomMedico,
                    "horEspMedico"  => $horEspMedico,
                    "iorIdn"        => 3,
                    
                    "horFecha"      => $horFecha,
                    "horEst"        => $horEst,
                    "horDireccion"  => $horDireccion,
                    

                    );
                //$data = json_encode($data);
                //$json = 'data='.$json;
                


            $data_string = json_encode($data); 
            $data_string = 'data='.$data_string;
            echo $data_string;      
//die;
            $ch = curl_init('https://www.colmena.cl/wsAgendaColmenaRest/SHA_256/AgendamientoHoraColmena');                                                                      
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");                                                                     
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);                                                                  
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                                                                      
            curl_setopt($ch, CURLOPT_HEADER, false);                                                                                                               

            $result = curl_exec($ch);

            IF($result === '{"status":false}'){
                echo 'ERROR ENVIO ACTUALIZACIÓN A COLMENA------- QUERY===='.$data_string.'           RESPUESTA===='.$result;
                die;
            }
            //else $result.$data_string;

        

}
?>
