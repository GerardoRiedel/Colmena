<?php 
	session_name("agenda2");
	session_start();

	include('../../../lib/datos.php');
	include('../../../lib/funciones.php');
	include('../../../lib/usuarios/funciones.php');
	include('../../../lib/prestadores/funciones.php');
	include('../../../lib/encuesta_peritaje/funciones.php');
	include('../../../lib/informe_entrevista/funciones.php');
	include('../../../lib/conectar.php');
	
	$conectar = conectar();
	
	if($_POST['rut'])
	{
		$rut = SacarPunto($_POST['rut']);
	}
	else
	{
		$rut = SacarPunto($_GET['rut']);
	}
?>

<script>
	function validar(form)
	{
		if(form.rut.value == '')
		{
			alert("Ingrese el RUT");
			return false;
		}
		else
		{
			form.submit();
		}
	}
</script>

<script language="javascript" src="<?php echo $LIB; ?>/numeros.js"></script>

<link href="../../templates/defecto/estilos.css" rel="stylesheet" type="text/css">

<br />
<br />
<br />

<table width="400" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
	<tr>
		<td align="center" class="titulo3">Listado de peritajes </td>
	</tr>
</table>
<br />
<table width="267" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF" class="borde_tabla" id="cambio_color">
	<tr class="tituloTablas">
		<td height="27" align="center">Fecha</td>
		<td height="27" align="center">Ciudad</td>
		<td align="center">Informe</td>

	</tr>

<?php
include_once('../../../lib/datos.php');
include_once('../../../lib/pacientes/funciones.php');
include_once('../../../lib/querys/ciudades.php');
include_once('../../../lib/horas/funciones.php');
include_once('../../../lib/isapres/funciones.php');

//Si es un prestador muestro sólo los que ha hecho el prestador
	$query = "
	SELECT 
		h.`id`, 
		DATE_FORMAT(h.`hora`, '%d-%m-%Y') as fecha,
		 `f_ciudad`(h.ciudad) AS ciudad
	FROM 
		horas h, 
		pacientes p
	WHERE 
		p.`rut`=$rut AND 
		p.`id`=h.`paciente`
	";


$sql = mysql_query($query, $conectar);
 
while($row = mysql_fetch_array($sql))
{
	$idHora = $row[id];
	$fecha = $row[fecha];
	$existe = existeInformeEntrevista($idHora, $conectar);
	$especialidad = especialidadHoraPrestador($idHora, $conectar);
	//Si el resultado es positivo, muestra la agenda antigua
    //if ( daysDifference($FECHA_NUEVO, $fecha) > 0)
    if(restaDosFechas($FECHA_NUEVO, $fecha) > 0 )

    {
		$link[url] = 'chk_informeEntrevistaSegundaDescarga';
	}
	else
	{
		$link[url] = 'chk_informeEntrevistaSegundaDescargaNuevo';
	}
	
	?>
	<tr>
		<td width="201" height="35" align="left" class="letraDocumento" style="padding-left:10px;"><?php echo $row['fecha']; ?>&nbsp;</td>
        <td width="201" height="35" align="left" class="letraDocumento" style="padding-left:10px;"><?php echo $row['ciudad']; ?>&nbsp;</td>
		<td width="66" align="center" class="letraDocumento">
			<?php
			$datosInforme = datosInformeHora($idHora, $conectar);
			$datoshora = datosHora($idHora, $conectar);



			//echo 'isa'.isapreUsuario($_SESSION['idUsuario'], $conectar);


			if(($datosInforme['fechaPublicacion'] == '0000-00-00') &&  ($datosInforme['publicado'] == 'NO' ) && (isapreUsuario($_SESSION['idUsuario'], $conectar) == '4' || isapreUsuario($_SESSION['idUsuario'], $conectar) == '5' ) && (diferenciaHoraActualHora($idHora, $conectar) >= 24)   )

			{
				?>
				<a href="<?php echo $MODULOS; ?>/agenda/chk_ResumeninformeEntrevistaDescarga.php?id=<?php echo $idHora; ?>" title="Resumen Informe " rel="gb_page[700, 600]"><img src="../../../contenido/templates/defecto/imagenes/PreInforme.png" width="16" height="16" border="0" title="header=[Pre Informe] body=[]"/></a>
			<?php }elseif (
				($datosInforme['fechaPublicacion'] == '0000-00-00') &&  ($datosInforme['publicado'] == 'NO' ) && (isapreUsuario($_SESSION['idUsuario'], $conectar) != '4' || isapreUsuario($_SESSION['idUsuario'], $conectar) != '5' ))
			{?>

				<a href="" title="Estado Informe " rel="gb_page[700, 600]"><img src="../../../contenido/templates/defecto/imagenes/Informe.png" width="16" height="16" border="0" title="header=[Informe Sin Publicr] body=[]"/></a>
			<?php }elseif (
				($datosInforme['fechaPublicacion'] != '0000-00-00') &&  ($datosInforme['publicado'] == 'SI' ) && (isapreUsuario($_SESSION['idUsuario'], $conectar) == '4' || isapreUsuario($_SESSION['idUsuario'], $conectar) == '5' ) && $especialidad == 1 )
			{?>

				<a href="<?php echo $MODULOS; ?>/agenda/chk_informeEntrevistaSegundaDescargaNuevo.php?id=<?php echo $idHora; ?>" title="VER Informe " rel="gb_page[700, 600]"><img src="../../../contenido/templates/defecto/imagenes/Informe.png" width="16" height="16" border="0" title="header=[Informe Publicado] body=[]"/></a>
			<?php }elseif (
				($datosInforme['fechaPublicacion'] != '0000-00-00') &&  ($datosInforme['publicado'] == 'SI' ) && (isapreUsuario($_SESSION['idUsuario'], $conectar) != '4' || isapreUsuario($_SESSION['idUsuario'], $conectar) != '5' ) && $especialidad == 1 )
			{?>

				<a href="<?php echo $MODULOS; ?>/agenda/chk_informeEntrevistaSegundaDescargaNuevo.php?id=<?php echo $idHora; ?>" title="VER Informe " rel="gb_page[700, 600]"><img src="../../../contenido/templates/defecto/imagenes/Informe.png" width="16" height="16" border="0" title="header=[Informe Publicado] body=[]"/></a>
			<?php }elseif (
				($datosInforme['fechaPublicacion'] != '0000-00-00') &&  ($publicado == 'SI' ) && (isapreUsuario($_SESSION['idUsuario'], $conectar) != '4' || isapreUsuario($_SESSION['idUsuario'], $conectar) != '5' ) && $especialidad == 2 )
			{?>

				<a href="<?php echo $MODULOS; ?>/agenda/chk_informeEntrevistaTraumatologicoDescarga.php?id=<?php echo $idHora; ?>" title="VER Informe " rel="gb_page[700, 600]"><img src="../../../contenido/templates/defecto/imagenes/Informe.png" width="16" height="16" border="0" title="header=[Informe Traumatologico] body=[]"/></a>
			<?php	}elseif (diferenciaHoraActualHora($idHora, $conectar) >= 72 && $datoshora['asiste']== 'no' ) {	?>
				<a href="<?php echo $MODULOS; ?>/agenda/chk_certificadoInasistencia.php?id=<?php echo $idHora; ?>" title="VER Certificado " rel="gb_page[700, 600]"><img src="../../../contenido/templates/defecto/imagenes/Inasistencia.png" width="16" height="16" border="0" title="header=[Certificado Inasistencia] body=[]"/></a>


			<?php } else {	?>
					
			<?php	}	?>









		</td>

	</tr>
	<?php 
}
?>
</table>
<br />
<table width="400" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
	<tr>
		<td align="center" class="tituloDocumento">
			<label>
			<input name="Button" type="button" class="botonNormal" value="Volver" onclick="window.history.go(-1);"/>
			</label>
		</td>
	</tr>
</table>
