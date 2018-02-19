<?php
/**
 * Created by PhpStorm.
 * User: CETEP
 * Date: 18/06/2015
 * Time: 9:56
 */

	include "../../lib/Slim/Slim.php";


	\Slim\Slim::registerAutoloader();
	use Slim\Slim;
// creamos una nueva instancia de Slim
	$ejemplo = new Slim();

// agregamos una nueva ruta y un código
	// add new Route
	$app->get("/",'hola') ;
		function hola() {

		echo "<h1>Hello Slim World</h1>";
	}
// corremos la aplicación
	$ejemplo->run();