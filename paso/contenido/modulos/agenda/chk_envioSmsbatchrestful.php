<?php 
	session_name("agenda2");
	session_start();

	include('../../../lib/funciones.php');
     include('../../../lib/conectar.php');
    include('../../../lib/class/restclient.php');
	$conectar = conectar();
    //    $conectar = mysql_connect("localhost", "cetepcl", "rootsecurity626");
     //   mysql_select_db("cetepcl_agenda", $conectar);
      //  echo mysql_errno($conectar) . ": " . mysql_error($conectar). "\n";
    $sql="SELECT
   `horas`.`id`
      ,DATE_FORMAT(`horas`.`hora`,'%d/%m/%Y') AS fecha
    ,DATE_FORMAT(`horas`.`hora`,'%H:%i') AS hora
    , `pacientes`.`celular`
    , UPPER(`f_elimina_ene`(f_html_encode(`f_eliminaacento`(`pacientes`.`apellidoPaterno`)))) AS apellidoPaterno
    ,UPPER(`f_nomisapre`(`horas`.`isapre`)) AS isapre
    ,DATEDIFF(`horas`.`hora`,NOW()) AS dif
   , UPPER(`f_elimina_ene`(`f_elimina_ene`(`f_html_encode`(`f_eliminaacento`(`prestadores`.`apellidoPaterno`))))) AS profesional
      ,UPPER(`f_elimina_ene`(`f_html_encode`(`f_eliminaacento`( `ciudades`.`direccion`)))) AS direccion
 FROM
    `pacientes`
    INNER JOIN `horas`
        ON (`pacientes`.`id` = `horas`.`paciente`)
    INNER JOIN `ciudades`
        ON (`horas`.`ciudad` = `ciudades`.`id`)
    INNER JOIN `prestadores`
        ON (`horas`.`prestador` = `prestadores`.`id`)
		WHERE (DATEDIFF(`horas`.`hora`,NOW()) = 2) AND LENGTH(`pacientes`.`celular`) > 4 AND
		(`horas`.`isapre` = 1 or `horas`.`isapre` = 4  or `horas`.`isapre` = 5 );";
        $result= mysql_query($sql,$conectar);
    //$data = mysql_fetch_assoc($sql)
    $row = mysql_fetch_assoc($result);
//      var_dump($row);

    $user='cetep';
    $pass='2015cetep';

    while (($fila = mysql_fetch_array($result))!=NULL){
           require_once ("../../../lib/class/SimpleRestClient.php");
           if ($fila['isapre'] == 'CRUZ BLANCA') {
               $mandante = "CETEP";
           } else {
               $mandante = $fila['isapre'];
           }
           $celular = preg_replace ("[^0-9]", "", $fila['celular']);
           $mensaje = 'Sr(a).' . $fila['apellidoPaterno'] . ':' . 'Le recordamos que tiene peritaje el' . ' ' . $fila['fecha'] . ' ' . 'a las' . ' ' . $fila['hora'] . '' . ' en ' . '' . $fila['direccion'] . ' ' . 'con Dr(a).' . '' . elimina_acentos ($fila['profesional']) . '. ' . 'Atte.' . '' . $mandante;
            //echo $mensaje;
            $data_string = array();
            $data_string["username"] = "cetep";
            $data_string["password"] = "2015cetep";
            $data_string["numero"] = $celular;
            $data_string["mensaje"] = $mensaje;
          //  	var_dump($data_string) ;
            		
            $resp=enviar_sms($data_string,$fila['id'],$mensaje,$conectar);

           }

	function enviar_sms ($data,$idhora,$mensaje,$conectar)
	{
		//   $c = new RestClient();

		/*$options = ["http" => ["method" => "POST",
			"header" => ["Content-Type: application/json"],
			"content" => $data
		]];*/
		$options = array('http' =>
				array(
        'method'  => 'POST',
        'header'  => 'Content-type: application/json',
        'content' => $data
			)
			);
				
		
		$xml = null;
		$restclient = null;
		$result = null;
		$cert_file = null;//Path to cert file
		$key_file = null;//Path to private key
		$key_password = null;//Private key passphrase
		$curl_opts = $options ;//Array to set additional CURL options or override the default options of the SimpleRestClient
		$post_data = $data;//Array or string to set POST data
		$user_agent = "PHP cetep Rest Client";
		$url = "http://ws.connectus.cl/send_sms";
		$restclient = new SimpleRestClient($cert_file, $key_file, $key_password, $user_agent, $curl_opts);

		if (!is_null ($post_data)) {
			$restclient->postWebRequest ($url, $post_data);
		} else {
			$restclient->getWebRequest ($url);
		}

		if (!is_null($restclient))
		{
			//Get the Http_Status_Code
//        echo 'Http Status Code: ' . $restclient->getStatusCode() . '<br />';
			$response = $restclient->getWebResponse();

			//Get the error message returned from web service
			//$xml = simplexml_load_string($response);
		//	echo $response ;

		}
		$obj = json_decode($response);
		print $obj->{'id_mensaje'}; // 12345
		print $obj->{'response'}; // 12345
		$idmensaje= $obj->{'id_mensaje'}; // 12345
		$codmensaje= $obj->{'response'}; // 12345
		
		if (!empty($obj)){
		$sqlin="INSERT INTO enviosms (idhora,request,response,cod_respuesta,id_mensaje) VALUES($idhora,$mensaje,$response,$codmensaje,$idmensaje)";
		//echo $sqlin;
		$exec=mysql_query($sqlin ,$conectar) ;	
		}	

		

	}




?>