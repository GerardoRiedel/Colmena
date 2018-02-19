<?php 
	session_name("agenda2");
	session_start();
	require_once('../../../lib/fpdf/fpdf.php');
	require_once('../../../lib/pacientes/funciones.php');
	require_once('../../../lib/isapres/funciones.php');
	require_once('../../../lib/usuarios/funciones.php');
	require_once('../../../lib/horas/funciones.php');
	require_once('../../../lib/prestadores/funciones.php');
	require_once('../../../lib/informe_entrevista/funciones.php');
	require_once('../../../lib/querys/comunas.php');
	require_once('../../../lib/querys/ciudades.php');
	require_once('../../../lib/datos.php');
	require_once('../../../lib/funciones.php');
	require_once('../../../lib/conectar.php');
    require_once('../../../lib/soap/funcionessoap.php');
    require_once('../../../lib/class/paramInfoperit.php');
	$conectar = conectar();

	$tipoSalida = 'F';
    $carpetasalida='';
    $numerolicencia=0;
$sql="SELECT
  `i`.`id`         AS `id`,
  `i`.`hora`       AS `hora`,
  `i`.`paciente`   AS `paciente`,
  `f_datospaciente`(`i`.`paciente`,1) AS rutpaciente,
  `f_digito`(`f_datospaciente`(`i`.`paciente`,1)) AS digitopac ,
  `i`.`prestador`  AS `prestador`,
  `i`.`isapre`     AS `isapre`,
  `i`.`asiste`     AS `asiste`,
  `i`.`confirmada` AS `confirmada`,
   IF (`i`.`numerolicencia` = 0 ,`f_datosinforme`(`i`.`id`,`i`.`prestador`,5),`i`.`numerolicencia`) AS numerolicencia,
  `f_datosinforme`(`i`.`id`,`i`.`prestador`,1)  AS `fecpub`,
  `f_datosinforme`(`i`.`id`,`i`.`prestador`,5)  AS `numerolicenciaI`,
  `f_datosinforme`(`i`.`id`,`i`.`prestador`,6)  AS `fecXML`
  ,`i`.`fechaEnvioXML`
FROM `horas` `i`
WHERE ((DATE_FORMAT(`i`.`hora`,'%Y-%m-%d') >= '2015-06-01') AND
(DATE_FORMAT(`i`.`hora`,'%Y-%m-%d') < DATE_FORMAT(NOW(),'%Y-%m-%d'))AND
(`i`.`isapre` = 3) AND `f_datosinforme`(`i`.`id`,`i`.`prestador`,6)  IS NULL AND 
(`f_datosinforme`(`i`.`id`,`i`.`prestador`,1) IS NOT NULL OR  `i`.`asiste`= 'no')  AND  
(`f_datosinforme`(`i`.`id`,`i`.`prestador`,6) IS NULL  AND `i`.`fechaEnvioXML` IS NULL)AND
DATEDIFF(DATE_FORMAT(NOW(),'%Y-%m-%d %H:%i:%s'),`i`.`hora`)>=2 AND (`i`.`numerolicencia` IS NOT NULL AND `i`.`numerolicencia` > 0 ))AND i.`asiste`='no' ;";
$result= mysql_query($sql,$conectar);
$num_rows = mysql_num_rows($result);


while($row = mysql_fetch_array($result)) {
    $idHora = $row['id'];
    $hora = $row['hora'];
    $asiste = $row['asiste'];
    $idpaciente = $row['paciente'];
    $tipo = 'DI';
        $numerolicencia =$row['numerolicencia'];


        $idPaciente = $row['paciente'];
        $rutPaciente = $row['rutpaciente'];
        $dvPaciente = $row['digitopac'];
        $numeroLicencia = (integer)$numerolicencia ;
        $file = crearCertificadoInasistencia($idHora, $conectar);
        $archivo =  $file;
        $TipoDocumento = $tipo;
        $rutsinformato = $rutPaciente;
        $digito = $dvPaciente;

    //  ini_set('max_execution_time', -1);
//leer documento generado
    $filename = $archivo;
    $gestor = fopen($filename, "r+b");
    $archivopdf = fread($gestor, filesize($filename));
    fclose($gestor);

    $rutcetep = 76552660;

    // clave server desarrollo CB
	// $pass = (string)'C5E4T4EP';
	//clave produccion CB
     $pass= 'C5E4T4EPXB';

//creacion de objeto por clase
    $datoscb = new ParamInfoPeritaje($rutsinformato, $digito, $numeroLicencia, $archivopdf, $TipoDocumento);
//
// formateo de los datos de clase para envio en parametro webservice
    $paramsCB = array('ParamInfoPerit' => $datoscb);
    // webserice url produccion
     $URL = "http://ws-servexternos.cruzblanca.cl/ServicioPeritajesLM/PeritajesLM_Ws.asmx?WSDL";
    // webserice url produccion
    //   $URL = "http://des.movil.cruzblanca.cl/servicioperitajeslm/peritajeslm_ws.asmx?WSDL";

        $options = array(
            'soap_version' => SOAP_1_2,
            'exceptions' => 1,
            'trace' => TRUE,
            'cache_wsdl' => WSDL_CACHE_NONE
        );
        $client = new SoapClient($URL, $options);

        $ns = "http://tempuri.org/";
        $auth = array(
            'User' => $rutcetep,
            'Password' => $pass
        );
        $header = new SoapHeader($ns, 'LoginInfo', $auth, false);
        $client->__setSoapHeaders($header);
        try {
			// WS produccion 
			// habilitar para envios oficiales
			 $response = $client->__soapCall('EnviarInformePeritaje', array($paramsCB));
			//WS desarrollo solo pruebas
     	//		$response = $client->__soapCall('EnviarInformePeritaje_PruebasDes', array($paramsCB));
											 
            // var_dump($response);
            $request = beautify($client->__getLastRequest());
            $response = beautify($client->__getLastResponse());
        } catch (SoapFault $client) {
            //printf("<br/> Request = %s </br>", htmlspecialchars($client->faultcode));
            print $client->getMessage();
            print $client->getTraceAsString();
        }
    ///actualizar informe con fecha de envio a CB


    if ($tipo == 'DI'){
        $sqlenvio=" INSERT INTO `envioXML` (`idhora`,`response`,`fecha`,`rut`,`tipodocumento`)
        VALUES($idHora,'". $response."', now() , $rutPaciente,'".$TipoDocumento."') ;";

        $resulenvio=mysql_query($sqlenvio,$conectar);
        /* se envia a proceso para verificar el estado del envio.
        * el estado 2 se debe anular o borrar la fecha de envio del xml
        * en las tablas hora e informes. la funcion anulaenvioinformeconerror
        * hace el proceso.
        */

        $sqlestado=mysql_query("SELECT * FROM venvioxml WHERE idhora = $idHora  AND fecha = `f_fechaUltimoEnvioXML`(idhora)",$conectar) ;
        $rowestado = mysql_fetch_array( $sqlestado) ;
        $estado = $rowestado['codigo'];
        $id= $rowestado['idhora'];
        if ($estado == '2') {

            $sqlanula = "UPDATE horas set fechaEnvioXML= NULL  where  id ='$id'";
            $resultanula = mysql_query($sqlanula, $conectar);
            $sqlanulainforme = "UPDATE informe_entrevista set fechaEnvioXML= NULL  where  hora ='$id'";
            $resultanulainforme = mysql_query($sqlanulainforme, $conectar);
        }
        if ($estado == '0') {


            $sqlactualializahora = "UPDATE horas set fechaEnvioXML=now() where  id ='$idHora'";
            $resultupdate = mysql_query($sqlactualializahora, $conectar);
            $sqlactualializainforme = "UPDATE informe_entrevista set fechaEnvioXML=now() where  hora ='$idHora'";
            $resultupdate = mysql_query($sqlactualializainforme, $conectar);

        }


    }


}
    echo "$num_rows Informes de Inasistencia enviados\n";
?>