<?php 
	session_name("agenda2");
session_start();

	include('../../../lib/datos.php');
	include('../../../lib/funciones.php');
	include('../../../lib/conectar.php');
	
	$conectar = conectar();
	
?>

<script>
	function validar(form)
	{
		if(form.antigua.value == '')
		{
			alert("Ingrese la contraseña actual");
			return false;
		}
		else if(form.nueva.value == '')
		{
			alert("Ingrese la contraseña nueva");
			return false;
		}
		else if(form.repite.value == '')
		{
			alert("Ingrese la repetición");
			return false;
		}
		else if(form.nueva.value != form.repite.value)
		{
			alert("Las contraseñas no coinciden");
			return false;
		}
		else
		{
			form.submit();
		}
	}
</script>

<link href="../../templates/defecto/estilos.css" rel="stylesheet" type="text/css">

<br />
<br />
<br />
<form id="form1" name="form1" method="post" action="chk_cambiarPass.php" onsubmit="return validar(this);">
	<table width="400" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF" class="bordeTabla1 letra7">
		<tr>
			<td width="50%" height="41" align="right" style="padding-right:10px;">
			Contrase&ntilde;a actual:
				<label></label>
			</td>
			<td width="50%" align="left">
				<label>
				<input name="antigua" type="password" class="letra7" id="antigua" />
				</label>
			</td>
		</tr>
		<tr>
			<td height="40" align="right" style="padding-right:10px;">Contrase&ntilde;a nueva: </td>
			<td align="left">
				<label></label>
				<label>
				<input name="nueva" type="password" class="letra7" id="nueva" />
				</label>
			</td>
		</tr>
		<tr>
			<td height="40" align="right" style="padding-right:10px;">Repita la nueva contrase&ntilde;a: </td>
			<td align="left">
				<label></label>
				<label>
				<input name="repite" type="password" class="letra7" id="repite" />
				</label>
			</td>
		</tr>
		<tr align="right">
			<td colspan="2" align="center" style="padding-left:10px;">
				<br />
				<input name="Submit" type="submit" class="boton" value="Siguiente" />
				<br />
				<br />
			</td>
		</tr>
	</table>
</form>
