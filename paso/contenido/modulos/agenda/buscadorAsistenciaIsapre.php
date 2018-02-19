<?php 
	session_name("agenda2");
	session_start();

	include('../../../lib/datos.php');
	include('../../../lib/funciones.php');
	include_once('../../../lib/usuarios/funciones.php');
	include('../../../lib/conectar.php');
	
	$conectar = conectar();
$idUsuario = $_SESSION['idUsuario'];	
$idisa=id_usuarioisapre($idUsuario,$conectar);

?>
<html>
<head>
<script language="javascript" src="<?php echo $LIB; ?>/numeros.js"></script>
<link href="../../../lib/jvalidate/css/style.css" rel="stylesheet" media="screen">

<link href="../../templates/defecto/estilos.css" rel="stylesheet" type="text/css">

<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
		
<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/south-street/jquery-ui.css" />
	<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
	<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
	
      
<script type="text/javascript">
$(function() {
	$('#desde').datepicker({
		dateFormat: 'yy/mm/dd',
		 changeMonth: true, 
		 changeYear: true, 
		 showButtonPanel: true,
		 firstDay: 1,
		 
		 yearRange: '-100:+50'}
		 );
});
$(function() {
    $('#hasta').datepicker({
            dateFormat: 'yy/mm/dd',
            changeMonth: true,
            changeYear: true,
            showButtonPanel: true,
            firstDay: 1,

            yearRange: '-100:+50'}
    );
});
 $.datepicker.regional['es'] = 
  {
  closeText: 'Cerrar', 
  prevText: '<Ant.', 
  nextText: 'Sig.>',
   currentText: 'Hoy',
  monthNames: ['Enero','Febrero','Marzo','Abril','Mayo','Junio',
  'Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'],
  monthNamesShort: ['Ene','Feb','Mar','Abr','May','Jun',
  'Jul','Ago','Sep','Oct','Nov','Dic'],
  monthStatus: 'Ver otro mes', yearStatus: 'Ver otro año',
  dayNames: ['Domingo','Lunes','Martes','Miércoles','Jueves','Viernes','Sábado'],
  dayNamesShort: ['Dom','Lun','Mar','Mie','Jue','Vie','Sáb'],
  dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','Sa'],
  dateFormat: 'dd/mm/yy', firstDay: 1, 
  initStatus: 'Selecciona la fecha', isRTL: false};
 $.datepicker.setDefaults($.datepicker.regional['es']);
</script>



</head>

<body>
<br>
<br>

<form id="formulario" name="formulario" method="post" action="chk_asistenciaPeritajeIsapreEntreFechas.php" >
 <input type="hidden" id="idisapre" name="idisapre" value="<?php echo $idisa;?>"/>
 
  <table  align="center" width="500" border="0" class="bordeTabla1">
  <tr >
    <td colspan="3" align="center" class="fondo_grid2" ><span class="titulo3">Buscador de Asistencia</span></td>
    </tr>
  <tr></tr>
  <tr></tr>
  <tr >
    <td colspan="3">&nbsp;</td>
  </tr>
  <tr >
    <td align="right" width="41%"><span class="letraDocumentoTitulo" style="padding-right:10px;">Desde</span></td>
    
    <td width="246"><input type="text" id="desde" name="desde"  data-type="date"  size="20" required />
        </td>
    </tr>
  <tr >
    <td align="right"><span class="letraDocumentoTitulo" style="padding-right:10px;">Fecha</span></td>
    <td><input type="text" id="hasta" name="hasta"  data-type="date"  size="20" required /></td>
    </tr>
  <tr>
    <td colspan="3">&nbsp;</td>
  </tr>
  </table>

<table align="center" width="500" border="0">
  <tr>
    <td align="center">
    <input  type="submit"  name="submit" id="submit"class="boton" value="Siguiente" />
    </td>
  </tr>
</table>

   
</form>

</body>
<!--script type="text/javascript" src="<?php //echo $LIB; ?>/jvalidate/jquery.Jvalidate.js"></script-->
	<!--script type="text/javascript">
	$('#formulario').Jvalidate({
    language: 'es',
    submit: '#submit',
    success: function(){
    	alert('send!');
      return false;
    }
  });
	</script-->

</html>
