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
			i.`antecedentesPersonales`, 
			i.`antecedentesMorbidos`, 
			i.`factoresEstresantes`, 
			i.`existeEstresLaboral`, 
			i.`anamnesis`, 
			i.`examenMental`, 
			i.`tratamientoActual`, 
			i.`opinionTratamiento`, 
			i.`comentarios`, 
			i.`diagnosticoLicenciaMedica`, 
			i.`opinionSobreDiagnostico`, 
			i.`eje1`, 
			i.`eje2`, 
			i.`eje3`, 
			i.`eje4`, 
			i.`eje5`, 
			i.`opinionReposoMedico`, 
			i.`siReposoCorresponde`, 
			i.`cuantosDiasReposo`, 
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
		$antecedentesPersonales = caracteres_html_inversa($rowDatos[antecedentesPersonales]);
		$antecedentesMorbidos = caracteres_html_inversa($rowDatos[antecedentesMorbidos]);
		$factoresEstresantes = caracteres_html_inversa($rowDatos[factoresEstresantes]);
		$existeEstresLaboral = caracteres_html_inversa($rowDatos[existeEstresLaboral]);
		$anamnesis = caracteres_html_inversa($rowDatos[anamnesis]);
		$examenMental = caracteres_html_inversa($rowDatos[examenMental]);
		$tratamientoActual = caracteres_html_inversa($rowDatos[tratamientoActual]);
		$opinionTratamiento = caracteres_html_inversa($rowDatos[opinionTratamiento]);
		$comentarios = caracteres_html_inversa($rowDatos[comentarios]);
		$diagnosticoLicenciaMedica = caracteres_html_inversa($rowDatos[diagnosticoLicenciaMedica]);
		$opinionSobreDiagnostico = caracteres_html_inversa($rowDatos[opinionSobreDiagnostico]);
		$eje1 = caracteres_html_inversa($rowDatos[eje1]);
		$eje2 = caracteres_html_inversa($rowDatos[eje2]);
		$eje3 = caracteres_html_inversa($rowDatos[eje3]);
		$eje4 = caracteres_html_inversa($rowDatos[eje4]);
		$eje5 = caracteres_html_inversa($rowDatos[eje5]);
		$opinionReposoMedico = caracteres_html_inversa($rowDatos[opinionReposoMedico]);
		$siReposoCorresponde = caracteres_html_inversa($rowDatos[siReposoCorresponde]);
		$cuantosDiasReposo = caracteres_html_inversa($rowDatos[cuantosDiasReposo]);
		$comentarios2 = caracteres_html_inversa($rowDatos[comentarios2]);
	}
	
	$idPacienteHora = idPacienteHora($idHora, $conectar);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<!--CABECERAS PARA EL CALENDARIO-->
	<!--Hoja de estilos del calendario -->
	<link rel="stylesheet" type="text/css" media="all" href="<?php echo $HOME; ?>/lib/calendar-blue.css" title="win2k-cold-1" />
	
	<!-- librería principal del calendario -->
	<script type="text/javascript" src="<?php echo $HOME; ?>/lib/calendar.js"></script>
	
	<!-- librería para cargar el lenguaje deseado -->
	<script type="text/javascript" src="<?php echo $HOME; ?>/lib/calendar-es.js"></script>
	
	<!-- librería que declara la función Calendar.setup, que ayuda a generar un calendario en unas pocas líneas de código -->
	<script type="text/javascript" src="<?php echo $HOME; ?>/lib/calendar-setup.js"></script> 

<!--FIN CABECERAS PARA EL CALENDARIO-->

<script language="javascript" src="../../../lib/numeros.js"></script>
<script language="javascript" src="../../../lib/validaforms.js"></script>

<script>

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
		var tiempoLicencia = document.getElementById("tiempoLicencia").value;
		var medicoTratante = document.getElementById("medicoTratante").value;
		var nombreMedicoTratante = document.getElementById("nombreMedicoTratante").value;
		var antecedentesPersonales = document.getElementById("antecedentesPersonales").value;
		var antecedentesMorbidos = document.getElementById("antecedentesMorbidos").value;
		var factoresEstresantes = document.getElementById("factoresEstresantes").value;
		var existeEstresLaboral = document.getElementById("existeEstresLaboral").value;
		var anamnesis = document.getElementById("anamnesis").value;
		var examenMental = document.getElementById("examenMental").value;
		var tratamientoActual = document.getElementById("tratamientoActual").value;
		var opinionTratamiento = document.getElementById("opinionTratamiento").value;
		var comentarios = document.getElementById("comentarios").value;
		var diagnosticoLicenciaMedica = document.getElementById("diagnosticoLicenciaMedica").value;
		var opinionSobreDiagnostico = document.getElementById("opinionSobreDiagnostico").value;
		var eje1 = document.getElementById("eje1").value;
		var eje2 = document.getElementById("eje2").value;
		var eje3 = document.getElementById("eje3").value;
		var eje4 = document.getElementById("eje4").value;
		var eje5 = document.getElementById("eje5").value;
		var opinionReposoMedico = document.getElementById("opinionReposoMedico").value;
		var siReposoCorresponde = document.getElementById("siReposoCorresponde").value;
		var cuantosDiasReposo = document.getElementById("cuantosDiasReposo").value;
		var comentarios2 = document.getElementById("comentarios2").value;
				
		var params = "idHora="+idHora+"&fecha="+fecha+"&ocupacion="+ocupacion+"&sexo="+sexo+"&edad="+edad+"&tiempoLicencia="+tiempoLicencia+"&medicoTratante="+medicoTratante+"&nombreMedicoTratante="+nombreMedicoTratante+"&antecedentesPersonales="+antecedentesPersonales+"&antecedentesMorbidos="+antecedentesMorbidos+"&factoresEstresantes="+factoresEstresantes+"&existeEstresLaboral="+existeEstresLaboral+"&anamnesis="+anamnesis+"&examenMental="+examenMental+"&tratamientoActual="+tratamientoActual+"&opinionTratamiento="+opinionTratamiento+"&comentarios="+comentarios+"&diagnosticoLicenciaMedica="+diagnosticoLicenciaMedica+"&opinionSobreDiagnostico="+opinionSobreDiagnostico+"&eje1="+eje1+"&eje2="+eje2+"&eje3="+eje3+"&eje4="+eje4+"&eje5="+eje5+"&opinionReposoMedico="+opinionReposoMedico+"&siReposoCorresponde="+siReposoCorresponde+"&cuantosDiasReposo="+cuantosDiasReposo+"&comentarios2="+comentarios2;
				
		var http = getHTTPObject();
		http.onreadystatechange = function(){
			if(http.readyState==4 && http.status==200){
				msg = document.getElementById("msg");
				var ahora = new Date();
				msg.innerHTML = "<span style=\"background-color:#FFFF66\">Informe autoguardado a las "+ahora.getHours()+":"+ahora.getMinutes()+":"+ahora.getSeconds()+"&nbsp;&nbsp;&nbsp;&nbsp;</span>";
			}
			else
			{
				msg = document.getElementById("msg");
				var ahora = new Date();
				msg.innerHTML = "<span style=\"background-color:#FFFFCE\">No se ha guardado el informe</span>";
			}
		};
		http.open("POST", 'chk_informeEntrevistaSegundaAuto.php', true);
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

	function validarForm(form)
	{
		if(form.edad.value == '')
		{
			alert('Ingrese la edad.');
			return false;
		}
		else if(form.nombreMedicoTratante.value == '')
		{
			alert('Ingrese el nombre del médico tratante.');
			return false;
		}
		else if(form.antecedentesPersonales.value == '')
		{
			alert('Ingrese los antecedentes personales.');
			return false;
		}
		else if(form.antecedentesMorbidos.value == '')
		{
			alert('Ingrese los antecedentes mórbidos.');
			return false;
		}
		else if(form.factoresEstresantes.value == '')
		{
			alert('Ingrese los factores estresantes.');
			return false;
		}
		else if(form.anamnesis.value == '')
		{
			alert('Ingrese la anamnesis.');
			return false;
		}
		else if(form.examenMental.value == '')
		{
			alert('Ingrese el examen mental.');
			return false;
		}
		else if(form.tratamientoActual.value == '')
		{
			alert('Ingrese el tratamiento actual.');
			return false;
		}
		else if(form.diagnosticoLicenciaMedica.value == '')
		{
			alert('Ingrese el diagnóstico de licencia médica.');
			return false;
		}
		else if(form.eje1.value == '')
		{
			alert('Ingrese el eje I.');
			return false;
		}
		else if(form.eje2.value == '')
		{
			alert('Ingrese el eje II.');
			return false;
		}
		else if(form.eje3.value == '')
		{
			alert('Ingrese el eje III.');
			return false;
		}
		else if(form.eje4.value == '')
		{
			alert('Ingrese el eje IV.');
			return false;
		}
		else if(form.eje5.value == '')
		{
			alert('Ingrese el eje V.');
			return false;
		}
		else if(form.opinionReposoMedico.value == 'SI CORRESPONDE' &&  form.siReposoCorresponde.value == '')
		{
			alert('Seleccione alguna opción si el reposo corresponde.');
			return false;
		}
		else
		{
			form.submit();
		}
	}
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
</script>

<link href="../../templates/defecto/estilos.css" rel="stylesheet" type="text/css">
</head>
<body onLoad="init();">

<div id="topPaciente">
<table border="1" align="left" cellpadding="0" cellspacing="0" style="border-collapse:collapse; background-color:#FFF;">
	<tr>
		<td height="23" align="left" bgcolor="#FFFFE8" class="letra7">Paciente: <span class="letraDocumentoTitulo"><?php echo nombreCompletoPaciente($idPacienteHora, $conectar); ?></span></td>
	</tr>
</table>
</div>

<br />
<form id="form" name="form" method="post" action="chk_informeEntrevistaSegunda.php" onSubmit="return validarForm(this);">
	<table width="474" border="0" align="center" cellpadding="0" cellspacing="0" class="borde_tabla" style="border-collapse:collapse;">
		<tr>
			<td height="29" colspan="2" align="center" bgcolor="#AACCFF" class="tituloTablas">Informe de Entrevista Psiqui&aacute;trica de Peritaje </td>
		</tr>
		<tr>
			<td width="191" height="34" align="right" class="letra7" style="padding-right:10px;">Fecha:</td>
			<td width="235" class="letra7" style="padding-left:10px;">
				<input name="fecha" type="text" class="letra7" id="fecha" value="<?php 
					if($existe == true)
					{
						echo $fecha;
					}
					else
					{
						echo date('d-m-Y'); 
					}	
				?>" size="17" maxlength="15" readonly="readonly"/>
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
			<td width="191" height="34" align="right" class="letra7" style="padding-right:10px;">Ocupaci&oacute;n:</td>
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
				</label>			</td>
		</tr>
		<tr>
			<td height="34" align="right" class="letra7" style="padding-right:10px;">Sexo:</td>
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
			<td height="34" align="right" class="letra7" style="padding-right:10px;">Edad:</td>
			<td class="letra7" style="padding-left:10px;"><label>
				<input name="edad" type="text" id="edad" value="<?php echo $edad; ?>" size="2">
			</label></td>
		</tr>
		<tr>
			<td height="34" align="right" class="letra7" style="padding-right:10px;">Tiempo de Licencia Psiquiátrica:</td>
			<td class="letra7" style="padding-left:10px;"><label>
				<select name="tiempoLicencia" id="tiempoLicencia">
					<?php 
					if($existe == true)
					{
						?><option value="<?php echo $tiempoLicencia; ?>" selected="selected"><?php echo $tiempoLicencia; ?></option><?php 
					}
					
					for($i=0; $i<=1000; $i++)
					{	
						?><option value="<?php echo $i; ?>"><?php echo $i; ?></option><?php 
					}	
					?>
				</select>
			d&iacute;as</label></td>
		</tr>
		<tr>
			<td height="34" align="right" class="letra7" style="padding-right:10px;">M&eacute;dico Tratante:</td>
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
			<td height="34" align="right" class="letra7" style="padding-right:10px;">Nombre M&eacute;dico Tratante:</td>
			<td class="letra7" style="padding-left:10px;"><label>
				<input name="nombreMedicoTratante" type="text" id="nombreMedicoTratante" value="<?php 
					if($existe == true)
					{
						echo $nombreMedicoTratante;
					}
				?>" size="35" />
			</label></td>
		</tr>
	</table>
<br />
	<table width="680" border="0" align="center" cellpadding="0" cellspacing="0" class="letraDocumentoTitulo" id="msg">
		<tr>
			<td></td>
		</tr>
	</table>
	<br />
	<table width="680" border="0" align="center" cellpadding="0" cellspacing="0" class="bordeTabla1">
		<tr>
			<td class="" style="padding-left:10px; padding-top:5px; padding-bottom:5px;"><span class="letraDocumentoTitulo">Antecedentes Personales:</span><br />
				<textarea name="antecedentesPersonales" cols="120" rows="8" class="letra7" id="antecedentesPersonales"><?php 
					if($existe == true)
					{
						echo $antecedentesPersonales;
					}
				?></textarea>
				<br />
				<br />
				<span class="letraDocumentoTitulo">Antecedentes M&oacute;rbidos (incluye antecedentes psiqui&aacute;tricos):</span><br />
				<textarea name="antecedentesMorbidos" cols="120" rows="8" class="letra7" id="antecedentesMorbidos"><?php 
					if($existe == true)
					{
						echo $antecedentesMorbidos;
					}
				?></textarea>				
				<br />
				<br />
				<span class="letraDocumentoTitulo">Factores Estresantes:</span><br />
				<textarea name="factoresEstresantes" cols="120" rows="8" class="letra7" id="factoresEstresantes"><?php 
					if($existe == true)
					{
						echo $factoresEstresantes;
					}
				?></textarea>				
				<br />
				<br />
			  <span class="letraDocumentoTitulo">¿Existe estrés laboral significativo?:</span><br />
				<label>
				<select name="existeEstresLaboral" class="letra7" id="existeEstresLaboral">
					<?php
						if($existe == true)
						{
							?><option value="<?php echo $existeEstresLaboral; ?>" selected="selected"><?php echo $existeEstresLaboral; ?></option><?php 
						}
					?>					
					<option value="SI">SI</option>
					<option value="NO">NO</option>
				</select>
				</label>
				<br />
				<br />
				<span class="letraDocumentoTitulo">Anamnesis:</span><br />
				<textarea name="anamnesis" cols="120" rows="8" class="letra7" id="anamnesis"><?php 
					if($existe == true)
					{
						echo $anamnesis;
					}
				?></textarea>				
				<br />
				<br />
				<span class="letraDocumentoTitulo">Ex&aacute;men Mental:</span><br />
				<textarea name="examenMental" cols="120" rows="8" class="letra7" id="examenMental"><?php 
					if($existe == true)
					{
						echo $examenMental;
					}
				?></textarea>				
				<br />
				<br />
				<span class="letraDocumentoTitulo">Tratamiento Actual:</span><br />
				<textarea name="tratamientoActual" cols="120" rows="8" class="letra7" id="tratamientoActual"><?php 
					if($existe == true)
					{
						echo $tratamientoActual;
					}
				?></textarea>				
				<br />
				<br />
				<span class="letraDocumentoTitulo">Opinión Sobre Tratamiento Farmacológico:</span><br />
				<select name="opinionTratamiento" id="opinionTratamiento">
					<?php
						if($existe == true)
						{
							?><option value="<?php echo $opinionTratamiento; ?>" selected="selected"><?php echo $opinionTratamiento; ?></option><?php 
						}
					?>					
					<option value="CORRESPONDE">CORRESPONDE</option>
					<option value="NO CORRESPONDE">NO CORRESPONDE</option>
					<option value="CORRESPONDE PERO DOSIS DE FARMACOS ES INSUFICIENTE">CORRESPONDE PERO DOSIS DE FARMACOS ES INSUFICIENTE</option>
					<option value="CORRESPONDE PERO DEBE AGREGARSE PSICOTERAPIA">CORRESPONDE PERO DEBE AGREGARSE PSICOTERAPIA</option>
					<option value="PACIENTE NO CUMPLE INDICACIONES">PACIENTE NO CUMPLE INDICACIONES</option>
				</select>
				<br />
				<br />
				<span class="letraDocumentoTitulo">Comentario Sobre el Tratamiento Actual:</span><br />
				<textarea name="comentarios" cols="120" rows="8" class="letra7" id="comentarios"><?php 
					if($existe == true)
					{
						echo $comentarios;
					}
				?></textarea>				
				<br />
				<br />
				<span class="letraDocumentoTitulo">Diagn&oacute;stico de Licencia M&eacute;dica:</span><br />
				<textarea name="diagnosticoLicenciaMedica" cols="120" rows="8" class="letra7" id="diagnosticoLicenciaMedica"><?php 
					if($existe == true)
					{
						echo $diagnosticoLicenciaMedica;
					}
				?></textarea>				
				<br />
				<br />
				<span class="letraDocumentoTitulo">Opini&oacute;n Sobre el Diagn&oacute;stico de la Licencia M&eacute;dica:</span><br />
				<select name="opinionSobreDiagnostico" id="opinionSobreDiagnostico">
					<?php
						if($existe == true)
						{
							?><option value="<?php echo $opinionSobreDiagnostico; ?>" selected="selected"><?php echo $opinionSobreDiagnostico; ?></option><?php 
						}
					?>					
					<option value="DE ACUERDO CON DIAGNOSTICO PSIQUIATRICO PRINCIPAL">DE ACUERDO CON DIAGNOSTICO PSIQUIATRICO PRINCIPAL</option>
					<option value="PACIENTE PRESENTA OTRO DIAGNOSTICO PSIQUIATRICO PRINCIPAL">PACIENTE PRESENTA OTRO DIAGNOSTICO PSIQUIATRICO PRINCIPAL</option>
					<option value="PACIENTE SIN DIAGNOSTICO PSIQUIATRICO">PACIENTE SIN DIAGNOSTICO PSIQUIATRICO</option>
				</select>
				<br />
				<br />
				<span class="letraDocumentoTituloRojo">Diagn&oacute;sticos del Perito</span><br>
				<br>
				<span class="letraDocumentoTitulo">Eje I:</span><br>
				<label>
                <textarea name="eje1" cols="120" rows="5" class="letra7" id="eje1"><?php echo $eje1; ?></textarea>
				<br>
				<br>
				<span class="letraDocumentoTitulo">				Eje II:</span><br>
				</label>
				<input name="eje2" type="text" class="letra7" id="eje2" size="120" value="<?php echo $eje2; ?>">
				<span class="letraDocumentoTitulo">
				<label><br>
				<br>
				Eje III:<br>
				</label>
				</span>
				<textarea name="eje3" cols="120" rows="5" class="letra7" id="eje3"><?php echo $eje3; ?></textarea>
				<span class="letraDocumentoTitulo">
				<label><br>
				<br>
				Eje IV:<br>
				</label>
				</span>
				<textarea name="eje4" cols="120" rows="5" class="letra7" id="eje4"><?php echo $eje4; ?></textarea>
				<span class="letraDocumentoTitulo">
				<label><br>
				<br>
				Eje V:<br>
				</label>
				</span>
				<input name="eje5" type="text" class="letra7" id="eje5" size="120" value="<?php echo $eje5; ?>">
				<br />
				<br />
				<span class="letraDocumentoTitulo">Opini&oacute;n Sobre el Reposo M&eacute;dico:</span><br />
				<select name="opinionReposoMedico" id="opinionReposoMedico" onChange="cambiarReposo(this.form);">
				<?php
 					if($existe == true)
					{
						?><option value="<?php echo $opinionReposoMedico; ?>" selected="selected"><?php echo $opinionReposoMedico; ?></option><?php 
					}
				?>					
					<option value="SI CORRESPONDE">SI CORRESPONDE</option>
					<option value="NO CORRESPONDE">NO CORRESPONDE</option>
				</select>
				<br />
				<br />
				<span class="letraDocumentoTitulo">Si el Reposo Corresponde, Especifique:</span><br />
				<select name="siReposoCorresponde" id="siReposoCorresponde" <?php 
				if($opinionReposoMedico == 'NO CORRESPONDE')
				{
					?>disabled="disabled"<?php
				}
				?>>
					<?php
 					if($existe == true)
					{
						?><option value="<?php echo $siReposoCorresponde; ?>" selected="selected"><?php echo $siReposoCorresponde; ?></option><?php 
					}
					?>					
					<option value="SI CORRESPONDE, PERIODO COMPLETO INDICADO">SI CORRESPONDE, PERIODO COMPLETO INDICADO</option>
					<option value="SI CORRESPONDE, PERO POR PERIODO MENOR AL INDICADO">SI CORRESPONDE, PERO POR PERIODO MENOR AL INDICADO</option>
					<option value="SI CORRESPONDE, PERO REPOSO SE HA PROLONGADO POR TRATAMIENTO INADECUADO">SI CORRESPONDE, PERO REPOSO SE HA PROLONGADO POR TRATAMIENTO INADECUADO</option>
					<option value="SI CORRESPONDE, PERO POR CAUSA MEDICA NO PSIQUIATRICA">SI CORRESPONDE, PERO POR CAUSA MEDICA NO PSIQUIATRICA</option>
				</select>
				<br />
				<br />
				<span class="letraDocumentoTitulo">&iquest;Cu&aacute;ntos D&iacute;as de Reposo Corresponde a Partir de Esta Fecha?:</span><br />
				<select name="cuantosDiasReposo" class="letra7" id="cuantosDiasReposo">
					<?php 
					if($existe == true)
					{
						?><option value="<?php echo $cuantosDiasReposo; ?>" selected="selected"><?php echo $cuantosDiasReposo; ?></option><?php 
					}
					
					for($i=0; $i<=30; $i++)
					{	
						?><option value="<?php echo $i; ?>"><?php echo $i; ?></option><?php 
					}	
					?>
				</select>
				<br />
				<br />
				<span class="letraDocumentoTitulo">Comentario Sobre el Reposo:</span><br />
		<textarea name="comentarios2" cols="120" rows="8" class="letra7" id="comentarios2"><?php 
					if($existe == true)
					{
						echo $comentarios2;
					}
				?></textarea>		
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
				</label>
			</td>
		</tr>
	</table>
</form>
</body>