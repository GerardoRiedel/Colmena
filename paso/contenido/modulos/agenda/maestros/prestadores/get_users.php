<?php
	$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
	$rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
	$sort = isset($_POST['sort']) ? strval($_POST['sort']) : 'id';
	$order = isset($_POST['order']) ? strval($_POST['order']) : 'asc';
	
	$offset = ($page-1)*$rows;
	$result = array();
            
	include 'conn.php';
	
        $rs = mysql_query("select count(*) from prestadores ");
	$row = mysql_fetch_row($rs);
	$result["total"] = $row[0];
	$rs = mysql_query("SELECT
    `prestadores`.`id` as id
    , `prestadores`.`activo` as activo
    , `prestadores`.`rut` as rut
    , `prestadores`.`nombres` as nombres
    , `prestadores`.`apellidoPaterno` as apellidoPaterno
    , `prestadores`.`apellidoMaterno` apellidoMaterno
    , `prestadores`.`telefono` as telefono
    , `prestadores`.`celular` as celular
    , `prestadores`.`especialidad` as especialidad
    , `prestadores`.`cobroSantiago` as cobroSantiago
    , `prestadores`.`cobroRegiones` as cobroRegiones
    , `especialidad`.`especialidad` AS nombre_especialidad
FROM
    `cetepcl_agenda`.`prestadores`
    INNER JOIN `cetepcl_agenda`.`especialidad` 
        ON (`prestadores`.`especialidad` = `especialidad`.`id`)
		ORDER BY $sort $order
	limit $offset,$rows");
	
	
	$items = array();
	while($row = mysql_fetch_object($rs)){
		array_push($items, $row);
	}
	$result["rows"] = $items;

	echo json_encode($result);

?>