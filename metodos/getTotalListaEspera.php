<?php


require 'clientPrueba.php';
require 'db.php';

IF ($_SESSION['estado'] != 1){
    echo '{"EstadoListaEsperaColmena": ' . json_encode(array('error'=>400)) . '}';
    die();
}
/*EJEMPLO DE URL DE COLMENA FUNCIONANDO OK!!!
 * http://190.96.77.22:8180/wsAgendaColmenaRest/SHA_256/EstadoListaEsperaColmena
 * data={
    "iorIdn": 3,
    "fechaConsulta": "2016-11-08",
    "token": "autenticacion_Q0VURVBfUkRrNU5qUXpOVGhCUVVSQ1JUa3hOemN5TTBWRVEwVkNORUU0UXpreVFVUXpNVUpEUmpCR01VUTJNRFU0TnpsQk5FRkZNRFl6TlRkQk5rSTBPVVUxT0E9PQ=="
    }
 */
$fecha = str_replace('-','',$fecha);

$sql = "SELECT count(pacientes_espera.id)cantidad
                ,ciudades2.ctu AS comuna
        FROM cetepcl_agenda.`pacientes_espera`
        INNER JOIN cetepcl_agenda.`ciudades2` ON (`ciudades2`.`id` = `pacientes_espera`.`ciudad`)
        WHERE isapre = 4 AND DATE (fechaIngreso) = DATE ('$fecha')
        GROUP BY ctu";
		

        try {

                $db = getConnection();
                $stmt = $db->prepare($sql) ;
                $stmt->execute();
                $lista = $stmt->fetchAll(PDO::FETCH_OBJ);
                $db = null;

                echo '{"EstadoListaEsperaColmena": ' . json_encode($lista) . '}';
                mysql_stmt_close;
        } catch(PDOException $e) {
                echo '{"error":{"text":'. $e->getMessage() .'}}';
        }
?>
