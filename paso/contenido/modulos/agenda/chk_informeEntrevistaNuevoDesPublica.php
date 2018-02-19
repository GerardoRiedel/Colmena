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
	if(siEstaLogueado() == false)
	{
		header('Location: '.$HOME);
	}
	$idhora = $_GET['idHora'];
	//$sqlPublica =  mysql_query("update informe_entrevista set publicado='NO', fechaPublicacion='0000-00-00' where hora='$idhora'", $conectar);


	
	
	
	
	
	$_SESSION['msj'] = 'Informe publicado';

    $prestador = prestadorUsuario($_SESSION['idUsuario'], $conectar);
    $datosInformeId = datosInformeHora($idhora, $conectar);
    agregarLog($_SERVER['HTTP_REFERER'], $_SESSION['idUsuario'], nombreUsuario($_SESSION['idUsuario'], $conectar), date('Y-m-d H:i:s'), 'Despublica informe - hora: '.$datosInformeId['hora'].' informe: '.$informe, $conectar);

	// crearInformeNuevoBin($idHora, $conectar) ;
	//	header('Location: chk_informeEntrevistaSegundaDescargaNuevo.php?id='.$idhora);	        
	//DIFERENCIANDO SI ES INFORME ENTREVISTA O INFORME TRAUMATOLOGICO-----
	if ($prestador != '')
	{
		if (especialidadPrestador($prestador, $conectar) == 1)
	  	{
			$sqlPublica =  mysql_query("update informe_entrevista set publicado='NO'  where hora='$idhora'", $conectar);
			header('Location: chk_informeEntrevistaSegundaDescargaNuevo.php?id='.$idhora);	        
		 }elseif (especialidadPrestador($prestador, $conectar) == 2)
	  	{
			$sqlPublica =  mysql_query("update informe_traumatologico set publicado='NO'  where hora='$idhora'", $conectar);
			header('Location: chk_informeEntrevistaTraumatologicoDescarga.php?id='.$idhora);	        
	  	}
	}elseif ($prestador == '')
	{
		// y luego la especialidad de ese prestador		
		$sql_especialidad = mysql_query("SELECT 
			especialidad
		FROM
			prestadores, horas
		WHERE horas.id='$idhora' 
		AND horas.prestador = prestadores.id", $conectar);  
		  $res_especialidad = mysql_fetch_array($sql_especialidad);
		  $especialidad = $res_especialidad['especialidad'];
		if ($especialidad == 1)
		{
			$sqlPublica =  mysql_query("update informe_entrevista set publicado='NO'  where hora='$idhora'", $conectar);
			header('Location: chk_informeEntrevistaSegundaDescargaNuevo.php?id='.$idhora);	        
		 }elseif ($especialidad == 2)
		{
			$sqlPublica =  mysql_query("update informe_traumatologico set publicado='NO'  where hora='$idhora'", $conectar);
			header('Location: chk_informeEntrevistaTraumatologicoDescarga.php?id='.$idhora);	        
		}
	}
	
?>
