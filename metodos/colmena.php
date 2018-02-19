<?php
//require 'tokenColmena.php';
//require 'db.php';
date_default_timezone_set('America/Santiago');
include_once('../../../ws/colmena/db.php');
include_once('../../../ws/colmena/tokenColmena.php');

$url    = "https://www.colmena.cl/wsAgendaColmenaRest/SHA_256/EstadoListaEsperaColmena";
//$url    = "http://190.96.77.22:8180/wsAgendaColmenaRest/SHA_256/EstadoListaEsperaColmena";
$fecha  = date('Y-m-d H:i:s');
$dia    = date('Y-m-d');
$data = array(
    "iorIdn"=> 3,
    "fechaConsulta"=> $dia,
    "token"=> $result
    //"token"=>"autenticacion_Q0VURVBfTUVVeFJFTTBOREpDUmpJd1FUQTBNa0kyTTBWRE5UVXdOa0pGT0RoRk56bEJOa1UxTnpsRVFqaEVRelJCTkVJNVJUSkdPRFZDTVRCQk9EWkZNa0V5TlE9PQ=="
    );
$json = json_encode($data);
$json = 'data='.$json;

$data_string = json_encode($data); 
$data_string = 'data='.$data_string;

$ch = curl_init($url);                                                                      
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");                                                                     
curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);                                                                  
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                                                                      
curl_setopt($ch, CURLOPT_HEADER, false);                                                                                                               
                                                                                                                     
$resulta = curl_exec($ch);
$result = json_decode($resulta);


$db = getConnection();

try {
    $date = date('Y-m-d H:i:s');
    $s = "INSERT INTO cetepcl_agenda.logColmena (logQuery,logUsuario,logDate,logProceso)
        VALUES ('$resulta',161,'$date','Consulta Lista de Espera')";
        $stmt = $db->prepare($s);
        $stmt->execute();
} catch(PDOException $e) {}

//echo var_dump($result);
IF(!empty($result)){   
    $truncar = 'truncate table cetepcl_agenda.lista_espera_colmena';
    $stmt = $db->prepare($truncar);
    $stmt->execute();
    foreach ($result as $res[0]):
        $comuna         = $res[0]->pacComuna;
        //$cantidad = $res[0]->perIdn;
        $finLicencia    = $res[0]->expFechaFinLic;
        $fueraPlazo     = $res[0]->expFueraLic;
        $especialidad   = $res[0]->especialidad;
        $glosa          = $res[0]->glosaEspecialidad;
        $glosa          = str_replace('í','i',$glosa);
        //die('FUERA PLAZO: '.$res[0]->expFueraLic);
        $sql = "INSERT INTO cetepcl_agenda.lista_espera_colmena (lisFecha,lisComuna,lisFinLicencia,lisFueraPlazo,lisEspecialidad,lisGlosa)
                VALUES ('$fecha',$comuna,'$finLicencia',$fueraPlazo,'$especialidad','$glosa')";
        $stmt = $db->prepare($sql);
        $stmt->execute();
    endforeach;
    //echo json_encode(array('status'=>true));
}
ELSE {
    $sql = "INSERT INTO lista_espera_colmena (lisFecha)
            VALUES ('$fecha')";
            $stmt = $db->prepare($sql);
            $stmt->execute();
    echo json_encode(array('status'=>false,'respuesta'=>$result,'query'=>$data_string));
}
    


    
?>