<?php 
session_name("ugh");
session_start();

include_once('../../../lib/datos.php');
include_once('../../../lib/funciones.php');
include_once('../../../lib/querys/profesionales.php');
include_once('../../../lib/querys/pacientes.php');
include_once('../../../lib/querys/solicitudHospitalizacion.php');
include_once('../../../lib/querys/epicrisis.php');
include_once('../../../lib/querys/evaluacionIngreso.php');
include_once('../../../lib/querys/registros.php');
include_once('../../../lib/querys/formularios.php');
if(siEstaLogueado() == false)
{
	header('Location: '.$HOME);
}

$conectar = conectar();

if (isset($_GET['registro']))
{
	$registro = $_GET['registro'];
	
}elseif (isset($_POST['registro']))
{
	$registro = $_POST['registro'];	
}

$datosRegistro = datosRegistro($registro, $conectar);
$datosPaciente = datosPaciente($datosRegistro[paciente], $conectar);
$datosEpicrisis = datosEpicrisis($registro, $conectar);
$datosEvaluacionIngreso = datosEvaluacionIngresoRegistro($registro, $conectar);
$fechaEdicionFormat = $datosEpicrisis[fechaEdicionFormat];

?>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />

<!--CABECERAS PARA EL CALENDARIO-->
    <link rel="stylesheet" type="text/css" href="<?php echo $HOME; ?>/lib/JSCal2/src/css/jscal2.css" />
	<link rel="stylesheet" type="text/css" media="all" href="<?php echo $HOME; ?>/lib/JSCal2/src/css/border-radius.css" title="win2k-cold-1" />
    <link rel="stylesheet" type="text/css" href="<?php echo $HOME; ?>/lib/JSCal2/src/css/win2k/win2k.css" />
	
    <script src="<?php echo $HOME; ?>/lib/JSCal2/src/js/jscal2.js"></script>
	<script type="text/javascript" src="<?php echo $HOME; ?>/lib/JSCal2/src/js/lang/es.js"></script>
<!--FIN CABECERAS PARA EL CALENDARIO-->

<!--Ayuda-->
<script type="text/javascript" src="<?php echo $LIB; ?>/boxover.js"></script>
<!--Ayuda-->

<!--Ocultar/Mostrar-->
<script type="text/javascript" src="<?php echo $LIB; ?>/jquery/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo $LIB; ?>/animatedcollapse.js"></script>
<script type="text/javascript" src="<?php echo $LIB; ?>/numeros.js"></script>

<script>
//Animaciones
//
animatedcollapse.addDiv('cont', 'fade=0');
animatedcollapse.addDiv('cont2', 'fade=0');
animatedcollapse.addDiv('evaluacionDiariaCal', 'fade=0');
animatedcollapse.ontoggle=function($, divobj, state){ //fires each time a DIV is expanded/contracted
	//$: Access to jQuery
	//divobj: DOM reference to DIV being expanded/ collapsed. Use "divobj.id" to get its ID
	//state: "block" or "none", depending on state
}
animatedcollapse.init()

window.moveTo(0, 0);
window.resizeTo(window.screen.width, window.screen.height - 25);


function confirmarDespublicacionEvaluacionIngreso(id)
{
	if(confirm('Para Despublicar el informe presione en "Aceptar"'))
	{
			var JQR = jQuery.noConflict ();
			JQR("#contenido").load("<?php echo $MODULOS; ?>/formularios/chk_despublicaEvaluacionIngreso.php", { 
			id: id,  registro: "<?php echo $registro;?>"
			});
	}
}


function confirmarPublicacionEvaluacionIngreso(id)
{
	if(confirm('Para publicar el informe presione en "Aceptar"'))
	{
			var JQR = jQuery.noConflict ();
			JQR("#contenido").load("<?php echo $MODULOS; ?>/formularios/chk_publicaEvaluacionIngreso.php", { 
			id: id,  registro: "<?php echo $registro;?>"
			});
	}
}

function confirmarDespublicacionEpicrisis(id)
{
	if(confirm('Para Despublicar el informe presione en "Aceptar"'))
	{
			var JQR = jQuery.noConflict ();
			JQR("#contenido").load("<?php echo $MODULOS; ?>/formularios/chk_despublicaEpicrisis.php", { 
			id: id,  registro: "<?php echo $registro;?>"
			});
	}
}


function confirmarPublicacionEpicrisis(id)
{
	if(confirm('Para publicar el informe presione en "Aceptar"'))
	{
			var JQR = jQuery.noConflict ();
			JQR("#contenido").load("<?php echo $MODULOS; ?>/formularios/chk_publicaEpicrisis.php", { 
			id: id,  registro: "<?php echo $registro;?>"
			});
	}
}



</script>

<link href="../../templates/defecto/estilos.css" rel="stylesheet" type="text/css" />
<link href="../../templates/defecto/dropdown.css" rel="stylesheet" type="text/css" />
<!--script type="text/javascript" src="../../templates/defecto/js/modernizr.custom.79639.js"></script> 
<noscript><link rel="stylesheet" type="text/css" href="../../templates/defecto/noJS.css" /></noscript-->

<body style="background:#FFF;" onLoad="self.focus()">
<br>
<div id="contenido">
<table width="700" border="0" align="center" cellpadding="0" cellspacing="0">
	<tr>
		<td align="center" class="tituloPrincipal2"><?php echo $datosPaciente[nombres].' '.$datosPaciente[apellidoPaterno].' '.$datosPaciente[apellidoMaterno]; ?>&nbsp;</td>
	</tr>
</table>
<br>
<table width="536" border="0" align="center" cellpadding="0" cellspacing="0" id="cambio_color" style="border-collapse:collapse">
  <tr>
    <td colspan="5" align="center" class="tituloTablas">Formularios</td>
  </tr>
  <tr>
  	<td height="25" align="center"><?php if(existeInformeEspecial($registro,$conectar)>0){?><a href="informeEspecialLista.php?registro=<?php echo $registro; ?>"><img src="<?php echo $IMAGENES2 ?>/lupa.png" alt="" width="16" height="16" border="0" title="header=[Ver listado de informes] body=[]"></a><?php }?></td>
  	<td colspan="4" class="tablaLetraContenidoIzquierda"> Informe Especial</td>
  	</tr>
  <tr>
  	<td height="25" align="center"><?php if(existeEvaluacionClinica($registro,$conectar)>0){?><a href="evaluacionDiariaLista.php?registro=<?php echo $registro; ?>"><img src="<?php echo $IMAGENES2 ?>/lupa.png" alt="" width="16" height="16" border="0" title="header=[Ver listado de informes] body=[]"></a><?php }?></td>
  	<td colspan="4"  class="tablaLetraContenidoIzquierda">
	    Evaluación Cl&iacute;nica</td>
  	</tr>
  <tr>
  	<td height="25" align="center"><?php 
	if($datosEvaluacionIngreso[id] != NULL || $_SESSION['nombreUsuario']=='terapeuta')
	{
		 $publicadoEvaluacionIngreso = $datosEvaluacionIngreso[publicado];
	?>
	<div class="dropdown" id="dropdown">
				<input type="checkbox" id="drop1" />
        <label for="drop1" class="dropdown_button"><img src="<?php echo $IMAGENES2 ?>/lupa.png" alt="" width="16" height="16" border="0"></label>
        <ul class="dropdown_content">
            <li><a href="/ugh/contenido/modulos/formularios/evaluacionIngresoPDF.php?registro=<?php echo $registro ?>">Evaluaci&oacute;n de ingreso</a></li>
            <li><a href="/ugh/contenido/modulos/formularios/evaluacionIngresoPDFresumen.php?registro=<?php echo $registro ?>">Resumen</a></li>
        </ul>
	</div>
	
	
	<?php 
	}
	?></td>
  	<td class="tablaLetraContenidoIzquierda"> Evaluaci&oacute;n de Ingreso</td>
    
    
            <td width="77" height="25" valign="middle" align="center">
         <a href="#" onClick="javascript:confirmarPublicacionEvaluacionIngreso(<?php echo $datosEvaluacionIngreso[id];?>);">Publicar</a>
            </td> 
            <td width="111" height="25" valign="middle" align="center">
         <a href="#" onClick="javascript:confirmarDespublicacionEvaluacionIngreso(<?php echo $datosEvaluacionIngreso[id];?>);">Despublicar</a>
            </td> 

            <td width="105" height="25" valign="middle" align="center">
				<?php echo $publicadoEvaluacionIngreso;?>&nbsp;
            </td>            
    
    
  	</tr>
  <tr>
  	<td width="52" height="25" align="center"><?php if(existeInformeIsapre($registro,$conectar)>0){?><a href="evaluacionClinicaSemanalLista.php?registro=<?php echo $registro; ?>"><img src="<?php echo $IMAGENES2 ?>/lupa.png" alt="" width="16" height="16" border="0" title="header=[Ver listado de informes] body=[]"></a><?php }?></td>
  	<td colspan="4"  class="tablaLetraContenidoIzquierda"> Informe a Isapre</td>
  	</tr>
  <tr>
  	<td height="25" align="center">
	<?php 
	 if($datosEpicrisis[id] != NULL || $_SESSION['nombreUsuario']=='terapeuta')
	{
		$publicadoEpicrisis = $datosEpicrisis[publicado];
	?>
	<div class="dropdown" id="dropdown">
				<input type="checkbox" id="drop2" />
        <label for="drop2" class="dropdown_button"><img src="<?php echo $IMAGENES2 ?>/lupa.png" alt="" width="16" height="16" border="0"></label>
        <ul class="dropdown_content">
            <li><a href="/ugh/contenido/modulos/formularios/epicrisisPDF.php?registro=<?php echo $registro ?>&epicrisis=<?php echo $datosEpicrisis[id]; ?>">Epicrisis</a></li>
            <li><a href="/ugh/contenido/modulos/formularios/epicrisisPDFresumen.php?registro=<?php echo $registro ?>&epicrisis=<?php echo $datosEpicrisis[id]; ?>">Resumen</a></li>
        </ul>
	</div>
	   
	<?php 
	}
	?>
    </td>
  	<td class="tablaLetraContenidoIzquierda">Epicrisis&nbsp;&nbsp;
    </td>
    

            <td width="77" height="25" valign="middle" align="center">
         <a href="#" onClick="javascript:confirmarPublicacionEpicrisis(<?php echo $datosEpicrisis[id];?>);">Publicar</a>
            </td> 
            <td width="111" height="25" valign="middle" align="center">
         <a href="#" onClick="javascript:confirmarDespublicacionEpicrisis(<?php echo $datosEpicrisis[id];?>);">Despublicar</a>
            </td> 

            <td width="105" height="25" valign="middle" align="center">
				<?php echo $publicadoEpicrisis;?>&nbsp;
            </td>            
    
    
    
    
  	</tr>
	<?php
	//Si la epicrisis tiene derivación
	if(siExisteEpicrisis($registro, $conectar) != false)
	{
		$datosEpicrisis = datosEpicrisis($registro, $conectar);
		if($datosEpicrisis[derivacion] == 'Hospital de día' or $datosEpicrisis[derivacion] == 'Corta estadía')
		{
			$datosSolicitudHospitalizacion = datosSolicitudHospitalizacion($registro, $conectar);
			
			$fechaEdicion = $datosSolicitudHospitalizacion[fechaEdicionFormatDate];
			if($fechaEdicion == '0000-00-00')
			{
				$fechaEdicion = NULL;
			}
				?>
				<tr>
					<td height="25" align="center"><?php 
					if($datosSolicitudHospitalizacion[id] != NULL)
					{
					?>
                    <a href="/ugh/contenido/modulos/formularios/solicitudHospitalizacionPDF.php?registro=<?php echo $registro ?>&solicitudHospitalizacion=<?php echo $datosSolicitudHospitalizacion[id]; ?>" class="letraNormal"><img src="<?php echo $IMAGENES2 ?>/lupa.png" alt="" width="16" height="16" border="0"></a><?php 
					}
					?></td>
					<td colspan="4"  class="tablaLetraContenidoIzquierda"> Solicitud de Hospitalizaci&oacute;n</td>
				</tr>
				<?php 

		}
	}
	?>
</table>
</div>
</body>