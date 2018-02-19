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
    
$pacRut = $json->pacRut;
$horaId = $json->horExtId;
$numeroLic = $json->lccIdn;
$finLicencia = $json->expFechaFinLic;
IF(empty($finLicencia))$finLicencia = '1111-11-11';
$comuna = $json->pacComuna;

$pacNombre = $json->pacNombre;
$pacApePat = $json->pacApePat;
$pacApeMat = $json->pacApeMat;
$pacFecNac = $json->pacFechaNac;
$pacDirecc = $json->pacDireccion;
$pacTelFij = $json->pacTelFijo;
$pacTelCel = $json->pacTelCelular;
$pacEmail  = $json->pacMail;

$expUrl    = $json->expUrl;
 
IF(empty($expUrl) || $expUrl === ' '){
        //echo '{"agendarHora": "Hora de agendamiento sin URL de Expediente"}';
        $expUrl = '0';
        }

$idHora = $json->horExtId;


require 'clientPrueba.php';
require 'db.php'; 
$db = getConnection();

IF(empty($pacRut) || $expUrl === ' '){echo '{"Modificar Paciente": ' . json_encode(array('status' => false,'pacRut'=>'vacio')) . '}';die;}
IF(empty($idHora) || $idHora === ' '){echo '{"Modificar Paciente": ' . json_encode(array('status' => false,'idHora'=>'vacio')) . '}';die;}
   
try {
    date_default_timezone_set('America/Santiago');
    $date = date('Y-m-d H:i:s');
    $s = "INSERT INTO logColmena (logQuery,logUsuario,logDate,logProceso)
          VALUES ('$body',161,'$date','Modificar Paciente')";
        $stmt = $db->prepare($s);
        $stmt->execute();
} catch(PDOException $e) {}

$comunaIne = $comuna;
$comuna = "select codregion FROM  cetepcl_agenda.`comunaine` WHERE codcomuna=$comuna";
        $stmt = $db->prepare($comuna) ;
        $stmt->execute();
        $comuna = $stmt->fetchAll(PDO::FETCH_OBJ);
        $region = $comuna[0]->codregion;
        
        IF(empty($region)){
            //CIUDAD NO EXISTE
            echo '{"agendarHora": "Código INE invalido}';
            die;
        }
$ciudad = "select id FROM cetepcl_agenda.`ciudades` WHERE regionIne=$region";
        $stmt = $db->prepare($ciudad) ;
        $stmt->execute();
        $ciudad = $stmt->fetchAll(PDO::FETCH_OBJ);
        $ciudad = $ciudad[0]->id;
IF(empty($ciudad)){
        //CIUDAD NO EXISTE
        echo '{"agendarHora": ' . json_encode(array('error' => 200)) . '}';
        die;
    }
    
        $pacRut = explode("-",str_replace(array(".",','),'',$pacRut));
        $pacRut = $pacRut[0];
        $sql1   = "SELECT count(id)contar,id FROM pacientes WHERE rut=$pacRut" ;
                
        $stmt = $db->prepare($sql1);
        $stmt->execute();
        $lista = $stmt->fetchAll(PDO::FETCH_OBJ);
        //verifica si paciente existe para insertarlo
        if($lista[0]->contar == 0){

            $sql2 = "INSERT INTO pacientes (rut,nombres,apellidoPaterno,apellidoMaterno,fechaNacimiento,direccion,comuna,telefono,celular,email,isapre)
                    VALUES ('$pacRut','$pacNombre','$pacApePat','$pacApeMat','$pacFecNac','$pacDirecc',$ciudad,'$pacTelFij','$pacTelCel','$pacEmail',4)";
            $stmt = $db->prepare($sql2);
            $stmt->execute();

            $stmt = $db->prepare($sql1);
            $stmt->execute();
            $lista = $stmt->fetchAll(PDO::FETCH_OBJ);
        }
                    
        $paciente = $lista[0]->id;

        
        session_start();
        IF ($_SESSION['estado'] != 1){
            echo '{"Modificar Paciente": ' . json_encode(array('error'=>400)) . '}';
            die();
        }
        $sql3 = "SELECT hora,ciudad,prestador FROM horas_prestadores WHERE id=$idHora" ;
        $stmt = $db->prepare($sql3);
        $stmt->execute();
        $lista = $stmt->fetchAll(PDO::FETCH_OBJ);
        
        IF(empty($lista)){echo '{"Modificar Hora": ' . json_encode(array('status' => false,'lista'=>'vacia-hora invalida')) . '}';die;}
        
        $prestador = $lista[0]->prestador;
        $ciudad = $lista[0]->ciudad;
        $hora = $lista[0]->hora;
        
        $fecha = date('Y-m-d H:i:s');
        $sql = "SELECT id FROM horas WHERE hora='$hora' AND prestador = $prestador AND ciudad = $ciudad AND paciente != 'null' AND isapre='4'" ;
        $stmt = $db->prepare($sql);
        $stmt->execute();
        $check = $stmt->fetchAll(PDO::FETCH_OBJ);
        
        IF(!empty($check)){
            try {
                    $id = $check[0]->id;//echo  $id;
                    $fecha = date('Y-m-d H:i:s');
                    $sql = "UPDATE horas SET paciente='$paciente',fechaCambio='$fecha',usuarioCambio=161,reagendadocolmena=5,numeroLicenciaCheck='$numeroLic',numerolicencia='$numeroLic',finlicencia='$finLicencia',urlExpedienteColmena='$expUrl',urlEstadoEnvioColmena=0 WHERE id=$id" ;
                    $stmt = $db->prepare($sql);
                    $stmt->execute();
                            $s = "INSERT INTO logColmena (logQuery,logUsuario,logDate,logProceso)
                            VALUES ('Exitoso',161,'$date','Modificar Paciente')";
                            $stmt = $db->prepare($s);
                            $stmt->execute();
                    echo json_encode(array('status' => true));
		} 
            catch(PDOException $e) 
                {
                    echo '{"error":{"text":'. $e->getMessage() .'}}';
		}
        }ELSE {
            
            try {
                $fecha=date('Y-m-d');
                $sql4 = "INSERT INTO horas (usuario,hora,fecha,ciudad,paciente,prestador,isapre,idHoraPrestador,urlExpedienteColmena,numerolicencia,comunaIne,finlicencia,numeroLicenciaCheck,reagendadocolmena)
                                    VALUES (161,'$hora','$fecha',$ciudad,$paciente,$prestador,4,$horaId,'$expUrl','$numeroLic',$comunaIne,'$finLicencia','$numeroLic',5)";
                    $stmt = $db->prepare($sql4);
                    $stmt->execute();
                    
                    //$id = $check[0]->id;//echo  $id;
                   // $fecha = date('Y-m-d H:i:s');
       //             $sql = "UPDATE horas SET paciente='$paciente',fechaCambio='$fecha',usuarioCambio=161,numeroLicenciaCheck='$numeroLic',numerolicencia='$numeroLic',finlicencia='$finLicencia',urlExpedienteColmena='$expUrl',urlEstadoEnvioColmena=0 WHERE id=$id" ;
        //            $stmt = $db->prepare($sql);
         //           $stmt->execute();
                            $s = "INSERT INTO logColmena (logQuery,logUsuario,logDate,logProceso)
                            VALUES ('Exitoso',161,'$date','Modificar Paciente')";
                            $stmt = $db->prepare($s);
                            $stmt->execute();
                    echo json_encode(array('status' => true));
                    
                $msg = "Modificacion Paciente: ".$paciente;
                $msg = wordwrap($msg,70);
                mail("griedel@cetep.cl","MODIFICACION PACIENTE",$msg);
                } 
                catch(PDOException $e) 
                {
                    echo '{"error":{"text":'. $e->getMessage() .'}}';
                }
            
            
            
            
            
            
            
            
            
           // echo '{"Modificar Paciente": ' . json_encode(array('status' => false,'check'=>'vacio-hora sin agendar')) . '}';
                }
            //$null = null;
            //$sql = "UPDATE horas SET paciente=null WHERE idHoraPrestador=$idHora";
		
		
?>