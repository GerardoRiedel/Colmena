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

// GET route
	$app->get('/consultarlistaespera', 'getLista');
	$app->get('/consultarlistaespera/:id', 'getListaid');
	$app->get('/sincronizarAgenda/:fecha', 'getsincronizarAgenda');
	$app->get('/consultarHoraExterna/:ciudad',  'getconsultarHoraExterna');
	$app->get('/wines/search/:query', 'findByName');
	$app->post('/wines', 'addWine');
	$app->put('/wines/:id', 'updateWine');
	$app->delete('/wines/:id',   'deleteWine');



	$clave_aplicacion = "CETEP_";
	$clave_compartida = "Colmena";
	$paso1 = $clave_aplicacion . date("d-m-Y");
	$paso2 = hash_hmac("sha256", $paso1, $clave_compartida);
	$paso3 = base64_encode($paso2);
	$paso4 = $clave_aplicacion . $paso3;
	$paso5 = base64_encode($paso4);
	$token = "autenticacion_" . $paso5;
    // echo $token ;
function auth()
{
    $app = \Slim\Slim::getInstance();

    $request = $app->request();
    $publicHash = $request->headers('X-Public');
    $contentHash = $request->headers('X-Hash');
    $privateHash = 'e249c439ed7697df2a4b045d97d4b9b7e1854c3ff8dd668c779013653913572e';
    $content = $request->getBody();

    $hash = hash_hmac('sha256', $content, $privateHash);

    if ($hash == $combinedHash)
    {
        $data = array('status' => "success");
        response($data);
    }
    else
    {
        $data = array('status' => "failed");
        response($data);
    }
}

//*cliente

/*

$publicHash = '3441df0babc2a2dda551d7cd39fb235bc4e09cd1e4556bf261bb49188f548348';
$privateHash = 'e249c439ed7697df2a4b045d97d4b9b7e1854c3ff8dd668c779013653913572e';

$content = json_encode( array( 'test' => 'content' ) );

$hash = hash_hmac('sha256', $content, $privateHash);

$headers = array(
    'X-Public: '.$publicHash,
    'X-Hash: '.$hash
);

*/
/*
$ch = curl_init('http://domain.com/api2/core/device/auth');
curl_setopt($ch,CURLOPT_HTTPHEADER,$headers);
curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
curl_setopt($ch,CURLOPT_POSTFIELDS,$content);

$result = curl_exec($ch);
curl_close($ch);

echo "RESULT\n======\n".print_r($result, true)."\n\n";
*/
//fin cliente

	function getLista() {
		$sql = "SELECT `id`,
				  `fechaIngreso`,
				  `ciudad`,
				  `rut` AS pac_rut,
				  `nombres` AS pac_nombres,
				  `apellidoPaterno` AS pac_apePat,
				  `apellidoMaterno` AS pac_apeMat,
				  `fechaVencimientoLic` AS exp_fechaIniLic,
				   `f_html_encode`(`direccion` )AS pac_direccion,
				  `comuna` AS pac_comuna,
				  `telefono` AS pac_telFijo,
				  `celular` AS pac_telCelular,
				  `email` AS pac_mail
				FROM
				  `pacientes_espera`
				WHERE isapre = 4 limit 4 ";
		$sql2 = "SELECT * FROM `pacientes_espera` WHERE isapre = 4 limit 1";



		try {
			$db = getConnection();
			$stmt = $db->query($sql);
			//$lista = $stmt->fetchAll(PDO::FETCH_OBJ);
			$lista = $stmt->fetchAll();
			$db = null;

			echo '{"consultarlistaespera": ' . json_encode($lista) . '}';
		} catch(PDOException $e) {
			echo '{"error":{"text":'. $e->getMessage() .'}}';
		}
	}
	function getListaid($id) {
		$sql = "SELECT `id`,
				  `fechaIngreso`,
				  `ciudad`,
				  `rut` AS pac_rut,
				  `nombres` AS pac_nombres,
				  `apellidoPaterno` AS pac_apePat,
				  `apellidoMaterno` AS pac_apeMat,
				  `fechaVencimientoLic` AS exp_fechaIniLic,
				   `f_html_encode`(`direccion` )AS pac_direccion,
				  `comuna` AS pac_comuna,
				  `telefono` AS pac_telFijo,
				  `celular` AS pac_telCelular,
				  `email` AS pac_mail
				FROM
				  `pacientes_espera`
				WHERE isapre = 4 and id = :id";
		



		try {
			$db = getConnection();
			$stmt = $db->prepare($sql) ;
			$stmt->bindParam("id",$id);
			$stmt->execute();
			$lista = $stmt->fetchAll(PDO::FETCH_OBJ);
			
			$db = null;
			
			echo '{"consultarlistaespera": ' . json_encode($lista) . '}';
		} catch(PDOException $e) {
			echo '{"error":{"text":'. $e->getMessage() .'}}';
		}
	}
	function getsincronizarAgenda($fecha) {
		$sql = "SELECT
    `pacientes`.`rut` AS pac_rut
    , `f_html_encode`(`pacientes`.`nombres`) AS pac_nombres
    , `f_html_encode`(`pacientes`.`apellidoPaterno`) AS pac_apePat
    , `f_html_encode`(`pacientes`.`apellidoMaterno`) AS pac_apeMat
    , `f_html_encode`(`pacientes`.`direccion`) AS pac_direccion
    , `pacientes`.`direccion` AS pac_direccion2
    , `pacientes`.`comuna` AS pac_comuna
      , `f_datosciudadperitaje`(`horas`.`ciudad`,1) AS ctu
    , `pacientes`.`telefono` AS pac_telFijo
    , `pacientes`.`celular`  AS pac_telCelular
    , `pacientes`.`email` AS pac_mail
    , `horas`.`prestador` AS prestador
    , `f_perito`( `horas`.`prestador` ,3) AS med_nombres
, `f_perito`( `horas`.`prestador` ,4) AS med_apePat
, `f_perito`( `horas`.`prestador` ,3) AS med_apMat
, 'Psiquiatria' AS med_especialidad
,  NULL AS med_ciudad
, `horas`.`hora` AS per_fecha
, `f_dirPeritaje`(`horas`.`ciudad`) AS per_ciudad
, `horas`.`observacion` AS per_observacion
, NULL AS per_estado
, `horas`.`confirmada` AS per_confirma
FROM
    `horas`
    INNER JOIN `pacientes`
        ON (`horas`.`paciente` = `pacientes`.`id`)
WHERE (`horas`.`isapre` = 4) AND DATE(`horas`.`hora`) >= :fecha ";
		//echo $sql ;
		try {
			$db = getConnection();
			$stmt = $db->prepare($sql) ;
			$stmt->bindParam("fecha",$fecha);
			$stmt->execute();
			$lista = $stmt->fetchAll(PDO::FETCH_OBJ);
			$db = null;
		//	var_dump($lista);
			echo '{"sincronizarAgenda": ' . json_encode($lista) . '}';
		} catch(PDOException $e) {
			echo '{"error":{"text":'. $e->getMessage() .'}}';
		}
	}

	function getconsultarHoraExterna($ciudad) {
		$sql = "SELECT `id`,`prestador`,`hora`,`ciudad` FROM `horas_prestadores`
			WHERE ciudad = :ciudad AND DATE(hora) >= DATE(NOW()) AND (`f_horatomada`(hora,prestador ,ciudad) IS NULL)
ORDER BY hora ASC limit 1 ";
		echo $sql ;
		try {
			$db = getConnection();
			$stmt = $db->prepare($sql) ;
			$stmt->bindParam("ciudad",$ciudad);
			$stmt->execute();
			$lista = $stmt->fetchAll(PDO::FETCH_OBJ);
			$db = null;
			//	var_dump($lista);
			echo '{"sincronizarAgenda": ' . json_encode($lista) . '}';
		} catch(PDOException $e) {
			echo '{"error":{"text":'. $e->getMessage() .'}}';
		}
	}








	function getWine($id) {
		$sql = "SELECT * FROM wine WHERE id=:id";
		try {
			$db = getConnection();
			$stmt = $db->prepare($sql);
			$stmt->bindParam("id", $id);
			$stmt->execute();
			$wine = $stmt->fetchObject();
			$db = null;
			echo json_encode($wine);
		} catch(PDOException $e) {
			echo '{"error":{"text":'. $e->getMessage() .'}}';
		}
	}

	function addWine() {
		$request = Slim::getInstance()->request();
		$wine = json_decode($request->getBody());
		$sql = "INSERT INTO wine (name, grapes, country, region, year, description) VALUES (:name, :grapes, :country, :region, :year, :description)";
		try {
			$db = getConnection();
			$stmt = $db->prepare($sql);
			$stmt->bindParam("name", $wine->name);
			$stmt->bindParam("grapes", $wine->grapes);
			$stmt->bindParam("country", $wine->country);
			$stmt->bindParam("region", $wine->region);
			$stmt->bindParam("year", $wine->year);
			$stmt->bindParam("description", $wine->description);
			$stmt->execute();
			$wine->id = $db->lastInsertId();
			$db = null;
			echo json_encode($wine);
		} catch(PDOException $e) {
			echo '{"error":{"text":'. $e->getMessage() .'}}';
		}
	}

	function updateWine($id) {
		$request = Slim::getInstance()->request();
		$body = $request->getBody();
		$wine = json_decode($body);
		$sql = "UPDATE wine SET name=:name, grapes=:grapes, country=:country, region=:region, year=:year, description=:description WHERE id=:id";
		try {
			$db = getConnection();
			$stmt = $db->prepare($sql);
			$stmt->bindParam("name", $wine->name);
			$stmt->bindParam("grapes", $wine->grapes);
			$stmt->bindParam("country", $wine->country);
			$stmt->bindParam("region", $wine->region);
			$stmt->bindParam("year", $wine->year);
			$stmt->bindParam("description", $wine->description);
			$stmt->bindParam("id", $id);
			$stmt->execute();
			$db = null;
			echo json_encode($wine);
		} catch(PDOException $e) {
			echo '{"error":{"text":'. $e->getMessage() .'}}';
		}
	}

	function deleteWine($id) {
		$sql = "DELETE FROM wine WHERE id=:id";
		try {
			$db = getConnection();
			$stmt = $db->prepare($sql);
			$stmt->bindParam("id", $id);
			$stmt->execute();
			$db = null;
		} catch(PDOException $e) {
			echo '{"error":{"text":'. $e->getMessage() .'}}';
		}
	}

	function findByName($query) {
		$sql = "SELECT * FROM wine WHERE UPPER(name) LIKE :query ORDER BY name";
		try {
			$db = getConnection();
			$stmt = $db->prepare($sql);
			$query = "%".$query."%";
			$stmt->bindParam("query", $query);
			$stmt->execute();
			$wines = $stmt->fetchAll(PDO::FETCH_OBJ);
			$db = null;
			echo '{"wine": ' . json_encode($wines) . '}';
		} catch(PDOException $e) {
			echo '{"error":{"text":'. $e->getMessage() .'}}';
		}
	}

	function getConnection() {
		$dbhost="10.0.0.155";
		$dbuser="cetepcl";
		$dbpass="rootsecurity626";
		$dbname="cetepcl_agenda";
		$dbh = new PDO("mysql:host=$dbhost;dbname=$dbname", $dbuser, $dbpass);
		$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$dbh->exec("set names utf8");
		return $dbh;
	}

// POST route
$app->post(
    '/post',
    function () {
        echo 'This is a POST route';
    }
);

// PUT route
$app->put(
    '/put',
    function () {
        echo 'This is a PUT route';
    }
);

// PATCH route
$app->patch('/patch', function () {
    echo 'This is a PATCH route';
});

// DELETE route
$app->delete(
    '/delete',
    function () {
        echo 'This is a DELETE route';
    }
);

/**
 * Step 4: Run the Slim application
 *
 * This method should be called last. This executes the Slim application
 * and returns the HTTP response to the HTTP client.
 */
$app->run();
