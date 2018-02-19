<?php 
	session_name("agenda2");
	session_start();
	
	include('../../../lib/pacientes/funciones.php');
	include('../../../lib/isapres/funciones.php');
	include('../../../lib/usuarios/funciones.php');
	include('../../../lib/horas/funciones.php');
	include('../../../lib/informe_entrevista/funciones.php');
	include('../../../lib/querys/comunas.php');
	include('../../../lib/datos.php');
	include('../../../lib/funciones.php');
	include('../../../lib/conectar.php');
	
	$conectar = conectar();
	
	//Verifico si el usuario es isapre y lo saco
	if(tipoUsuario($_SESSION['idUsuario'], $conectar) == 'isapre')
	{
		$_SESSION['msj'] = 'No tiene acceso';
		
		header('Location: '.$TEMPLATE_DIR2.'/mensajes.php');
		die();
	}
	
	$idHora = $_GET['hora'];
	
	$existe = false;

	if(existeInformeEntrevista($idHora, $conectar) != false)
	{
		$existe = true;
	
		$sqlDatos = mysql_query("
		SELECT 
			i.`id`, 
			i.`paciente`, 
			i.`prestador`, 
			i.`hora`, 
			i.`fecha`, 
			i.`ocupacion`, 
			i.`sexo`, 
			i.`edad`, 
			i.`tiempoLicencia`, 
			i.`medicoTratante`, 
			i.`nombreMedicoTratante`, 
			i.`numeroLicencia`, 
			i.`antecedentesPersonales`, 
			i.`antecedentesMorbidos`, 
			i.`factoresEstresantes`, 
			i.`anamnesis`, 
			i.`examenMental`, 
			i.`tratamientoActual`, 
			i.`opinionTratamiento`, 
			i.`comentarios`, 
			i.`diagnosticoLicenciaMedica`,
			i.`opinionSobreDiagnostico`, 
			i.`comentariosDLM`, 
			i.`eje1`, 
			i.`eje2`, 
			i.`eje3`, 
			i.`eje4`, 
			i.`eje5`, 
			i.`diasAcumulados`, 
			i.`fechaInicioUL`, 
			i.`diasReposoIndicados`, 
			i.`correspondeReposo`, 
			i.`periodo`, 
			i.`comentarios2`
		FROM 
			informe_entrevista i
		WHERE 
			i.`hora`=".$idHora."
		", $conectar);
		
		$rowDatos = mysql_fetch_array($sqlDatos);
		
		$id = $rowDatos[id];
		
		$idPaciente = $rowDatos[paciente];
		$idPestador = $rowDatos[prestador];
		$fecha = VueltaFecha($rowDatos[fecha]);
		$ocupacion = $rowDatos[ocupacion];
		$sexo = $rowDatos[sexo];
		$edad = $rowDatos[edad];
		$tiempoLicencia = $rowDatos[tiempoLicencia];
		$medicoTratante = caracteres_html_inversa($rowDatos[medicoTratante]);
		$nombreMedicoTratante = caracteres_html_inversa($rowDatos[nombreMedicoTratante]);
		$numeroLicencia = $rowDatos[numeroLicencia];
		$antecedentesPersonales = caracteres_html_inversa($rowDatos[antecedentesPersonales]);
		$antecedentesMorbidos = caracteres_html_inversa($rowDatos[antecedentesMorbidos]);
		$factoresEstresantes = caracteres_html_inversa($rowDatos[factoresEstresantes]);
		$anamnesis = caracteres_html_inversa($rowDatos[anamnesis]);
		$examenMental = caracteres_html_inversa($rowDatos[examenMental]);
		$tratamientoActual = caracteres_html_inversa($rowDatos[tratamientoActual]);
		$opinionTratamiento = caracteres_html_inversa($rowDatos[opinionTratamiento]);
		$comentarios = caracteres_html_inversa($rowDatos[comentarios]);
		$diagnosticoLicenciaMedica = caracteres_html_inversa($rowDatos[diagnosticoLicenciaMedica]);
		$opinionSobreDiagnostico = caracteres_html_inversa($rowDatos[opinionSobreDiagnostico]);
		$comentariosDLM = caracteres_html_inversa($rowDatos[comentariosDLM]);
		$eje1 = caracteres_html($rowDatos[eje1]);
		$eje2 = caracteres_html_inversa($rowDatos[eje2]);
		$eje3 = caracteres_html_inversa($rowDatos[eje3]);
		$eje4 = caracteres_html_inversa($rowDatos[eje4]);
		$eje5 = caracteres_html_inversa($rowDatos[eje5]);
		$diasAcumulados = $rowDatos[diasAcumulados];
		if($diasAcumulados == 0)
		{
			$diasAcumulados = NULL;
		}
		$fechaInicioUL = VueltaFecha($rowDatos[fechaInicioUL]);
		$diasReposoIndicados = $rowDatos[diasReposoIndicados];
		if($diasReposoIndicados == 0)
		{
			$diasReposoIndicados = NULL;
		}
		$correspondeReposo = $rowDatos[correspondeReposo];
		$periodo = $rowDatos[periodo];
		$comentarios2 = caracteres_html_inversa($rowDatos[comentarios2]);
	}
	
	$idPacienteHora = idPacienteHora($idHora, $conectar);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<!--SCRIPTS-->
	<script type="text/javascript" src="<?php echo $LIB; ?>/ajax.js"></script>
	<script type="text/javascript" src="<?php echo $LIB; ?>/autocompletar_cie10.js"></script>
<!--FIN SCRIPTS-->

<!--CABECERAS PARA EL CALENDARIO-->
	<!-Hoja de estilos del calendario -->
	<link rel="stylesheet" type="text/css" media="all" href="<?php echo $HOME; ?>/lib/calendar-blue.css" title="win2k-cold-1" />
	
	<!-- librería principal del calendario -->
	<script type="text/javascript" src="<?php echo $HOME; ?>/lib/calendar.js"></script>
	
	<!-- librería para cargar el lenguaje deseado -->
	<script type="text/javascript" src="<?php echo $HOME; ?>/lib/calendar-es.js"></script>
	
	<!-- librería que declara la función Calendar.setup, que ayuda a generar un calendario en unas pocas líneas de código -->
	<script type="text/javascript" src="<?php echo $HOME; ?>/lib/calendar-setup.js"></script> 

<!--FIN CABECERAS PARA EL CALENDARIO-->

<script language="javascript" src="../../../lib/boxover.js"></script>
<script language="javascript" src="../../../lib/numeros.js"></script>
<script language="javascript" src="../../../lib/validaforms.js"></script>
<script language="javascript" src="../../../lib/ocultarmostrar.js"></script>
<script src="../../../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<script src="../../../SpryAssets/SpryValidationTextarea.js" type="text/javascript"></script>
<script src="../../../SpryAssets/SpryValidationSelect.js" type="text/javascript"></script>
<script>
<?php 
//AUTOGUARDADO SÓLO PARA PERITOS
//
if(tipoUsuario($_SESSION['idUsuario'], $conectar) == 'prestador' and existeInformeEntrevista($idHora, $conectar) == false)
{
	?>
	function init()
	{
		window.setInterval(autoSave,30000);                  // 30 segundos
		alert('    ATENCION\n\n1. El informe se autoguardará cada 30 segundos. Cuando finalice presione el botón Guardar que se encuentra al final del informe.\n2. Al presionar Guardar se dirigirá automáticamente a la versión final del informe, por favor revise el resultado.');
	}

	function autoSave()
	{
		var idHora = document.getElementById("idHora").value;
		var fecha = document.getElementById("fecha").value;
		var ocupacion = document.getElementById("ocupacion").value;
		var sexo = document.getElementById("sexo").value;
		var edad = document.getElementById("edad").value;
		var medicoTratante = document.getElementById("medicoTratante").value;
		var nombreMedicoTratante = document.getElementById("nombreMedicoTratante").value;
		var numeroLicencia = document.getElementById("numeroLicencia").value;
		var antecedentesPersonales = document.getElementById("antecedentesPersonales").value;
		var antecedentesMorbidos = document.getElementById("antecedentesMorbidos").value;
		var factoresEstresantes = document.getElementById("factoresEstresantes").value;
		var anamnesis = document.getElementById("anamnesis").value;
		var examenMental = document.getElementById("examenMental").value;
		var tratamientoActual = document.getElementById("tratamientoActual").value;
		var opinionTratamiento = document.getElementById("opinionTratamiento").value;
		var comentarios = document.getElementById("comentarios").value;
		var diagnosticoLicenciaMedica = document.getElementById("diagnosticoLicenciaMedica").value;
		var opinionSobreDiagnostico = document.getElementById("opinionSobreDiagnostico").value;
		var comentariosDLM = document.getElementById("comentariosDLM").value;
		var eje1 = document.getElementById("eje1").value;
		var eje2 = document.getElementById("eje2").value;
		var eje3 = document.getElementById("eje3").value;
		var eje4 = document.getElementById("eje4").value;
		var eje5 = document.getElementById("eje5").value;
		var diasAcumulados = document.getElementById("diasAcumulados").value;
		var fechaInicioUL = document.getElementById("fechaInicioUL").value;
		var diasReposoIndicados = document.getElementById("diasReposoIndicados").value;
		var correspondeReposo = document.getElementById("correspondeReposo").value;
		var periodo = document.getElementById("periodo").value;
		var comentarios2 = document.getElementById("comentarios2").value;
				
		var params = "idHora="+idHora+"&fecha="+fecha+"&ocupacion="+ocupacion+"&sexo="+sexo+"&edad="+edad+"&medicoTratante="+medicoTratante+"&nombreMedicoTratante="+nombreMedicoTratante+"&numeroLicencia="+numeroLicencia+"&antecedentesPersonales="+antecedentesPersonales+"&antecedentesMorbidos="+antecedentesMorbidos+"&factoresEstresantes="+factoresEstresantes+"&anamnesis="+anamnesis+"&examenMental="+examenMental+"&tratamientoActual="+tratamientoActual+"&opinionTratamiento="+opinionTratamiento+"&comentarios="+comentarios+"&diagnosticoLicenciaMedica="+diagnosticoLicenciaMedica+"&opinionSobreDiagnostico="+opinionSobreDiagnostico+"&comentariosDLM="+comentariosDLM+"&eje1="+eje1+"&eje2="+eje2+"&eje3="+eje3+"&eje4="+eje4+"&eje5="+eje5+"&diasAcumulados="+diasAcumulados+"&fechaInicioUL="+fechaInicioUL+"&diasReposoIndicados="+diasReposoIndicados+"&correspondeReposo="+correspondeReposo+"&periodo="+periodo+"&comentarios2="+comentarios2;
				
		var http = getHTTPObject();
		http.onreadystatechange = function(){
			if(http.readyState==4 && http.status==200){
				msg = document.getElementById("msg");
				var ahora = new Date();
				msg.innerHTML = "<span style=\"background-color:#FFFFE8;\">Informe autoguardado a las "+ahora.getHours()+":"+ahora.getMinutes()+":"+ahora.getSeconds()+"&nbsp;&nbsp;&nbsp;&nbsp;</span>";
			}
			else
			{
				msg = document.getElementById("msg");
				var ahora = new Date();
				msg.innerHTML = "<span style=\"background-color:#FFB0B0\">No se ha guardado el informe</span>";
			}
		};
		http.open("POST", 'chk_informeEntrevistaSegundaAutoNuevo.php', true);
		http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		http.setRequestHeader("Content-length", params.length);
		http.setRequestHeader("Connection", "close");
		http.send(params);
	}
	
	//cross-browser xmlHTTP getter
	function getHTTPObject() 
	{ 
		var xmlhttp; 
		
		if (!xmlhttp && typeof XMLHttpRequest != 'undefined') 
		{ 
			try 
			{   
				xmlhttp = new XMLHttpRequest(); 
			}
			catch (e)
			{ 
				xmlhttp = false; 
			} 
		} 
		
		return xmlhttp;
	}
<?php 
}
?>
	function cambiarReposo(form)
	{
		if(form.opinionReposoMedico.value == 'SI CORRESPONDE')
		{
			form.siReposoCorresponde.disabled = false;
		}
		else
		{
			form.siReposoCorresponde.disabled = true;
		}
	}
	
	function cambiarCorrespondeReposo(form)
	{
		if(form.correspondeReposo.value == 'SI')
		{
			muestraTabla('tablaCorrespondeReposo');
			form.periodo.disabled = false;
		}
		else
		{
			ocultaTabla('tablaCorrespondeReposo');
			form.periodo.disabled = true;
		}
	}
	

	function publicar(idHora)
	{
	window.location.href = '<?php echo $MODULOS; ?>/agenda/chk_informeEntrevistaNuevoPublica.php?idHora='+ idHora;
	}

	function despublicar(idHora)
	{
	window.location.href = '<?php echo $MODULOS; ?>/agenda/chk_informeEntrevistaNuevoDesPublica.php?idHora='+ idHora;
	}



	function grabaCamposInforme()
	{
		var idHora = document.getElementById("idHora").value;
		var fecha = document.getElementById("fecha").value;
		var ocupacion = document.getElementById("ocupacion").value;
		var sexo = document.getElementById("sexo").value;
		var edad = document.getElementById("edad").value;
		var medicoTratante = document.getElementById("medicoTratante").value;
		var nombreMedicoTratante = document.getElementById("nombreMedicoTratante").value;
		var numeroLicencia = document.getElementById("numeroLicencia").value;
		var antecedentesPersonales = document.getElementById("antecedentesPersonales").value;
		var antecedentesMorbidos = document.getElementById("antecedentesMorbidos").value;
		var factoresEstresantes = document.getElementById("factoresEstresantes").value;
		var anamnesis = document.getElementById("anamnesis").value;
		var examenMental = document.getElementById("examenMental").value;
		var tratamientoActual = document.getElementById("tratamientoActual").value;
		var opinionTratamiento = document.getElementById("opinionTratamiento").value;
		var comentarios = document.getElementById("comentarios").value;
		var diagnosticoLicenciaMedica = document.getElementById("diagnosticoLicenciaMedica").value;
		var opinionSobreDiagnostico = document.getElementById("opinionSobreDiagnostico").value;
		var comentariosDLM = document.getElementById("comentariosDLM").value;
		var eje1 = document.getElementById("eje1").value;
		var eje2 = document.getElementById("eje2").value;
		var eje3 = document.getElementById("eje3").value;
		var eje4 = document.getElementById("eje4").value;
		var eje5 = document.getElementById("eje5").value;
		var diasAcumulados = document.getElementById("diasAcumulados").value;
		var fechaInicioUL = document.getElementById("fechaInicioUL").value;
		var diasReposoIndicados = document.getElementById("diasReposoIndicados").value;
		var correspondeReposo = document.getElementById("correspondeReposo").value;
		var periodo = document.getElementById("periodo").value;
		var comentarios2 = document.getElementById("comentarios2").value;
				
		var params = "idHora="+idHora+"&fecha="+fecha+"&ocupacion="+ocupacion+"&sexo="+sexo+"&edad="+edad+"&medicoTratante="+medicoTratante+"&nombreMedicoTratante="+nombreMedicoTratante+"&numeroLicencia="+numeroLicencia+"&antecedentesPersonales="+antecedentesPersonales+"&antecedentesMorbidos="+antecedentesMorbidos+"&factoresEstresantes="+factoresEstresantes+"&anamnesis="+anamnesis+"&examenMental="+examenMental+"&tratamientoActual="+tratamientoActual+"&opinionTratamiento="+opinionTratamiento+"&comentarios="+comentarios+"&diagnosticoLicenciaMedica="+diagnosticoLicenciaMedica+"&opinionSobreDiagnostico="+opinionSobreDiagnostico+"&comentariosDLM="+comentariosDLM+"&eje1="+eje1+"&eje2="+eje2+"&eje3="+eje3+"&eje4="+eje4+"&eje5="+eje5+"&diasAcumulados="+diasAcumulados+"&fechaInicioUL="+fechaInicioUL+"&diasReposoIndicados="+diasReposoIndicados+"&correspondeReposo="+correspondeReposo+"&periodo="+periodo+"&comentarios2="+comentarios2;
				
		var http = getHTTPObject();
		http.onreadystatechange = function(){
			if(http.readyState==4 && http.status==200){
				msg = document.getElementById("msg");
				var ahora = new Date();
				msg.innerHTML = "<span style=\"background-color:#FFFFE8;\">Informe guardado por usted a las "+ahora.getHours()+":"+ahora.getMinutes()+":"+ahora.getSeconds()+"&nbsp;&nbsp;&nbsp;&nbsp;</span>";
			}
			else
			{
				msg = document.getElementById("msg");
				var ahora = new Date();
				msg.innerHTML = "<span style=\"background-color:#FFB0B0\">No se ha guardado el informe</span>";
			}
		};
		http.open("POST", 'chk_informeEntrevistaSegundaAutoNuevo.php', true);
		http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		http.setRequestHeader("Content-length", params.length);
		http.setRequestHeader("Connection", "close");
		http.send(params);
	}

	//cross-browser xmlHTTP getter
	function getHTTPObject() 
	{ 
		var xmlhttp; 
		
		if (!xmlhttp && typeof XMLHttpRequest != 'undefined') 
		{ 
			try 
			{   
				xmlhttp = new XMLHttpRequest(); 
			}
			catch (e)
			{ 
				xmlhttp = false; 
			} 
		} 
		
		return xmlhttp;
	}
</script>

<link href="../../templates/defecto/estilos.css" rel="stylesheet" type="text/css">
<link href="../../../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
<link href="../../../SpryAssets/SpryValidationTextarea.css" rel="stylesheet" type="text/css" />
<link href="../../../SpryAssets/SpryValidationSelect.css" rel="stylesheet" type="text/css" />
</head>
<body <?php if(tipoUsuario($_SESSION['idUsuario'], $conectar) == 'prestador' and existeInformeEntrevista($idHora, $conectar) == false){?>onLoad="init();"<?php }?>>

<div id="topPaciente">
<table border="1" align="left" cellpadding="0" cellspacing="0" style="border-collapse:collapse; background-color:#FFF;">
	<tr>
		<td height="23" align="left" bgcolor="#FFFFE8" class="letra7">Paciente: <span class="letraDocumentoTitulo"><?php echo caracteres_html(nombreCompletoPaciente($idPacienteHora, $conectar)); ?></span></td>
	</tr>
</table>
</div>

<div id="topMensajeAutoguardado">
	<table width="250" align="right" border="0"cellpadding="0" cellspacing="0" class="letraDocumentoTitulo" id="msg">
		<tr>
			<td></td>
		</tr>
	</table>
</div>

<br />
<form id="form1" name="form1" method="post" action="chk_informeEntrevistaSegundaNuevo.php">
<table width="474" border="0" align="center" cellpadding="0" cellspacing="0" class="borde_tabla" style="border-collapse:collapse;">
		<tr>
			<td height="29" colspan="2" align="center" class="tituloTablas">Informe de Entrevista Psiqui&aacute;trica de Peritaje </td>
		</tr>
		<tr>
			<td width="191" height="25" align="right" class="letra7" style="padding-right:10px;">Fecha:</td>
			<td width="235" class="letra7" style="padding-left:10px;">
				<input name="fecha" type="text" class="letra7" id="fecha" value="<?php if($existe == true){echo $fecha;}else
{echo date('d-m-Y');}?>" size="17" maxlength="15" readonly="readonly"/>
				<img src="<?php echo $IMAGENES2; ?>/b_calendar.png" alt="ayuda" width="15" height="15" title="header=[Fecha] body=[Presione para ver el calendario]" id="lanzador"/>
				</label>
				<!-- script que define y configura el calendario-->
				<script type="text/javascript">
				   Calendar.setup({
					inputField     :    "fecha",     // id del campo de texto
					ifFormat     :     "%d-%m-%Y",     // formato de la fecha que se escriba en el campo de texto
					button     :    "lanzador"     // el id del bot&oacute;n que lanzar&aacute; el calendario
				});
				</script>			</td>
		</tr>
		<tr>
			<td width="191" height="25" align="right" class="letra7" style="padding-right:10px;">Ocupaci&oacute;n:</td>
			<td class="letra7" style="padding-left:10px;">
				<label>
				<select name="ocupacion" class="letra7" id="ocupacion">
				<?php 
				if($existe == true)
				{
					?>
					<option value="<?php echo $ocupacion; ?>" selected="selected"><?php echo $ocupacion; ?></option>
					<?php 
				}
				?>
					<option value="TECNICO">TECNICO</option>
					<option value="ADMINISTRATIVO">ADMINISTRATIVO</option>
					<option value="PROFESIONAL">PROFESIONAL</option>
					<option value="VENDEDOR">VENDEDOR</option>
					<option value="EMPRESARIO">EMPRESARIO</option>
					<option value="OTRO">OTRO</option>
				</select>
				</label>
			</td>
		</tr>
		<tr>
			<td height="25" align="right" class="letra7" style="padding-right:10px;">Sexo:</td>
			<td class="letra7" style="padding-left:10px;"><select name="sexo" class="letra7" id="sexo">
				<?php 
				if($existe == true)
				{
					?><option value="<?php echo $sexo; ?>" selected="selected"><?php echo $sexo; ?></option><?php 
				}
				?>
				<option value="M">M</option>
				<option value="F">F</option>
			</select></td>
		</tr>
		<tr>
			<td height="25" align="right" class="letra7" style="padding-right:10px;">Edad:</td>
			<td class="letra7" style="padding-left:10px;"><label>
				<input name="edad" type="text" id="edad" value="<?php echo $edad; ?>" size="2">
			</label></td>
		</tr>
		<tr>
			<td height="25" align="right" class="letra7" style="padding-right:10px;">M&eacute;dico Tratante:</td>
			<td class="letra7" style="padding-left:10px;">
				<select name="medicoTratante" class="letra7" id="medicoTratante">
					<?php 
					if($existe == true)
					{
						?>
						<option value="<?php echo $medicoTratante; ?>" selected="selected"><?php echo $medicoTratante; ?></option>
						<?php 
					}
					?>
					<option value="PSIQUIATRA">PSIQUIATRA</option>
					<option value="NEUROLOGO">NEUROLOGO</option>
					<option value="MEDICO DE FAMILIA">MEDICO DE FAMILIA</option>
					<option value="MEDICO GENERAL">MEDICO GENERAL</option>
					<option value="OTRO">OTRO</option>
				</select>			</td>
		</tr>
		<tr>
			<td height="25" align="right" class="letra7" style="padding-right:10px;">Nombre M&eacute;dico Tratante:</td>
			<td class="letra7" style="padding-left:10px;"><label>
				<input name="nombreMedicoTratante" type="text" id="nombreMedicoTratante" value="<?php if($existe == true){echo $nombreMedicoTratante;}?>" size="35" />
			</label></td>
		</tr>
		<tr>
			<td height="25" align="right" class="letra7" style="padding-right:10px;">Número de Licencia:</td>
			<td class="letra7" style="padding-left:10px;"><label for="numeroLicencia"></label>
			<input name="numeroLicencia" type="text" class="letra7" id="numeroLicencia" value="<?php echo $numeroLicencia; ?>" size="10" /></td>
		</tr>
	</table>
	<br />
	<table width="680" border="0" align="center" cellpadding="0" cellspacing="0" class="borde_tabla" style="border-collapse:collapse;">
		<tr>
			<td height="25" class="tituloTablas">Historia Clínica</td>
		</tr>
		<tr>
			<td style="padding-left:10px; padding-top:5px; padding-bottom:5px;"><span class="informeTituloCampo">Antecedentes Personales</span><br />
			  <span id="sprytextarea2">
			  <textarea name="antecedentesPersonales" cols="120" rows="8" class="letra7" id="antecedentesPersonales"><?php if($existe == true){echo $antecedentesPersonales;}?></textarea>
		    <span class="textareaMaxCharsMsg">*</span><span class="letra7" id="countsprytextarea2">&nbsp;</span></span>           			
           <input type="button" name="grabaCampos" id="grabaCampos" value="grabar" onclick="grabaCamposInforme();" /> <br />
				<br />
				<span class="informeTituloCampo">Antecedentes M&oacute;rbidos (incluye antecedentes psiqui&aacute;tricos)</span><br />
		    <span id="sprytextarea3">
            <textarea name="antecedentesMorbidos" cols="120" rows="8" class="letra7" id="antecedentesMorbidos"><?php if($existe == true){echo $antecedentesMorbidos;}?></textarea>
          <span class="letra7" id="countsprytextarea3">&nbsp;</span><span class="textareaMaxCharsMsg">*</span></span>
                     <input type="button" name="grabaCampos1" id="grabaCampos1" value="grabar" onclick="grabaCamposInforme();" />
          <br />
				<br />
				<span class="informeTituloCampo">Factores Estresantes</span><br />
				<table width="97%" border="0" cellpadding="0" cellspacing="0" class="tablaAyuda" title="header=[Tips] body=[]">
					<tr>
						<td>
							<ul>
									<li>Indicar  existencia de estrés laboral, ÚNICAMENTE si es relevante en etiología de cuadro  psiquiátrico que motiva la licencia.</li>
									<li>SIEMPRE  que se indique que existe estrés laboral SE DEBE especificar SI REQUIERE O NO  EVALUACIÓN ESPECIALIZAD</li>
							</ul>
						</td>
					</tr>
				</table>
<span id="sprytextarea4">
				<textarea name="factoresEstresantes" cols="120" rows="8" class="letra7" id="factoresEstresantes"><?php if($existe == true){echo $factoresEstresantes;}?></textarea>
		    <span class="letra7" id="countsprytextarea4">&nbsp;</span><span class="textareaMaxCharsMsg">*</span></span>           <input type="button" name="grabaCampos2" id="grabaCampos2" value="grabar" onclick="grabaCamposInforme();" /><br />
				<br />
				<span class="informeTituloCampo">Anamnesis</span><br />
				<textarea name="anamnesis" cols="120" rows="8" class="letra7" id="anamnesis"><?php if($existe == true){echo $anamnesis;}?></textarea>
				           <input type="button" name="grabaCampos3" id="grabaCampos3" value="grabar" onclick="grabaCamposInforme();" /><br />
				<br />
				<span class="informeTituloCampo">Ex&aacute;men Mental</span><br />
				<table width="97%" border="0" cellpadding="0" cellspacing="0" class="tablaAyuda" title="header=[Tips] body=[]">
					<tr>
						<td>
							<ul>
								<li>Debe  ser extenso, objetivo, con términos psicopatológicos.</li>
								<li>Poner  énfasis en apariencia, conducta, psicomotricidad, pensamiento y afectividad.</li>
								<li>Debe  ser concordante con diagnóstico y con GAF</li>
							</ul>
						</td>
					</tr>
				</table>
				<textarea name="examenMental" cols="120" rows="8" class="letra7" id="examenMental"><?php if($existe == true){echo $examenMental;}?></textarea>
				           <input type="button" name="grabaCampos4" id="grabaCampos4" value="grabar" onclick="grabaCamposInforme();" /><br />
				<br />
			</td>
			</tr>
			<tr>
				<td height="25" class="tituloTablas">Tratamiento Actual</td>
		</tr>
			<tr>
				<td style="padding-left:10px; padding-top:5px; padding-bottom:5px;">
				<span class="informeTituloCampo">Tratamiento Actual</span><br />
				<table width="97%" border="0" cellpadding="0" cellspacing="0" class="tablaAyuda" title="header=[Tips] body=[]">
					<tr>
						<td>
							<ul>
								<li>Indicar  SOLAMENTE EN ESTE CAMPO todos los comentarios relacionados con el tratamiento  farmacológico, tratamiento psicoterapéutico, frecuencia de controles con  psiquiatra y adherencia a tratamiento por parte del paciente.</li>
							</ul>
						</td>
					</tr>
				</table>
				<span id="sprytextarea5">
				<textarea name="tratamientoActual" cols="120" rows="8" class="letra7" id="tratamientoActual"><?php if($existe == true){echo $tratamientoActual;}?></textarea>
				<span class="letra7" id="countsprytextarea5">&nbsp;</span><span class="textareaMaxCharsMsg">*</span></span>           <input type="button" name="grabaCampos5" id="grabaCampos5" value="grabar" onclick="grabaCamposInforme();" /><br />
				<br />
				<span class="informeTituloCampo">Opinión Sobre Tratamiento Farmacológico</span><br />
				<select name="opinionTratamiento" id="opinionTratamiento">
					<?php
						if($existe == true)
						{
							?>
					<option value="<?php echo $opinionTratamiento; ?>" selected="selected"><?php echo $opinionTratamiento; ?></option>
					<?php 
						}
					?>
					<option value="CORRESPONDE">CORRESPONDE</option>
					<option value="TRATAMIENTO INSUFICIENTE">TRATAMIENTO INSUFICIENTE</option>
					<option value="CORRESPONDE PERO DOSIS DE FARMACOS ES INSUFICIENTE">CORRESPONDE PERO DOSIS DE FARMACOS ES INSUFICIENTE</option>
					<option value="CORRESPONDE PERO DEBE AGREGARSE PSICOTERAPIA">CORRESPONDE PERO DEBE AGREGARSE PSICOTERAPIA</option>
					<option value="PACIENTE NO CUMPLE INDICACIONES">PACIENTE NO CUMPLE INDICACIONES</option>
				</select>
				           <input type="button" name="grabaCampos6" id="grabaCampos6" value="grabar" onclick="grabaCamposInforme();" /><br />
				<br />
				<span class="informeTituloCampo">Comentario Sobre el Tratamiento Actual</span><br />
				<textarea name="comentarios" cols="120" rows="8" class="letra7" id="comentarios"><?php if($existe == true){echo $comentarios;}?></textarea>
				           <input type="button" name="grabaCampos7" id="grabaCampos7" value="grabar" onclick="grabaCamposInforme();" /><br />
				<br />
				</td>
			</tr>
			<tr>
				<td height="25" class="tituloTablas">Diagnóstico de la Licencia Médica N&deg; <?php echo $numeroLicencia; ?></td>
		</tr>
			<tr>
				<td style="padding-left:10px; padding-top:5px; padding-bottom:5px;">
				<span class="informeTituloCampo">Diagn&oacute;stico de Licencia M&eacute;dica N&deg; <?php echo $numeroLicencia; ?></span><br />
				<table width="97%" border="0" cellpadding="0" cellspacing="0" class="tablaAyuda" title="header=[Tips] body=[]">
					<tr>
						<td>
						<ul>
							<li>Indicar  SOLAMENTE EN ESTE CAMPO todos los comentarios relacionados con el diagnóstico  que aparece registrado en licencia médica.</li>
						</ul>
						</td>
					</tr>
				</table>
				<textarea name="diagnosticoLicenciaMedica" cols="120" rows="8" class="letra7" id="diagnosticoLicenciaMedica"><?php if($existe == true){echo $diagnosticoLicenciaMedica;}?></textarea>
				           <input type="button" name="grabaCampos8" id="grabaCampos8" value="grabar" onclick="grabaCamposInforme();" /><br />
				<br />
				<span class="informeTituloCampo">Opini&oacute;n Sobre el Diagn&oacute;stico de Licencia M&eacute;dica N&deg; <?php echo $numeroLicencia; ?></span><br />
				<select name="opinionSobreDiagnostico" id="opinionSobreDiagnostico">
					<?php
						if($existe == true)
						{
							?>
							<option value="<?php echo $opinionSobreDiagnostico; ?>" selected="selected"><?php echo $opinionSobreDiagnostico; ?></option>
					<?php 
						}
					?>
					<option value="DE ACUERDO CON DIAGNOSTICO PSIQUIATRICO PRINCIPAL">DE ACUERDO CON DIAGNOSTICO PSIQUIATRICO PRINCIPAL</option>
					<option value="PACIENTE PRESENTA OTRO DIAGNOSTICO PSIQUIATRICO PRINCIPAL">PACIENTE PRESENTA OTRO DIAGNOSTICO PSIQUIATRICO PRINCIPAL</option>
					<option value="NO SE DISPONE DE ESTA INFORMACION">NO SE DISPONE DE ESTA INFORMACION</option>
					<option value="PACIENTE SIN DIAGNOSTICO PSIQUIATRICO">PACIENTE SIN DIAGNOSTICO PSIQUIATRICO</option>
				</select>
				           <input type="button" name="grabaCampos9" id="grabaCampos9" value="grabar" onclick="grabaCamposInforme();" /><br />
				<br />
				<span class="informeTituloCampo">Comentarios</span><br />
				<span id="sprytextarea6">
                <label>
                  <textarea name="comentariosDLM" cols="120" rows="3" class="letra7" id="comentariosDLM"><?php if($existe == true){echo $comentariosDLM;}?></textarea>
                <span class="letra7" id="countsprytextarea6">&nbsp;</span></label>
<span class="textareaMaxCharsMsg">*</span></span>
           <input type="button" name="grabaCampos10" id="grabaCampos10" value="grabar" onclick="grabaCamposInforme();" /><br />
				<br />
				</td>
			</tr>
			<tr>
				<td height="25" class="tituloTablas">Diagnóstico del Perito</td>
		</tr>
			<tr>
				<td style="padding-left:10px; padding-top:5px; padding-bottom:5px;">
				<span class="informeTituloCampo">Eje I</span><br />
				<label>
					<input name="eje1" type="text" class="letra7" id="eje1" value="<?php echo $eje1; ?>" size="120" onkeyup="ajax_showOptions(this,'getCountriesByLetters',event);"/>
					           <input type="button" name="grabaCampos11" id="grabaCampos11" value="grabar" onclick="grabaCamposInforme();" /><br />
					<br />
				 	<span class="informeTituloCampo">Eje II</span><br />
				</label>
				<input name="eje2" type="text" class="letra7" id="eje2" size="120" value="<?php echo $eje2; ?>" />
				
				<label>           <input type="button" name="grabaCampos12" id="grabaCampos12" value="grabar" onclick="grabaCamposInforme();" /><br />
					<br />
					<span class="informeTituloCampo">Eje III</span><br />
				</label>
				<textarea name="eje3" cols="120" class="letra7" id="eje3"><?php echo $eje3; ?></textarea>
				
				<label>           <input type="button" name="grabaCampos13" id="grabaCampos13" value="grabar" onclick="grabaCamposInforme();" /><br />
					<br />
					<span class="informeTituloCampo">Eje IV</span><br />
				</label>
				<textarea name="eje4" cols="120" rows="5" class="letra7" id="eje4"><?php echo $eje4; ?></textarea>
				
				<label>           <input type="button" name="grabaCampos14" id="grabaCampos14" value="grabar" onclick="grabaCamposInforme();" /><br />
					<br />
					</label>
				<table width="97%" border="0" cellpadding="0" cellspacing="0" class="tablaAyuda" title="header=[Tips] body=[]" style="border-collapse:collapse">
					<tr>
						<td width="86%" align="left" style="cursor:pointer;" onclick="mostrar('tablaGAF')">GAF</td>
						<td width="14%" align="right" style="cursor:pointer;" onclick="mostrar('tablaGAF')">Ocultar/Mostrar</td>
					</tr>
					<tr id="tablaGAF" style="display:none">
						<td colspan="2"><table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" id="cambio_color">
							<tr>
								<td><span class="letraMensajes">91-100:</span> <span class="letraNormal"> Actividad satisfactoria en una amplia gama de actividades, nunca parece superado por los problemas de su vida, es valorado por los dem&aacute;s a causa de sus abundantes cualidades positivas. Sin s&iacute;ntomas.</span></td>
							</tr>
							<tr>
								<td><span class="letraMensajes">81-90:</span> <span class="letraNormal">S&iacute;ntomas ausentes o m&iacute;nimos (por ejemplo, ligera ansiedad antes de un examen), buena actividad en todas las &aacute;reas, interesado e implicado en una amplia gama de actividades, socialmente eficaz, generalmente satisfecho de su vida, sin mas preocupaciones o problemas que los cotidianos (por ejemplo, una discusi&oacute;n ocasional con miembros de su familia). </span></td>
							</tr>
							<tr>
								<td><span class="letraMensajes">71-80:</span> <span class="letraNormal">Si existen s&iacute;ntomas, son transitorios y constituyen reacciones esperables ante agentes estresantes psicosociales (por ejemplo, dificultades para concentrarse tras una discusi&oacute;n familiar); solo existe una ligera alteraci&oacute;n de la actividad social, laboral &oacute; escolar (por ejemplo, descenso temporal del rendimiento escolar). </span></td>
							</tr>
							<tr>
								<td><span class="letraMensajes">61-70:</span> <span class="letraNormal"> Algunos s&iacute;ntomas leves (por ejemplo, humor depresivo o insomnio ligero) o alguna dificultad en la actividad social, laboral &oacute; escolar ( por ejemplo, hacer novillos ocasionalmente o robar algo en casa) pero, en general funciona bastante bi&eacute;n, tiene algunas relaciones interpersonales significativas.  &nbsp;</span></td>
							</tr>
							<tr>
								<td><span class="letraMensajes">51-60:</span> <span class="letraNormal">S&iacute;ntomas moderados (por ejemplo, afecto aplanado y lenguaje circunstancial, crisis de angustia ocasionales) o dificultades moderadas en la actividad social, laboral o escolar (por ejemplo, pocos amigos, conflictos con compa&ntilde;eros de trabajo o de escuela). </span></td>
							</tr>
							<tr>
								<td><span class="letraMensajes">41-50:</span> <span class="letraNormal">S&iacute;ntomas graves (por ejemplo, ideaci&oacute;n suicida, rituales obsesivos graves, robos en tiendas) o cualquier alterac&oacute;n grave de la actividad social, laboral o escolar, (por ejemplo, sin amigos, incapacidad de mantenerse en un empleo). </span></td>
							</tr>
							<tr>
								<td><span class="letraMensajes">31-40:</span> <span class="letraNormal">Una alteraci&oacute;n de la verificaci&oacute;n de la realidad o de la comunicaci&oacute;n (por ejemplo, el lenguaje es a veces il&oacute;gico, oscuro o irrelevante) o alteraci&oacute;n importante en varias &aacute;reascomo el trabajo escolar, las relaciones familiares, el juicio, el pensamiento o el estado de &aacute;nimo (por ejemplo, un hombre depresivo evita a sus amigos, abandona a la familia y es incapaz de trabajar; un ni&ntilde;o golpe frecuentemente a ni&ntilde;os m&aacute;s peque&ntilde;os, es desafiante en casa y deja de acudir a la escuela).</span></td>
							</tr>
							<tr>
								<td><span class="letraMensajes">21-30:</span> <span class="letraNormal">La conducta est&aacute; considerablemente influida por ideas delirantes o alucinaciones o existe una alteraci&oacute;n grave de la comunicaci&oacute;n o el juicio (por ejemplo, a veces es incoherente, actua de manera claramente inapropiada,preocupaci&oacute;n suicida) o incapacidad para funcionar en casi todas las &aacute;reas (por ejemplo, permanece en la cama todo el d&iacute;a; sin trabajo, vivienda o amigos).</span></td>
							</tr>
							<tr>
								<td><span class="letraMensajes">11-20:</span> <span class="letraNormal"> Alg&uacute;n peligro de causar lesiones a otros o a s&iacute; mismo (por ejemplo, intentos de suicidio sin una espectativa manifiesta de muerte; frecuentemente violento; excitaci&oacute;n man&iacute;aca) u ocasionalmente deja de mantener la higiene personal m&iacute;nima (por ejemplo, con manchas de escrementos) o alteraci&oacute;n importante de la comunicaci&oacute;n (por ejemplo, muy incoherente o mudo).</span></td>
							</tr>
							<tr>
								<td><span class="letraMensajes">1-10:</span><span class="letraNormal">Peligro persistente de lesiononar gravemente a otros o a s&iacute; mismo (por ejemplo, violencia recurrente)o incapacidad persistente para mantener la higiene personal m&iacute;nima o acto suicida grave con expectativa manifiesta de muerte. </span></td>
							</tr>
							<tr>
								<td><span class="letraMensajes">0:</span> <span class="letraNormal">Informaci&oacute;n inadecuada </span></td>
							</tr>
						</table></td>
					</tr>
				</table>
				<label><span class="informeTituloCampo">Eje V</span><br />
				</label>
				<span id="sprytextfield1">
				<input name="eje5" type="text" class="letra7" id="eje5" size="120" value="<?php echo $eje5; ?>" />
				<span class="textfieldRequiredMsg">Se necesita un valor.</span></span>           <input type="button" name="grabaCampos15" id="grabaCampos15" value="grabar" onclick="grabaCamposInforme();" /><br />
				<br /></td>
			</tr>
			<tr>
				<td height="25" class="tituloTablas">Conclusión sobre el Reposo Médico</td>
		</tr>
			<tr>
				<td style="padding-left:10px; padding-top:5px; padding-bottom:5px;">
				<table width="97%" border="0" cellpadding="0" cellspacing="0" class="tablaAyuda" title="header=[Tips] body=[]" style="border-collapse:collapse">
					<tr>
						<td align="right" style="cursor:pointer;" onclick="mostrar('tablaAyudaConclusionReposo')">Ocultar/Mostrar</td>
					</tr>
					<tr id="tablaAyudaConclusionReposo">
						<td>
						<strong>REGISTRAR SIEMPRE:</strong>
							<ul>
								<li>Valoración de capacidad funcional  actual (a la fecha del examen) del paciente: <strong><em>“al momento de la entrevista  paciente con un compromiso (leve-moderado-grave-sin compromiso) de su capacidad  funcional”</em></strong></li>
								<li>ESTAS CONCLUSIÓNES DEBE SER  CONCORDANTES CON EXAMEN MENTAL – DIAGNÓSTICO Y GAF.</li>
								<li>Si el paciente está reintegrado al  trabajo o renunció, indicar desde qué fecha.</li>
							</ul>
<strong>NUNCA REGISTRAR:</strong>
<ul>
	<li>NO SEÑALAR: más información a menos  que tenga DIRECTA relación con las conclusiones anteriores<br />
No dar sugerencias respecto al tratamiento  (esas sugerencias van en el apartado respecto al tratamiento)<br />
No pronunciarse respecto a origen  laboral del cuadro.</li>
	<li>Ser muy cuidadoso al sugerir  inicio de trámite de pensión de invalidez, se debe argumentar grado de  invalidez (porcentaje de discapacidad) y refractariedad al tratamiento  (criterios de dosis de fármaco, tiempo y pertinencia), de forma técnicamente  adecuada y basada en evidencia científica.</li>
</ul>
<strong>SÍ REGISTRAR</strong>:
<ul>
	<li>SÍ, se debe señalar cuando el  reposo ha contribuido a perpetuar el cuadro psiquiátrico (p. ej. Fobia social,  trastorno de personalidad, etc.)</li>
	<li>SÍ, se debe señalar cuando el  paciente ha iniciado trámites de invalidez, indicarlo como dato y NO dar  opiniones al respecto</li>
</ul>
	</td>
					</tr>
				</table>
				<span class="informeTituloSeccion">I)</span><span class="informeTituloCampo"><br />
				Días acumulados  de reposo a la fecha de hoy día (incluye licencia N&deg; <?php echo $numeroLicencia; ?>)</span><br />
				<span id="sprytextfield3">
				<label>
					<input name="diasAcumulados" type="text" id="diasAcumulados" size="3" title="header=[Si no tiene información deje en blanco] body=[]" value="<?php if($existe == true){echo $diasAcumulados;}?>"/>
				</label>
<span class="textfieldMinValueMsg">El valor introducido es inferior al mínimo permitido. Si no tiene el dato, déjelo en blanco.</span></span>
           <input type="button" name="grabaCampos16" id="grabaCampos16" value="grabar" onclick="grabaCamposInforme();" /><br />
				<br />
				<span class="informeTituloCampo">Fecha de inicio de licencia N&deg; <?php echo $numeroLicencia; ?></span><br />
				<input name="fechaInicioUL" type="text" id="fechaInicioUL" value="<?php if($existe == true){echo $fechaInicioUL;}?>" size="17" maxlength="15" readonly="readonly"/>
				<img src="<?php echo $IMAGENES2; ?>/b_calendar.png" alt="ayuda" name="lanzador2" width="16" height="16" id="lanzador2" title="header=[Fecha] body=[Presione para ver el calendario]"/>
				</label>
				<!-- script que define y configura el calendario-->
				<script type="text/javascript">
				   Calendar.setup({
					inputField     :    "fechaInicioUL",     // id del campo de texto
					ifFormat     :     "%d-%m-%Y",     // formato de la fecha que se escriba en el campo de texto
					button     :    "lanzador2"     // el id del bot&oacute;n que lanzar&aacute; el calendario
				});
				</script>
				           <input type="button" name="grabaCampos17" id="grabaCampos17" value="grabar" onclick="grabaCamposInforme();" /><br />
				<br />				
				<span class="informeTituloCampo">Días de reposo indicados en licencia N&deg; <?php echo $numeroLicencia; ?></span><br />
				<span id="sprytextfield4">
				<label>
					<input name="diasReposoIndicados" type="text" id="diasReposoIndicados" title="header=[Si no tiene información deje en blanco] body=[]" size="3" value="<?php if($existe == true){echo $diasReposoIndicados;}?>"/>
				</label>
				<span class="textfieldInvalidFormatMsg">Formato no válido.</span><span class="textfieldMinValueMsg">El valor introducido es inferior al mínimo permitido. Si no tiene el dato, déjelo en blanco.</span></span>           <input type="button" name="grabaCampos18" id="grabaCampos18" value="grabar" onclick="grabaCamposInforme();" /><br />
				<br />
				<span class="informeTituloSeccion">II)</span><span class="informeTituloCampo"><br />
				Respecto a licencia N&deg; <?php echo $numeroLicencia; ?>, corresponde reposo</span><br />
				<span id="spryselect1">
				<label>
				  <select name="correspondeReposo" id="correspondeReposo" onchange="cambiarCorrespondeReposo(form);">
				    <?php 
						if($existe == true)
						{
							?>
				    <option value="<?php echo $correspondeReposo; ?>"><?php echo $correspondeReposo; ?></option>
				    <?php
						}
						?>
				    <option value=""></option>
				    <option value="NO">NO</option>
				    <option value="SI">SI</option>
			      </select>
			    </label>
				<span class="selectRequiredMsg">*</span></span>           <input type="button" name="grabaCampos19" id="grabaCampos19" value="grabar" onclick="grabaCamposInforme();" /><br />
				<br />
				<table width="742" border="0" cellspacing="0" cellpadding="0" id="tablaCorrespondeReposo" style="<?php if($correspondeReposo != 'SI'){  ?>display:none;<?php } ?>border:none;">
					<tr>
						<td style="padding-left:15px;"><span class="informeTituloCampo">Período</span><br />
							<label>
								<select name="periodo" id="periodo" <?php 
									if($existe == true)
									{
										if($correspondeReposo != 'SI')
										{
											?> disabled="disabled"<?php }}?>>
									<?php 
									if($existe == true)
									{
										if($correspondeReposo == 'SI')
										{
											?>
									<option value="<?php echo $periodo; ?>" selected="selected"><?php echo $periodo; ?></option>
									<?php 
										}
									}
									?>
									<option value="COMPLETO">COMPLETO</option>
									<option value="REDUCIDO">REDUCIDO</option>
								</select>
							</label>
							           <input type="button" name="grabaCampos20" id="grabaCampos20" value="grabar" onclick="grabaCamposInforme();" /><br />
							<br />
						<span id="sprytextfield5"><span class="textfieldInvalidFormatMsg">Formato no válido.</span><span class="textfieldMinValueMsg">El valor introducido es inferior al mínimo permitido.</span></span></td>
					</tr>
				</table>
				<span class="informeTituloSeccion"><br />
				</span>
				<table width="500" border="0" cellspacing="0" cellpadding="0" id="pronosticoReintegroTabla" <?php if($pronosticoReintegro != 'CON UN TRATAMIENTO ADECUADO PACIENTE EN CONDICIONES DE REINTEGRARSE EN [ ] DIAS A SU ACTIVIDAD LABORAL'){  ?>style="display:none;"<?php } ?>>
					<tr>
					</tr>
				</table>
				<span class="informeTituloSeccion">III)</span><br />
				<span class="informeTituloCampo">Conclusión  respecto del reintegro laboral al examen actual del paciente</span><br />
				<span id="sprytextarea1">
				<textarea name="comentarios2" cols="120" rows="8" class="letra7" id="comentarios2"><?php if($existe == true)
{echo $comentarios2;}?></textarea>
				<span class="textareaRequiredMsg">*</span></span>           <input type="button" name="grabaCampos21" id="grabaCampos21" value="grabar" onclick="grabaCamposInforme();" /></td>
		</tr>
	</table>
	<br />
	<table width="90%" border="0" align="center" cellpadding="0" cellspacing="0">
		<tr>
			<td align="center">
				<?php 
				if($existe == true)
				{
					?>
					<input name="id" type="hidden" id="id" value="<?php echo $id; ?>" />
					<?php
				}
				?>			
				<input name="idHora" type="hidden" id="idHora" value="<?php echo $idHora; ?>" />
				<label>
				<input name="Submit" type="submit" class="boton" value="Guardar" />
				</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <?php
				if(tipoUsuario($_SESSION['idUsuario'], $conectar) != 'prestador')				
				{ ?>
                    <input type="button"  onclick="publicar(<?php echo $idHora; ?>)" value="Publicar" />
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <input type="button"  onclick="despublicar(<?php echo $idHora; ?>)" value="Despublicar" />
				<?php }?>
    		</td>
		</tr>
	</table>
</form>
<script type="text/javascript">
<!--
var sprytextfield3 = new Spry.Widget.ValidationTextField("sprytextfield3", "none", {isRequired:false});
var sprytextfield4 = new Spry.Widget.ValidationTextField("sprytextfield4", "integer", {validateOn:["blur"], isRequired:false, minValue:1});
var sprytextarea1 = new Spry.Widget.ValidationTextarea("sprytextarea1");
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1");
var sprytextarea2 = new Spry.Widget.ValidationTextarea("sprytextarea2", {isRequired:false, counterId:"countsprytextarea2", counterType:"chars_remaining", maxChars:350});
var sprytextarea3 = new Spry.Widget.ValidationTextarea("sprytextarea3", {maxChars:1000, counterId:"countsprytextarea3", isRequired:false, counterType:"chars_remaining"});
var sprytextarea4 = new Spry.Widget.ValidationTextarea("sprytextarea4", {isRequired:false, maxChars:1000, counterId:"countsprytextarea4", counterType:"chars_remaining"});
var sprytextarea5 = new Spry.Widget.ValidationTextarea("sprytextarea5", {isRequired:false, maxChars:1000, counterId:"countsprytextarea5", counterType:"chars_remaining"});
var sprytextarea6 = new Spry.Widget.ValidationTextarea("sprytextarea6", {maxChars:150, counterId:"countsprytextarea6", counterType:"chars_remaining", isRequired:false});

//-->
</script>
</body>