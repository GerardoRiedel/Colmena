<?php 
	session_name("agenda2");
	session_start();
	
	include('../../../lib/informe_entrevista/funciones.php');
	include('../../../lib/usuarios/funciones.php');
	include('../../../lib/pacientes/funciones.php');
	include('../../../lib/datos.php');
	include('../../../lib/funciones.php');
	include('../../../lib/conectar.php');
	include('../../../lib/querys/ciudades.php');
	include('../../../lib/querys/comunas.php');
	include('../../../lib/prestadores/funciones.php');
	include('../../../lib/horas/funciones.php');
	
	
	
	$conectar = conectar();
	if (isset($_GET['idUsuario']))
	{
		$idUsuario = $_SESSION['idUsuario'];
		$tipoUsuario = tipoUsuario($idUsuario, $conectar);

		if ($tipoUsuario == "prestador")
		{
			$prestador = prestadorUsuario($_SESSION['idUsuario'], $conectar);
			$informes = siInformesNoConfirmadosPrestador($prestador, $conectar);			
		}elseif ($tipoUsuario == "administrador")
		{
			$informes = siInformesNoConfirmados($conectar);			
		}

	}
?>


<link href="../../templates/defecto/estilos.css" rel="stylesheet" type="text/css">
<br />
<br />
<br />

	<table width="90%" border="0" align="center" cellpadding="0" cellspacing="0" class="borde_tabla" id="cambio_color">
		<tr>
            <?php if ($tipoUsuario == "prestador") { ?>
			   				<td width="50" align="center">&nbsp;</td>
			<?php } ?>

        	<td width="254" height="25" align="center" bgcolor="#AACCFF" class="tituloTablas">Paciente</td>
        	<td width="104" height="25" align="center" bgcolor="#AACCFF" class="tituloTablas">Rut</td>
			<td align="center" bgcolor="#AACCFF" class="tituloTablas">Fecha</td>
            <td align="center" bgcolor="#AACCFF" class="tituloTablas">Prestador</td>
            
			<td align="center" bgcolor="#AACCFF" class="tituloTablas">Ciudad</td>
		</tr>        
		<?php 
		for($i = 0; $i < count($informes); $i++){

			$datosInformeId = datosInformeId($informes[$i], $conectar);
			$datosPacienteId = datosPacienteId($datosInformeId['paciente'], $conectar);			
			$rutPaciente = PonerPunto($datosPacienteId['rut']).'-'.DigitoVerificador($datosPacienteId['rut']);
			$perito = $datosInformeId['prestador'];
			
			$hora = $datosInformeId['hora']; //id hora
			$datosHoraId = datosHora($hora, $conectar);
			$ciudad = $datosHoraId['ciudad']; //id ciudad
			
			?>
			<tr>
           <?php if ($tipoUsuario == "prestador") { ?>
			   				<td height="25" align="center" class="letra7"><a href="informesSinConfirmarInformeFrameset.php?id=<?php echo $informes[$i]; ?>"><img src="<?php echo $IMAGENES2; ?>/pdf.png" width="16" height="16" border="0" /></a></td>
			<?php } ?>
            
				<td class="letra7" style="padding-left:10px;">
	<?php echo caracteres_html(strtoupper($datosPacienteId['apellidoPaterno'].' '.$datosPacienteId['apellidoMaterno'].', '.$datosPacienteId['nombres'])); ?></td>
                <td class="letra7"   align="center"  style="padding-left:10px;"><?php echo $rutPaciente;  ?></td>
				<td width="80" align="center" class="letra7"><?php echo VueltaFecha($datosInformeId['fecha']); ?></td>
                
                <td width="229"  align="left" class="letra7">&nbsp;<?php echo strtoupper(caracteres_html(nombreCompletoPrestador($perito, $conectar))); ?></td>
                <td width="132"  align="left" class="letra7">&nbsp;<?php echo caracteres_html(strtoupper(nombreCiudad($ciudad, $conectar))); ?></td>
			</tr>
            <?php } ?>
	</table>