<?php 
	session_name("agenda2");
session_start();
	
	include_once('../../../lib/usuarios/funciones.php');
	include('../../../lib/querys/ciudades.php');
	include('../../../lib/prestadores/funciones.php');
	include('../../../lib/pacientes/funciones.php');
	include('../../../lib/isapres/funciones.php');
	include('../../../lib/datos.php');
	include('../../../lib/funciones.php');
	include('../../../lib/conectar.php');

	header("Content-type: application/vnd.ms-excel");
	header("Content-Disposition: attachment; filename=Lista de Espera Colmena.xls");
	header("Pragma: no-cache");
	header("Expires: 0");
	
	$conectar = conectar();
	
	//Verifico si el usuario es prestador y lo saco
	if(tipoUsuario($_SESSION['idUsuario'], $conectar) == 'isapre')
	{
		$_SESSION['msj'] = 'No tiene acceso';
		
		header('Location: '.$TEMPLATE_DIR2.'/mensajes.php');
		die();
	}
	
	
	
	$sql = mysql_query("
            SELECT 
                    c.lisFecha,c.lisComuna,c.lisCantidad,comunaine.NombreComuna,c.lisFinLicencia,c.lisFueraPlazo,c.lisGlosa
            FROM 
                    lista_espera_colmena c
            INNER JOIN `comunaine` ON (c.lisComuna = comunaine.codComuna)
            ORDER BY c.lisComuna;

            ", $conectar);
		
?>

<style type="text/css">
<!--
body {
	background-color: #FFFFFF;
}
.letraDocumentoTitulo
{
	font-family: Arial, Helvetica, sans-serif;
	font-size: 14px;
	color: #000000;
	font-weight:bolder;
}
.letraDocumento
{
	font-family: Arial, Helvetica, sans-serif;
	font-size: 13px;
	color: #000000;
}
.tituloDocumento
{
	font-family:"Trebuchet MS", Tahoma, Verdana;
	color:#000000;
	font-size:16px;
	font-weight:bolder;
}

-->
</style>
<table width="1071" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
	
	<tr>
		<td width="150" align="center" class="letraDocumentoTitulo">Comuna</td>
		<td width="150" align="center" class="letraDocumentoTitulo">Fecha Término Licencia</td>
		<td width="150" align="center" class="letraDocumentoTitulo">Fuera de Plazo</td>
		<td width="150" align="center" class="letraDocumentoTitulo">Especialidad</td>
	</tr>
	<?php 
	$i=1;
	
            while($row = mysql_fetch_array($sql))
            {
		$fecha = $row[lisFecha];
                    ?>
    <tr>
       <td align="center"><?php echo $row[NombreComuna]; ?></td><td align="center"><?php echo $row['lisFinLicencia']; ?></td><td align="center"><?php IF ($row[lisFueraPlazo] == '0')echo 'NO'; ELSE IF ($row[lisFueraPlazo] == '1')echo 'SI'; ?></td><td align="center"><?php echo $row['lisGlosa']; ?></td>

    </tr>
            
		<?php 
		$i++;
	}?>
<tr><td colspan="3" align="center" >Fecha Sincronización: <?php echo $fecha; ?></td></tr>
	
</table>
