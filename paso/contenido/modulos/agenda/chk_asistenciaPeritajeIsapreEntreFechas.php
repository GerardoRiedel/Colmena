<head>
<script language="javascript" src="<?php echo $LIB; ?>/numeros.js"></script>

<link href="../../../contenido/templates/defecto/estilos.css" rel="stylesheet" type="text/css">
    <style>
        body {font-family: Arial, Helvetica, sans-serif;}

        table {font-family: 'Lucida Sans Unicode', 'Lucida Grande', Sans-Serif;
            font-size: 12px;  margin: 45px; text-align: left; }

        th {font-size: 13px;font-weight: normal;padding:8px;background:#b9c9fe;
            border-top:4px solid #fff; border-bottom: 1px solid #fff; color: #039; }

        td {padding: 8px ; background: #e8edff; border-bottom: 1px solid #fff;
            color: #669;    border-top: 1px solid #000033  ; }
        tr: td { background: #d0dafd; color: #339;}
        td:hover {#eee;}
    </style>
    <script>
        function confirmar()
        {
            x_función_php();
            document.getElementById('resultado').innerHTML='<img src="../../../contenido/templates/defecto/imagenes/ajax-loader.gif">';
        }
    </script>

</head>
<body onload="confirmar()">
<div id="resultado"></div>
<table >
	<caption align="center"><h1>Listado Asistencia</h1></caption>
    <tr >
	  <th >Fecha</th>
	  <th>Total Agendado</th>
		<th>Asistentes</th>
		<th>Ausentes</th>
		<th>Desacuerdo</th>
        <th>% Asistencia</th>
  </tr>

<?php
include('../../../lib/datos.php');
include('../../../lib/conectar.php');
$conectar = conectar();
$idisa = $_POST['idisapre'] ;
$desde =$_POST['desde'] ;
$hasta= $_POST['hasta'] ;

//Si es un prestador muestro s�lo los que ha hecho el prestador
	$query = "
	SELECT DATE(hora) fecha,
prestador,
ciudad,
`f_ciudad`(ciudad)AS nomciu,
isapre,
`f_nomisapre`(isapre) AS descripcion,
`f_numerocitadosisaprefecha`(DATE(hora),isapre ) AS totalisapre,
`f_numerodeperitajeshechos`(DATE(hora),isapre)AS totalasistencia ,
`f_numerodeperitajesnohechos`(DATE(hora),isapre) AS noasiste,
`f_rechazo`(DATE(hora),isapre) AS rechazo,
round((`f_numerodeperitajesnohechos`(DATE(hora),isapre)/ `f_numerocitadosisaprefecha`(DATE(hora),isapre )*100),2) AS porcentaje
FROM horas WHERE DATE_FORMAT(hora,'%Y/%m/%d') BETWEEN '".$desde."' AND '".$hasta."'
AND isapre = ".$idisa."
GROUP BY DATE(hora)";
$sql = mysql_query($query, $conectar);
$stotalagendado= 0;
$stotalasiste = 0;
$stotalausente = 0;
$stotalporcentaje = 0;
$totalrechazo = 0 ;
$i=0;
    while ($row = mysql_fetch_array($sql)) {
      $i++;
        $fecha = $row['fecha'];
		$totalisapre=$row['totalisapre'];
		$totalasistencia=$row['totalasistencia'];
		$noasistencia = 	$row['noasiste'];
        $rechazo = $row['rechazo'];
		$porcentaje = 	$row['porcentaje'];
        //Si el resultado es positivo, muestra la agenda antigua

        ?>
        <tr>
            <td align="center"><?php echo $fecha; ?></td>
            <td align="center"><?php echo $totalisapre; ?></td>
            <td align="center"><?php echo $totalasistencia; ?></td>
            <td align="center"><?php echo $noasistencia; ?></td>
            <td align="center"><?php echo round(($totalisapre/$rechazo)*100,2);?></td>
            <td align="center"><?php echo $porcentaje; ?></td>
        </tr>
    <?php




    $stotalagendado=$stotalagendado+$totalisapre;
    $stotalasiste =$stotalasiste+$totalasistencia ;
    $stotalausente = $stotalausente+ $noasistencia ;
    $totalrechazo = $totalrechazo+$rechazo ;
    }
    ?>
   
<tr>
    <td>
    
    </td>
    <td align="center">
    <?php echo $stotalagendado;?>
    </td>
    <td align="center">
    <?php echo $stotalasiste;?>
    </td>
    <td align="center">
    <?php echo $stotalausente;?>
    </td>
    <td align="center">
        <?php  echo $totalrechazo.'%';?>
    </td>
    <td align="center">
    <?php echo round(($stotalasiste/$stotalagendado)*100,2).'%';?>
    </td>

</tr>
</table>
	<div align="center" >
			<label>
			<input name="Button" type="button" class="botonNormal" value="Volver" onclick="window.history.go(-1);"/>
			</label>
    </div>
</body>