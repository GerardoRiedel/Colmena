<?php 
////////////////////////////////////////////////////
//INDEX ACUERDOS
//Autor: Javier P�rez
//Fecha Creaci�n: 13-07-2007
//Fecha Modificaci�n: 
//Autor Modificaci�n: 
////////////////////////////////////////////////////

	
	//CARGO EL MODULO DEL TIPO DE ADJUDICACION
	if($_GET['modulo2'])
	{
		if(file_exists('contenido/modulos/'.$_GET['modulo'].'/'.$_GET['modulo2'].'.php'))
		{
			include_once('contenido/modulos/'.$_GET['modulo'].'/'.$_GET['modulo2'].'.php');
		}
		else
		{
			header('Location: '.$HOME);
		}
	}
	else
	{
		include_once('contenido/modulos/'.$_GET['modulo'].'/main.php');
	}

?>  
  