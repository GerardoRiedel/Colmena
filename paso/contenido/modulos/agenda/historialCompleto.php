<?php 
	session_name("agenda2");
session_start();
	
	include('../../../lib/datos.php');
	include('../../../lib/funciones.php');
	include('../../../lib/conectar.php');
	
	$conectar = conectar();
	
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

<link href="../../templates/defecto/estilos.css" rel="stylesheet" type="text/css">
<br />
<br />
<br />
<form id="form1" name="form1" method="post" action="chk_historialCompleto.php">
	<table width="400" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF" class="letra7">
		<tr>
			<td width="141" height="41" align="right" style="padding-right:10px;">Desde:
				<label></label>
			</td>
			<td width="249" align="left">
				<label>
				<input name="desde" type="text" class="letra7" id="desde" readonly="readonly" />
				</label>
              <img src="<?php echo $IMAGENES2; ?>/b_calendar.png" alt="ayuda" width="15" height="15" title="header=[Fecha] body=[Presione para ver el calendario]" id="lanzador1"/></label>
              <!-- script que define y configura el calendario-->
              <script type="text/javascript">
				   Calendar.setup({
					inputField     :    "desde",     // id del campo de texto
					ifFormat     :     "%d-%m-%Y",     // formato de la fecha que se escriba en el campo de texto
					button     :    "lanzador1"     // el id del bot&oacute;n que lanzar&aacute; el calendario
				});
				</script>
              <!-- script que define y configura el calendario-->				
			</td>
		</tr>
		<tr>
			<td height="40" align="right" style="padding-right:10px;">Hasta: </td>
			<td align="left">
				<label>
				<input name="hasta" type="text" class="letra7" id="hasta" readonly="readonly" />
				</label>
				<img src="<?php echo $IMAGENES2; ?>/b_calendar.png" alt="ayuda" width="15" height="15" title="header=[Fecha] body=[Presione para ver el calendario]" id="lanzador2"/></label>
				<!-- script que define y configura el calendario-->
				<script type="text/javascript">
					Calendar.setup({
					inputField     :    "hasta",     // id del campo de texto
					ifFormat     :     "%d-%m-%Y",     // formato de la fecha que se escriba en el campo de texto
					button     :    "lanzador2"     // el id del bot&oacute;n que lanzar&aacute; el calendario
					});
				</script>
				<!-- script que define y configura el calendario-->				
			</td>
		</tr>
		<tr align="right">
			<td colspan="2" align="center" style="padding-left:10px;">
				<br />
				<input name="Submit" type="submit" class="boton" value="Descargar" />
				<br />
				<br />
			</td>
		</tr>
	</table>
</form>
