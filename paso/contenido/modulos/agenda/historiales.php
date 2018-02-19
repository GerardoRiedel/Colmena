<?php 
	session_name("agenda2");
session_start();
	
	include('../../../lib/prestadores/funciones.php');
	include('../../../lib/usuarios/funciones.php');
	include('../../../lib/datos.php');
	include('../../../lib/funciones.php');
	include('../../../lib/conectar.php');
	
	$conectar = conectar();
?>

<link href="../../templates/defecto/estilos.css" rel="stylesheet" type="text/css">
<br />
<br />
<br />
<table width="400" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF" class="letra7">
	<tr>
		<td height="41" align="center"><a href="<?php echo $MODULOS; ?>/agenda/historialPeritajes.php">Historial de peritajes por prestador </a></td>
	</tr>
	<tr>
		<td height="41" align="center"><a href="historialCompleto.php">Historial completo</a></td>
	</tr>
</table>
