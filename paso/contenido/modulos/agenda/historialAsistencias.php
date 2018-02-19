<?php 
	session_name("agenda2");
session_start();
	
	include('../../../lib/isapres/funciones.php');
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
<form id="form1" name="form1" method="post" action="historialAsistencias2.php" onsubmit="return validarForm(this);">
	<table width="400" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF" class="letra7">
		<tr>
			<td width="50%" height="41" align="right" style="padding-right:10px;">
			Seleccione la Isapre:
				<label></label>
			</td>
			<td width="50%" align="left">
				<select name="isapre" class="letra7" id="isapre">
					<option value="0">Todas</option>
					<?php echo isapresOptions($conectar); ?>
				</select>
			</td>
		</tr>
		<tr>
			<td height="40" align="right" style="padding-right:10px;">Seleccione el mes: </td>
			<td align="left">
				<label>
				<select name="mes" class="letra7" id="mes">
					<option value="01">Enero</option>
					<option value="02">Febrero</option>
					<option value="03">Marzo</option>
					<option value="04">Abril</option>
					<option value="05">Mayo</option>
					<option value="06">Junio</option>
					<option value="07">Julio</option>
					<option value="08">Agosto</option>
					<option value="09">Septiembre</option>
					<option value="10">Octubre</option>
					<option value="11">Noviembre</option>
					<option value="12">Diciembre</option>
				</select>
				</label>
			</td>
		</tr>
		<tr>
			<td height="40" align="right" style="padding-right:10px;">Seleccione el a&ntilde;o: </td>
			<td align="left">
				<label>
				<select name="ano" id="ano">
					<option value="2008">2008</option>
					<option value="2009">2009</option>
					<option value="2010">2010</option>
					<option value="2011">2011</option>
				</select>
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
