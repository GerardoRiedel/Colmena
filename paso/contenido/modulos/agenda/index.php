<?php 
////////////////////////////////////////////////////
//INDEX ACUERDOS
//Autor: Javier Pérez
//Fecha Creación: 13-07-2007
//Fecha Modificación: 
//Autor Modificación: 
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
  