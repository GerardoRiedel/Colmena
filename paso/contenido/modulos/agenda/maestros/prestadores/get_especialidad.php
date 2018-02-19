<?php
	
	$result = array();

	include 'conn.php';
	   
	$rs = mysql_query("select id,especialidad from especialidad ");
	
	$items = array();
	while($row = mysql_fetch_object($rs)){
		array_push($items, $row);
	}
	$result["rows"] = $items;

	echo json_encode($items);

?>