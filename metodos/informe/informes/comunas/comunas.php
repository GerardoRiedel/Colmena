<?php 

//retorna los options de los bancos
function comunasOptions($conectar)
{
	$sql_comunas = mysql_query("
	SELECT 
		c.`id`, 
		c.`comuna` 
	FROM 
		comunas c
	ORDER BY 
		c.`comuna`
	", $conectar);

		?>
		<option value="NULL"></option>
	
	<?php 
	while($row_comunas = mysql_fetch_array($sql_comunas))
	{
		?>
		<option value="<?php echo $row_comunas[id]; ?>"><?php echo $row_comunas[comuna]; ?></option>
		<?php 
	}
}

//retorna la comuna
//recibe el id
function retornaComuna($id, $conectar)
{
	$sql_comunas = mysql_query("
	SELECT 
		c.`comuna` 
	FROM 
		comunas c
	WHERE 
		c.`id`=".$id."
	", $conectar);
	
	$row_comunas = mysql_fetch_array($sql_comunas);
	
	return $row_comunas['comuna'];

}

//retorna region de la comuna
//recibe el id de la comuna
function retornaRegion($id, $conectar)
{
	$sql_comunas = mysql_query("
	SELECT 
		r.`region` 
	FROM 
		comunas c, 
		regiones r
	WHERE 
		c.`id`=".$id." AND 
		c.`padre`=r.`id`
	", $conectar);
	
	$row_comunas = mysql_fetch_array($sql_comunas);
	
	return $row_comunas[region];

}

?>