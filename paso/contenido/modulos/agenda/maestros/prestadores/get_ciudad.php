<?php
	
	$result = array();

	include 'conn.php';
	   
	$rs = mysql_query("select id,ciudad from ciudades ");
	
	$data = array();
	while($row = mysql_fetch_object($rs)){
		array_push($data, $row);
	}
	$result["rows"] = $data;

	echo json_encode($data);

?>