<?php 
	session_name("agenda2");
	session_start();

	include_once('../../../lib/usuarios/funciones.php');
	include_once('../../../lib/prestadores/funciones.php');
	include_once('../../../lib/datos.php');
	include_once('../../../lib/funciones.php');
	include_once('../../../lib/conectar.php');
	
	$conectar = conectar();
	
?>
<script language="javascript" src="<?php echo $LIB; ?>/numeros.js"></script>

<script language="javascript">
function eliminar(id)
{
	if(confirm('¿Está seguro de eliminar este usuario?'))
	{
		window.location.href = 'chk_eliminarUsuario.php?id=' + id;
	}
}
function eliminarPrestador(id, prestador)
{
	if(confirm('¿Está seguro de eliminar este prestador?'))
	{
		window.location.href = 'chk_eliminarUsuario.php?id=' + id + '&prestador=' + prestador;
	}
}
</script>

<link href="../../templates/defecto/estilos.css" rel="stylesheet" type="text/css">

<?php include('../../../lib/mensajes.php'); ?>

<br />
<table width="90%" border="0" align="center" cellpadding="0" cellspacing="0">
	<tr>
		<td align="center" class="titulo3">Listado de usuarios </td>
	</tr>
</table>
<table width="90%" border="0" align="center" cellpadding="0" cellspacing="0">
	<tr>
		<td height="26" align="right" valign="bottom" class="letraDocumentoTitulo"><a href="agregarUsuario.php">+ Agregar usuario </a></td>
	</tr>
</table>
<form id="form1" name="form1" method="post" action="buscadorPeritajes2.php" onsubmit="return validar(this);">
	<table width="90%" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF" class="borde_tabla" id="cambio_color" style="border-collapse:collapse;">
		<tr>
			<td height="30" align="center">&nbsp;</td>
			<td align="center" class="letraDocumentoTitulo">Usuario</td>
			<td align="center" class="letraDocumentoTitulo">Tipo</td>
		</tr>
		<?php
		$sql = mysql_query("
		SELECT 
			u.`id`
		FROM 
			usuarios u
		WHERE
			u.`activo`='si'
		ORDER BY 
			u.`tipo`, u.`usuario` ASC
		", $conectar);
		 
		while($row = mysql_fetch_array($sql))
		{
			$id = $row[id];
			$nombreUsuario = nombreUsuario($id, $conectar);
			$tipoUsuario = tipoUsuario($id, $conectar);
			$linkEditar = 'editarUsuario.php?id='.$id;
			$linkEliminar = 'eliminar('.$id.')';
			
			if($tipoUsuario == 'prestador')
			{
				$idPrestador = prestadorUsuario($id, $conectar);
				
				//si el prestador no completó el proceso de ingreso, el idPrestador = 0
				if($idPrestador == NULL)
				{
					$idPrestador = 0;
				}
				
				$linkEditar = 'editarUsuarioPrestador.php?id='.$idPrestador;
				$linkEliminar = 'eliminarPrestador('.$id.', '.$idPrestador.')';
			}
			?>
			<tr class="fondo_grid1">
				<td height="30" align="center">
					<img src="../../templates/defecto/imagenes/no.png" width="15" height="15" onclick="<?php echo $linkEliminar; ?>;" style="cursor:pointer;"/>&nbsp;&nbsp;
					<a href="<?php echo $linkEditar; ?>"><img src="../../templates/defecto/imagenes/edit.png" width="15" height="15" border="0"/></a> </td>
				<td width="44%" align="left" class="letraDocumento" style="padding-left:10px;"><?php echo $nombreUsuario; ?>&nbsp;</td>
				<td width="44%" align="left" class="letraDocumento"style="padding-left:10px;"><?php echo $tipoUsuario; ?>&nbsp;</td>
			</tr>
			<?php 
		}
		?>
	</table>
</form>
