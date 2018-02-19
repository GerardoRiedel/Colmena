<?php
require 'clientPrueba.php';
require 'db.php';

session_start();
IF ($_SESSION['estado'] != 1){
    echo '{"SincronizarAgenda": ' . json_encode(array('error'=>400)) . '}';
    die();
}

//$fechaI = str_replace('-','',$fechaI);
$fechaI = str_replace(array("-", " ",':','/'), '', $fechaI);
    IF (!empty($fechaF)){
        $fechaF = str_replace(array("-", " ",':','/'),'',$fechaF);
        //$fechaF = str_replace(array("-", " ",':','/'), '', $fechaF);
        $difere = (strtotime($fechaF) - strtotime($fechaI))/60/60/24;
        ////VALIDA SINCRONIZACION SOLO DE 30 D�?AS
        IF ($difere > 31) {
            echo '{"SincronizarAgenda": ' . json_encode(array('error' => 100)) . '}';
            die();
        }
        $fechaF = "AND DATE(`horas`.`hora`) <= DATE ($fechaF)"; 
    }
    ELSE {$fechaF = '';}

                $sql = "SELECT `f_datospaciente`(`horas`.`paciente`,9) AS pacRut
				,cetepcl_agendarest.`f_licencia` (`informe_entrevista`.`id` , 1) AS lccIdn
				,`f_perito`( `horas`.`prestador` ,10) AS horRutMedico
				,`f_perito`( `horas`.`prestador` ,7) AS horNomMedico
				,IF ( `f_perito`( `horas`.`prestador` ,8) = 1 ,'Psiquiatria','Traumatologia' ) AS horEspMedico
				,3 AS iorIdn
				,ciudades2.ctu AS comuna
                                ,`horas`.`hora` AS horFecha
                                ,IF (`asiste` = 'si',1,3) AS horEst
				,`f_dirPeritaje`(`horas`.`ciudad`) AS horDireccion
				,`horas`.`id` AS horExtId
                        FROM `horas`
                        INNER JOIN `pacientes` ON (`horas`.`paciente` = `pacientes`.`id`)
                        INNER JOIN cetepcl_agenda.`ciudades2` ON (`ciudades2`.`id` = `horas`.`ciudad`)
                        LEFT JOIN cetepcl_agenda.`informe_entrevista` ON (`informe_entrevista`.`paciente` = `horas`.`paciente`)
                        WHERE (`horas`.`isapre` = 4) AND DATE(`horas`.`hora`) >= DATE($fechaI) $fechaF";
                //WHERE DATE(`horas`.`hora`) >= DATE($fechaI) $fechaF AND informe_entrevista.numeroLicencia >0 ";

                
		try {
			$db     = getConnection();
			$stmt   = $db->prepare($sql) ;
			$stmt->bindParam("fecha",$fechaI);
			$stmt->execute();
			$lista  = $stmt->fetchAll(PDO::FETCH_OBJ);
                        //$data['status'] = true;
                        foreach ($lista as $list){
                            //$cont[] = $cont+count($list->pacRut);
                            $data[] = $list;
                            //$data[] = array('iorId'=>$list->iorId);
                        }
                        //$arr = array('status'=>true,'hora'=>$data);
                        //$datos[] = $cont;
                        $datos[0] = array('status'=>true);
                        $datos[1] = $data;
                        //$datos = array($datos);
                        //$data = array($data);
                        //$data['hora']=$data;
                        //$data = array('status'=>true,$lista);
                        echo '{"SincronizarAgenda": ' . json_encode($lista) . '}';
			//echo json_encode($datos);
                        
		} catch(PDOException $e) {
			echo '{"error":{"text":'. $e->getMessage() .'}}';
		}
?>