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
<form id="form1" name="form1" method="post" action="historialesIsapres2.php" onsubmit="return validarForm(this);">
	<table width="400" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF" class="bordeTabla1">
		<tr>
			<td width="37%" height="35" align="right" class="letra7" style="padding-right:10px;">
			Prestador:
				<label></label>			</td>
			<td width="63%" align="left" class="letra7">
				<select name="idPrestador" class="letra7" id="idPrestador">
					<option value="0">Todos</option>
					<?php 
					
					$sql = mysql_query("
					SELECT 
						p.`id` 
					FROM 
						prestadores p
					ORDER BY 
						p.`apellidoPaterno` ASC
					", $conectar);	
					
					while($row = mysql_fetch_array($sql))
					{
						?>
						<option value="<?php echo $row[id]; ?>"><?php echo nombreCompletoPrestadorApellido($row[id], $conectar); ?></option>
						<?php 
					}
				?>
				</select>			</td>
		</tr>
		<tr class="bordeTabla1">
			<td height="35" align="right" class="letra7" style="padding-right:10px;">Ciudad:</td>
			<td align="left" class="letra7"><label>
				<select name="ciudad" class="letra7" id="ciudad">
					<option value="0" selected="selected">Todas</option>
					<?php 
					$sql = mysql_query("
					SELECT 
						c.`id`, 
						c.`ciudad` 
					FROM 
						ciudades c
					ORDER BY 
						c.`ciudad` ASC
					", $conectar);
					
					while($row = mysql_fetch_array($sql))
					{
						?>
					<option value="<?php echo $row[id]; ?>"><?php echo $row[ciudad]; ?></option>
					<?php 
					}
					?>
				</select>
			</label></td>
		</tr>
		<tr>
			<td height="35" align="right" class="letra7" style="padding-right:10px;">Mes: </td>
			<td align="left" class="letra7">
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
				</label>			</td>
		</tr>
		<tr>
			<td height="35" align="right" class="letra7" style="padding-right:10px;">A&ntilde;o: </td>
			<td align="left" class="letra7">
				<label>
				<select name="ano" id="ano">
					<option value="<?php echo date('Y'); ?>" selected="selected"><?php echo date('Y'); ?></option>
					<option value="2008">2008</option>
					<option value="2009">2009</option>
					<option value="2010">2010</option>
					<option value="2011">2011</option>
				</select>
				</label>			</td>
		</tr>
		<tr align="right">
			<td colspan="2" align="center" style="padding-left:10px;">
				<br />
				<input name="Submit" type="submit" class="boton" value="Siguiente" />
				<br />
				<br />			</td>
		</tr>
	</table>
</form>
