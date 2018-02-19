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
		<td align="center">Informe</td>
		<td align="center">PDF</td>
	</tr>

<?php
//Si es un prestador muestro sólo los que ha hecho el prestador
	$query = "
	SELECT 
		h.`id`, 
		DATE_FORMAT(h.`hora`, '%d-%m-%Y') as fecha 
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
	
	//Si el resultado es positivo, muestra la agenda antigua
    //if ( daysDifference($FECHA_NUEVO, $fecha) > 0)
    if(restaDosFechas($FECHA_NUEVO, $fecha) > 0)

    {
		$link[url] = 'chk_informeEntrevistaSegundaDescarga';
	}
	else
	{
		$link[url] = 'chk_informeEntrevistaSegundaDescargaNuevo';
	}
	
	?>
	<tr>
		<td width="201" height="35" align="left" class="letraDocumento" style="padding-left:10px;"><?php echo $row[fecha]; ?>&nbsp;</td>
		<td width="66" align="center" class="letraDocumento">
		<?php
			if($existe != false)
			{
				?>
				<span align="center" ><span>Peritaje</span></span>
				<?php 
			}
			else
			{
				?>
				<span >Inasistencia</span>
				<?php 
			}
		?>

		</td>
		<td align="center">
			<?php
			if($existe != false)
			{
			?>
			<a href="<?php echo $MODULOS; ?>/agenda/<?php echo $link[url]; ?>.php?id=<?php echo $row[id]; ?>"><img src="<?php echo $IMAGENES2; ?>/Informe.png" width="16" height="16" border="0"/></a>
			<?php
			}
			else
			{
				?>
				<a href="<?php echo $MODULOS; ?>/agenda/<?php echo 'chk_certificadoInasistencia'; ?>.php?id=<?php echo $row[id]; ?>"><img src="<?php echo $IMAGENES2; ?>/Inasistencia.png" width="16" height="16" border="0"/></a>

				<?php
			}
			?>
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
