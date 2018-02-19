<?php 
session_name("agenda2");
session_start();

include('../../../lib/informe_entrevista/funciones.php');
include('../../../lib/usuarios/funciones.php');
include('../../../lib/datos.php');
include('../../../lib/funciones.php');
include('../../../lib/conectar.php');

$conectar = conectar();

$datosInformeId = datosInformeId($_GET['id'], $conectar);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Frameset//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-frameset.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Confirmación de informe</title>
<link href="../../templates/defecto/estilos.css" rel="stylesheet" type="text/css">
</head>
<frameset rows="10%,90%" cols="*" framespacing="0" frameborder="no" border="0">
	<frame src="informesSinConfirmarInforme.php?id=<?php echo $_GET['id']; ?>" name="mainFrame" id="mainFrame" title="mainFrame" style="height:100px"/>
	<frame src="chk_informeEntrevistaSegundaDescargaNuevo.php?id=<?php echo $datosInformeId['hora']; ?>" name="bottomFrame" scrolling="No" noresize="noresize" id="bottomFrame" title="bottomFrame" style="height:200px"/>
</frameset>
<noframes><body>
</body></noframes>
</html>
