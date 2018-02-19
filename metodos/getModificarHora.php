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
$expUrl = $json->expUrl;

require 'clientPrueba.php';
require 'db.php'; 
$db = getConnection();


try {
    date_default_timezone_set('America/Santiago');
    $date = date('Y-m-d H:i:s');
    $s = "INSERT INTO logColmena (logQuery,logUsuario,logDate,logProceso)
          VALUES ('$body',161,'$date','Modificar Expediente')";
        $stmt = $db->prepare($s);
        $stmt->execute();
} catch(PDOException $e) {}



        IF(empty($expUrl) || $expUrl === ' '){echo '{"Modificar Hora": ' . json_encode(array('status' => false,'urlExpediente'=>'vacio')) . '}';die;}
        IF(empty($idHora) || $idHora === ' '){echo '{"Modificar Hora": ' . json_encode(array('status' => false,'idHora'=>'vacio')) . '}';die;}
        
        session_start();
        IF ($_SESSION['estado'] != 1){
            echo '{"Modificar Hora": ' . json_encode(array('error'=>400)) . '}';
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
        $sql = "SELECT id FROM horas WHERE hora='$hora' AND prestador = $prestador AND ciudad = $ciudad AND paciente != 'null'" ;
        $stmt = $db->prepare($sql);
        $stmt->execute();
        $check = $stmt->fetchAll(PDO::FETCH_OBJ);
        
        IF(!empty($check)){
            try {
                    $id = $check[0]->id;
                    $fecha = date('Y-m-d H:i:s');
                    $sql = "UPDATE horas SET urlExpedienteColmena='$expUrl',fechaCambio='$fecha',usuarioCambio=161 WHERE id=$id" ;
                    $stmt = $db->prepare($sql);
                    $stmt->execute();
                    echo '{"Modificar Hora": ' . json_encode(array('status' => true)) . '}';
		} 
            catch(PDOException $e) 
                {
                    echo '{"error":{"text":'. $e->getMessage() .'}}';
		}
        }
        ELSE echo '{"Modificar Hora": ' . json_encode(array('status' => false,'check'=>'vacio-hora sin agendar')) . '}';
            //$null = null;
            //$sql = "UPDATE horas SET paciente=null WHERE idHoraPrestador=$idHora";
		
		
?>