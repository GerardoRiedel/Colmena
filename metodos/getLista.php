<?php
require 'clientPrueba.php';
require 'db.php';

IF ($_SESSION['estado'] != 1){
    echo '{"consultarlistaespera": ' . json_encode(array('error'=>400)) . '}';
    die();
}

$sql = "SELECT  `id`,
                `fechaIngreso`,
                `ciudad`,
                `rut` AS pac_rut,
                `nombres` AS pac_nombres,
                `apellidoPaterno` AS pac_apePat,
                `apellidoMaterno` AS pac_apeMat,
                `fechaVencimientoLic` AS exp_fechaIniLic,
                `f_html_encode`(`direccion` )AS pac_direccion,
                `comuna` AS pac_comuna,
                `telefono` AS pac_telFijo,
                `celular` AS pac_telCelular,
                `email` AS pac_mail
        FROM
                `pacientes_espera`
        WHERE isapre = 4";

    try {

            $db = getConnection();
            $stmt = $db->prepare($sql) ;
            $stmt->execute();
            $lista = $stmt->fetchAll(PDO::FETCH_OBJ);

            echo '{"consultarlistaespera": ' . json_encode($lista) . '}';
            mysql_stmt_close;
    } catch(PDOException $e) {
            echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
?>
