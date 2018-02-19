<?php 
	session_name("agenda2");
	session_start();
	
	include_once('../../../lib/fpdf/fpdf.php');
	include_once('../../../lib/pacientes/funciones.php');
	include_once('../../../lib/isapres/funciones.php');
	include_once('../../../lib/usuarios/funciones.php');
	include_once('../../../lib/horas/funciones.php');
	include_once('../../../lib/prestadores/funciones.php');
	include_once('../../../lib/informe_entrevista/funciones.php');
	include_once('../../../lib/querys/comunas.php');
	include_once('../../../lib/querys/ciudades.php');
	include_once('../../../lib/datos.php');
	include_once('../../../lib/funciones.php');
	include_once('../../../lib/conectar.php');
   include_once('../../../lib/soap/funcionessoap.php');

	$conectar = conectar();
		
	$idHora = $_GET['idHora'];
    $tipo='DP';

	$tipoSalida = 'F';
    $carpetasalida='';


    if ($tipo =='DI')
    {
      //  $idinforme=idInformeEntrevistaHora($idHora, $conectar);
       // $numeroLicencia= numeroLicencia($idinforme, $conectar);
       // $idPaciente =idPacienteHora($idHora, $conectar);
       // $file=crearInformeNuevo($idHora, $tipoSalida, $carpetaSalida, $conectar);
     //   $archivo='../../../informesRespaldo/'.$file;
      //  $TipoDocumento= 'DP';
        //$rutsinformato=	(int)rutPaciente($idPaciente, $conectar);
        //$digito = (string)DigitoVerificador($rutsinformato);

    }
    if ($tipo =='DI')
        {
            $sqlDatos = mysql_query("
	SELECT
		i.`id`,
		i.`hora`,
	   	i.`paciente`,
		i.`prestador`,
		i.`isapre`,
		i.`confirmada`

	FROM
		horas i
	WHERE
		i.`id`=".$idHora."
	", $conectar);

            $rowDatos = mysql_fetch_array($sqlDatos);
            $idPaciente = $rowDatos['paciente'];
            $rutPaciente = rutPaciente($idPaciente, $conectar);
            $dvPaciente = DigitoVerificador($rutPaciente);

        $file='10.674.855-1_DI.pdf';
        $archivo='../../../contenido/modulos/agenda/certificadosInasistencia/'.$file;
        $TipoDocumento= 'DI';
            $rutsinformato=	$rutPaciente;
            $digito = $dvPaciente ;

      }else
    {
        $idPaciente =idPacienteHora($idHora, $conectar);
        $idinforme=idInformeEntrevistaHora($idHora, $conectar);
        $numeroLicencia= numeroLicencia($idinforme, $conectar);
        $rutPaciente = rutPaciente($idPaciente, $conectar);
        $dvPaciente = DigitoVerificador($rutPaciente);
        $file=crearInformeNuevo($idHora, $tipoSalida, $carpetaSalida, $conectar);
        $archivo='../../../informesRespaldo/'.$file;
        $TipoDocumento= 'DP';
        $rutsinformato=	rutPaciente($idPaciente, $conectar);
        $digito = DigitoVerificador($rutsinformato);



    }


ini_set('max_execution_time', -1);
//ini_set('memory_limit','512M');
// reading a pdf file
//$file = file_get_contents($archivo);
//$string_array = str_split($file);
// making a byte array from each character
//$byteArr = array();
//foreach ($string_array as $key=>$val) {
    // reading ascii values fo each character and storing in array
//$byteArr[$key] = ord($val);

//}

//$byte_arr=create_byte_array($file);

// metodo 1
// aqui se lee y convierte el archive a binario
//$filename = $archivo;
//$archivo = fread($filename, filesize($filename));

// metodo 2
//PDF a BIN
$filename = $archivo;
$gestor = fopen($filename, "r+b");
//$archivo = utf8_encode(fread($gestor, filesize($filename)));
$archivopdf = base64_encode(fread($gestor, filesize($filename)));
fclose($gestor);





//echo "ID.".$idinforme.'-'.'L'.$numeroLicencia.'-'.'Pac'.$idPaciente.'rut'.$rutsinformato.'c:'.$nomarchivo;

//vaciarCarpeta("../../../informesRespaldo/");
//$separador='_';
//$dir="../../../informesRespaldo/";





$rutcetep=76552660;
$pass=(string)'C5E4T4EP';

//var_dump($informe);
$params=array('ParamInfoPeritaje' =>array(
    'RutCotizante' =>is_int($rutsinformato),
    'DvRutCotizante' =>is_string($digito),
    'FolioLicencia'  =>is_int($numeroLicencia),
    'DocumentoPeritaje'  =>is_object($archivopdf),
    'ExtensionDocumento' => 'PDF',
    'TipoDocumento'=>$TipoDocumento )

) ;


//$URL = "http://ws-servexternos.cruzblanca.cl/ServicioPeritajesLM/PeritajesLM_Ws.asmx?WSDL";
$URL1="http://des.movil.cruzblanca.cl/servicioperitajeslm/peritajeslm_ws.asmx?WSDL";

$options = array(
    'soap_version'=>SOAP_1_1,
    'exceptions'=>1,
    'trace'=>TRUE,
    'cache_wsdl'=>WSDL_CACHE_NONE
);
$client= new SoapClient($URL1,$options);


$ns="http://tempuri.org/";
$auth = array(
    'User'=>$rutcetep,
    'Password'=>$pass

);
$header = new SoapHeader($ns,'LoginInfo',$auth,false);
$client->__setSoapHeaders($header);






try {
  //  $response = $client->__soapCall('EnviarInformePeritaje_TipDoc_PruebasDes',$params);
  $response = $client->__soapCall('EnviarInformePeritaje_PruebasDes',$params);

   // var_dump($response);
    $request=beautify( $client->__getLastRequest());
    $response= beautify($client->__getLastResponse());

    echo($request);

    echo($response);
    var_dump($params) ;

} catch(SoapFault $client) {
    //printf("<br/> Request = %s </br>", htmlspecialchars($client->faultcode));
    print $client->getMessage();
    print $client->getTraceAsString();


}




?>