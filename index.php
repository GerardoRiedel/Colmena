<?php

/**
 * Step 1: Require the Slim Framework
 *
 * If you are not using Composer, you need to require the
 * Slim Framework and register its PSR-0 autoloader.
 *
 * If you are using Composer, you can skip this step.
 */

require 'Slim/Slim.php';

\Slim\Slim::registerAutoloader();

/**
 * Step 2: Instantiate a Slim application
 *
 * This example instantiates a Slim application using
 * its default settings. However, you will usually configure
 * your Slim application now by passing an associative array
 * of setting names and values into the application constructor.
 */
$app = new \Slim\Slim();

/**
 * Step 3: Define the Slim application routes
 *
 * Here we define several Slim application routes that respond
 * to appropriate HTTP request methods. In this example, the second
 * argument for `Slim::get`, `Slim::post`, `Slim::put`, `Slim::patch`, and `Slim::delete`
 * is an anonymous function.
 */
////PRUEBAS DE FLUJO

$app->get('/GetToken/', 'getToken');
$app->get('/SincronizarAgenda/:fechaI/:fechaF/:token', 'getsincronizarAgenda');
$app->get('/ConsultarHoraExterna/:comuna/:fecha/:expFueraLic/:token', 'getconsultarHoraExterna');
$app->get('/ReagendarHoraColmena/:idHora/:idHoraNueva', 'ReagendamientoHoraColmena');
	//$app->get('/ConsultarListaEspera/:token', 'getLista');
	//$app->get('/ConsultarUsuarioEspera/:id/:token', 'getListaid');
$app->get('/RecepcionInforme/', 'postRecibeInforme');
$app->get('/InformeInasistencia/', 'informeInasistencia');
$app->get('/AnularHoraColmena/:idHora', 'AnularHoraColmena');
$app->get('/Colmena/', 'colmena');
$app->post('/AnularHoraExt/', 'getAnularHora');
$app->post('/ModificarHora/', 'getModificarHora');
$app->post('/ModificarDatosPaciente/', 'getModificarPaciente');
$app->post('/AgendarHoraSegunHoraDisponible/','postAgendar');
$app->post('/ReagendamientoHora/:pacRut/:licencia/:medRut/:medNombre/:medEsp/:ior/:ciudad/:peritaje/:asist/:dir/:horaVieja/:horaNueva/:token', 'postReagendarHora');

////LLAMADO A FUNCIONES
        function colmena() {
            require_once 'metodos/colmena.php';
	}
        function ReagendamientoHoraColmena($idHora,$idHoraNueva) {
            require_once 'metodos/reagendamientoHoraColmena.php';
	}
        function AnularHoraColmena($idHora) {
            require_once 'metodos/anularHoraColmena.php';
	}
        function getToken() {
            require_once 'metodos/getToken.php';
	}
	function getLista($token) {
            require_once 'metodos/getLista.php';
	}
        function getListaid($id,$token) {
            require_once 'metodos/getListaid.php';
	}
	function getsincronizarAgenda($fechaI,$fechaF,$token) {
            require_once 'metodos/getsincronizarAgenda.php';
	}
	function getconsultarHoraExterna($comuna,$fecha,$expFueraLic,$token) {
            require_once 'metodos/getconsultarHoraExterna.php';
	}
        function postAgendar() {
            require_once 'metodos/postAgendar.php';
	}
        function postReagendarHora($pacRut,$licencia,$medRut,$medNombre,$medEsp,$ior,$ciudad,$peritaje,$asist,$dir,$horaVieja,$horaNueva,$token) {
            require_once 'metodos/postReagendarHora.php';
	}
        function getAnularHora() {
            require_once 'metodos/getAnularHora.php';
	}
        function getModificarHora() {
            require_once 'metodos/getModificarHora.php';
	}
        function getModificarPaciente() {
            require_once 'metodos/getModificarPaciente.php';
	}
        function addInforme() {
            require_once 'metodos/addInforme.php';
        }
        function postRecibeInforme() {
            require_once 'metodos/postRecibeInforme.php';
        }
        function informeInasistencia() {
            require_once 'metodos/informeInasistencia.php';
        }
        
/**
 * Step 4: Run the Slim application
 *
 * This method should be called last. This executes the Slim application
 * and returns the HTTP response to the HTTP client.
 */
$app->run();
