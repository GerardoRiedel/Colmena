<?php 
	session_name("agenda2");
	session_start();
	
	include('../../../lib/isapres/funciones.php');
	include('../../../lib/usuarios/funciones.php');
	include('../../../lib/horas/funciones.php');
	include('../../../lib/datos.php');
	include('../../../lib/funciones.php');
	include('../../../lib/conectar.php');

	$conectar = conectar();
	
	$idHoraPrestador = $_GET['hora'];
?>

<link href="../../templates/defecto/estilos.css" rel="stylesheet" type="text/css">
<br>
<table width="383" border="0" align="center" cellpadding="0" cellspacing="0" class="borde_tabla" style="border-collapse:collapse">
	<tr>
		<td height="25" class="campoTituloTabla">Vincular Isapres</td>
	</tr>
	<tr>
		<td height="125" align="center" valign="top" class="letra7"><br>
			<form name="form1" method="post" action="chk_isapreHora.php">
				<table width="300" border="0" align="center" cellpadding="0" cellspacing="0" style="border-collapse:collapse">
					<?php 
					$sql = mysql_query("
					SELECT 
						i.`id`, 
						i.`isapre` 
					FROM 
						isapres i
					ORDER BY 
						i.`isapre`
					", $conectar);
					
					while($row = mysql_fetch_array($sql))
					{
						$isapre = $row[id];
						$nombreIsapre = $row[isapre];
						
						//Si esta isapre está vinculada a la hora la chequeo
						$chequeo = NULL;
						if(siIsapresHoraPrestador($isapre, $idHoraPrestador, $conectar) == true)
						{
							$chequeo = 'checked';
						}
						?>
						<tr>
							<td height="25">
								<label class="letra7">
									<input name="isapre[]" type="checkbox" id="isapre[]" value="<?php echo $isapre; ?>" <?php echo $chequeo; ?>><?php echo $nombreIsapre; ?>
								</label>
							</td>
						</tr>
						<?php 
					}
					?>
				</table>
				<label>
					<br>
					<input name="hora" type="hidden" id="hora" value="<?php echo $idHoraPrestador; ?>">
					<input name="button" type="submit" class="botonNormal" id="button" value="Guardar">
				</label>
				<br>
				<br>
			</form></td>
	</tr>
</table>
