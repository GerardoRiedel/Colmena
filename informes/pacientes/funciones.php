<?php


function crearPaciente($rut, $nombres, $apellidoPaterno, $apellidoMaterno, $direccion, $comuna, $telefono, $celular, $email, $isapre , $conectar)
{
	$sql = mysql_query("
	SELECT 
		p.`rut` 
	FROM 
		pacientes p
	WHERE 
		p.`rut`=$rut
	", $conectar);

	
	if(mysql_num_rows($sql) == 0)//si no existe el paciente
	{
		mysql_query("
		INSERT INTO
			pacientes
			(rut, nombres, apellidoPaterno, apellidoMaterno, direccion, comuna, telefono, celular, email, isapre)
		VALUES
			('".$rut."', '".$nombres."', '".$apellidoPaterno."', '".$apellidoMaterno."', '".$direccion."', '".$comuna."', '".$telefono."', '".$celular."', '".$email."', '".$isapre."')
		", $conectar);	
		
		return mysql_insert_id();	
	}
	else//si existe el paciente
	{
		return false;
	}

}

function crearPacienteEspera($rut, $nombres, $apellidoPaterno, $apellidoMaterno, $direccion, $comuna, $telefono, $celular, $email, $isapre , $conectar)
{
	mysql_query("
	INSERT INTO
		pacientes
		(rut, nombres, apellidoPaterno, apellidoMaterno, direccion, comuna, telefono, celular, email, isapre)
	VALUES
		('".$rut."', '".$nombres."', '".$apellidoPaterno."', '".$apellidoMaterno."', '".$direccion."', '".$comuna."', '".$telefono."', '".$celular."', '".$email."', '".$isapre."')
	", $conectar);	
	
	return mysql_insert_id();	
}

function crearPacienteEspera_Espera($idCiudad, $rut, $nombres, $apellidoPaterno, $apellidoMaterno, $fechaVencimientoLic, $direccion, $comuna, $telefono, $celular, $email, $isapre, $observacion,$usuario,$numerolicencia, $conectar)
{
	$sql="
	INSERT INTO
		pacientes_espera
		(fechaIngreso, ciudad, rut, nombres, apellidoPaterno, apellidoMaterno, fechaVencimientoLic, direccion, comuna, telefono, celular, email, isapre, observacion,idusuario,numeroLicencia)
	VALUES
		(now(), '".$idCiudad."', '".$rut."', '".$nombres."', '".$apellidoPaterno."', '".$apellidoMaterno."', '".$fechaVencimientoLic."', '".$direccion."', '".$comuna."', '".$telefono."', '".$celular."', '".$email."', '".$isapre."', '".$observacion."','$usuario','$numerolicencia')
	";
    //echo $sql;
    $resul=mysql_query($sql, $conectar);



	return mysql_insert_id();	
}

function editarPaciente($id, $rut, $nombres, $apellidoPaterno, $apellidoMaterno, $direccion, $comuna, $telefono, $celular, $email, $isapre , $conectar)
{	
	mysql_query("
	UPDATE
		pacientes
	SET	
		rut='$rut', 
		nombres='$nombres', 
		apellidoPaterno='$apellidoPaterno', 
		apellidoMaterno='$apellidoMaterno', 
		direccion='$direccion', 
		comuna='$comuna', 
		telefono='$telefono', 
		celular='$celular', 
		email='$email', 
		isapre='$isapre'
	WHERE
		id=$id
	", $conectar);	
}

function eliminarPaciente($id, $conectar)
{	
	mysql_query("
	DELETE FROM
		pacientes
	WHERE
		id=$id
	", $conectar);	
}

function datosPacienteRut($rut, $conectar)
{
	$sql = mysql_query("
	SELECT 
		p.`id`, 
		p.`rut`, 
		p.`nombres`, 
		p.`apellidoPaterno`, 
		p.`apellidoMaterno`, 
		p.`direccion`, 
		p.`comuna`, 
		 `f_licencialistaespera`($rut) as lic,
		p.`telefono`, 
		p.`celular`, 
		p.`email`, 
		p.`isapre` 
	FROM 
		pacientes p
	WHERE 
		p.`rut`=".$rut."
	", $conectar);
	
	$row = mysql_fetch_array($sql);
	
	return $row;	
}

function datosPacienteId($id, $conectar)
{
	$sql = mysql_query("
	SELECT 
		p.`id`, 
		p.`rut`, 
		p.`nombres`, 
		p.`apellidoPaterno`, 
		p.`apellidoMaterno`, 
		p.`direccion`, 
		p.`comuna`, 
		p.`telefono`, 
		p.`celular`, 
		p.`email`, 
		p.`isapre` 
	FROM 
		pacientes p
	WHERE 
		p.`id`=".$id."
	", $conectar);
	
	$row = mysql_fetch_array($sql);
	
	return $row;	
}

function nombreCompletoPacienteApellido($id, $conectar)
{
	$sql = mysql_query("
	SELECT 
		p.`nombres`, 
		p.`apellidoPaterno`, 
		p.`apellidoMaterno` 
	FROM 
		pacientes p
	WHERE 
		p.`id`=$id
	", $conectar);
	
	$row = mysql_fetch_array($sql);
	
	return $row[apellidoPaterno].' '.$row[apellidoMaterno].', '.$row[nombres];	
}
function nombreCompletoPacienterut($rut, $conectar)
{
	$sql = mysql_query("
	SELECT 
		p.`nombres`, 
		p.`apellidoPaterno`, 
		p.`apellidoMaterno` 
	FROM 
		pacientes p
	WHERE 
		p.`rut`='$rut'
	", $conectar);
	
	$row = mysql_fetch_array($sql);
	
	return $row['nombres'].' '.$row['apellidoPaterno'].' '.$row['apellidoMaterno'];	
}
function nombreCompletoPaciente($id, $conectar)
{
	$sql = mysql_query("
	SELECT 
		p.`nombres`, 
		p.`apellidoPaterno`, 
		p.`apellidoMaterno` 
	FROM 
		pacientes p
	WHERE 
		p.`id`=$id
	", $conectar);
	
	$row = mysql_fetch_array($sql);
	
	return $row['nombres'].' '.$row['apellidoPaterno'].' '.$row['apellidoMaterno'];
}

function telefonosPaciente($id, $conectar)
{
	$sql = mysql_query("
	SELECT 
		p.`telefono`,
		p.`celular`
	FROM 
		pacientes p
	WHERE 
		p.`id`=$id
	", $conectar);
	
	$row = mysql_fetch_array($sql);
	
	return $row[telefono].', '.$row[celular];		
}

function rutPaciente($id, $conectar)
{
	$sql = mysql_query("
	SELECT 
		p.`rut`
	FROM 
		pacientes p
	WHERE 
		p.`id`=$id
	", $conectar);
	
	$row = mysql_fetch_array($sql);
	
	return $row['rut'];
}

function nombresPaciente($id, $conectar)
{
	$sql = mysql_query("
	SELECT 
		p.`nombres`
	FROM 
		pacientes p
	WHERE 
		p.`id`=$id
	", $conectar);
	
	$row = mysql_fetch_array($sql);
	
	return $row[nombres];		
}

function apellidoPaternoPaciente($id, $conectar)
{
	$sql = mysql_query("
	SELECT 
		p.`apellidoPaterno`
	FROM 
		pacientes p
	WHERE 
		p.`id`=$id
	", $conectar);
	
	$row = mysql_fetch_array($sql);
	
	return $row[apellidoPaterno];		
}

function apellidoMaternoPaciente($id, $conectar)
{
	$sql = mysql_query("
	SELECT 
		p.`apellidoMaterno`
	FROM 
		pacientes p
	WHERE 
		p.`id`=$id
	", $conectar);
	
	$row = mysql_fetch_array($sql);
	
	return $row[apellidoMaterno];		
}

function telefonoPaciente($id, $conectar)
{
	$sql = mysql_query("
	SELECT 
		p.`telefono`
	FROM 
		pacientes p
	WHERE 
		p.`id`=$id
	", $conectar);
	
	$row = mysql_fetch_array($sql);
	
	return $row[telefono];		
}

function celularPaciente($id, $conectar)
{
	$sql = mysql_query("
	SELECT 
		p.`celular`
	FROM 
		pacientes p
	WHERE 
		p.`id`=$id
	", $conectar);
	
	$row = mysql_fetch_array($sql);
	
	return $row[celular];		
}

function emailPaciente($id, $conectar)
{
	$sql = mysql_query("
	SELECT 
		p.`email`
	FROM 
		pacientes p
	WHERE 
		p.`id`=$id
	", $conectar);
	
	$row = mysql_fetch_array($sql);
	
	return $row[email];		
}

function direccionPaciente($id, $conectar)
{
	$sql = mysql_query("
	SELECT 
		p.`direccion`
	FROM 
		pacientes p
	WHERE 
		p.`id`=$id
	", $conectar);
	
	$row = mysql_fetch_array($sql);
	//die($row['direccion']);
	return $row['direccion'];		
}

function idComunaPaciente($id, $conectar)
{
	$sql = mysql_query("
	SELECT 
		p.`comuna`
	FROM 
		pacientes p
	WHERE 
		p.`id`=$id
	", $conectar);
	
	$row = mysql_fetch_array($sql);
	
	return $row['comuna'];		
}

function isaprePaciente($id, $conectar)
{
	$sql = mysql_query("
	SELECT 
		p.`isapre`
	FROM 
		pacientes p
	WHERE 
		p.`id`=$id
	", $conectar);
	
	$row = mysql_fetch_array($sql);
	
	return $row[isapre];		
}

//Retorna el id del paciente
//Recibe el rut del paciente
function idPaciente($rut, $conectar)
{
	$sql = mysql_query("
	SELECT 
		p.`id`
	FROM 
		pacientes p
	WHERE 
		p.`rut`=$rut
	", $conectar);
	
	$row = mysql_fetch_array($sql);

	return $row[id];		
}

//Si el paciente ya ha sido citado con anterioridad
function siPacienteAntiguo($paciente, $conectar)
{
	$sql = mysql_query("
	SELECT 
		COUNT(h.`id`) as cuenta 
	FROM 
		horas h
	WHERE 
		h.`paciente`=".$paciente."
	", $conectar);
	
	if(mysql_num_rows($sql) > 1)
	{
		return true;
	}
	else
	{
		return false;	
	}
}
?>