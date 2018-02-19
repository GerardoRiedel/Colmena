<?php
$json = $_POST['data'];

//die(var_dump($json));
$json = json_decode( preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $json), true );
//$json = json_decode($json);
//echo json_decode($json);
   // [{"pacRut":15274423,"horExtId":123,"pacNombre":"GERA","pacComuna":1,pacApePat":"RIE","pacApeMat":"CAS","lccIdn":5,"pacFechaNac":"1980-08-29","pacDireccion":"MACHICURA","pacTelFijo":111111,"pacTelCelular":999999,"pacMail":"1@1","token":"autentication_NTQwU3MDViOWZiYzg0Y2Q5ZWU3MjMwYmVhODBkZDRhODJlY2E2YmMyOWZiM2NlYzg3YTM0Nzg4Y2I5YjE0Mw"}]
   // [{"pacRut":15274423,"horExtId":123,"pacNombre":"GERA","pacComuna":1,"pacApePat":"RIE","pacApeMat":"CAS","lccIdn":5,"pacFechaNac":"1980-08-29","pacDireccion":"MACHICURA","pacTelFijo":111111,"pacTelCelular":999999,"pacMail":"1@1","token":"autentication_NTQwU3MDViOWZiYzg0Y2Q5ZWU3MjMwYmVhODBkZDRhODJlY2E2YmMyOWZiM2NlYzg3YTM0Nzg4Y2I5YjE0Mw"}]
   // [{"pacRut":15274423,"horExtId":123,"pacNombre":"GERA","pacComuna":1,pacApePat":"RIE","pacApeMat":"CAS","lccIdn":5,"pacFechaNac":"1980-08-29","pacDireccion":"MACHICURA","pacTelFijo":111111,"pacTelCelular":999999,"pacMail":"1@1","token":"autentication_NTQwU3MDViOWZiYzg0Y2Q5ZWU3MjMwYmVhODBkZDRhODJlY2E2YmMyOWZiM2NlYzg3YTM0Nzg4Y2I5YjE0Mw"}]
die(var_dump($json));
   echo var_dump($json);die();
foreach ($json as $js){
    die($js->pacRut);
    $token = $js->token;
    $pacRut = $js->pacRut;
    $horaId = $js->horExtId;
    $numeroLic = $js->lccIdn;
    
    $ciudad = $js->pacComuna;
    $pacNombre = $js->pacNombre;
    $pacApePat = $js->pacApePat;
    
    $pacApeMat = $js->pacApeMat;
    $pacFecNac = $js->pacFechaNac;
    $pacDirecc = $js->pacDireccion;
    
    $pacTelFij = $js->pacTelFijo;
    $pacTelCel = $js->pacTelCelular;
    $pacEmail = $js->pacMail;
    
    
}

require 'clientPrueba.php';
require 'db.php';

session_start();
IF ($_SESSION['estado'] != 1){
    echo '{"agendarHora": ' . json_encode(array('error'=>400)) . '}';
    die();
}


        /**
        * @api {post} /AgendarHora/ Agendamiento de una hora de atención.
        * @apiName /addAgendar
        * @apiGroup metodos
        * @apiDescription Agendamiento de un usuario asignandole una hora de atención.
        *
        * @apiParam {Integer} pacRut Rut del paciente
        * @apiParam {date} horExtId id id de la hora asignar desde la tabla HORAS_PRESTADORES
        * @apiParam {date} pacNombre Nombre del paciente
        * @apiParam {date} pacApePat Apellido Paterno del paciente
        * @apiParam {date} pacApeMat Apellido Materno del paciente
        * @apiParam {date} pacFecNac Fecha de nacimiento del paciente
        * @apiParam {date} pacDirecc Direccion del paciente
        * @apiParam {date} pacComuna Comuna de residencia del paciente
        * @apiParam {date} pacTelFij Telefono Fijo de contacto
        * @apiParam {date} pacTelCel Celular del paciente
        * @apiParam {date} pacEmail Correo electronico del paciente
        * 
        * @apiError (200) {String} status Ciudad no existe
        * @apiError (304) {String} status Id de Hora no existe
        * @apiError (305) {String} status Nueva hora ya agendada previamente
        */  


            if (!empty($_SESSION['idusuario']))$usuario=$_SESSION['idusuario']; 
            else $usuario = 161;
            
            //$horaId     = $_POST['horExtId'];
            //$numeroLic  = $_POST['lccIdn'];
            //$pacRut     = $_POST['pacRut'];
            //$pacRut     = explode("-",str_replace(array(".",','),'',$pacRut));
            
                $sql1 = "SELECT count(id)contar,id FROM pacientes WHERE rut=$pacRut" ;
                
                try {
                    $db = getConnection();
                    $stmt = $db->prepare($sql1);
                    $stmt->execute();
                    $lista = $stmt->fetchAll(PDO::FETCH_OBJ);
                    //verifica si paciente existe para insertarlo
                    if($lista[0]->contar == 0){
                        
                        //$ciudad = $_POST['pacComuna'];
                            $sqlCiudad ="SELECT id,ciudad FROM cetepcl_agendarest.ciudades2 WHERE ctu = $ciudad";               
                            $stmt = $db->prepare($sqlCiudad);
                            $stmt->execute();
                            $lista = $stmt->fetchAll(PDO::FETCH_OBJ);
                            
                            IF(empty($lista)){
                                //CIUDAD NO EXISTE
                                echo '{"agendarHora": ' . json_encode(array('error' => 200)) . '}';
                                die();
                            }
                        $ciudad = $lista[0]->id;
                        
                        //$pacNombre = $_POST['pacNombre'];
                        //$pacApePat = $_POST['pacApePat'];
                        //$pacApeMat = $_POST['pacApeMat'];
                        //$pacFecNac = $_POST['pacFechaNac'];
                        //$pacDirecc = $_POST['pacDireccion'];
                        //$pacTelFij = $_POST['pacTelFijo'];
                        //$pacTelCel = $_POST['pacTelCelular'];
                        //$pacEmail  = $_POST['pacMail'];
                        
//echo $pacRut.$pacNombre.$pacApePat.$pacApeMat.$pacFecNac.$pacDirecc.$ciudad.$pacTelFij.$pacTelCel.$pacEmail;die();
                        $sql2 = "INSERT INTO pacientes (rut,nombres,apellidoPaterno,apellidoMaterno,fechaNacimiento,direccion,comuna,telefono,celular,email,isapre)
                                        VALUES ('$pacRut','$pacNombre','$pacApePat','$pacApeMat','$pacFecNac','$pacDirecc',$ciudad,$pacTelFij,$pacTelCel,'$pacEmail',4)";
			$stmt = $db->prepare($sql2);
                        $stmt->execute();
                        
                        $stmt = $db->prepare($sql1);
                        $stmt->execute();
                        $lista = $stmt->fetchAll(PDO::FETCH_OBJ);
                    }
                    
                        $paciente = $lista[0]->id;
                        
                    $sql3 = "SELECT id,hora,ciudad,prestador FROM horas_prestadores WHERE id=$horaId AND (`f_horatomada2`(hora,prestador,ciudad) = 0)" ;
                    $stmt = $db->prepare($sql3);
                    $stmt->execute();
                    $lista = $stmt->fetchAll(PDO::FETCH_OBJ);
                    
                    ////IF VALIDA QUE LA HORA EXISTA Y NO SE ENCUENTRE TOMADA
                    IF(empty($lista)) {
                        $sqlHora = "SELECT id,hora,ciudad,prestador FROM horas_prestadores WHERE id=$horaId";
                        $stmt = $db->prepare($sqlHora);
                        $stmt->execute();
                        $lista = $stmt->fetchAll(PDO::FETCH_OBJ);  

                        IF(empty($lista)){
                            //HORA NO EXISTE
                            echo '{"agendarHora": ' . json_encode(array('error' => 304)) . '}';
                            mysql_stmt_close;
                            die();
                        }
                        ELSE {
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
                    die($fecha);
                    $fecha      = str_replace('-','',$fecha);
                    $hora       = str_replace(array("-", " ",':'), "",$hora) ;
                    

                    $sql4 = "INSERT INTO horas (hora,fecha,isapre,paciente,usuario,ciudad,prestador,idHoraPrestador,urlInforme,numerolicencia)
                                    VALUES ($hora,$fecha,4,$paciente,$usuario,$ciudad,$prestador,$horaId,'$expUrl','$numeroLic')";
                    $stmt = $db->prepare($sql4);
                    $stmt->execute();
                //echo $sql4;
                
                    $sql5 = "SELECT `f_datospaciente`(`horas`.`paciente`,4) AS pacRut
				,`horas`.`numerolicencia` AS lccIdn
				,`f_perito`( `horas`.`prestador` ,0) AS horRutMedico
				,`f_perito`( `horas`.`prestador` ,7) AS horNomMedico
				,IF ( `f_perito`( `horas`.`prestador` ,8) = 1 ,'Psiquiatria','Traumatologia' ) AS horEspMedico
				,3 AS iorIdn
				,ciudades2.ctu AS comuna
                                ,`horas`.`hora` AS horFecha
                                ,IF ( `horas`.`confirmada` = 'no',0,1 ) AS horEst	
				,`f_dirPeritaje`(`horas`.`ciudad`) AS horDireccion
				,`horas`.`idHoraPrestador` AS horExtId	
				FROM `horas`
				INNER JOIN `pacientes` ON (`horas`.`paciente` = `pacientes`.`id`)
				INNER JOIN cetepcl_agendarest.`ciudades2` ON (`ciudades2`.`id` = `horas`.`ciudad`)
                                WHERE (`horas`.`isapre` = 4) AND (`horas`.`paciente` = $paciente) AND (`horas`.`hora` = $hora) ";
			$stmt = $db->prepare($sql5);
			$stmt->execute();
                        
			$db = null;
                        $resp = $stmt->fetchAll(PDO::FETCH_OBJ);
                        
                        echo '{"hora": ' . json_encode($resp) . '}';
                        mysql_stmt_close;
		} catch(PDOException $e) {
			echo '{"error":{"text":'. $e->getMessage() .'}}';
		}
                
?>