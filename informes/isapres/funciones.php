<?php

function nombreIsapre($id, $conectar)
{
	$sql = mysql_query("
	SELECT 
		i.`isapre` 
	FROM 
		isapres i
	WHERE 
		i.`id`=$id
	", $conectar);
	
	$row = mysql_fetch_array($sql);
	
	return $row['isapre'];
}

//Retorna el numero de isapres total
function numeroIsapres($conectar)
{
	$sql = mysql_query("
	SELECT 
		i.`id` 
	FROM 
		isapres i
	", $conectar);
	
	$num = mysql_num_rows($sql);
	
	return $num;
}


//retorna los options de los bancos
function isapresOptions($conectar)
{
	$sqlIsapres = mysql_query("
	SELECT 
		i.`id`, 
		i.`isapre` 
	FROM 
		isapres i
	ORDER BY 
		i.`id` ASC
	", $conectar);
	
	?>

	<?php 
	while($rowIsapres = mysql_fetch_array($sqlIsapres))
	{
		?>
		<option value="<?php echo $rowIsapres[id]; ?>"><?php echo $rowIsapres[isapre]; ?></option>
		<?php 
	}

}

function isapreUsuario($idUsuario, $conectar)
{
	$sql = mysql_query("
	SELECT  
		p.`isapre` 		
	FROM 
		usuario_isapre p
	WHERE 
		p.`usuario`=$idUsuario
	", $conectar);
	
	$row = mysql_fetch_array($sql);
	
	return $row[isapre];
}

//Verifica si el prestador tiene la isapre recibida
//Retorna true o false
//recibe el idPrestador y idIsapre
function siIsaprePrestador($idPrestador, $idIsapre, $conectar)
{
	$sql = mysql_query("
	SELECT  
		p.`isapre` 		
	FROM 
		prestador_isapre p
	WHERE 
		p.`prestador`=$idPrestador AND
		p.`isapre`=$idIsapre
	", $conectar);
	
	$num = mysql_num_rows($sql);
	
	if($num != 0)
	{
		return true;
	}
	else
	{
		return false;
	}
}


function idIsapre($isapre,$conectar){
	$sql = mysql_query("
	SELECT
		i.`id`
	FROM
		isapres i
	where isapre ='$isapre'
	", $conectar);

	$row = mysql_fetch_array($sql);

	return $row['id'];

}


?>