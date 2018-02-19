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
//echo $body;
//die(var_dump($json));

//$body2 = '[{"horExtId":247618,"pacRut":"15274423-2","pacNombre":"GERA","pacApePat":"RIE","pacApeMat":"CAS","pacFechaNac":"1980-08-29","pacDireccion":"MACHICURA","pacComuna":1,"pacTelFijo":"1111111","pacTelCelular":"999999","pacMail":"1@1","lccIdn":"5","token":"autentication_Yjc0ZmFiMzExZjQ5ZTQwOTQzZGExNjQ5OTE4NGIyMWVhMjM5NTcwYzFlM2U5MTU0YzgxMWI2ZjBiNGQyMDhkOQ\u003d\u003d"}]';
//$body1 = '[{"status":"true"},{"hora":{"iorIdn":"3","horExtId":"247617","horFecha":"2016-10-01 08:00:00","direccion":"Dr.Torres Boonen 636,  Providencia","ciudad":"1","horRutMedico":"15377257-6","horNomMedico":"Barros Walker Isabel","horEspMedico":"Traumatologia"}}]' ;

//die($json->token);
//foreach ($json as $js){
require 'db.php'; 
$db = getConnection();
try {
    date_default_timezone_set('America/Santiago');
    $date = date('Y-m-d H:i:s');
$s = "INSERT INTO cetepcl_agenda.logColmena (logQuery,logUsuario,logDate,logProceso)
        VALUES ('$body',161,'$date','Agendar')";
        $stmt = $db->prepare($s);
        $stmt->execute();
} catch(PDOException $e) {}
                        
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
    
    
    IF(empty($horaId)){echo '{"agendarHora": "Consulta sin HORA"}';die;}
    //$arr[$js] = $item;
    
//}
//die($pacApeMat);
//die($arr['pacRut']);
//$pacRut = $arr['pacRut'];
//$horaId = $arr['horExtId'];
//$numeroLic = $arr['lccIdn'];
//
//$ciudad = $arr['pacComuna'];
//$pacNombre = $arr['pacNombre'];
//$pacApePat = $arr['pacApePat'];
//
//$pacApeMat = $arr['pacApeMat'];
//$pacFecNac = $arr['pacFechaNac'];
//$pacDirecc = $arr['pacDireccion'];
//
//$pacTelFij = $arr['pacTelFijo'];
//$pacTelCel = $arr['pacTelCelular'];
//$pacEmail = $arr['pacMail'];
//$token = $arr['token'];

//die(var_dump($pacRut));
require 'clientPrueba.php';

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


session_start();
IF ($_SESSION['estado'] != 1){
    echo '{"agendarHora": ' . json_encode(array('error'=>400)) . '}';
    die();
}

            if (!empty($_SESSION['idusuario']))$usuario=$_SESSION['idusuario']; 
            else $usuario = 161;
            
            //$horaId     = $_POST['horExtId'];
            //$numeroLic  = $_POST['lccIdn'];
            //$pacRut     = $_POST['pacRut'];
            
            $pacRut = explode("-",str_replace(array(".",','),'',$pacRut));
            $pacRut = $pacRut[0];
            $sql1   = "SELECT count(id)contar,id FROM pacientes WHERE rut=$pacRut" ;
                
                try {
                    $db = getConnection();
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
                        
                    //$sql3 = "SELECT id,hora,ciudad,prestador FROM horas_prestadores WHERE id=$horaId AND (`f_horatomada2`(hora,prestador,ciudad) = 0)" ;
                    $sql3 = "SELECT id,hora,ciudad,prestador FROM horas_prestadores WHERE id=$horaId" ;
                    $stmt = $db->prepare($sql3);
                    $stmt->execute();
                    $lista = $stmt->fetchAll(PDO::FETCH_OBJ);
                    
                    
                    //$sqlCiudad = "SELECT id,hora,ciudad,prestador FROM horas_prestadores WHERE id=$horaId and ciudad = $ciudad" ;
                    //$stmt = $db->prepare($sqlCiudad);
                    //$stmt->execute();
                    //$listaCiudad = $stmt->fetchAll(PDO::FETCH_OBJ);
                    
                    ////IF VALIDA QUE LA HORA EXISTA Y NO SE ENCUENTRE TOMADA
                    IF(empty($lista)) {
                            //HORA NO EXISTE
                            echo '{"agendarHora": ' . json_encode(array('error' => 304)) . '}';
                            mysql_stmt_close;
                            die();
                    }
                    ELSE {
                    //echo 'hora='.$hora.'-fecha='.$fecha.'-paciente='.$paciente.'-usuario='.$usuario.'-ciudad='.$ciudad.'-prestador='.$prestador.'-horId='.$horaId.'-url='.$expUrl.'-licencia='.$numeroLic;
                        $prestador = $lista[0]->prestador;
                        $ciudad = $lista[0]->ciudad;
                        //die ('aca'.$ciudad.'-'.$prestador.'-'.$horaId);
                        $s = "SELECT id FROM horas WHERE idHoraPrestador=$horaId AND prestador = $prestador AND ciudad = $ciudad AND paciente != 'null'" ;
                        $stmt = $db->prepare($s);
                        $stmt->execute();
                        $listadoHora = $stmt->fetchAll(PDO::FETCH_OBJ);
                            IF (!empty($listadoHora)){
                                //HORA YA ESTA TOMADA
                                echo '{"agendarHora": ' . json_encode(array('error' => 305)) . '}';
                                mysql_stmt_close;
                                die();
                            }
                    }
                    
                    $id         = $lista[0]->id;
                    $ciudad     = $lista[0]->ciudad;
                    $hora       = $lista[0]->hora;
                    $prestador  = $lista[0]->prestador;
                    $fecha      = explode(" ", $hora);
                    //die($fecha[0]);
                    $fecha      = $fecha[0];
                    $fecha      = str_replace('-','',$fecha);
                    $hora       = str_replace(array("-", " ",':'), "",$hora) ;
                    
                    
                    //echo '                 REPETICION: hora='.$hora.'-fecha='.$fecha.'-paciente='.$paciente.'-usuario='.$usuario.'-ciudad='.$ciudad.'-prestador='.$prestador.'-horId='.$horaId.'-url='.$expUrl.'-licencia='.$numeroLic.'....................................';
                    $sql4 = "INSERT INTO horas (hora,fecha,isapre,paciente,usuario,ciudad,prestador,idHoraPrestador,urlExpedienteColmena,numerolicencia,comunaIne,finlicencia,numeroLicenciaCheck)
                                    VALUES ($hora,$fecha,4,$paciente,$usuario,$ciudad,$prestador,$horaId,'$expUrl','$numeroLic',$comunaIne,'$finLicencia','$numeroLic')";
                    $stmt = $db->prepare($sql4);
                    $stmt->execute();
                //echo $sql4;
                //,comunaine.prueba AS comuna
                    $sql5 = "SELECT `f_datospaciente`(`horas`.`paciente`,9) AS pacRut
				,`horas`.`numerolicencia` AS lccIdn
				,`f_perito`( `horas`.`prestador` ,10) AS horRutMedico
				,`f_perito`( `horas`.`prestador` ,7) AS horNomMedico
				,IF ( `f_perito`( `horas`.`prestador` ,8) = 1 ,'Psiquiatria','Traumatologia' ) AS horEspMedico
				,3 AS iorIdn
				,comunaine.codcomuna AS comuna
                                ,`horas`.`hora` AS horFecha
                                ,IF ( `horas`.`confirmada` = 'no',0,1 ) AS horEst	
				,`f_dirPeritaje`(`horas`.`ciudad`) AS horDireccion
				,`horas`.`idHoraPrestador` AS horExtId	
				FROM `horas`
				INNER JOIN `pacientes` ON (`horas`.`paciente` = `pacientes`.`id`)
				INNER JOIN cetepcl_agenda.`ciudades` ON (`ciudades`.`id` = `horas`.`ciudad`)
                                INNER JOIN cetepcl_agenda.`comunaine` ON (`horas`.`comunaIne` = `comunaine`.`codcomuna`)
                                WHERE (`horas`.`isapre` = 4) AND (`horas`.`paciente` = $paciente) AND (`horas`.`hora` = $hora) ";
			$stmt = $db->prepare($sql5);
			$stmt->execute();
                        
			$db = null;
                        $resp = $stmt->fetchAll(PDO::FETCH_OBJ);
                        IF(empty($resp))die('SELECT VACIA');
                        $resp = json_encode($resp);
                        $resp = str_replace('[', '', $resp);
                        $resp = str_replace(']', '', $resp);
                        echo $resp;
                       
		} catch(PDOException $e) {
			echo '{"error":{"text":'. $e->getMessage() .'}}';
		}
                
?>