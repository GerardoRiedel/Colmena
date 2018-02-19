<?php 
	session_name("agenda2");
	session_start();
       //include('../../../lib/service/wedservice.php');
	include('../../../lib/funciones.php');
        include('../../../lib/conectar.php');
	//$conectar = conectar();
        $conectar = mysql_connect("localhost", "cetepcl", "rootsecurity626");
        mysql_select_db("cetepcl_agenda", $conectar);
        echo mysql_errno($conectar) . ": " . mysql_error($conectar). "\n";
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
       $num_rows = mysql_num_rows($result);
       echo "$num_rows Rows\n";
      
       while($row = mysql_fetch_array($result))
	{	
        $idHora = $row['id'];
        $apellido=$row['apellidoPaterno'] ;
        $citado=$row['fecha'] ;
        $hora=$row['hora'];
        $lugar=$row['direccion'] ;
        $medico= elimina_acentos($row['profesional']) ;
         if ($row['isapre']=='CRUZ BLANCA'){
            $mandante="CETEP";
        }else{
        $mandante=$row['isapre'];
        }

        $telefono2 = preg_replace("[^0-9]", "", $row['celular']);
// echo "data en la base: ".$row['telefono']."<br/>New string is: ".$telefono2."</br>";
        $mensaje='Sr(a).'.$apellido.':'.'Le recordamos que tiene peritaje el'.' '.$citado.' '.'a las'.' '.$hora.''.' en '.''.$lugar.' '.'con Dr(a).'.''. $medico.'. '.'Atte.'.''.$mandante; 
        $user='rodrigot';
        $pass='rt123';
var_dump($mensaje);
$params1 = array(
  'in0'	=> $user,
  'in1'	=> $pass,
  'in2'	=> '569'.$telefono2,
  'in3'	=> $mensaje
  
);
	$URL1="http://ida.itdchile.cl/services/smsApiService?wsdl";
         $options = array('trace' => 1,
                        'encoding'  => 'UTF-8',       
                        'exceptions'=>1, 
                        'cache_wsdl'=>WSDL_CACHE_NONE); 
        $client= new SoapClient($URL1,$options);
     //   var_dump($client->__getFunctions()); 
        //var_dump($client->__getTypes()); 
        $response=$client->sendSms($params1);
       //  $response=$client->getCredits($params1);
         $request=beautify( $client->__getLastRequest());
         $response= beautify($client->__getLastResponse());
         $sqlin="INSERT INTO `enviosms` (`idhora`,`request`,`response`)
            VALUES($idHora,'$request','$response')";	
          $exec=mysql_query($sqlin ,$conectar) ;
          echo $exec ;
 }
function beautify($xmlString)
{
 $outputString = "";
 $previousBitIsCloseTag = false;
    $previousBitIsSimplifiedTag=false;
 $indentLevel = 0;
 $bits = explode("<", $xmlString);
 foreach($bits as $bit){
  $bit = trim($bit);
     if (!empty($bit)){
      if ($bit[0]=="/"){ $isCloseTag = true; }
   else{ $isCloseTag = false; }
   if(strstr($bit, "/>")){
        $prefix = "\n".str_repeat(" ",$indentLevel);
        $previousBitIsSimplifiedTag = true;
   }else{
    if ( !$previousBitIsCloseTag and $isCloseTag){
     if ($previousBitIsSimplifiedTag){
      $indentLevel--;
      $prefix = "\n".str_repeat(" ",$indentLevel);
      }else{
      $prefix = "";
      $indentLevel--;
     }
    }
    if ( $previousBitIsCloseTag and !$isCloseTag){$prefix = "\n".str_repeat(" ",$indentLevel); $indentLevel++;}
    if ( $previousBitIsCloseTag and $isCloseTag){$indentLevel--;$prefix = "\n".str_repeat(" ",$indentLevel);}
    if ( !$previousBitIsCloseTag and !$isCloseTag){{$prefix = "\n".str_repeat(" ",$indentLevel); $indentLevel++;}}
    $previousBitIsSimplifiedTag = false;
   }
   $outputString .= $prefix."<".$bit;
   $previousBitIsCloseTag = $isCloseTag;
  }
 }
 return $outputString;
}
        
        
?>