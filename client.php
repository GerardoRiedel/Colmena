<?php
	/**
	 * Created by PhpStorm.
	 * User: CETEP
	 * Date: 24/08/2015
	 * Time: 9:10
	 */
	date_default_timezone_set('America/santiago');

$url2 = 'https://www.restwebserviceurl.com';
$urlbase = 'http://190.96.77.22:8180/wsAgendaColmenaRest/SHA_256/autenticacion';
$urllista = 'http://190.96.77.22:8180/wsAgendaColmenaRest/SHA_256/autenticacion_{token}/consultarListEspera/{cod_ciudad}';
/*	Verify: Permite validar si el servicio esta operando
	URL: http://190.96.77.22:8180/wsAgendaColmenaRest/SHA_256/autenticacion_{token}/verify
	Resultado esperado wsAgendaColmenaRest para <clave compartida>
	Ejemplo wsAgendaColmenaRest para EGIA

	ValidarToken: Permite validar si token es el esperado
	URL: http://190.96.77.22:8180/wsAgendaColmenaRest/SHA_256/autenticacion_{token}/validarToken
	Resultado esperado <clave compartida>
	Ejemplo CETEP
	ConsultarListEspera: Permite obtener un JSON con las lista de espera
	URL: http://190.96.77.22:8180/wsAgendaColmenaRest/SHA_256/autenticacion_{token}/consultarListEspera/{cod_ciudad}
    http://190.96.77.22:8180/wsAgendaColmenaRest/SHA_256/autenticacion_{token}/consultarListEspera/{cod_ciudad}
*/

	$clave_aplicacion = "CETEP_";
	$clave_compartida = "Colmena";
	$paso1 = $clave_aplicacion . date("d-m-Y");
	$paso2 = hash_hmac("sha256", $paso1, $clave_compartida);
	$paso3 = base64_encode($paso2);
	$paso4 = $clave_aplicacion . $paso3;
	$paso5 = base64_encode($paso4);
	$token = "autenticacion_" . $paso5;



	// base64_encode(hash_hmac(�sha256", �Datos �nicos�,�Clave compartida"))
///	$token64=base64_encode(sha256("'.$claveUnica.'","'.$publicId.'"));
//	$token_concat = $claveUnica.$token64 ;
//	$access_token = ($token_concat) ;
	//echo $paso5 ;




// prepare the body data. Example is JSON here
$data = json_encode(array(
	'cod_ciudad' => '13'

));
$ciudad = '13' ;
$cupos = '4' ;
// set up the request context
$options = ["http" => [
	"method" => "GET",
	"header" => ["Authorization: token " . $paso5,
	"Content-Type: application/json"],
	"content" => $data
]];
$context = stream_context_create($options);

// make the request
//$response = file_get_contents($urlbase.'_'.$paso5.'/'.'verify', false, $context);
$response2 = file_get_contents($urlbase.'_'.$paso5.'/'.'consultarListaEspera/'.$ciudad.'/'.$cupos, false, $context);
$jobj=json_decode($response2,true);

//	echo $paso5 ;
	echo "</br>";
	//echo $response2 ;
	echo print_r($jobj);
	//echo $jobj[token] ;
	echo "numero de ele. en arreglo:".count($jobj) ;
	$longitud = count($jobj);

//Recorro todos los elementos

	//$listaProductos = json_decode($_POST['productos']);
/*
	foreach($jobj as $row)
	{
		echo $row[token] . ', ';
		echo $row[codigoTransaccion] . ', ';
		echo $row[glosaTransaccion] . ', ';
		echo '<br/>';
	}*/
	foreach($jobj as $persona => $data){
		print "$persona es de $data<br>";
	}