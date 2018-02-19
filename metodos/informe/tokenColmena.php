<?php error_reporting(E_ALL);

$ch = curl_init('https://www.colmena.cl/wsAgendaColmenaRest/Common/Q0VURVBfMjAxNl9QZXJpdGFqZQ==/getToken');
$data = array();

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($ch, CURLOPT_POSTFIELDS,http_build_query($data));
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        $result = curl_exec($ch);
        curl_close($ch);
    return $result;         
?>