<?php 

	session_name("agenda2");

	session_start();



	include('../../../lib/funciones.php');

	include('../../../lib/datos.php');

	include('../../../lib/horas/funciones.php');

	include('../../../lib/prestadores/funciones.php');

	include('../../../lib/informe_entrevista/funciones.php');

	include('../../../lib/usuarios/funciones.php');

	include('../../../lib/conectar.php');
	
	date_default_timezone_set('America/Santiago');	

	$conectar = conectar();

	setlocale(LC_ALL,"SP");

	$fechaActual = strftime("%Y")."-".strftime("%m")."-".strftime("%d");

		//$fechaActual = editames($fechaActual);

//	$fechaActual = invertirFecha(cambiaf_a_mysql($fechaActual));



	if(siEstaLogueado() == false)

	{

		header('Location: '.$HOME);

	}



	$informe = $_GET['informe'];

	$datosInformeId = datosInformeId($informe, $conectar);

	$sqlu="UPDATE 	informe_entrevista SET `confirmado`=1, 

		`fechaConfirmacion`= '".$fechaActual."'

	WHERE	id=".$informe."";

//print_r($sqlu) ;

	$exe = mysql_query($sqlu, $conectar);

		

	

	/* la publicacion la hace un administrador una vez que revisa , el profesional solo confirma su informe

	//para saber si existe fecha de publicacion, si no existe entonces la graba

	$sql_publicacion = mysql_query("select fechaPublicacion, publicado from informe_entrevista where id=".$informe."", $conectar);

	$res = mysql_fetch_array($sql_publicacion);

	$fechaPublicacion = $res['fechaPublicacion'];

	$publicado = $res['publicado'];	

	if ($fechaPublicacion == '0000-00-00' && $publicado == 'NO')

	{

		mysql_query("

		UPDATE

			informe_entrevista

		SET

			publicado='SI', 

			fechaPublicacion = '".$fechaActual."'

		WHERE

			id=".$informe."

		", $conectar);		

	}

*/





	$_SESSION['msj'] = 'Informe confirmado';

		

	$prestador = prestadorUsuario($_SESSION['idUsuario'], $conectar);

	

	agregarLog($_SERVER['HTTP_REFERER'], $_SESSION['idUsuario'], nombreUsuario($_SESSION['idUsuario'], $conectar), date('Y-m-d H:i:s'), 'Confirmar informe - hora: '.$datosInformeId['hora'].' informe: '.$informe, $conectar);

		

	header('Location: informesSinConfirmarLista.php?prestador='.$prestador);	

?>