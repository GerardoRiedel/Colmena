<?php 
session_name("agenda2");
session_start();

include('../../../lib/fpdf/fpdf.php');
include('../../../lib/pacientes/funciones.php');
include('../../../lib/isapres/funciones.php');
include('../../../lib/usuarios/funciones.php');
include('../../../lib/horas/funciones.php');
include('../../../lib/prestadores/funciones.php');
include('../../../lib/informe_entrevista/funciones.php');
include('../../../lib/querys/comunas.php');
include('../../../lib/querys/ciudades.php');
include('../../../lib/datos.php');
include('../../../lib/funciones.php');
include('../../../lib/conectar.php');

$conectar = conectar();
	
$idHora = $_GET['id'];
$tipoSalida = 'I';

crearInformeNuevo($idHora, $tipoSalida, $carpetaSalida, $conectar);

?>