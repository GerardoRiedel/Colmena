<?php
        $clave_aplicacion = "autentication_";
	$clave_compartida = "Colmena";
	$paso1 = $clave_compartida . date("d-m-Y");
        //ESTAS LINEA SON DE PRUEBA PARA GENERAR TOKEN VALIDO
        $paso2 = hash_hmac("sha256", $paso1, $clave_compartida);
        $paso3 = base64_encode($paso2);
        $paso4 = $clave_aplicacion . $paso3;
        $token = $paso4;

    try {

            

            echo $token;
            
    } catch(PDOException $e) {
            echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
?>
