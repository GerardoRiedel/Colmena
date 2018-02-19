<?php 
	session_name("agenda2");
	session_start();
	
	include('../../../lib/prestadores/funciones.php');
	include('../../../lib/usuarios/funciones.php');
	include('../../../lib/horas/funciones.php');
	include('../../../lib/querys/comunas.php');
	include('../../../lib/funciones.php');
	include('../../../lib/datos.php');
	include('../../../lib/conectar.php');
include('../../../ws/colmena/metodos/colmena.php');
	
	$conectar = conectar();
	
?>
	
<link href="../../templates/defecto/estilos.css" rel="stylesheet" type="text/css">
<br />
<table width="300" border="0" align="center" cellpadding="0" cellspacing="0">
	<tr>
		<td align="center" class="titulo2">Informes</td>
	</tr>
</table>
<br />
	<table width="400" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF" class="borde_tabla" style="border-collapse:collapse">
		<tr align="right">
			<td align="center" class="tituloTablas" style="padding-left:10px;">Seleccione una opci&oacute;n</td>
		</tr>
		<tr align="right">
			<td width="100%" align="center" style="padding-left:10px;"><p><br />
				<input name="Submit" type="submit" class="boton" value="N&ordm; Peritajes" onclick="window.location.href='numeroPeritajes.php'"/>
				<br />
				<br />
				<input name="Submit3" type="submit" class="boton" value="Ingreso Dinero" onclick="window.location.href='ingresoDinero.php'"/>
				<br />
				<br />
				<input name="Submit2" type="submit" class="boton" value="Utilidades" onclick="window.location.href='utilidades.php'"/>
				</p>
				<p>
					<input name="Submit5" type="submit" class="boton" value="Estad&iacute;sticos" onclick="window.location.href='estadisticos.php'"/>
					<br />
					<br />
					<input name="Submit4" type="submit" class="boton" value="Asistencia" onclick="window.location.href='asistencia.php'"/>
					<br />
					<br />
					<input name="Submit4" type="submit" class="boton" value="Historiales" onclick="window.location.href='../agenda/historiales.php'"/>
					<br />
					<br />
					<input name="Submit4" type="submit" class="boton" value="Informes Peritaje" onclick="window.location.href='informesPeritaje.php'"/>
				  <br/>
				  <br/>
                    <input name="Submit4" type="submit" class="botonNormal" value="Informe Peritajes TMT" onclick="window.location.href='reporteInformesTMT.php'"/>
                    <br/>
                    <br/>
                  <input name="Submit4" type="submit" class="boton" value="Licencias" onclick="window.location.href='informesLicencias.php'"/>
				  <br />
				    <br />
				  <input name="Submit5" type="submit" class="boton" value="Envio Peritaje CB" onclick="window.location.href='../envioxmlcb/envioxmlcb.php' "/>
					<br/><br />
                                        <input name="Submit6" style=" cursor: pointer" type="submit" class="botonNormal" value="Lista Espera Colmena" onclick="window.location.href='listaEsperaColmena.php' "/>
					<br/>
		    </p></td>
		</tr>
</table>
<br />