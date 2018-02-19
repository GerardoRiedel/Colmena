<?php

function crearHora($usuario, $hora, $idCiudad, $paciente, $prestador, $isapre, $confirmada, $observacion,$numerolicencia, $conectar)
{
	setlocale(LC_ALL,"SP");
	$fechaActual = strftime("%d")." de ".strftime("%B")." de ".strftime("%Y");
	$fechaActual = editames($fechaActual);
	$fechaActual = cambiaf_a_mysql($fechaActual);
    $numerolicencia = empty($numerolicencia) ? 0 : $numerolicencia;
    $q="INSERT INTO	horas (usuario, hora, fecha, ciudad, paciente, prestador, isapre, confirmada, observacion,numerolicencia)
	VALUES	($usuario, '$hora', '$fechaActual', '$idCiudad',  $paciente, $prestador, $isapre, '$confirmada','$observacion','$numerolicencia')" ;
    $resulInsert =mysql_query($q, $conectar);

	$idinsertahora= mysql_insert_id();



return ($idinsertahora);
}

function crearHoralista($usuario,$hora, $idCiudad, $paciente, $prestador, $isapre, $confirmada, $observacion,$idusuariolista,$numerolicencia, $conectar){
    setlocale(LC_ALL,"SP");
    $fechaActual = strftime("%d")." de ".strftime("%B")." de ".strftime("%Y");
    $fechaActual = editames($fechaActual);
    $fechaActual = cambiaf_a_mysql($fechaActual);
	$sql="INSERT INTO horas (usuario, hora, fecha, ciudad, paciente, prestador, isapre, confirmada, observacion,idusuarioLista,numerolicencia)
    	VALUES 	($usuario, '$hora', '$fechaActual', '$idCiudad',  $paciente, $prestador, $isapre, '$confirmada','$observacion','$idusuariolista','$numerolicencia' )	";
	
		mysql_query($sql,$conectar);

   return mysql_insert_id();
}



function crearHoraPrestador($prestador, $hora, $ciudad, $conectar)
{
	//Verifico si la ciudad es o no una regi�n
	$sql = mysql_query("
	SELECT 
		c.`region` 
	FROM 
		ciudades c
	WHERE 
		c.`id`=$ciudad
	", $conectar);
	
	$row = mysql_fetch_array($sql);
	$siRegion = $row['region'];
	
	$sqlRegion = mysql_query("
	SELECT 
		p.`cobroSantiago`, 
		p.`cobroRegiones` 
	FROM 
		prestadores p
	WHERE 
		p.`id`=$prestador
	", $conectar);
	
	$rowRegion = mysql_fetch_array($sqlRegion);

	$cobroSantiago = $rowRegion['cobroSantiago'];
	$cobroRegiones = $rowRegion['cobroRegiones'];
		
	mysql_query("
	INSERT INTO 
		horas_prestadores
		(prestador, hora, ciudad, cobroSantiago, cobroRegiones)
	VALUES
		($prestador, '$hora', '$ciudad', '$cobroSantiago', '$cobroRegiones')
	", $conectar);
	
	return mysql_insert_id($conectar);
}

function datosHora($id, $conectar)
{
	$sql = mysql_query("
	SELECT 
		h.`id`, 
		h.`usuario`, 
		h.`hora`, 
		h.`fecha`, 
		h.`ciudad`, 
		h.`paciente`, 
		h.`prestador`, 
		h.`isapre`, 
		h.`confirmada`, 
		h.`asiste`, 
		h.`observacion` 
	FROM 
		horas h
	WHERE 
		h.`id`=".$id."
	", $conectar);
		
	$row = mysql_fetch_array($sql);
	
	return $row;		
}
function vincularIsapreHora($isapre, $hora, $conectar)
{
	$sql="INSERT INTO isapres_hora (isapre, hora) VALUES ($isapre, $hora)";	
	$result= mysql_query($sql,$conectar) ;
	//echo $sql ;
		if($sql == false)
	{
		die('No se pudo registrar la vinculac de la hora');
	}


}


function datosHora2($id, $conectar)
{

    $sql = mysql_query("SELECT
    `horas`.`hora`
    ,`horas`.`numerolicencia`
    ,`horas`.`paciente`
    , REPLACE(FORMAT(`pacientes`.`rut`,0),',','.') AS rut
    ,`f_digito`(`pacientes`.`rut`) AS dv
    ,`pacientes`.`nombres`
    ,`pacientes`.`apellidoPaterno`
    ,`pacientes`.`apellidoMaterno`
    ,`pacientes`.`telefono`
    ,`pacientes`.`celular`
    ,`pacientes`.`email`
    ,`pacientes`.`direccion`
   , `pacientes`.`comuna`
    ,`horas`.`isapre`
    ,`f_nomisapre`(`horas`.`isapre`)AS nombreisapre
    ,`horas`.`observacion`
    ,`ciudades`.`ciudad`
    ,`horas`.`id`
    ,`f_nombreusuario`(`usuario`) AS usuario
	,`horas`.`fechaIngresoALista`
	,`horas`.`fechaAscenso`
	,`f_nombreusuario`(`idusuarioLista`) AS usuariolista
FROM
    `pacientes`
    INNER JOIN `horas`
        ON (`pacientes`.`id` = `horas`.`paciente`)
    INNER JOIN `ciudades`
        ON (`ciudades`.`id` = `horas`.`ciudad`)
WHERE (`horas`.`id` =".$id.");",$conectar);


    $row=mysql_fetch_array($sql);
return $row;
}

function siExisteHora($hora, $idCiudad, $prestador, $conectar)
{
	$sql = mysql_query("
	SELECT 
		h.`id` 
	FROM 
		horas h
	WHERE 
		h.`hora`='".$hora."' AND 
		h.`ciudad`=".$idCiudad." AND 
		h.`prestador`=".$prestador."
	", $conectar);	
	
	if(mysql_num_rows($sql) != 0)
	{
		$row = mysql_fetch_array($sql);
		return $row['id'];
	}
	else
	{
		return false;	
	}
}

function eliminarHora($id, $usuario, $hora, $paciente, $prestador, $isapre, $conectar)
{
	$datosHora = datosHora($id, $conectar);
	
	$sql = mysql_query("
	INSERT INTO 
		horas_eliminadas
		(usuario, fecha, idHora, hora, ciudad, paciente, prestador, isapre)
	VALUES
		($usuario, now(), ".$id.", '$hora', ".$datosHora['ciudad'].", $paciente, $prestador, $isapre)
	", $conectar);	

	if($sql == false)
	{
		die('No se pudo registrar la eliminacion de la hora');
	}

	$sql = mysql_query("
	DELETE FROM 
		horas 
	WHERE
		id=$id
	", $conectar);
	
	if($sql == false)
	{
		die('No se elimin� la hora');
	}
}

//S�lo para el enroque de horas
function eliminarHora2($id, $conectar)
{
	mysql_query("
	DELETE FROM 
		horas 
	WHERE
		id=$id
	", $conectar);
}

function editarHora($id, $isapre, $observacion, $conectar)
{
	mysql_query("
	UPDATE 
		horas 
	SET	 
		isapre=$isapre,  
		observacion='$observacion'
	WHERE
		id=$id
	", $conectar);
}

function editarHora2($id, $paciente, $isapre, $observacion,$numerolicencia, $conectar)
{
	mysql_query("
	UPDATE 
		horas 
	SET
		paciente=".$paciente.",
		isapre=".$isapre.",  
		observacion='".$observacion."',
		numerolicencia=".$numerolicencia."
	WHERE
		id=$id
	", $conectar);
}

//////////////////////////////////////////////////////
////////////////////  ISAPRE - HORA  /////////////////

//Si la isapre est� vinculada a la hora del prestador
function siIsapresHoraPrestador($isapre, $idHoraPrestador, $conectar)
{
	$sql = mysql_query("
	SELECT 
		i.`id` 
	FROM 
		isapres_hora i
	WHERE 
		i.`isapre`=".$isapre." AND 
		i.`hora`= '".$idHoraPrestador."'
	", $conectar);
		
	if(mysql_num_rows($sql) != 0)
	{
		return true;	
	}
	else
	{
		return false;	
	}
}
////////////////////  ISAPRE - HORA  /////////////////
//////////////////////////////////////////////////////

function editarIsapreHora($id, $isapre, $conectar)
{
	mysql_query("
	UPDATE 
		horas 
	SET	 
		isapre=$isapre
	WHERE
		id=$id
	", $conectar);
}

//Retorna el id del paciente
//Recibe el id de la hora
function idPacienteHora($id, $conectar)
{
	$sql = mysql_query("
	SELECT 
		h.`paciente` 
	FROM 
		horas h
	WHERE 
		h.`id`=$id
	", $conectar);
	
	$row = mysql_fetch_array($sql);
	
	return $row['paciente'];
}

//Retorna el id del prestador
//Recibe el id de la hora
function idPrestadorHora($id, $conectar)
{
	$sql = mysql_query("
	SELECT 
		h.`prestador` 
	FROM 
		horas h
	WHERE 
		h.`id`=$id
	", $conectar);
	
	$row = mysql_fetch_array($sql);
	
	return $row['prestador'];
}

function fechaFormateadaHora($id, $conectar)
{
	$sql = mysql_query("
	SELECT 
		DATE_FORMAT(h.`hora`, '%Y-%m-%d') as fecha 
	FROM 
		horas h
	WHERE 
		h.`id`=$id
	", $conectar);

	$row = mysql_fetch_array($sql);
	
	return $row['fecha'];
}

function fechaHora($id, $conectar)
{
	$sql = mysql_query("
	SELECT 
 		h.`hora`
	FROM 
		horas h
	WHERE 
		h.`id`=$id
	", $conectar);

	$row = mysql_fetch_array($sql);
	
	return $row['hora'];
}

function horaHora($id, $conectar)
{
	$sql = mysql_query("
	SELECT 
		h.`hora` 
	FROM 
		horas h
	WHERE 
		h.`id`=$id
	", $conectar);

	$row = mysql_fetch_array($sql);
	
	return $row['hora'];
}

function usuarioHora($id, $conectar)
{
	$sql = mysql_query("
	SELECT 
		h.`usuario` 
	FROM 
		horas h
	WHERE 
		h.`id`=$id
	", $conectar);

	$row = mysql_fetch_array($sql);
	
	return $row['usuario'];
}

function observacionHora($id, $conectar)
{
	$sql = mysql_query("
	SELECT 
		h.`observacion` 
	FROM 
		horas h
	WHERE 
		h.`id`=$id
	", $conectar);
		
	$row = mysql_fetch_array($sql);
	
	return $row['observacion'];
}

function isapreHora($id, $conectar)
{
    
	$sql = mysql_query("
	SELECT 
		h.`isapre` 
	FROM 
		horas h
	WHERE 
		h.`id`=$id
	", $conectar);
	
	$row = mysql_fetch_array($sql);
	
	return $row['isapre'];
}

function ciudadHora($id, $conectar)
{
	$sql = "
	SELECT 
		h.`ciudad` 
	FROM 
		horas h
	WHERE 
		h.`id`=$id";
	
	$db = getConnection();
	$stmt = $db->prepare($sql);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
	
	return $row['ciudad'];

}


function horaConfirmada($id, $conectar)
{
	$sql = mysql_query("
	SELECT 
		h.`confirmada` 
	FROM 
		horas h
	WHERE 
		h.`id`=$id
	", $conectar);
	
	$row = mysql_fetch_array($sql);
	
	if($row['confirmada'] == 'si')
	{
		return true;
	}
	else
	{
		return false;
	}
}

function fechaAscenso($id, $fechoraAscenso, $conectar)
{
	mysql_query("
	UPDATE  
		horas
	SET
		 fechaAscenso = '$fechoraAscenso'
	WHERE 
		id='$id'
	", $conectar);
}


function fechaIngresoLista($id, $fechaIngreso, $conectar)
{
	mysql_query("
	UPDATE  
		horas
	SET
		 fechaIngresoALista = '$fechaIngreso'
	WHERE 
		id='$id'
	", $conectar);
}



function confirmarHora($id, $fechoraConfirmacion, $conectar)
{
	mysql_query("
	UPDATE  
		horas
	SET
		confirmada='si', fechoraConfirmacion = '$fechoraConfirmacion'
	WHERE 
		id='$id'
	", $conectar);
}

/*
function confirmarHora($id, $conectar)
{
	mysql_query("
	UPDATE  
		horas
	SET
		confirmada='si'
	WHERE 
		id=$id
	", $conectar);
}
*/

function confirmarAsistencia($id, $conectar)
{
	mysql_query("
	UPDATE  
		horas
	SET
		asiste='si'
	WHERE 
		id='".$id."'
	", $conectar);	
}

//Cambia el estado de la asistencia

function confirmarAsistenciaHora($id,$asiste,$conectar){
	date_default_timezone_set('America/Santiago');
	$estado = '' ;
	if($asiste != '')
	{
		$sql = "UPDATE	horas SET asiste= '$asiste' WHERE id=$id" ;
		
		mysql_query($sql, $conectar);
		agregarLog($MODULOS.'/agenda/chk_confirmarAsistenciaHora.php?hora='.$id, $_SESSION['idUsuario'], nombreUsuario($_SESSION['idUsuario'], $conectar), date('Y-m-d H:i:s'), 'Confirma asistencia ='.$asiste, $conectar);
    	$estado	= 1 ;
	}

echo $estado;
}


function confirmarAsistenciaHora_old($id, $conectar)
{
	
	$sql = mysql_query("
	SELECT 
		h.`asiste` 
	FROM 
		horas h
	WHERE 
		h.`id`=$id
	", $conectar);
	
	$row = mysql_fetch_array($sql);
	
	if($row['asiste'] == 'si')
	{
		mysql_query("
		UPDATE  
			horas
		SET
			asiste='no'
		WHERE 
			id=$id
		", $conectar);
		
		agregarLog($MODULOS.'/agenda/chk_confirmarAsistenciaHora.php?hora='.$id, $_SESSION['idUsuario'], nombreUsuario($_SESSION['idUsuario'], $conectar), date('Y-m-d H:i:s'), 'Confirma asistencia = no', $conectar);
	}	
	elseif($row['asiste'] == 'no')
	{
		mysql_query("
		UPDATE  
			horas
		SET
			asiste='si'
		WHERE 
			id=$id
		", $conectar);	
		
		agregarLog($MODULOS.'/agenda/chk_confirmarAsistenciaHora.php?hora='.$id, $_SESSION['idUsuario'], nombreUsuario($_SESSION['idUsuario'], $conectar), date('Y-m-d H:i:s'), 'Confirma asistencia = si', $conectar);
	}
}

function asisteHora($id, $conectar)
{
	$sql = mysql_query("
	SELECT 
		h.`asiste` 
	FROM 
		horas h
	WHERE 
		h.`id`=$id
	", $conectar);
	
	$row = mysql_fetch_array($sql);
    $x=false;
	if($row['asiste'] == 'si')
	{
		$x=true;
	}	
	elseif($row['asiste'] == 'no')
	{
        $x=false;
	}
	elseif(isset($row['asiste']))
	{
        $x=false;
	}else {
		$x=false ;
	}
    return $x ;
}

//Diferencia de la hora actual now con la fecha de la hora
function diferenciaFechaHora($id, $conectar)
{
	$fecha = date('Y-m-d H:i:s');
	
	$sql = mysql_query("
	SELECT 
		TIMEDIFF(h.`hora`, '$fecha') as diferencia,
		h.`hora`
	FROM 
		horas h
	WHERE 
		h.`id`=$id
	", $conectar);
	
	$row = mysql_fetch_array($sql);
	
	//Si es negativo, la fecha actual es mayor que la hora
	if($row['diferencia'] < 0)
	{
		return true;
	}
	else
	{
		return false;
	}
}

//Elige prestador para ingresar una hora nueva
//Recibe la fecha en formato Y-m-d
function eligePrestadorHora($fecha, $ciudad, $conectar)
{
	$sql = mysql_query("
	SELECT 
		h.`prestador` 
	FROM 
		horas_prestadores h
	WHERE 
		h.`hora`='".$fecha."' AND
		h.`ciudad`='".$ciudad."'
	ORDER BY
		RAND()
	", $conectar);
	
	$num1 = mysql_num_rows($sql);

	while($row = mysql_fetch_array($sql))
	{
		$prestador = $row['prestador'];
		
		$sql2 = mysql_query("
		SELECT 
			h.`id` 
		FROM 
			horas h
		WHERE 
			h.`hora`='".$fecha."' AND 
			h.`ciudad`='".$ciudad."' AND 
			h.`prestador`=".$prestador."
		", $conectar);
		
		$num = mysql_num_rows($sql2);
		
		if($num == 0)
		{
			return $prestador;
			break;
		}
	}	
}

//Diferencia de la hora actual now con la fecha de la hora
function diferenciaHoraActualHora($id, $conectar)
{
	$fecha = date('Y-m-d H:i:s');
	
	$sql = mysql_query("
	SELECT 
		TIMESTAMPDIFF(HOUR,h.`hora`, '$fecha') as diferencia
	FROM 
		horas h
	WHERE 
		h.`id`=$id
	", $conectar);
	
	$row = mysql_fetch_array($sql);
	
	//Si es negativo, la fecha actual es mayor que la hora
	return $row['diferencia'];
}


function numeroCitadosFechaPeritoCiudad($fecha, $perito, $ciudad, $conectar)
{
	$sql = mysql_query("
	SELECT 
		h.`id` 
	FROM 
		horas h
	WHERE 
		h.`prestador`=".$perito." AND 
		h.`ciudad`=".$ciudad." AND 
		DATE(h.`hora`)='".$fecha."'
	", $conectar);
	
	return mysql_num_rows($sql);
}

function numeroCitadosFechaPeritoCiudadIsapre($fecha, $perito, $ciudad,$idIsapre, $conectar)
{
	$sql = mysql_query("
	SELECT 
		h.`id` 
	FROM 
		horas h
	WHERE 
		h.`prestador`=".$perito." AND 
		h.`ciudad`=".$ciudad." AND 
		h.`isapre`=".$idIsapre." AND
		DATE(h.`hora`)='".$fecha."'
	", $conectar);
	
	return mysql_num_rows($sql);
}




function numeroAsistentesFacturacionPeritoCiudad($facturacion, $conectar)
{
	//Si la fecha de la facturaci�n es m�ltiple
	$sqlFechas = mysql_query("
	SELECT 
		f.`fecha`, 
		f.`idCiudad`, 
		f.`idPrestador` 
	FROM 
		facturacion_viajes_datos f
	WHERE 
		f.`idFacturacionViajes`=".$facturacion."
	", $conectar);
	
	$asistentes = 0;

	while($rowFechas = mysql_fetch_array($sqlFechas))
	{	
		$fecha = $rowFechas['fecha'];
		$ciudad = $rowFechas['idCiudad'];
		$prestador = $rowFechas['idPrestador'];
		
		$sql = mysql_query("
		SELECT 
			h.`id` 
		FROM 
			horas h
		WHERE 
			h.`asiste`='si' AND 
			h.`prestador`=".$prestador." AND 
			h.`ciudad`=".$ciudad." AND 
			DATE(h.`hora`)='".$fecha."'
		", $conectar);
		
		$asistentes += mysql_num_rows($sql);
	}
	
	return $asistentes;
}

function numeroInasistentesFacturacionPeritoCiudad($facturacion, $conectar)
{
	//Si la fecha de la facturaci�n es m�ltiple
	$sqlFechas = mysql_query("
	SELECT 
		f.`fecha`, 
		f.`idCiudad`, 
		f.`idPrestador` 
	FROM 
		facturacion_viajes_datos f
	WHERE 
		f.`idFacturacionViajes`=".$facturacion."
	", $conectar);
	
	$inasistentes = 0;
	
	while($rowFechas = mysql_fetch_array($sqlFechas))
	{	
		$fecha = $rowFechas['fecha'];
		$ciudad = $rowFechas['idCiudad'];
		$prestador = $rowFechas['idPrestador'];
		
		$sql = mysql_query("
		SELECT 
			h.`id` 
		FROM 
			horas h
		WHERE 
			h.`asiste`='no' AND 
			h.`prestador`=".$prestador." AND 
			h.`ciudad`=".$ciudad." AND 
			DATE(h.`hora`)='".$fecha."'
		", $conectar);
		
		$inasistentes = $inasistentes + mysql_num_rows($sql);
	}
	
	return $inasistentes;
}

//Para datos espec�ficos de isapre
function numeroAsistentesFacturacionPeritoCiudadIsapre($facturacion, $isapre, $conectar)
{
	//Si la fecha de la facturaci�n es m�ltiple
	$sqlFechas = mysql_query("
	SELECT 
		f.`fecha`, 
		f.`idCiudad`, 
		f.`idPrestador` 
	FROM 
		facturacion_viajes_datos f
	WHERE 
		f.`idFacturacionViajes`=".$facturacion."
	", $conectar);
	
	$asistentes = 0;

	while($rowFechas = mysql_fetch_array($sqlFechas))
	{	
		$fecha = $rowFechas['fecha'];
		$ciudad = $rowFechas['idCiudad'];
		$prestador = $rowFechas['idPrestador'];
		
		$sql = mysql_query("
		SELECT 
			h.`id` 
		FROM 
			horas h
		WHERE 
			h.`asiste`='si' AND 
			h.`isapre`='".$isapre."' AND 
			h.`prestador`=".$prestador." AND 
			h.`ciudad`=".$ciudad." AND 
			DATE(h.`hora`)='".$fecha."'
		", $conectar);
		
		$asistentes += mysql_num_rows($sql);
	}
	
	return $asistentes;
}

function numeroInasistentesFacturacionPeritoCiudadIsapre($facturacion, $isapre, $conectar)
{
	//Si la fecha de la facturaci�n es m�ltiple
	$sqlFechas = mysql_query("
	SELECT 
		f.`fecha`, 
		f.`idCiudad`, 
		f.`idPrestador` 
	FROM 
		facturacion_viajes_datos f
	WHERE 
		f.`idFacturacionViajes`=".$facturacion."
	", $conectar);
	
	$asistentes = 0;

	while($rowFechas = mysql_fetch_array($sqlFechas))
	{	
		$fecha = $rowFechas['fecha'];
		$ciudad = $rowFechas['idCiudad'];
		$prestador = $rowFechas['idPrestador'];
		
		$sql = mysql_query("
		SELECT 
			h.`id` 
		FROM 
			horas h
		WHERE 
			h.`asiste`='no' AND 
			h.`isapre`='".$isapre."' AND 
			h.`prestador`=".$prestador." AND 
			h.`ciudad`=".$ciudad." AND 
			DATE(h.`hora`)='".$fecha."'
		", $conectar);
		
		$asistentes += mysql_num_rows($sql);
	}
	
	return $asistentes;
}

//N�mero de asistentes de un viaje por perito
function numeroAsistentesPeritoFecha($idPerito, $ano, $mes, $conectar)
{
	//Si la fecha de la facturaci�n es m�ltiple
	$sqlFechas = mysql_query("
	SELECT
		f.`idFacturacionViajes`
	FROM 
		facturacion_viajes_datos f
	WHERE
		f.`idPrestador`=".$idPerito." AND 
		f.`fecha` BETWEEN '".$ano."-".$mes."-01' AND '".$ano."-".$mes."-31'
	GROUP BY 
		f.`idFacturacionViajes`
	", $conectar);
	
	$asistentes = 0;

	while($rowFechas = mysql_fetch_array($sqlFechas))
	{	
		$idFacturacion = $rowFechas['idFacturacionViajes'];
		
		$asistentes += numeroAsistentesFacturacionPeritoCiudad($idFacturacion, $conectar);
	}
	
	return $asistentes;
}

//N�mero de asistentes de un viaje por perito
function numeroInasistentesPeritoFecha($idPerito, $ano, $mes, $conectar)
{
	//Si la fecha de la facturaci�n es m�ltiple
	$sqlFechas = mysql_query("
	SELECT
		f.`idFacturacionViajes`
	FROM 
		facturacion_viajes_datos f
	WHERE
		f.`idPrestador`=".$idPerito." AND 
		f.`fecha` BETWEEN '".$ano."-".$mes."-01' AND '".$ano."-".$mes."-31'
	GROUP BY 
		f.`idFacturacionViajes`
	", $conectar);
	
	$inasistentes = 0;

	while($rowFechas = mysql_fetch_array($sqlFechas))
	{	
		$idFacturacion = $rowFechas['idFacturacionViajes'];
		
		$inasistentes += numeroInasistentesFacturacionPeritoCiudad($idFacturacion, $conectar);
	}
	
	return $inasistentes;
}


//N�mero de asistentes de en santiago en un mes
function numeroAsistentesSantiagoPeritoFecha($idPerito, $ano, $mes, $conectar)
{
	//Si la fecha de la facturaci�n es m�ltiple
	$sql = mysql_query("
	SELECT 
		h.`id` 
	FROM 
		horas h
	WHERE 
		h.`asiste`='si' AND 
		h.`prestador`=".$idPerito." AND 
		h.`ciudad`=1 AND 
		DATE(h.`hora`) BETWEEN '".$ano."-".$mes."-01' AND '".$ano."-".$mes."-31'
	", $conectar);
		
	return mysql_num_rows($sql);
}

//N�mero de INASISTENTES de en santiago en un mes
function numeroInasistentesSantiagoPeritoFecha($idPerito, $ano, $mes, $conectar)
{
	//Si la fecha de la facturaci�n es m�ltiple
	$sql = mysql_query("
	SELECT 
		h.`id` 
	FROM 
		horas h
	WHERE 
		h.`asiste`='no' AND 
		h.`prestador`=".$idPerito." AND 
		h.`ciudad`=1 AND 
		DATE(h.`hora`) BETWEEN '".$ano."-".$mes."-01' AND '".$ano."-".$mes."-31'
	", $conectar);
		
	return mysql_num_rows($sql);
}

///////HORAS PRESTADOR///////////////

function fechaHoraPrestador($id, $conectar)
{
	$sql = mysql_query("
	SELECT 
		h.`hora` 
	FROM 
		horas_prestadores h
	WHERE 
		h.`id`=$id
	", $conectar);

	$row = mysql_fetch_array($sql);
	
	return $row['hora'];
}
function ciudadHoraPrestador($id, $conectar)
{
	$sql = mysql_query("
	SELECT 
		h.`ciudad` 
	FROM 
		horas_prestadores h
	WHERE 
		h.`id`=$id
	", $conectar);

	$row = mysql_fetch_array($sql);
	
	return $row['ciudad'];
}

function prestadorHoraPrestador($id, $conectar)
{
	$sql = mysql_query("
	SELECT 
		h.`prestador` 
	FROM 
		horas_prestadores h
	WHERE 
		h.`id`=$id
	", $conectar);

	$row = mysql_fetch_array($sql);
	
	return $row['prestador'];
}

//Retorna la hora del prestador seg�n la hora de la agenda y la ciudad
function idHoraPrestadorHoraCiudad($prestador, $hora, $ciudad, $conectar)
{
	$sql = mysql_query("
	SELECT 
		h.`id` 
	FROM 
		horas_prestadores h
	WHERE 
		h.`prestador`='".$prestador."' AND
		h.`hora`='".$hora."' AND
		h.`ciudad`='".$ciudad."'
	", $conectar);

	$row = mysql_fetch_array($sql);
	
	return $row['id'];
}

//Retorna los montos cobrados por el perito de santiago
function cobroSantiagoHoraPrestadorHoraCiudad($prestador, $hora, $ciudad, $conectar)
{
	$sql = mysql_query("
	SELECT 
		h.`cobroSantiago`
	FROM 
		horas_prestadores h
	WHERE 
		h.`prestador`='".$prestador."' AND
		h.`hora`='".$hora."' AND
		h.`ciudad`='".$ciudad."'
	", $conectar);

	$row = mysql_fetch_array($sql);
	
	return $row['cobroSantiago'];
}

//Retorna los montos cobrados por el perito den regiones
function cobroRegionesHoraPrestadorHoraCiudad($prestador, $hora, $ciudad, $conectar)
{
	$sql = mysql_query("
	SELECT 
		h.`cobroRegiones`
	FROM 
		horas_prestadores h
	WHERE 
		h.`prestador`='".$prestador."' AND
		h.`hora`='".$hora."' AND
		h.`ciudad`='".$ciudad."'
	", $conectar);
	
	$row = mysql_fetch_array($sql);
	
	return $row['cobroRegiones'];
}

function siPacienteTienePeritaje($paciente, $conectar)
{
	$sql = mysql_query("
	SELECT 
		i.`id` 
	FROM 
		informe_entrevista i
	WHERE 
		i.`paciente`=".$paciente."
	GROUP BY 
		i.`id`
	ORDER BY 
		i.`fecha` DESC
	LIMIT
	0,1
	", $conectar);
	
	if(mysql_num_rows($sql) != 0)
	{
		$row = mysql_fetch_array($sql);
		return $row;
	}
	else
	{
		return false;
	}
}




function siExisteHoraPrevia($paciente,$inicial,$final,  $conectar)
{
    $sql ="
	SELECT COUNT(*) as total
    FROM  `horas`
    WHERE DATE_FORMAT(hora,'%Y-%m-%d')
    BETWEEN '".$inicial."' AND '".$final."' AND paciente = '".$paciente."' ";
    // echo $sql ;
    $result= mysql_query($sql,$conectar);

        $row = mysql_fetch_array($result);
        return $row['total'];

}
function especialidadHoraPrestador($idHora,$conectar)
{
$sql="SELECT `prestadores`.`especialidad`
	  FROM   `horas`
    	INNER JOIN `prestadores`
        ON (`horas`.`prestador` = `prestadores`.`id`)
        WHERE `horas`.`id` ='".$idHora."'";
	$result= mysql_query($sql,$conectar);
	$row = mysql_fetch_array($result);
	return $row['especialidad'];

}

function datosEnvioEmail($id,$conectar)

{



$sql=mysql_query("SELECT

					`f_ciudadhora`(`horas`.`id`)AS ciudad

					, `horas`.`hora`

					,f_datospaciente(`horas`.`paciente`,3) AS paciente

					, CONCAT(`prestadores`.`nombres`,' ',`prestadores`.`apellidoPaterno`,' ',`prestadores`.`apellidoMaterno`) AS prestador

					,`prestadores`.`email`

				FROM `horas`

    			INNER JOIN `prestadores`

        		ON (`horas`.`prestador` = `prestadores`.`id`)

				WHERE  `horas`.`id` = $id ",$conectar)   ;



	$row=mysql_fetch_array($sql);

	return $row;



}
function emailreserva ($idHora,$conectar){


        $sqlDatos = "SELECT
                    `horas`.`id`
                    ,`f_datospaciente`(`horas`.`paciente`,2) AS paciente
                    ,`f_datospaciente`(`horas`.`paciente`,8) AS emailpaciente
                    , `ciudades`.`ciudad`
                    , `ciudades`.`direccion`
                    , `ciudades`.`google_map`
                    , `ciudades`.`locomocion`
                    , `ciudades`.`estacionamiento`
                    , `ciudades`.`ctu`
                    , `horas`.`prestador`
                    
                     ,DATE_FORMAT(`horas`.`hora`,'%d/%m/%Y') AS fechacitacion
                    ,DATE_FORMAT(`horas`.`hora`,'%H:%i') AS horacitacion
                    , `f_nomisapre`(`horas`.`isapre`) AS isapre
                    ,`f_perito`(`horas`.`prestador`,2) AS perito
                FROM
                    `horas`
                    INNER JOIN `ciudades` 
                        ON (`horas`.`ciudad` = `ciudades`.`id`)
                WHERE (`horas`.`id` =$idHora);";

        $result = mysql_query($sqlDatos, $conectar);
        $i = 0;
        //$table="<table border='1' cellpadding='10'> n";
        //$tabla .= "<tr><th>N&ordm</th><th>Rut</th><th>Paciente</th><th>ciudad</th><th>Glosa</th></tr> n";

        while ($fila = mysql_fetch_array($result)) {
            $i++;
            $rut = $fila['rut'];
            $hora = $fila['horacitacion'];
            $fecha = $fila['fechacitacion'];
            $horacitacion = $fila['horacitacion'];
            $nombres = $fila['paciente'];
            $profesional = $fila['perito'];
            $ciudad = $fila['ciudad'];
            $correo = $fila['emailpaciente'];
            $isapre = $fila['isapre'];
            $url = $fila['google_map'];
            $locomocion = $fila['locomocion'];
            $estacionamiento = $fila['estacionamiento'];
            $direccionperitaje = $fila['direccion'];


            // style='background-color:'<?php echo $bg;

            $mensaje1 = "
                <head>
                <meta http-equiv='Content-Type' content='text/html; charset=utf-8 ' />
                
                <style type= 'text/css '>
                .tablaref {
                    position: relative;
                    height: 10px;
                    width: 480px;
                    left: 420px;
                    top: -280px;
                    right: auto;
                }
                .negrita{
                    font-weight:bold;
                }
                </style>
                </head>
                <body>
                <div class= 'cabecera' id= 'cabeza '>
                  <table width= '1349 ' border= '0 ' cellpadding= '0' cellspacing= '0' >
                    <tr>
                      <td width= '959 ' valign= 'top '>
                      <img src= 'http://www.cetep.cl/agenda/contenido/templates/defecto/imagenes/logoNuevo/ceteplogotrans.png' alt= 'logo ' width= '92 ' height= '78 ' align= 'left ' hspace= '9 ' />
                      </td>
                      <td width= '17 ' valign= 'top '>
                      <p>
                      <img src= 'http://www.cetep.cl/agenda/contenido/templates/defecto/imagenes/lineafooter.png' alt= 'linea ' width= '5 ' height= '92 ' />
                      </p>
                      </td>
                      <td width= '373 ' valign= 'top '>
                      <p>Dr. Torres Boonen 636, Providencia<br />
                        Santiago ? Chile<br/>
                        (56?2) 26119980<br/>
                        www.cetep.cl</p>
                        </td>
                    </tr>
                  </table>
                </div>
                
                <p align= 'center '><span class='negrita'>Recordatorio Citaci&oacute;n a peritaje Psiqui&aacute;trico:</span></p>
                <p>Estimada Sr (a).  " . utf8_decode($nombres) . "   </p>
                <p>Junto con  saludar, queremos recordar su citaci&oacute;n a peritaje psiqui&aacute;trico encargado por su  isapre <span class='negrita'>" . $isapre . " </span> para el <span class='negrita'> " . $fecha . " </span> a las " . $horacitacion . " en <span class='negrita'>" . $direccion . " </span>con la Dra. <span class='negrita'>" . $profesional . ".</span></p>
                <p><span class='negrita'>Para ver la direcci&oacute;n: en Google Maps haga clic <a href='" . $url . "'>aqui</a></span><br />
                </p>
                <div class= 'mapa ' id= 'mapagoogle '>
                  <table width= '415 ' border= '0 ' align= 'center ' class= 'tablaref '>
                  </table>
                </div>
                <p>
                  <span class='negrita'>Estacionamiento:</span> " . $estacionamiento . "<br />
                  <span class='negrita'>Locomoci&oacute;n</span><br/>
                  " . $locomocion . "
                <span class='negrita'>¿En qué consiste esta citaci&oacute;n?</span>Se  trata de una entrevista de segunda opini&oacute;n con un psiquiatra externo a su  Seguro de Salud, quien lo evaluará por su reposo laboral y emitirá un informe  t&eacute;cnico al respecto. Esta segunda opini&oacute;n puede enriquecer m&aacute;s su diagn&oacute;stico o  tratamiento. (Ley 20.585)</p>
                <ul type= 'disc '>
                  <li>Tenga presente que en esta evaluaci&oacute;n se le realizar&aacute;n varias       preguntas relacionadas con sus datos biogr&aacute;ficos y clínicos. Traer       claramente detallados los nombres de los medicamentos que Ud. tiene       indicados, con los miligramos y horario de ingesta.</li>
                  <li>En esta entrevista de evaluaci&oacute;n, el psiquiatra deberá registrar la       informaci&oacute;n en un computador para hacer el informe por lo que habrá       momentos en que no lo mire a los ojos. Ello, no significa que no le está       prestando atenci&oacute;n.</li>
                  <li>La entrevista dura como m&aacute;ximo 30 minutos, por tanto se solicita       llegar puntualmente a su cita, el m&aacute;ximo tiempo de espera 10 minutos.</li>
                  <li>En caso que llegue atrasado a la cita se le entregará un       certificado indicando la hora de citaci&oacute;n y la hora de llegada, para que       Ud. solicite una nueva hora en la ISAPRE.  </li>
                </ul>
                <p>Cualquier duda llamar a su seguro de salud.<br /></p>
                 <p align= 'center '><span class='negrita'>Cetep</span></p>
                </body>
                </html>";


            require_once '../../../lib/PHPMailer/class.phpmailer.php';

            //require_once '../PHPMailer/class.phpmailer.php';

            $Tos = array("" . $nombres . "" => "" . $correo . "");

            $Ccs = array(
                "Ddi" => "llopez@cetep.cl"
                // "dti" => "dti@cetep.cl"
            );

            try {

                $mail = new PHPMailer(true); //New instance, with exceptions enabled
                $body = $mensaje1;
                //	$body             = preg_replace('/    /','', $body); //Strip backslashes

                ///cuenta envio cetep

                ///capacitaciones@cetep.cl  //  capa1208

                ///ip server  190.96.85.243
                $mail->IsSMTP();                           // tell the class to use SMTP
                $mail->SMTPDebug = 0;
                $mail->SMTPAuth = true;                  // enable SMTP authentication
                //$mail->SMTPSecure = "ssl";
                $mail->Port = 26;                   // set the SMTP server port
                $mail->Host = "190.96.85.243";        // SMTP server
                //$mail->Host       = "173.194.76.109;173.194.68.108;173.194.76.108;173.194.68.109";        // SMTP server
                //	$mail->Username   = "cetepasociadosltda@gmail.com";     // SMTP server username
                $mail->Username = "revisoras@cetep.cl";     // SMTP server username
                $mail->Password = "revi1010";            // SMTP server password
                //	$mail->IsSendmail();  // tell the class to use Sendmail


                //	$mail->AddReplyTo("franciscoalc@gmail.com","Tito Tito");


                $mail->From = "revisoras@cetep.cl";

                $mail->FromName = "Reserva de Hora a Peritaje";
                foreach ($Tos as $key => $val) {
                    $mail->AddAddress($val, $key);
                }

                foreach ($Ccs as $key => $val) {
                    $mail->AddCC($val, $key);
                }

                $mail->Subject = utf8_encode("=?UTF-8?B?" . base64_encode("Reserva segunda Opinión ") . "?=");
                $mail->AltBody = "Si tiene Problemas para visualizar este correo, Por favor habilete la vista en HTML !"; // optional, comment out and test
                $mail->WordWrap = 80; // set word wrap
                $mail->MsgHTML($body);
                $mail->IsHTML(true); // send as HTML
                $mail->Send();

                $resp = 'Mensaje enviado con &eacutexito ...!  ';


            } catch (phpmailerException $e) {
                $resp .= 'Se produjo un error al enviar e-mail con destino a:  ';
                $resp .= '¡¡Error!! : ' . $e->errorMessage();
            }
        }




    echo $resp;
}



?>