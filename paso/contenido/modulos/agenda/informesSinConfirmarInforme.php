<?php 
	session_name("agenda2");
	session_start();
	
	include('../../../lib/informe_entrevista/funciones.php');
	include('../../../lib/usuarios/funciones.php');
	include('../../../lib/pacientes/funciones.php');
	include('../../../lib/datos.php');
	include('../../../lib/funciones.php');
	include('../../../lib/conectar.php');
	
	$conectar = conectar();
	
	$informe = $_GET['id'];
?>

<link href="../../templates/defecto/estilos.css" rel="stylesheet" type="text/css">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td align="left" class="letra4"><a onclick="window.history.back()" class="letra4" style="cursor:pointer">&lt;&lt;Volver</a></td>
	</tr>
</table>
<br />
<br />
<table width="300" border="0" align="center" cellpadding="0" cellspacing="0">
	<tr>
		<td align="center"><input name="button" type="submit" class="botonNormal" id="button" value="Confirmar informe" onclick="window.parent.location.href='chk_informesSinConfirmarInforme.php?informe=<?php echo $informe; ?>'"/></td>
	</tr>
</table>
