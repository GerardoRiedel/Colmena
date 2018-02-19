<?php 
////////////////////////////////////////////////////
//Template por defecto
//Autor: Javier Pérez
//Fecha Creación: 29-6-2007
//Fecha Modificación:
//Autor Modificación: 
////////////////////////////////////////////////////

session_name("agenda2");
session_start();

include('../../../lib/funciones.php');

if($_SERVER['REQUEST_URI'] != '/'.$CARPETA.'/' and $_SERVER['REQUEST_URI'] != '/'.$CARPETA.'/index.php')
{
	if(siEstaLogueado() == false)
	{
		header('Location: '.$HOME);
	}
}

include('../../../lib/conectar.php');
$conectar = conectar();
?>

<script language="javascript">
	function cerrar(){
		window.parent.location.reload();
		window.close();
	}
	setTimeout("cerrar();",1300)
</script>
<?php 
	if($_SESSION['msj'])
	{
?>
			<link href="estilos.css" rel="stylesheet" type="text/css" />

			<table width="90%" border="0" align="center" cellpadding="0" cellspacing="0">
				<tr>
					<td height="185" align="center" valign="middle">
						<table width="60%" border="0" align="center" cellpadding="0" cellspacing="0" class="tabla_mensajes">
							<tr>
								<td height="23" align="center" valign="middle" class="letra2"><?php echo $_SESSION['msj']; ?> </td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
			<br />
			<br />
<?php 
	}
	
	$_SESSION['msj'] = NULL;
?>
