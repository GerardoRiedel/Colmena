<?php
require 'clientPrueba.php';
require 'db.php';
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


$db = getConnection();
try {
    $date = date('Y-m-d H:i:s');
$s = "INSERT INTO cetepcl_agenda.logColmena (logQuery,logUsuario,logDate,logProceso)
        VALUES ('$pacRut',161,'$date','ReagendarDESDECOLMENA')";
        $stmt = $db->prepare($s);
        $stmt->execute();
        
        $msg = "COLMENAAA Se ha reagendado la hora; PACIENTERUT= $pacRut, HORA VIEJA= $horaVieja, HORANUEVA= '$horaNueva'";
        // use wordwrap() if lines are longer than 70 characters
        $msg = wordwrap($msg,70);
        // send email
        mail("griedel@cetep.cl","REAGENDAMIENTO COLMENAAA",$msg);
        
} catch(PDOException $e) {}

session_start();
IF ($_SESSION['estado'] != 1){
    echo '{"reagendarHora": ' . json_encode(array('error'=>400)) . '}';
    die();
}
        /**
        * @api {post} /ReagendarHora/ Reagendamiento de un usuario asignandole una nueva hora de atención.
        * @apiName /postReagendarHora
        * @apiGroup metodos
        * @apiDescription Reagendamiento de un usuario asignandole una nueva hora de atención.
        *
        * @apiParam {Integer} pacRut Rut del paciente
        * @apiParam {date} horExtId id de la hora a anular desde la tabla HORAS
        * @apiParam {date} horExtIdNueva id de la hora asignar desde la tabla HORAS_PRESTADORES
        * 
        * @apiError (304) {String} status Id de Hora no existe
        * @apiError (305) {String} status Nueva hora ya agendada previamente
        */  

if (!empty($_SESSION['idusuario']))$usuario=$_SESSION['idusuario']; 
else $usuario = 161;
            
            
            
            $pacRut     = explode("-",str_replace(array(".",','),'',$pacRut))[0];
            
          
        try {   
                ////PRIMERO PROCESA AGENDAMIENTO
                $sql1 = "SELECT count(id)contar,id FROM pacientes WHERE rut=$pacRut" ;
                $db = getConnection();
                $stmt = $db->prepare($sql1);
                $stmt->execute();
                $lista = $stmt->fetchAll(PDO::FETCH_OBJ);
                
                ////VERIFICO USUARIO REGISTRADO
                IF(empty($lista[0]->id)){
                    echo '{"agendarHora": ' . json_encode(array('error' => 400,'data'=>'Paciente no registrado')) . '}';
                            mysql_stmt_close;
                            die();
                }
                
                
                ////LUEGO ANULA
                $sql = "UPDATE horas SET paciente=null WHERE id=$horaVieja";
		$stmt = $db->prepare($sql);
                $stmt->execute();
                
                $paciente = $lista[0]->id;
                
                    
                    
                
                    $sql3 = "SELECT id,hora,ciudad,prestador FROM horas_prestadores WHERE id=$horaNueva AND (`f_horatomada`(hora,prestador,ciudad) = 0)" ;
                    $stmt = $db->prepare($sql3);
                    $stmt->execute();
                    $lista = $stmt->fetchAll(PDO::FETCH_OBJ);
                    
                    ////IF VALIDA QUE LA HORA EXISTA Y NO SE ENCUENTRE TOMADA
                    IF(empty($lista)) {
                        $sqlHora = "SELECT id FROM horas_prestadores WHERE id=$horaNueva";
                        $stmt = $db->prepare($sqlHora);
                        $stmt->execute();
                        $lista = $stmt->fetchAll(PDO::FETCH_OBJ);  

                        IF(empty($lista)){
                            echo '{"agendarHora": ' . json_encode(array('error' => 304)) . '}';
                            mysql_stmt_close;
                            die();
                        }
                        ELSE {
                            echo '{"agendarHora": ' . json_encode(array('error' => 305)) . '}';
                            mysql_stmt_close;
                            die();
                        }
                    }
                    
                $id         = $lista[0]->id;
                $ciudad     = $lista[0]->ciudad;
                $hora       = $lista[0]->hora;
                $prestador  = $lista[0]->prestador;
                $fecha      = explode(" ", $hora)[0];
                $fecha      = str_replace('-','',$fecha);
                $hora       = str_replace(array("-", " ",':'), "",$hora) ;
                $sql4 = "INSERT INTO horas (hora,fecha,isapre,paciente,usuario,ciudad,prestador,idHoraPrestador)
                                VALUES ($hora,$fecha,4,$paciente,$usuario,$ciudad,$prestador,$horaNueva)";
                $stmt = $db->prepare($sql4);
                $stmt->execute();
                
                    //INSERTAR A HORA ELIMINADA LA HORA VIEJA
                    $fecha = date('Y-m-d H:i:s');        
                    $sqlInsert = "INSERT INTO cetepcl_agenda.horas_eliminadas (usuario, fecha, idHora, hora, ciudad, paciente, prestador, isapre)
                    VALUES (161, '$fecha',$horaVieja, '$hora',$ciudad, $paciente, $prestador, 4)";	
                    $stmt = $db->prepare($sqlInsert);
                    $stmt->execute();  
                    
                $db = null;    
                
                ////ENVIA RESPUESTA
                echo '{"reagendarHora": ' . json_encode(array('status'=>true)) . '}';
                mysql_stmt_close;
        } catch(PDOException $e) {
                echo '{"error":{"text":'. $e->getMessage() .'}}';
        }
?>
