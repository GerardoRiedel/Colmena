<?php 
	session_name("agenda2");
	session_start();
	
	include('../../../lib/pacientes/funciones.php');
	include('../../../lib/isapres/funciones.php');
	include('../../../lib/usuarios/funciones.php');
	include('../../../lib/horas/funciones.php');
	include('../../../lib/informe_trauma/funciones.php');
	include('../../../lib/querys/comunas.php');
	include('../../../lib/querys/ciudades.php');
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
	
		$sqlDatos = "
		SELECT 
			i.`id`, 
			i.`confirmado`,	
			i.`paciente`, 
		    `f_datospaciente`(i.`paciente`,3)as nombrepaciente,
			i.`prestador`,
			i.`hora`, 
			i.`fecha`, 
			i.`ocupacion`, 
			i.`sexo`, 
			i.`edad`, 
			i.`medicoTratante`,
			i.`nombreMedicoTratante`, 
			i.`numeroLicencia`, 
			i.`antecedentesPersonales`, 
			i.`antecedentesMedicos`,
			i.`antecedentestraumatologicos`,
			i.`anamnesis`,
			i.`rxexamenlaboratorio`,
			i.`examenfisico`,
			i.`enfermedadlaboral`,
			i.`tratamientoActual`,
		    i.`ttopendiente`,
		    i.`ttosugerido`,
			LTRIM(RTRIM(REPLACE(i.`diagnosticoLicenciaMedica`,CHAR(9),''))) AS `diagnosticoLicenciaMedica`, 
			i.`diagnosticoTMT`,
			i.`diagnosticoconcomitantes`,
			i.`gradolimitacionfuncional`,
			i.`opinionSobreDiagnostico`,
			i.`comentariosDLM`,
			i.`diasAcumulados`,
			i.`fechaInicioUL`, 
			i.`diasReposoIndicados`, 
			i.`correspondeReposo`, 
			i.`periodo`, 
			i.`comentarios2`,
			 i.`ttoRedGES`,
  			i.`lugarRedGES`

		FROM 
			informe_traumatologico i
		WHERE 
			i.`hora`=".$idHora." ";
			$response =mysql_query($sqlDatos,$conectar);

		$rowDatos = mysql_fetch_array($response);
		
		$id = $rowDatos['id'];
		
		$idPaciente = $rowDatos['paciente'];
		$nombrePaciente =$rowDatos['nombrepaciente'];
		$idPestador = $rowDatos['prestador'];
		$fecha = VueltaFecha($rowDatos['fecha']);
		$ocupacion = $rowDatos['ocupacion'];
		$sexo = $rowDatos['sexo'];
		$edad = $rowDatos['edad'];
		$medicoTratante = caracteres_html_inversa($rowDatos['medicoTratante']);
		$nombreMedicoTratante = caracteres_html_inversa($rowDatos['nombreMedicoTratante']);
		$numeroLicencia = $rowDatos['numeroLicencia'];
		$antecedentesPersonales = caracteres_html_inversa($rowDatos['antecedentesPersonales']);
		$antecedentesMedicos = caracteres_html_inversa($rowDatos['antecedentesMedicos']);
        $antecedentesTraumatologicos = caracteres_html_inversa($rowDatos['antecedentestraumatologicos']);

		$anamnesis = caracteres_html_inversa($rowDatos['anamnesis']);
        $rxexamenlaboratorio=caracteres_html_inversa($rowDatos['rxexamenlaboratorio']);
        $examenfisico=caracteres_html_inversa($rowDatos['examenfisico']);
        $enfermedadLaboral = caracteres_html_inversa($rowDatos['enfermedadlaboral']);

		$tratamientoActual = caracteres_html_inversa($rowDatos['tratamientoActual']);
        $tratamientoPendiente = caracteres_html_inversa($rowDatos['ttopendiente']);
        $tratamientoSugerido = caracteres_html_inversa($rowDatos['ttosugerido']);

		$diagnosticoLicenciaMedica = caracteres_html_inversa($rowDatos['diagnosticoLicenciaMedica']);
		$diagnosticoTMT =caracteres_html_inversa($rowDatos['diagnosticoTMT']) ;
		$diagnosticoconcomitantes =caracteres_html_inversa($rowDatos['diagnosticoconcomitantes']) ;
		$gradolimitacionfuncional=	caracteres_html_inversa($rowDatos['gradolimitacionfuncional']);
		$opinionSobreDiagnostico = caracteres_html_inversa($rowDatos['opinionSobreDiagnostico']);
		$comentariosDLM = caracteres_html_inversa($rowDatos['comentariosDLM']);

		$diasAcumulados = $rowDatos['diasAcumulados'];
		if($diasAcumulados == 0)
		{
			$diasAcumulados = NULL;
		}
		$fechaInicioUL = VueltaFecha($rowDatos['fechaInicioUL']);
		$diasReposoIndicados = $rowDatos['diasReposoIndicados'];
		if($diasReposoIndicados == 0)
		{
			$diasReposoIndicados = NULL;
		}
		$correspondeReposo = $rowDatos['correspondeReposo'];
		$periodo = $rowDatos['periodo'];
		$comentarios2 = caracteres_html_inversa($rowDatos['comentarios2']);
		//$ttoRedGES = $rowDatos['ttoRedGES'] ;
  		//$lugarRedGES = $rowDatos['lugarRedGES'] ;

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
	<!--Hoja de estilos del calendario -->
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
if(tipoUsuario($_SESSION['idUsuario'], $conectar) == 'prestador')
{
	?>
	function init()
	{
		window.setInterval(autoSave,5000);                  // 30 segundos
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
		var antecedentesMedicos = document.getElementById("antecedentesMedicos").value;
        var antecedentesTraumatologicos = document.getElementById("antecedentesTraumatologicos").value;
		var anamnesis = document.getElementById("anamnesis").value;
		var rxexamenlaboratorio =document.getElementById("rxexamenlaboratorio").value ;
        var examenfisico =document.getElementById("examenfisico").value ;
        var enfermedadLaboral = document.getElementById("enfermedadLaboral").value ;
        var tratamientoActual = document.getElementById("tratamientoActual").value;
        var tratamientoPendiente = document.getElementById("tratamientoPendiente").value;
        var tratamientoSugerido = document.getElementById("tratamientoSugerido").value;
        var diagnosticoLicenciaMedica = document.getElementById("diagnosticoLicenciaMedica").value;
		var diagnosticoTMT = document.getElementById("diagnosticoTMT").value;
		var diagnosticoconcomitantes = document.getElementById("diagnosticoconcomitantes").value;
        var gradolimitacionfuncional = document.getElementById("gradolimitacionfuncional").value;
		var opinionSobreDiagnostico = document.getElementById("opinionSobreDiagnostico").value;
		var comentariosDLM = document.getElementById("comentariosDLM").value;
        var diasAcumulados = document.getElementById("diasAcumulados").value;
		var fechaInicioUL = document.getElementById("fechaInicioUL").value;
		var diasReposoIndicados = document.getElementById("diasReposoIndicados").value;
		var correspondeReposo = document.getElementById("correspondeReposo").value;
		var periodo = document.getElementById("periodo").value;

		var comentarios2 = document.getElementById("comentarios2").value;

        var params = "idHora="+idHora+"&fecha="+fecha+"&ocupacion="+ocupacion+"&sexo="+sexo+"&edad="+edad+"&medicoTratante="+medicoTratante+"&nombreMedicoTratante="+nombreMedicoTratante+"&numeroLicencia="+numeroLicencia+"&antecedentesPersonales="+antecedentesPersonales+"&antecedentesMedicos="+antecedentesMedicos+"&antecedentesTraumatologicos="+antecedentesTraumatologicos+"&anamnesis="+anamnesis+"&rxexamenlaboratorio="+rxexamenlaboratorio+"&examenfisico="+examenfisico+"&enfermedadLaboral="+enfermedadLaboral+"&tratamientoActual="+tratamientoActual+"&tratamientoPendiente="+tratamientoPendiente+"&tratamientoSugerido="+tratamientoSugerido+"&diagnosticoLicenciaMedica="+diagnosticoLicenciaMedica+"&diagnosticoTMT="+diagnosticoTMT+"&diagnosticoconcomitantes="+diagnosticoconcomitantes+"&gradolimitacionfuncional="+gradolimitacionfuncional+ "&opinionSobreDiagnostico="+opinionSobreDiagnostico+"&comentariosDLM="+comentariosDLM+"&diasAcumulados="+diasAcumulados+"&fechaInicioUL="+fechaInicioUL+"&diasReposoIndicados="+diasReposoIndicados+"&correspondeReposo="+correspondeReposo+"&periodo="+periodo+"&comentarios2="+comentarios2;

        var http = getHTTPObject();
		http.onreadystatechange = function(){
            var ahora = new Date();
            var msg = "" ;
            if(http.readyState==4 && http.status==200){
				msg = document.getElementById("msg");
				msg.innerHTML = "<span style=\"background-color:#2FA32F;\">Informe autoguardado a las "+ahora.getHours()+":"+ahora.getMinutes()+":"+ahora.getSeconds()+"&nbsp;&nbsp;&nbsp;&nbsp;</span>";
			}
			else
			{
				msg = document.getElementById("msg");
				msg.innerHTML = "<span style=\"background-color:#FFB0B0\">No se ha guardado el informe</span>";
			}
		};
		http.open("POST", 'chk_informeEntrevistaTraumatologicoAutosave.php', true);
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

function enviarpdf(idHora)
{
    window.location.href = '<?php echo $MODULOS; ?>/agenda/chk_informeEntrevistaSegundaNuevoxml.php?idHora='+ idHora;
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
		var antecedentesMedicos = document.getElementById("antecedentesMedicos").value;
		var antecedentesTraumatologicos = document.getElementById("antecedentesTraumatologicos").value;
		var anamnesis = document.getElementById("anamnesis").value;
		var rxexamenlaboratorio =document.getElementById("rxexamenlaboratorio").value ;
		var examenfisico =document.getElementById("examenfisico").value ;
		var enfermedadLaboral = document.getElementById("enfermedadLaboral").value ;
		var tratamientoActual = document.getElementById("tratamientoActual").value;
		var tratamientoPendiente = document.getElementById("tratamientoPendiente").value;
		var tratamientoSugerido = document.getElementById("tratamientoSugerido").value;
		var diagnosticoLicenciaMedica = document.getElementById("diagnosticoLicenciaMedica").value;
		var diagnosticoTMT = document.getElementById("diagnosticoTMT").value;
		var diagnosticoconcomitantes = document.getElementById("diagnosticoconcomitantes").value;
		var gradolimitacionfuncional = document.getElementById("gradolimitacionfuncional").value;
		var opinionSobreDiagnostico = document.getElementById("opinionSobreDiagnostico").value;
		var comentariosDLM = document.getElementById("comentariosDLM").value;
		var diasAcumulados = document.getElementById("diasAcumulados").value;
		var fechaInicioUL = document.getElementById("fechaInicioUL").value;
		var diasReposoIndicados = document.getElementById("diasReposoIndicados").value;
		var correspondeReposo = document.getElementById("correspondeReposo").value;
		var periodo = document.getElementById("periodo").value;

		var comentarios2 = document.getElementById("comentarios2").value;

		var params = "idHora="+idHora+"&fecha="+fecha+"&ocupacion="+ocupacion+"&sexo="+sexo+"&edad="+edad+"&medicoTratante="+medicoTratante+"&nombreMedicoTratante="+nombreMedicoTratante+"&numeroLicencia="+numeroLicencia+"&antecedentesPersonales="+antecedentesPersonales+"&antecedentesMedicos="+antecedentesMedicos+"&antecedentesTraumatologicos="+antecedentesTraumatologicos+"&anamnesis="+anamnesis+"&rxexamenlaboratorio="+rxexamenlaboratorio+"&examenfisico="+examenfisico+"&enfermedadLaboral="+enfermedadLaboral+"&tratamientoActual="+tratamientoActual+"&tratamientoPendiente="+tratamientoPendiente+"&tratamientoSugerido="+tratamientoSugerido+"&diagnosticoLicenciaMedica="+diagnosticoLicenciaMedica+"&diagnosticoTMT="+diagnosticoTMT+"&diagnosticoconcomitantes="+diagnosticoconcomitantes+"&gradolimitacionfuncional="+gradolimitacionfuncional+ "&opinionSobreDiagnostico="+opinionSobreDiagnostico+"&comentariosDLM="+comentariosDLM+"&diasAcumulados="+diasAcumulados+"&fechaInicioUL="+fechaInicioUL+"&diasReposoIndicados="+diasReposoIndicados+"&correspondeReposo="+correspondeReposo+"&periodo="+periodo+"&comentarios2="+comentarios2;

		var http = getHTTPObject();
		http.onreadystatechange = function(){
            var ahora = new Date();
			
            if(http.readyState==4 && http.status==200){
				msg = document.getElementById("msg");
				msg.innerHTML = "<span style=\"background-color:#2FA32F;\">Informe guardado por usted a las "+ahora.getHours()+":"+ahora.getMinutes()+":"+ahora.getSeconds()+"&nbsp;&nbsp;&nbsp;&nbsp;</span>";			}
			else
			{
				msg = document.getElementById("msg");
				msg.innerHTML = "<span style=\"background-color:#FFB0B0\">No se ha guardado el informe</span>";
			}
		};
		http.open("POST", 'chk_informeEntrevistaTraumatologicoAutosave.php', true);
		http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		// http.setRequestHeader("Content-length", params.length);
		// http.setRequestHeader("Connection", "close");
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
	
	function cambiarDonde(form)
	{
		if(form.ttoRedGES.value == 'SI')
		{
			muestraTabla('tabladonde');
			form.lugarRedGES.disabled = false;
		}
		else
		{
			ocultaTabla('tabladonde');
			form.lugarRedGES.disabled = true;
		}
	}


/// autoguadado jquery

	
</script>

<link href="../../templates/defecto/estilos.css" rel="stylesheet" type="text/css">
<link href="../../../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
<link href="../../../SpryAssets/SpryValidationTextarea.css" rel="stylesheet" type="text/css" />
<link href="../../../SpryAssets/SpryValidationSelect.css" rel="stylesheet" type="text/css" />
</head>
<body
    <?php if(tipoUsuario($_SESSION['idUsuario'], $conectar) == 'prestador' && existeInformeEntrevista2($idHora, $conectar) == 1){?>onLoad="init();"<?php }?>
    >


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
<form id="form" name="form" method="post" action="chk_informeEntrevistaTraumatologicoNuevo.php">
<table width="474" border="0" align="center" cellpadding="0" cellspacing="0" class="borde_tabla" style="border-collapse:collapse;">
		<tr>
			<td height="29" colspan="2" align="center" class="tituloTablas">Informe de Entrevista Traumatologico de Peritaje </td>
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
				  <option value="<?php echo $medicoTratante; ?>"><?php echo $medicoTratante; ?></option>

					<?php 
					if($existe == true)
					{
						?>
						<?php 
					}
					?>
					<option value="TRAUMATOLOGO">TRAUMATOLOGO</option>
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
	<table width="753" border="0" align="center" cellpadding="0" cellspacing="0" class="borde_tabla" style="border-collapse:collapse;">
		<tr>
			<td width="753" height="25" class="tituloTablas">Historia Clínica</td>
		</tr>
	  <tr>
		<td style="padding-left:10px; padding-top:5px; padding-bottom:5px;"><table width="200" border="0">
			  <tr>
			    <th align="left" scope="col"><span class="informeTituloCampo">Antecedentes Personales</span><br /></th>
			    <th valign="bottom" scope="col">&nbsp;</th>
		      </tr>
			  <tr>
			    <th scope="row"><textarea name="antecedentesPersonales" cols="120" rows="8" class="letra7" id="antecedentesPersonales"><?php if($existe == true){echo $antecedentesPersonales;}?></textarea></th>
			    <th valign="bottom"><input type="button" name="grabaCampos" id="grabaCampos" value="grabar" onclick="grabaCamposInforme();" /></th>
		      </tr>
			  <tr>
			    <th align="left" scope="row"><span class="informeTituloCampo">Antecedentes Médicos</span></th>
			    <th valign="bottom">&nbsp;</th>
		      </tr>
			  <tr>
			    <th scope="row"><textarea name="antecedentesMedicos" cols="120" rows="8" class="letra7" id="antecedentesMedicos"><?php if($existe == true){echo $antecedentesMedicos;}?></textarea></th>
			    <th valign="bottom"><input type="button" name="grabaCampos6" id="grabaCampos6" value="grabar" onclick="grabaCamposInforme();" /></th>
		      </tr>
			  <tr>
			    <th align="left" scope="row"><span class="informeTituloCampo">Antecedentes Traumatol&oacute;gicos</span></th>
			    <th valign="bottom">&nbsp;</th>
		      </tr>
			  <tr>
			    <th scope="row"><textarea name="antecedentesTraumatologicos" cols="120" rows="8" class="letra7" id="antecedentesTraumatologicos"><?php if($existe == true){echo $antecedentesTraumatologicos;}?></textarea></th>
			    <th valign="bottom"><input type="button" name="grabaCampos7" id="grabaCampos7" value="grabar" onclick="grabaCamposInforme();" /></th>
		      </tr>
			  <tr>
			    <th align="left" scope="row"><span class="informeTituloCampo">Anamnesis (Señalar Origen del cuadro)</span></th>
			    <th valign="bottom">&nbsp;</th>
		      </tr>
			  <tr>
			    <th scope="row"><textarea name="anamnesis" cols="120" rows="8" class="letra7" id="anamnesis"><?php if($existe == true){echo $anamnesis;}?></textarea></th>
			    <th valign="bottom"><input type="button" name="grabaCampos3" id="grabaCampos3" value="grabar" onclick="grabaCamposInforme();" /></th>
		      </tr>
			  <tr>
			    <th align="left" scope="row"><span class="informeTituloCampo">Imagenes y Examenes de Laboratotrio </span></th>
			    <th valign="bottom">&nbsp;</th>
		      </tr>
			  <tr>
			    <th scope="row"><textarea name="rxexamenlaboratorio" cols="120" rows="8" class="letra7" id="rxexamenlaboratorio"><?php if($existe == true){echo $rxexamenlaboratorio;}?></textarea></th>
			    <th valign="bottom"><input type="button" name="grabaCampos4" id="grabaCampos4" value="grabar" onclick="grabaCamposInforme();" /></th>
		      </tr>
			  <tr>
			    <th align="left" scope="row"><span class="informeTituloCampo">Examen Físico</span></th>
			    <th valign="bottom">&nbsp;</th>
		      </tr>
			  <tr>
			    <th scope="row"><textarea name="examenfisico" cols="120" rows="8" class="letra7" id="examenfisico"><?php if($existe == true){echo $examenfisico;}?></textarea></th>
			    <th valign="bottom"><input type="button" name="grabaCampos2" id="grabaCampos2" value="grabar" onclick="grabaCamposInforme();" /></th>
		      </tr>
			  <tr>
			    <th scope="row">&nbsp;</th>
			    <th valign="bottom">&nbsp;</th>
		      </tr>
			  </table>
		  <table width="291" border="0">
			    <tr>
			      <td width="135" align="left" class="informeTituloCampo" scope="col">Origen Laboral</td>
			      <th width="55" scope="col"><label for="laboral"></label>
			       <select name="enfermedadLaboral" id="enfermedadLaboral" >
				    <?php 
						if($existe == true)
						{
							?>
				    <option value="<?php echo $enfermedadLaboral; ?>"><?php echo $enfermedadLaboral; ?></option>
				    <?php
						}
						?>
					<option value=""></option>	
				    <option value="NO">NO</option>
				    <option value="SI">SI</option>
			      </select>
                  </th>
	        </tr>
	      </table>
		  <p>&nbsp;</p>
			
	    </td>
			</tr>
			<tr>
				<td height="25" class="tituloTablas">Tratamiento Actual</td>
		</tr>
			<tr>
			  <td style="padding-left:10px; padding-top:5px; padding-bottom:5px;">
				<span class="informeTituloCampo">Tratamiento Actual</span><br />
				
				<table width="200" border="0">
				  <tr>
				    <th scope="col"><textarea name="tratamientoActual" cols="120" rows="8" class="letra7" id="tratamientoActual"><?php if($existe == true){echo $tratamientoActual;}?></textarea></th>
				    <th valign="bottom" scope="col"><input type="button" name="grabaCampos5" id="grabaCampos5" value="grabar" onclick="grabaCamposInforme();" /></th>
			      </tr>
				  <tr>
				    <th align="left" scope="row"><span class="informeTituloCampo">Tratamientos pendientes </span></th>
				    <th scope="row">&nbsp;</th>
			      </tr>
				  <tr>
				    <th scope="row"><textarea name="tratamientoPendiente" cols="120" rows="8" class="letra7" id="tratamientoPendiente"><?php if($existe == true){echo $tratamientoPendiente;}?></textarea></th>
				    <th valign="bottom"><input type="button" name="grabaCampos23" id="grabaCampos23" value="grabar" onclick="grabaCamposInforme();" /></th>
			      </tr>
				  <tr>
				    <th align="left" scope="row"><span class="informeTituloCampo">Tratamiendo Sugerido </span></th>
				    <th>&nbsp;</th>
			      </tr>
				  <tr>
				    <th scope="row"><textarea name="tratamientoSugerido" cols="120" rows="8" class="letra7" id="tratamientoSugerido"><?php if($existe == true){echo $tratamientoSugerido;}?></textarea></th>
				    <th valign="bottom"><input type="button" name="grabaCampos24" id="grabaCampos24" value="grabar" onclick="grabaCamposInforme();" /></th>
			      </tr>
				  <tr>
				    <th scope="row">&nbsp;</th>
				    <th>&nbsp;</th>
			      </tr>
			    </table>
				</td>
			</tr>
			<tr>
				<td height="25" class="tituloTablas">Diagnóstico de la Licencia Médica N&deg; <?php echo $numeroLicencia; ?></td>
		</tr>
			<tr>
				<td style="padding-left:10px; padding-top:5px; padding-bottom:5px;">
				<span class="informeTituloCampo">Diagn&oacute;stico de Licencia M&eacute;dica N&deg; <?php echo $numeroLicencia; ?></span><br />
				
				<table width="200" border="0">
				  <tr>
				    <th><input name="diagnosticoLicenciaMedica" type="text" class="letra7" id="diagnosticoLicenciaMedica" value="<?php if($existe == true){echo $diagnosticoLicenciaMedica;}?>" size="120" /></th>
				    <th valign="bottom" scope="col"><input type="button" name="grabaCampos8" id="grabaCampos8" value="grabar" onclick="grabaCamposInforme();" /></th>
			      </tr>
				  </table>
				<span class="informeTituloCampo">Opini&oacute;n Sobre el Diagn&oacute;stico de Licencia M&eacute;dica N&deg; <?php echo $numeroLicencia; ?></span><br />
				  <select name="opinionSobreDiagnostico" id="opinionSobreDiagnostico">
				    <option value="<?php echo $opinionSobreDiagnostico; ?>"><?php echo $opinionSobreDiagnostico; ?></option>
				    <option value="DE ACUERDO CON DIAGNOSTICO TRAUMATOLOGICO PRINCIPAL">DE ACUERDO CON DIAGNOSTICO TRAUMATOLOGICO PRINCIPAL</option>
				    <option value="PACIENTE NO TIENE DIAGNOSTICO TRAUMATOLOGICO">PACIENTE NO TIENE DIAGNOSTICO TRAUMATOLOGICO</option>
				    <?php
						if($existe == true)
						{
							?>
				    <?php 
						}
					?>
</select>
				  <input type="button" name="grabaCampos9" id="grabaCampos9" value="grabar" onclick="grabaCamposInforme();" /><br />
				  <br />
				  <span class="informeTituloCampo">Comentarios</span><br />
				  </p>
				<span id="sprytextarea6">
                <label>
                  <textarea name="comentariosDLM" cols="120" rows="5" class="letra7" id="comentariosDLM"><?php if($existe == true){echo $comentariosDLM;}?></textarea>
                <span class="letra7" id="countsprytextarea6">&nbsp;</span></label>
<span class="textareaMaxCharsMsg">*</span></span>
           <input type="button" name="grabaCampos10" id="grabaCampos10" value="grabar" onclick="grabaCamposInforme();" /><br />
				<br />
				</td>
			</tr>
			<tr>
				<td height="25" class="tituloTablas">Hípotesis Diagnóstica</td>
		</tr>
			<tr>
				<td style="padding-left:10px; padding-top:5px; padding-bottom:5px;">
				  <table width="200" border="0">
				  <tr>
				    <th align="left" ><span class="informeTituloCampo">Diagnóstico TMT</span></th>
				    <th scope="col">&nbsp;</th>
			      </tr>
				  <tr>
				    <th ><label for="diagnosticoTMT"></label>
			        <textarea name="diagnosticoTMT" cols="120" rows="8" class="letra7" id="diagnosticoTMT"><?php if($existe == true){echo $diagnosticoTMT;}?></textarea></th>
				    <th valign="bottom"><input type="button" name="grabaCampos11" id="grabaCampos11" value="grabar" onclick="grabaCamposInforme();" /></th>
			      </tr>
				  <tr>
				    <th align="left" scope="row"><span class="informeTituloCampo">Diagnóstico médico concomitantes</span></th>
				    <th>&nbsp;</th>
			      </tr>
				  <tr>
				    <th scope="row"><label for="diagnosticoconcomitante"></label>
			        <textarea name="diagnosticoconcomitantes" cols="120" rows="8" class="letra7" id="diagnosticoconcomitantes"><?php if($existe == true){echo $diagnosticoconcomitantes;}?></textarea></th>
				    <th valign="bottom"><input type="button" name="grabaCampos12" id="grabaCampos12" value="grabar" onclick="grabaCamposInforme();" /></th>
			      </tr>
				  <tr>
				    <th align="left" scope="row"><span class="informeTituloCampo">Grado de limitacion funcional</span></th>
				    <th>&nbsp;</th>
			      </tr>
				  <tr>
				    <th scope="row"><label for="gradolimitacionfuncional"></label>
			        <textarea name="gradolimitacionfuncional" cols="120" rows="8" class="letra7" id="gradolimitacionfuncional"><?php if($existe == true){echo $gradolimitacionfuncional;}?></textarea></th>
				    <th valign="bottom"><input type="button" name="grabaCampos13" id="grabaCampos13" value="grabar" onclick="grabaCamposInforme();" /></th>
			      </tr>
				  </table>
							
			  <br /></td>
	  </tr>
			<tr>
				<td height="25" class="tituloTablas">Conclusión sobre el Reposo Médico</td>
		</tr>
			<tr>
				<td style="padding-left:10px; padding-top:5px; padding-bottom:5px;"><span class="informeTituloSeccion">I)</span><span class="informeTituloCampo"><br />
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
				<table width="400" border="0" cellspacing="0" cellpadding="0" id="tablaCorrespondeReposo" style="<?php if($correspondeReposo != 'SI'){  ?>display:none;<?php } ?>border:none;">
					<tr>
						<td width="678" style="padding-left:15px;"><span class="informeTituloCampo">Período</span><br />
							<label>
								<select name="periodo"  id="periodo"  <?php 
									if($existe == true)
									{
										if($correspondeReposo != 'SI')
										{
											?><?php }}?>>
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
				<table width="500" border="1" cellspacing="0" cellpadding="0" id="pronosticoReintegroTabla" <?php if($pronosticoReintegro != 'CON UN TRATAMIENTO ADECUADO PACIENTE EN CONDICIONES DE REINTEGRARSE EN [ ] DIAS A SU ACTIVIDAD LABORAL'){  ?>style="display:none;"<?php } ?>>
					<tr>
					</tr>
				</table>
				<span class="informeTituloSeccion">III)</span><br />
				<span class="informeTituloCampo">Conclusión  respecto del reintegro laboral al examen actual del paciente</span><br />
				<span id="sprytextarea1">
				<textarea name="comentarios2" cols="120" rows="8" class="letra7" id="comentarios2"><?php if($existe == true){echo $comentarios2;}?></textarea>
				<span class="textareaRequiredMsg">*</span></span><input type="button" name="grabaCampos21" id="grabaCampos21" value="grabar" onclick="grabaCamposInforme();" /></td>
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
					<input name="confirmado" type="hidden" id="confirmado" value="<?php echo $confirmado; ?>" />
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
                    <input type="button"  onclick="publicar(<?php echo $idHora; ?>)" value="Publicar" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
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
var sprytextarea6 = new Spry.Widget.ValidationTextarea("sprytextarea6", {maxChars:150, counterId:"countsprytextarea6", counterType:"chars_remaining", isRequired:false});

//-->
</script>
</body>