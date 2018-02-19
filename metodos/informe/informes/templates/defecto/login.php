<?php 
	include_once('lib/datos.php');

/*
$ew = obtenerNavegadorWeb();

$navegador = $ew['nombre']; //Nombre del Navegador en Uso

$version= $ew['version']; //Version

$plataforma= $ew['platforma']; //Plataforma
*/
$info=detect();
/*
 * echo "Sistema operativo: ".$info["os"]."<br/>";
echo "Navegador: ".$info["browser"]."<br/>";
echo "Versión: ".$info["version"]."<br/>";
echo $_SERVER['HTTP_USER_AGENT']."<br/>";
*/

$navegador = $info['browser']; //Nombre del Navegador en Uso
/*
if ($navegador != 'CHROME' ){
	
echo "<script>alert('Su actual navegador es :" . $navegador .
". Favor utilizar Google Chrome. Haga clic en el icono que aparece debajo del Login');</script>";
}
*/
?>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />

<link href="<?php echo $TEMPLATE_DIR.'/'; ?>estilos.css" rel="stylesheet" type="text/css">
<title><?php echo $NOMBRE_SITIO; ?></title>

<style type="text/css">
<!--
body {
	background-color: #FFFFFF;
}
-->
</style><br /><table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td height="100" align="center" valign="middle"><img src="<?php echo $IMAGENES; ?>/logoAgenda.jpg" width="560" height="82" /></td>
	</tr>
	<tr>
		<td height="234" align="center" valign="middle"><br /><form id="form1" name="form1" method="post" action="chk_login.php">
			<table width="414" height="163" border="0" cellpadding="0" cellspacing="0" style="background:url(<?php echo $IMAGENES; ?>/fondoLogin.png) center no-repeat;">
				<tr>
					<td height="30" colspan="2" align="right" valign="middle" class="letra5">&nbsp;</td>
					</tr>
				<tr>
					<td width="163" height="25" align="right" class="letra5" style="padding-right:5px">Usuario:</td>
					<td width="251" align="left" class="letra5">
						<input name="usuario" type="text" id="usuario" size="20"/>
						<script>
							document.form1.usuario.focus();
						</script>
					</td>
				</tr>
				<tr>
					<td height="25" align="right" class="letra5" style="padding-right:5px">Contrase&ntilde;a: </td>
					<td align="left" class="letra5">
						<input name="pass" type="password" id="pass" size="20" />
					</td>
				</tr>
				<tr>
					<td height="83" colspan="2" align="center" valign="top" style="padding-top:15px; padding-bottom:15px;"><input name="button" type="image" src="<?php echo $IMAGENES; ?>/botonEntrar.png" id="button"/></td>
					</tr>
			</table>
						<br />
						<table width="500" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td width="104" align="center">&nbsp;</td>
								<td width="20" align="left"><a href="ChromeSetup.exe"><img src="<?php echo $IMAGENES; ?>/Google-Chrome-icon16.png" width="16" height="16" border="0" /></a></td>
								<td width="376" align="left" class="letra3"><a href="http://www.google.cl/chrome?hl=es&brand=CHMI">Google Chrome</a></td>
							</tr>
							<tr>
								<td align="center">&nbsp;</td>
								<td align="left"><a href="corrector.php"><img src="<?php echo $IMAGENES; ?>/spellcheck.png" width="16" height="16" border="0" /></a></td>
								<td align="left"><a href="corrector.php" class="letra3">Corrector ortogr&aacute;fico</a></td>
							</tr>
						</table>
		</form>			</td>
	</tr>
</table>
