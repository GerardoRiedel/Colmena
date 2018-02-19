<?php
error_reporting(E_ALL ^ E_NOTICE);
date_default_timezone_set('America/Santiago');

    $clave_aplicacion = "autentication_";
    $clave_compartida = "Colmena";
    $paso1 = $clave_compartida . date("d-m-Y");
    //IF (!empty($_POST['token']))$token = $_POST['token'];
    //$token = "autentication_NTQwY2U3MDViOWZiYzg0Y2Q5ZWU3MjMwYmVhODBkZDRhODJlY2E2YmMyOWZiM2NlYzg3YTM0Nzg4Y2I5YjE0Mw";
    $token = explode('_', $token);
    $urlToken = $token[1];
    
   
    //$urlClaveAplicacion = base64_decode($urlToken); //$urlClaveAplicacion = explode('_',base64_decode($paso5))[0];//ESTA LINEA ES 

//Creo la base para comparar la clave COLMENA//
    $urlClaveAplicacion= $token[0];
    //die($urlClaveAplicacion);
    
    $claveColmena   = "Colmena";
    $pasoToken      = $claveColmena . date("d-m-Y");
    $resu           = hash_hmac("sha256", $pasoToken, $claveColmena);
    
//Obtengo la clave compartida de Colmena de la URL para compararla con la que corresponde
  $urlClaveCompartida = base64_decode($urlToken); //$urlClaveCompartida = base64_decode(explode('_',base64_decode($paso5))[1]);//ESTA LINEA ES DE PRUEBA
//die($urlClaveCompartida.' '.$resu );

/////ACCESO CORRECTO
    IF($urlClaveCompartida===$resu && $urlClaveAplicacion==='autentication') {
        $data = array('status' => true);
        session_start();
        $_SESSION['estado'] = 1;
    }
/////INICIO MANEJO DE ERRORES DE ACCESO
    ELSEIF(empty($urlClaveAplicacion) || strlen($urlToken)<20){
        $data = array('status' => false,'error' => 'Error de datos para la generacion del token');
        echo json_encode($data);
        die();
    }
    ELSEIF($pasoToken!=$paso1){
        $data = array('status' => false,'error' => 'Fecha equivocada');
        echo json_encode($data);
        die();
    }
    ELSEIF($urlClaveAplicacion!='autentication'){
        $data = array('status' => false,'error' => 'Las claves de aplicacion no coinciden');
        echo json_encode($data);
        die();
    }
    ELSEIF($urlClaveCompartida!=$resu){
        $data = array('status' => false,'error' => 'Token invalido');
        echo json_encode($data);
        die();
    }
    ELSE {
        $data = array('status' => false,'error' => '500');
        echo json_encode($data);
        die();
    }
    
?>