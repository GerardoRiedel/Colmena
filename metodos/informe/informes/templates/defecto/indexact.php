<?php 
////////////////////////////////////////////////////
//Template por defecto
//Autor: cetep
//Fecha CreaciÃ³n: 29-6-2007
//Fecha ModificaciÃ³n:
//Autor ModificaciÃ³n: 
////////////////////////////////////////////////////

session_name("agenda2");
session_start();

if($_SERVER['REQUEST_URI'] != '/'.$CARPETA.'/' and $_SERVER['REQUEST_URI'] != '/'.$CARPETA.'/index.php')
{
	if(siEstaLogueado() == false)
	{
		if(siEstaLogueado() == false)
		{
			header('Location: '.$HOME);
		}
	}
}

include('lib/prestadores/funciones.php');
include('lib/usuarios/funciones.php');
include_once('lib/informe_entrevista/funciones.php');

if($_SESSION['idUsuario'])
{
	$idUsuario = $_SESSION['idUsuario'];
}
else 
{
	$idUsuario = 1;
}

?>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

<!--Ayuda-->
<script type="text/javascript" src="<?php echo $LIB; ?>/boxover.js"></script>
<!--Ayuda-->

<!--GREYBOX-->
<script type="text/javascript">
	var GB_ROOT_DIR = "<?php echo $LIB; ?>/greybox/";
	
	//Evitar Cierre de sesiÃ³n
	//
	function init()
	{
		window.setInterval(ping,15000);                  // 15 segundos
	}
	function ping()
	{
		$('#resultadoPing').load("<?php echo $LIB; ?>/ping.php");
	}
	//
	//Evitar Cierre de sesiÃ³n
</script>

<script type="text/javascript" src="<?php echo $LIB; ?>/greybox/AJS.js"></script>
<script type="text/javascript" src="<?php echo $LIB; ?>/greybox/AJS_fx.js"></script>
<script type="text/javascript" src="<?php echo $LIB; ?>/jquery/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo $LIB; ?>/greybox/gb_scripts.js"></script>
<link href="<?php echo $LIB; ?>/greybox/gb_styles.css" rel="stylesheet" type="text/css" />

<!--GREYBOX-->


<link rel="shortcut icon" href="favicon.ico">
<link href="estilos.css" rel="stylesheet" type="text/css">
<link href="<?php echo $TEMPLATE_DIR.'/'; ?>estilos.css" rel="stylesheet" type="text/css">
<title><?php echo $NOMBRE_SITIO; ?></title>
<table width="100%" height="600" border="0" cellpadding="0" cellspacing="0">
	<tr>
		<td width="19%" align="center" valign="top" style="padding-right:20px;" class="fondoTablaIzquierdaHoras">
			<div id="resultadoPing">&nbsp;</div>		
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td align="left" class="letraDocumento" style="padding-left:15px;"><img src="<?php echo $IMAGENES; ?>/usuario.png" width="16" height="16" /> <span class="letraDocumento"><?php echo tipoUsuario($idUsuario, $conectar);?></span> </td>
				</tr>
			</table>			
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td>
						<?php
							include('contenido/modulos/agenda/modulos/prestadores.php');
							if(tipoUsuario($idUsuario, $conectar) == 'isapre')
							{
								include('contenido/modulos/agenda/modulos/isapres.php');
							}
						?>
					</td>
				</tr>
				<tr>
					<td height="22" align="center">&nbsp;</td>
                    
				</tr>
                <?php if(tipoUsuario($idUsuario, $conectar) == 'administrador' || tipoUsuario($idUsuario, $conectar) == 'secretaria'  ){?>
					
				<tr>
					<td height="32" align="center">
						<a href="<?php echo $MODULOS; ?>/planillas/BMVidatres.php" title="Planillas" rel="gb_page[1100, 500]" id="Abridor"><input name="Button" type="button" class="boton" value="Planilla" style="cursor:pointer;"/></a>
					</td>
				</tr>	
					
			<?php	}?>

                
				<tr>
                 <?php if(tipoUsuario($idUsuario, $conectar) != 'Compin'){?>
					<td height="32" align="center">
						<a href="<?php echo $MODULOS; ?>/agenda/cambiarPass.php" title="Cambiar Contraseña" rel="gb_page[500, 250]" id="Abridor"><input name="Button" type="button" class="boton" value="Contraseña" style="cursor:pointer;"/></a>
					</td>
             			<?php	}?>
				</tr>
                
                
                
				<tr>
					<td height="32" align="center"><input name="Button2" type="button" class="boton" value="Salir" onClick="window.location.href='<?php echo $HOME; ?>/salir.php'" style="cursor:pointer;"/></td>
				</tr>
				<tr>
					<td height="32" align="center">&nbsp;</td>
				</tr>
				<tr>
					<td height="22" align="center">
				<?php 
				//ConfirmaciÃ³n de los informes
				if(tipoUsuario($idUsuario, $conectar) == 'prestador'){
					$prestador = prestadorUsuario($idUsuario, $conectar);
					$informes = siInformesNoConfirmadosPrestador($prestador, $conectar);
					if(count($informes) != NULL){
						$colorTabla = 'tablaRoja';
					}
					else{
						$colorTabla = 'tablaVerde';
					}
					?>
					<table width="159" border="0" align="center" cellpadding="0" cellspacing="0" class="<?php echo $colorTabla; ?>" style="cursor:pointer">
						<tr>
							<td height="25" align="center" onClick="return parent.GB_showCenter('', '<?php echo $MODULOS; ?>/agenda/informesSinConfirmarLista.php?prestador=<?php echo $prestador; ?>', 1000, 950)"><?php echo count($informes); ?> informes por confirmar</td>
						</tr>
					</table>
					<?php 
				}
				?>
					</td>
				</tr>
			</table>
		</td>
		<td width="81%" height="700" align="center" valign="top" style="padding-top:20px; background:url(<?php echo $IMAGENES; ?>/barrita.png) left repeat-y;">
			
			<!--	MENSAJES	-->

			<?php 
				if($_GET['msj'])
				{
					if(is_numeric($_GET['msj']))
					{
			?>
						<br />
						<table width="60%" border="0" align="center" cellpadding="0" cellspacing="0" class="tabla_mensajes">
							<tr>
								<td height="23" align="center" valign="middle" class="letra2"><?php echo mensajes($_GET['msj'], $conectar); ?>								</td>
							</tr>
						</table>
						<br />
			<?php 
					}
				}
			?>
			
			<!--	FIN MENSAJES	-->
			
			
			<?php 
				if($_GET['modulo'] or $_SESSION['idUsuario'])
				{
					if(file_exists('contenido/modulos/'.$_GET['modulo'].'/index.php'))
					{	
						include('contenido/modulos/'.$_GET['modulo'].'/index.php'); 
					}	
				}	
				else
				{	
					include($TEMPLATE_DIR.'/login.php'); 
				}
			?>		
		</td>
	</tr>
</table>