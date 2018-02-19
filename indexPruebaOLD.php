<?php


//    $_SESSION['url']  = $_SERVER["REQUEST_URI"];
//    $_SESSION['host'] = $_SERVER['HTTP_HOST']; 
//    header('Location: http://localhost/apirestcolmena/cliente.php/');}
//    else{

//    $data = array('status' => false);
//    echo json_encode($data);
//    die();


/**
 * Step 1: Require the Slim Framework
 *
 * If you are not using Composer, you need to require the
 * Slim Framework and register its PSR-0 autoloader.
 *
 * If you are using Composer, you can skip this step.
 */
require 'clientPrueba.php';
require 'Slim/Slim.php';
require 'db.php';

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
$metodo = $_SESSION['metodo'];
    IF ($metodo === 'ConsultarListaEspera')require_once 'metodos/getLista.php';
ELSEIF ($metodo === 'ConsultarUsuarioEspera')require_once 'metodos/getListaid.php';
ELSEIF ($metodo === 'EstadoListaEsperaColmena')require_once 'metodos/getTotalListaEspera.php';
ELSEIF ($metodo === 'SincronizarAgenda')require_once 'metodos/getsincronizarAgenda.php';
ELSEIF ($metodo === 'ConsultarHoraExterna')require_once 'metodos/getconsultarHoraExterna.php';
ELSEIF ($metodo === 'AnularHora')require_once 'metodos/getAnularHora.php';
ELSEIF ($metodo === 'ConsultaExpediente')require_once 'metodos/addInforme.php';

ELSEIF ($metodo === 'RecepcionInforme')require_once 'metodos/postRecibeInforme.php';
ELSEIF ($metodo === 'ReagendamientoHora')require_once 'metodos/postReagendarHora.php';
ELSEIF ($metodo === 'AgendarHoraSegunHoraDisponible')require_once 'metodos/postAgendar.php';

// GET route
//	$app->get('/ConsultarListaEspera', 'getLista');
//	$app->get('/ConsultarUsuarioEspera', 'getListaid');
//        $app->get('/EstadoListaEsperaColmena', 'getTotalListaEspera');
//	$app->get('/SincronizarAgenda', 'getsincronizarAgenda');
//	$app->get('/ConsultarHoraExterna', 'getconsultarHoraExterna');
//        $app->get('/AnularHora', 'getAnularHora');
//        $app->get('/ConsultaExpediente', 'addInforme');
//        
//        $app->post('/RecepcionInforme', 'postRecibeInforme');
//        $app->post('/ReagendamientoHora', 'postReagendarHora');
//        $app->post('/AgendarHoraSegunHoraDisponible','postAgendar');
//        
//	$app->get('/wines/search/:query', 'findByName');
//	$app->post('/wines','addWine');
//        $app->put('/wines/:id', 'updateWine');
//	$app->delete('/wines/:id', 'deleteWine');
//
//	$clave_aplicacion = "CETEP_";
//	$clave_compartida = "Colmena";
//	$paso1 = $clave_aplicacion . date("d-m-Y");
//	$paso2 = hash_hmac("sha256", $paso1, $clave_compartida);
//	$paso3 = base64_encode($paso2);
//	$paso4 = $clave_aplicacion . $paso3;
//	$paso5 = base64_encode($paso4);
//	$token = "autenticacion_" . $paso5;
//        //die(var_dump($token));
//     //echo $token ;
//function auth()
//{
//    $app = \Slim\Slim::getInstance();
//
//    $request = $app->request();
//    $publicHash = $request->headers('X-Public');
//    $contentHash = $request->headers('X-Hash');
//    $privateHash = 'e249c439ed7697df2a4b045d97d4b9b7e1854c3ff8dd668c779013653913572e';
//    $content = $request->getBody();
//
//    $hash = hash_hmac('sha256', $content, $privateHash);
//
//    if ($hash == $combinedHash)
//    {
//        $data = array('status' => "success");
//        response($data);
//    }
//    else
//    {
//        $data = array('status' => "failed");
//        response($data);
//    }
//}
//
////*cliente
//
///*
//
//$publicHash = '3441df0babc2a2dda551d7cd39fb235bc4e09cd1e4556bf261bb49188f548348';
//$privateHash = 'e249c439ed7697df2a4b045d97d4b9b7e1854c3ff8dd668c779013653913572e';
//
//$content = json_encode( array( 'test' => 'content' ) );
//
//$hash = hash_hmac('sha256', $content, $privateHash);
//
//$headers = array(
//    'X-Public: '.$publicHash,
//    'X-Hash: '.$hash
//);
//
//*/
///*
//$ch = curl_init('http://domain.com/api2/core/device/auth');
//curl_setopt($ch,CURLOPT_HTTPHEADER,$headers);
//curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
//curl_setopt($ch,CURLOPT_POSTFIELDS,$content);
//
//$result = curl_exec($ch);
//curl_close($ch);
//
//echo "RESULT\n======\n".print_r($result, true)."\n\n";
//*/
////fin cliente
//
//	function getLista() {
//            
//            require_once 'metodos/getLista.php';
//	}
//        function getTotalListaEspera() {
//            
//            require_once 'metodos/getTotalListaEspera.php';
//	}
//	function getListaid() {
//            
//            require_once 'metodos/getListaid.php';
//	}
//	function getsincronizarAgenda() {
//            
//            require_once 'metodos/getsincronizarAgenda.php';
//	}
//	function getconsultarHoraExterna() {
//            
//            require_once 'metodos/getconsultarHoraExterna.php';
//	}
//        function postAgendar() {
//            
//            require_once 'metodos/postAgendar.php';
//	}
//        function postReagendarHora() {
//            
//            require_once 'metodos/postReagendarHora.php';
//	}
//        function getAnularHora() {
//            
//            require_once 'metodos/getAnularHora.php';
//	}
//        function addInforme() {
//            
//            require_once 'metodos/addInforme.php';
//        }
//        function postRecibeInforme() {
//            
//            require_once 'metodos/postRecibeInforme.php';
//        }
//        
//        
//
//	function getWine($id) {
//		$sql = "SELECT * FROM wine WHERE id=:id";
//		try {
//			$db = getConnection();
//			$stmt = $db->prepare($sql);
//			$stmt->bindParam("id", $id);
//			$stmt->execute();
//			$wine = $stmt->fetchObject();
//			$db = null;
//			echo json_encode($wine);
//		} catch(PDOException $e) {
//			echo '{"error":{"text":'. $e->getMessage() .'}}';
//		}
//        }
//	
//        
//	function updateWine($id) {
//		$request = Slim::getInstance()->request();
//		$body = $request->getBody();
//		$wine = json_decode($body);
//		$sql = "UPDATE wine SET name=:name, grapes=:grapes, country=:country, region=:region, year=:year, description=:description WHERE id=:id";
//		try {
//			$db = getConnection();
//			$stmt = $db->prepare($sql);
//			$stmt->bindParam("name", $wine->name);
//			$stmt->bindParam("grapes", $wine->grapes);
//			$stmt->bindParam("country", $wine->country);
//			$stmt->bindParam("region", $wine->region);
//			$stmt->bindParam("year", $wine->year);
//			$stmt->bindParam("description", $wine->description);
//			$stmt->bindParam("id", $id);
//			$stmt->execute();
//			$db = null;
//			echo json_encode($wine);
//		} catch(PDOException $e) {
//			echo '{"error":{"text":'. $e->getMessage() .'}}';
//		}
//	}
//
//	function deleteWine($id) {
//		$sql = "DELETE FROM wine WHERE id=:id";
//		try {
//			$db = getConnection();
//			$stmt = $db->prepare($sql);
//			$stmt->bindParam("id", $id);
//			$stmt->execute();
//			$db = null;
//		} catch(PDOException $e) {
//			echo '{"error":{"text":'. $e->getMessage() .'}}';
//		}
//	}
//
//	function findByName($query) {
//		$sql = "SELECT * FROM wine WHERE UPPER(name) LIKE :query ORDER BY name";
//		try {
//			$db = getConnection();
//			$stmt = $db->prepare($sql);
//			$query = "%".$query."%";
//			$stmt->bindParam("query", $query);
//			$stmt->execute();
//			$wines = $stmt->fetchAll(PDO::FETCH_OBJ);
//			$db = null;
//			echo '{"wine": ' . json_encode($wines) . '}';
//		} catch(PDOException $e) {
//			echo '{"error":{"text":'. $e->getMessage() .'}}';
//		}
//	}
//        function addWine() {
//            $res = $_POST['rest'];
//		$request = Slim::getInstance()->request();
//		$wine = json_decode($request->getBody());
//		$sql = "INSERT INTO wine (name, grapes, country, region, year, description) VALUES (:name, :grapes, :country, :region, :year, :description)";
//		try {
//			$db = getConnection();
//			$stmt = $db->prepare($sql);
//			$stmt->bindParam("name", $wine->name);
//			$stmt->bindParam("grapes", $wine->grapes);
//			$stmt->bindParam("country", $wine->country);
//			$stmt->bindParam("region", $wine->region);
//			$stmt->bindParam("year", $wine->year);
//			$stmt->bindParam("description", $wine->description);
//			$stmt->execute();
//			$wine->id = $db->lastInsertId();
//			$db = null;
//			echo json_encode($wine);
//		} catch(PDOException $e) {
//			echo '{"error":{"text":'. $e->getMessage() .'}}';
//		}
//	}
//
//// POST route
//$app->post(
//    '/post',
//    function () {
//        echo 'This is a POST route';
//    }
//);
//
//// PUT route
//$app->put(
//    '/put',
//    function () {
//        echo 'This is a PUT route';
//    }
//);
//
//// PATCH route
//$app->patch('/patch', function () {
//    echo 'This is a PATCH route';
//});
//
//// DELETE route
//$app->delete(
//    '/delete',
//    function () {
//        echo 'This is a DELETE route';
//    }
//);
//
///**
// * Step 4: Run the Slim application
// *
// * This method should be called last. This executes the Slim application
// * and returns the HTTP response to the HTTP client.
// */
//$app->run();
mysql_stmt_close;