<?php
	session_name("agenda2");
	session_start();

	include('../../../lib/pacientes/funciones.php');
	include('../../../lib/isapres/funciones.php');
	include('../../../lib/usuarios/funciones.php');
	include('../../../lib/horas/funciones.php');
	include('../../../lib/informe_entrevista/funciones.php');
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

		$sqlDatos = mysql_query("
		SELECT
			i.`id`,
			i.`confirmado`,
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
			i.`pronosticoReintegro`,
			i.`comentarios2`,
			 i.`ttoRedGES`,
  			i.`lugarRedGES`
		FROM
			informe_entrevista i
		WHERE
			i.`hora`=".$idHora."
		", $conectar);

		$rowDatos = mysql_fetch_array($sqlDatos);

		$id = $rowDatos['id'];

		$idPaciente = $rowDatos['paciente'];
		$idPestador = $rowDatos['prestador'];
		$fecha = VueltaFecha($rowDatos['fecha']);
		$ocupacion = $rowDatos['ocupacion'];
		$sexo = $rowDatos['sexo'];
		$edad = $rowDatos['edad'];
		$tiempoLicencia = $rowDatos['tiempoLicencia'];
		$medicoTratante = caracteres_html_inversa($rowDatos['medicoTratante']);
		$nombreMedicoTratante = caracteres_html_inversa($rowDatos['nombreMedicoTratante']);
		$numeroLicencia = $rowDatos['numeroLicencia'];
		$antecedentesPersonales = caracteres_html_inversa($rowDatos['antecedentesPersonales']);
		$antecedentesMorbidos = caracteres_html_inversa($rowDatos['antecedentesMorbidos']);
		$factoresEstresantes = caracteres_html_inversa($rowDatos['factoresEstresantes']);
		$anamnesis = caracteres_html_inversa($rowDatos['anamnesis']);
		$examenMental = caracteres_html_inversa($rowDatos['examenMental']);
		$tratamientoActual = caracteres_html_inversa($rowDatos['tratamientoActual']);
		$opinionTratamiento = caracteres_html_inversa($rowDatos['opinionTratamiento']);
		$comentarios = caracteres_html_inversa($rowDatos['comentarios']);
		$diagnosticoLicenciaMedica = caracteres_html_inversa($rowDatos['diagnosticoLicenciaMedica']);
		$opinionSobreDiagnostico = caracteres_html_inversa($rowDatos['opinionSobreDiagnostico']);
		$comentariosDLM = caracteres_html_inversa($rowDatos['comentariosDLM']);
		$eje1 = caracteres_html($rowDatos['eje1']);
		$eje2 = caracteres_html_inversa($rowDatos['eje2']);
		$eje3 = caracteres_html_inversa($rowDatos['eje3']);
		$eje4 = caracteres_html_inversa($rowDatos['eje4']);
		$eje5 = caracteres_html_inversa($rowDatos['eje5']);
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
		$pronosticoReintegro=$rowDatos['pronosticoReintegro'];
		$comentarios2 = caracteres_html_inversa($rowDatos['comentarios2']);
		$ttoRedGES = $rowDatos['ttoRedGES'] ;
  		$lugarRedGES = $rowDatos['lugarRedGES'] ;
	}

	$idPacienteHora = idPacienteHora($idHora, $conectar);
?>


<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Documento sin título</title>
 <script type="text/javascript">
<?php
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
    var ttoRedGES = document.getElementById("ttoRedGES");
    var lugarRedGES = document.getElementById("lugarRedGES") ;

    var params = "idHora="+idHora+"&fecha="+fecha+"&ocupacion="+ocupacion+"&sexo="+sexo+"&edad="+edad+"&medicoTratante="+medicoTratante+"&nombreMedicoTratante="+nombreMedicoTratante+"&numeroLicencia="+numeroLicencia+"&antecedentesPersonales="+antecedentesPersonales+"&antecedentesMorbidos="+antecedentesMorbidos+"&factoresEstresantes="+factoresEstresantes+"&anamnesis="+anamnesis+"&examenMental="+examenMental+"&tratamientoActual="+tratamientoActual+"&opinionTratamiento="+opinionTratamiento+"&comentarios="+comentarios+"&diagnosticoLicenciaMedica="+diagnosticoLicenciaMedica+"&opinionSobreDiagnostico="+opinionSobreDiagnostico+"&comentariosDLM="+comentariosDLM+"&eje1="+eje1+"&eje2="+eje2+"&eje3="+eje3+"&eje4="+eje4+"&eje5="+eje5+"&diasAcumulados="+diasAcumulados+"&fechaInicioUL="+fechaInicioUL+"&diasReposoIndicados="+diasReposoIndicados+"&correspondeReposo="+correspondeReposo+"&periodo="+periodo+"&comentarios2="+comentarios2+"&ttoRedGES="+ttoRedGES+"&lugarRedGES="+lugarRedGES;

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
 </script>
</head>

<body>
<form class="form-horizontal">
    <div class="form-group">
        <label class="control-label col-xs-3">Fecha:</label>
        <div class="col-xs-9">
            <input type="date" class="form-control" id="fecha" placeholder="Ingrese fecha">

        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-xs-3">Ocupacion:</label>
        <div class="col-xs-9">
             <select class="form-control">
                <option>Ocupacion</option>
            </select>
        </div>
    </div>
    <div class="form-group">Sexo
      <div class="col-xs-9">
            <select class="form-control">
                <option>Sexo</option>
            </select>
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-xs-3">Edad:</label>
        <div class="col-xs-9">
            <input type="text" class="form-control" placeholder="Nombre">
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-xs-3">Médico Tratante:</label>
        <div class="col-xs-9">
 <select class="form-control">
                <option>Medico Tratante</option>
            </select>
                    </div>
    </div>
    <div class="form-group">
        <label class="control-label col-xs-3" >Nombre Médico Tratnte:</label>
        <div class="col-xs-9">
            <input type="text" class="form-control" placeholder="Telefono">
        </div>
    </div>
      <div class="form-group">
        <label class="control-label col-xs-3" >Numero de Licencia:</label>
        <div class="col-xs-9">
            <input type="text" class="form-control" placeholder="Telefono">
        </div>
    </div>
      
    
    <div class="form-group">Historia Clinica
       <div class="form-group">
        <label class="control-label col-xs-3" >Antecedentes Personales:</label>
      <div class="col-xs-3">
          <textarea rows="3" class="form-control" placeholder="Antecedentes Personales"></textarea>
        </div>
        </div>
        <div class="form-group">
        <label class="control-label col-xs-3" >Antecedentes Morbidos:</label>
        <div class="col-xs-3">
              <textarea rows="3"  class="form-control" placeholder="Antecedentes Morbidos"></textarea>
        </div>
        </div>
        <div class="form-group">
        <label class="control-label col-xs-3" >Factores Estresantes:</label>
        <div class="col-xs-3">
              <textarea rows="3"  class="form-control" placeholder="Factores Estresantes"></textarea>
        </div>
        </div>
        <div class="form-group">
        <label class="control-label col-xs-3" >Anamnesis:</label>
         <div class="col-xs-3">
              <textarea rows="3"  class="form-control" placeholder="Anannesis"></textarea>
        </div>
       </div>
    <div class="form-group">
        <label class="control-label col-xs-3" >Exámen Mental:</label>
         <div class="col-xs-3">
              <textarea rows="3" class="form-control" placeholder="Anannesis"></textarea>
        </div>
        
    </div>
    
    <div class="form-group">Tratamiento Actual
       <div class="form-group">
        <label class="control-label col-xs-3" >Tratamiento Actual:</label>
      <div class="col-xs-3">
           <textarea rows="3"  class="form-control" placeholder="Tratamiento Actual"></textarea>
        </div>
        </div>
        <div class="form-group">
        <label class="control-label col-xs-3" >Paciente Refiere Tratameiento en Red Ges:</label>
        <div class="col-xs-3">
               <select class="form-control">
                <option>SI</option>
            </select>
        </div>
        </div>
        <div class="form-group">
        <label class="control-label col-xs-3" >Opinión Sobre Tratamiento Farmacológico
:</label>
        <div class="col-xs-3">
               <select class="form-control">
                <option>Paciente No cumple indicacion</option>
            </select>
        </div>
        </div>
        <div class="form-group">
        <label class="control-label col-xs-3" >Comentario Sobre el Tratamiento Actual
:</label>
         <div class="col-xs-3">
              <textarea rows="3" class="form-control" placeholder="Anannesis"></textarea>
        </div>
       </div>
    <div class="form-group">
        <label class="control-label col-xs-3" >Exámen Mental:</label>
         <div class="col-xs-3">
              <textarea rows="3"  class="form-control" placeholder="Anannesis"></textarea>
        </div>
        
    </div>
    

     
    <div class="form-group">Diagnóstico de la Licencia Médica N°
       <div class="form-group">
        <label class="control-label col-xs-3" >Diagnóstico de Licencia Médica N°:</label>
      <div class="col-xs-3">
           <textarea rows="3"  class="form-control" placeholder="Diagnostico Licencia"></textarea>
        </div>
        </div>
        <div class="form-group">
        <label class="control-label col-xs-3" >Opinión Sobre el Diagnóstico de Licencia Médica N°:</label>
        <div class="col-xs-3">
             <select class="form-control">
                  <option>Deacuerdo con ....</option>
            </select>
        </div>
        </div>
  <div class="form-group">
Comentarios:</label>
        <div class="col-xs-3">
              <textarea rows="3"  class="form-control" placeholder="Comentarios"></textarea>
        </div>
        </div>
        <div class="form-group">Diagnóstico del Perito
        <div class="form-group">
        <label class="control-label col-xs-3" >Eje I:</label>
      <div class="col-xs-3">
           <input type="text" class="form-control" placeholder="Eje I">
        </div>
        </div>
        <div class="form-group">
        <label class="control-label col-xs-3" >Eje II:</label>
        <div class="col-xs-3">
              <input type="text" class="form-control" placeholder="Eje II">
        </div>
        </div>
        <div class="form-group">Eje III:</label>
        <div class="col-xs-3">
              <textarea rows="3" class="form-control" placeholder="Eje III"></textarea>
        </div>
        </div>

		<div class="form-group">Eje IV:</label>
        <div class="col-xs-3">
              <textarea rows="3" class="form-control" placeholder="Eje IV"></textarea>
        </div>
        </div>

<div class="form-group">Eje V:</label>
        <div class="col-xs-3">
              <input type="text" class="form-control" placeholder="Eje V">
        </div>
        </div>

 <div class="form-group">Conclusión sobre el Reposo Médico
        <div class="panel-group" id="accordion">
  
  
   <div class="panel panel-success">
	  
          <div class="panel-heading">
          <h4 class="panel-title">
            <a data-toggle="collapse" data-parent="#accordion" href="#accordionTwo">
              Informacion sobre Conclusion
            </a>
          </h4>
          </div>
		 
        <div id="accordionTwo" class="panel-collapse collapse">
          <div class="panel-body">
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
          </div>
        </div>
		
   </div>
   
   
	 
 </div>
        
        
        <div class="form-group">
        
        <label class="control-label col-xs-3" >I)
Días acumulados  de reposo a la fecha de hoy día (incluye licencia N°):</label>
      <div class="col-xs-3">
           <input type="text" class="form-control" placeholder="Dias <"Dias Acumulados">
        </div>
        </div>
        <div class="form-group">
        <label class="control-label col-xs-3" >Fecha de inicio de licencia N°:</label>
        <div class="col-xs-3">
              <input type="text" class="form-control" placeholder="Fecha Inicio Lic.">
        </div>
        </div>
        <div class="form-group">Días de reposo indicados en licencia N° :</label>
        <div class="col-xs-3">
              <input type="text" class="form-control" placeholder="Dias Reposo">
        </div>
        </div>

		<div class="form-group">II)Respecto a licencia N° , corresponde reposo
:</label>
        <div class="col-xs-3">
 <select class="form-control">
                <option>si</option>
            </select>
                    </div>
        </div>

<div class="form-group">III)
Conclusión respecto del reintegro laboral al examen actual del paciente:</label>
        <div class="col-xs-3">
              <input type="text" class="form-control" placeholder="conclusion">
        </div>
        </div>


<div class="form-group">IV)	Enfermedad de Origen Laboral 
:</label>
        <div class="col-xs-3">
 <select class="form-control">
                <option>Si</option>
            </select>        
            </div>
     </div>
 
    
    
    <br>
    <div class="form-group">
        <div class="col-xs-offset-3 col-xs-9">
            <input type="submit" class="btn btn-primary" value="Enviar">
            <input type="reset" class="btn btn-default" value="Limpiar">
        </div>
    </div>
</form>

</body>
</html>
