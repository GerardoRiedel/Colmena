<?php 
	session_name("agenda2");
session_start();
	
	include('../../../lib/pacientes/funciones.php');
	include('../../../lib/isapres/funciones.php');
	include('../../../lib/usuarios/funciones.php');
	include('../../../lib/horas/funciones.php');
	include('../../../lib/informe_entrevista/funciones.php');
	include('../../../lib/querys/comunas.php');
	include('../../../lib/datos.php');
	include('../../../lib/funciones.php');
	include('../../../lib/conectar.php');
	
	$conectar = conectar();
	
	//Verifico si el usuario es prestador y lo saco
	if(tipoUsuario($_SESSION['idUsuario'], $conectar) == 'isapre')
	{
		$_SESSION['msj'] = 'No tiene acceso';
		
		header('Location: '.$TEMPLATE_DIR2.'/mensajes.php');
		die();
	}
	
	$idHora = $_GET['hora'];
	
?>

<!--CABECERAS PARA EL CALENDARIO-->
	<!-Hoja de estilos del calendario -->
	<link rel="stylesheet" type="text/css" media="all" href="<?php echo $HOME; ?>/lib/calendar-blue.css" title="win2k-cold-1" />
	
	<!-- librería principal del calendario -->
	<script type="text/javascript" src="<?php echo $HOME; ?>/lib/calendar.js"></script>
	
	<!-- librería para cargar el lenguaje deseado -->
	<script type="text/javascript" src="<?php echo $HOME; ?>/lib/calendar-es.js"></script>
	
	<!-- librería que declara la función Calendar.setup, que ayuda a generar un calendario en unas pocas líneas de código -->
	<script type="text/javascript" src="<?php echo $HOME; ?>/lib/calendar-setup.js"></script> 

<!--FIN CABECERAS PARA EL CALENDARIO-->

<script language="javascript" src="../../../lib/numeros.js"></script>
<script language="javascript" src="../../../lib/validaforms.js"></script>

<link href="../../templates/defecto/estilos.css" rel="stylesheet" type="text/css">
<style type="text/css">
<!--
body {
	background-color: #FFFFFF;
}
-->
</style>
<table width="100%" height="165" border="0" cellpadding="0" cellspacing="0">
	<tr>
		<td height="165" align="center" valign="bottom" class="letra7"><a href="chk_agregarInformeEntrevistaDescarga.php?id=<?php echo $idHora; ?>"><img src="../../templates/defecto/imagenes/word.png" width="15" height="15" border="0" /> Presione para descargar </a></td>
	</tr>
</table>
