<?php 
	include_once('lib/pacientes/funciones.php');
	include_once('lib/querys/ciudades.php');
	include_once('lib/horas/funciones.php');
	include_once('lib/isapres/funciones.php');
	
	$idPrestador = $_GET['id'];
	$idCiudad = $_GET['ciudad'];
	
	$fecha = date('Y-m-d');
	
	if($_GET['fecha'])
	{
		$fecha = $_GET['fecha'];
	}
?>

<script>
	function popUp(URL) 
	{
		day = new Date();
		id = day.getTime();
		
		eval("page" + id + " = window.open(URL, 'ventana', 'toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=0,width=600,height=650,left=50,top=50');");
	}
	
	function confirmarHora(idHora)
	{
		if(confirm('¿Está seguro de confirmar esta hora?'))
		{
			day = new Date();
			id = day.getTime();
			
			eval("page" + id + " = window.open('<?php echo $MODULOS; ?>/agenda/chk_confirmarHora.php?hora='+idHora, 'ventana', 'toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=0,width=500,height=200,left=50,top=50');");
		}
	}

	function confirmarAsistenciaHora(idHora)
	{
		if(confirm('¿Está seguro de cambiar el estado de asistencia?'))
		{
			day = new Date();
			id = day.getTime();
			
			eval("page" + id + " = window.open('<?php echo $MODULOS; ?>/agenda/chk_confirmarAsistenciaHora.php?hora='+idHora, 'ventana', 'toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=0,width=500,height=200,left=50,top=50');");
		}
	}

</script>

<link href="../../templates/defecto/estilos.css" rel="stylesheet" type="text/css">
<table width="95%" border="0" align="center" cellpadding="0" cellspacing="0" class="borde_tabla">
	<tr>
		<td height="27" align="center" class="tituloTablas">Fecha: <?php echo str_replace('-','/',VueltaFecha($fecha)); ?></td>
	</tr>
</table>
<table width="95%" border="0" align="center" cellpadding="0" cellspacing="0">
	<tr>
		<td width="24%" align="left" valign="middle" class="letra7"><span onclick="window.location.href='<?php echo $MODULOS; ?>/agenda/prestadorPrint.php?fecha=<?php echo $fecha; ?>&ciudad=<?php echo $idCiudad; ?>'" style="cursor:pointer"><img src="<?php echo $IMAGENES2; ?>/excel.png" width="16" height="16" /> Exportar</span></td>
		<td width="76%" height="27" align="right" class="letra7" style="padding-right:10px;"><span class="letra7" style="padding-right:10px;"><img src="<?php echo $IMAGENES; ?>/rojo.png" alt="no confirmado" width="15" height="15" /> No confirmado </span><span class="letra7" style="padding-right:10px;"><img src="<?php echo $IMAGENES; ?>/amarillo.png" alt="confirmado" width="15" height="15" /> Confirmado <span class="letra7" style="padding-right:10px;"><span class="letra7" style="padding-right:10px;"> </span><span class="letra7" style="padding-right:10px;"><img src="<?php echo $IMAGENES; ?>/verde.png" alt="confirmado" width="15" height="15" /> Asiste <span class="letra7" style="padding-right:10px;"><span class="letra7" style="padding-right:10px;"> </span><span class="letra7" style="padding-right:10px;"><img src="<?php echo $IMAGENES; ?>/morado.png" alt="confirmado" width="15" height="15" /> No asisti&oacute;</span></span></span></span></span></td>
	</tr>
</table>
<table width="95%" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF" class="borde_tabla" id="cambio_color" style="border-collapse:collapse;">
	<tr>
		<td width="3%" align="center" style="border:none">&nbsp;</td>
		<td width="6%" align="center" bgcolor="#DFEFFF" class="tituloTablas">Hora</td>
		<td width="35%" align="center" bgcolor="#DFEFFF" class="tituloTablas">Paciente</td>
		<td width="10%" align="center" bgcolor="#DFEFFF" class="tituloTablas">RUT</td>
		<td width="21%" align="center" bgcolor="#DFEFFF" class="tituloTablas">Prestador</td>
		<td width="13%" align="center" bgcolor="#DFEFFF" class="tituloTablas">Isapre</td>
		<td width="6%" align="center" bgcolor="#DFEFFF" class="tituloTablas">Conf.</td>
		<td width="6%" align="center" bgcolor="#DFEFFF" class="tituloTablas">Asist.</td>
        
        <?php 
		 if (tipoUsuario($_SESSION['idUsuario'], $conectar) == 'administrador')
		 {	?>
			<td width="6%" align="center" bgcolor="#DFEFFF" class="tituloTablas">Publicado.</td>        		
		<?php } ?>
	</tr>
	<?php 
	//Si seleccionó al prestador
	if($idPrestador != NULL)
	{
		$queryAddPrestador = "h.`prestador`=".$idPrestador." AND ";
	}
	if($idCiudad != NULL)
	{
		$queryAdd = "h.`ciudad`=".$idCiudad." AND ";
	}

	$sql = mysql_query("
	SELECT
		h.`id`,
		h.`ciudad`,
		h.`prestador`,
		h.`hora`,
		DATE_FORMAT(h.`hora`, '%H:%i') AS HORA
	FROM
		horas_prestadores h
	WHERE
		".$queryAddPrestador ." ".$queryAdd."
		h.`hora` BETWEEN '".$fecha." ".$horaInicio."' AND '".$fecha." ".$horaTermino."' AND 
		h.`hora`=h.`hora`
	ORDER BY
		h.`hora` ASC
	", $conectar);

	$i=1;
	
	//INICIO WHILE PRINCIPAL
	while($row = mysql_fetch_array($sql))
	{	
		$idHoraPrestador = $row[id];
		$horaActual = $row[HORA];
		$fechaActual = $row[hora];
		$prestador = $row[prestador];

		$x = 0;
		
		$queryAdd = NULL;
		if($idPrestador != NULL)
		{
			$x++;
			$queryAdd = " AND h.`prestador`=".$idPrestador;
		}
		if($idCiudad != NULL)
		{
			$queryAdd = $queryAdd." AND h.`ciudad`=".$idCiudad;
			$x++;
		}

		$sqlHora = mysql_query("
		SELECT 
			h.`id`, 
			h.`ciudad`, 
			h.`paciente`, 
			h.`prestador`, 
			h.`isapre`, 
			h.`confirmada`, 
			h.`asiste` 
		FROM 
			horas h
		WHERE
			h.`hora`='".$fechaActual."'AND 
			h.`prestador`=".$prestador."
			".$queryAdd."
		", $conectar);

		$rowHora = mysql_fetch_array($sqlHora);
		
		$idHora = $rowHora[id];
		$idCiudad = $rowHora[ciudad];
		$idPaciente = $rowHora[paciente];
		$idIsapre = $rowHora[isapre];
		$confirmada = $rowHora[confirmada];
		$asiste = $rowHora[asiste];

		//Si el usuario es un prestador el link es para llenar la ficha además cambio el titulo
		if(tipoUsuario($_SESSION['idUsuario'], $conectar) != 'prestador')
		{
			$link = "";
			$tituloSi = "title=\"header=[Doble click para ver detalles] body=[]\"";
			$tituloNo = "title=\"header=[Doble click para tomar esta hora] body=[]\"";
		}
		else
		{
			$link = NULL;
			$tituloSi = "title=\"header=[Doble click para ingresar el informe] body=[]\"";
			$tituloNo = NULL;
		}
		
		//LA HORA SI TIENE PACIENTE
		//
		if($idPaciente != NULL)
		{			
			//Pongo un color amarillo si la hora está confirmada, verde si asiste, rojo si no está confirmada
			$color = '#FFFFFF';
			
			//Hora confirmada
			if(horaConfirmada($idHora, $conectar) == true)
			{
				
				if(asisteHora($idHora, $conectar) == true)
				{
					$color = '#8DFF8A';
				}
				else
				{
					//Si no asistió ya que la fecha pasó, le pongo 
					if(diferenciaFechaHora($idHora, $conectar) == true)
					{
						$color = '#DCC2E2';
					}
					else
					{
						$color = '#FFFF99';
					}	
				}	
			}
			//Hora no confirmada
			else if(horaConfirmada($idHora, $conectar) == false)
			{
				if(diferenciaFechaHora($idHora, $conectar) == true)
				{
					$color = '#DCC2E2';
				}
				else
				{
					$color = '#FF6F72';
				}	
			}
			
			//Si el usuario es una isapre
			if(tipoUsuario($_SESSION['idUsuario'], $conectar) == 'isapre')
			{
				$isapreUsuario = isapreUsuario($_SESSION['idUsuario'], $conectar);
				
				//Muestro los datos sólo de la isapre correspondiente
				if($isapreUsuario == $idIsapre)
				{
					$nombrePacienteApellido = nombreCompletoPacienteApellido($idPaciente, $conectar);
					$nombreCompletoPrestadorApellidoPaterno = nombreCompletoPrestadorApellidoPaterno ($prestador, $conectar);
					$telefonosPaciente = telefonosPaciente($idPaciente, $conectar);
					$nombreIsapre = nombreIsapre($idIsapre, $conectar);
				}
				else
				{
					continue;
				}	
			}
			else
			{
				$nombrePacienteApellido = utf8_encode(nombreCompletoPacienteApellido($idPaciente, $conectar));
				$nombreCompletoPrestadorApellidoPaterno = utf8_encode(nombreCompletoPrestadorApellidoPaterno ($prestador, $conectar));
				$telefonosPaciente = telefonosPaciente($idPaciente, $conectar);
				$nombreIsapre = nombreIsapre($idIsapre, $conectar);
			}
			?>
			<tr style="cursor:pointer; background-color:<?php echo $color; ?>" <?php echo $tituloSi; ?>>
				<td align="center" class="letraTablaHoras"><?php echo $i; ?></td>
				<td height="33" align="center" class="letraTablaHoras"><?php echo $horaActual; ?>&nbsp;</td>
				<td align="left" class="letraTablaHoras" style="padding-left:5px;" <?php 
			if(tipoUsuario($_SESSION['idUsuario'], $conectar) != 'prestador')
			{
				//Muestro los datos sólo de la isapre correspondiente
				if(tipoUsuario($_SESSION['idUsuario'], $conectar) == 'isapre')
				{
					$isapreUsuario = isapreUsuario($_SESSION['idUsuario'], $conectar);
					
					//Muestro los datos sólo de la isapre correspondiente
					if($isapreUsuario == $idIsapre)
					{
						?>onclick="popUp('<?php echo $MODULOS; ?>/agenda/agregarHora.php?hora=<?php echo $idHora; ?>&idPrestador=<?php echo $prestador; ?>');"<?php
					}	
				}
				else
				{
					?>onclick="popUp('<?php echo $MODULOS; ?>/agenda/agregarHora.php?hora=<?php echo $idHora; ?>&idPrestador=<?php echo $prestador; ?>');"<?php
				}
			}
			else if(tipoUsuario($_SESSION['idUsuario'], $conectar) == 'prestador')
			{
				?>onclick="popUp2('<?php echo $MODULOS; ?>/agenda/seleccionarDocumento.php?hora=<?php echo $idHora; ?>');"<?php
			}
			?>><?php 
				if(tipoUsuario($_SESSION['idUsuario'], $conectar) != 'isapre')
				{
					
				}
				echo $nombrePacienteApellido; 
				
				//SI EL PACIENTE TIENE PERITAJES ANTERIORES
				//
				$rutPaciente = rutPaciente($idPaciente, $conectar);
				
				if(tipoUsuario($_SESSION['idUsuario'], $conectar) == 'prestador' or tipoUsuario($_SESSION['idUsuario'], $conectar) == 'administrador')
				{
					if(siPacienteTienePeritaje($idPaciente, $conectar) != false)
					{
						?> <a href="<?php echo $MODULOS; ?>/agenda/buscadorPeritajes2.php?rut=<?php echo $rutPaciente; ?>" title="Buscar Peritajes" rel="gb_page[700, 600]"><img src="<?php echo $IMAGENES; ?>/pdf.png" width="16" height="16" border="0" title="header=[El paciente tiene peritajes anteriores] body=[]"/></a><?php
					}
				}
				//
				//SI EL PACIENTE TIENE PERITAJES ANTERIORES
				?>
	        </td>
				<td align="right" class="letraTablaHoras" style="padding-right:5px;"><?php echo PonerPunto($rutPaciente).'-'.DigitoVerificador($rutPaciente);?></td>
				<td align="left" class="letraTablaHoras" style="padding-left:5px;"><?php echo $nombreCompletoPrestadorApellidoPaterno; ?>&nbsp;</td>
				<td align="left" class="letraTablaHoras" style="padding-left:5px;"><?php echo $nombreIsapre; ?>&nbsp;</td>
				<td align="center" class="letraTablaHoras"><?php 
				
			if(horaConfirmada($idHora, $conectar) == false)
			{
				//Si el usuario es isapre no le pongo el botón
				if(tipoUsuario($_SESSION['idUsuario'], $conectar) != 'isapre')
				{
					?>
					<label>
					<input name="Button" type="image" src="<?php echo $IMAGENES; ?>/no.png" onclick="confirmarHora(<?php echo $idHora; ?>);" value="no" title="header=[Confirmar Hora] body=[Presione para confirmar la hora]"/>
					</label>
					<?php
				}	
				else
				{
					echo 'no';
				}	
			}
			else
			{
				echo 'si';
			}
				?></td>
				<td align="center" class="letra7"><?php 
			//ASISTENCIA
			//Si la hora está confirmada
			if(horaConfirmada($idHora, $conectar) == true)
			{
				//Si asiste
				if(asisteHora($idHora, $conectar) == true)
				{
					//Si el usuario no es prestador le pongo el botón
					if(tipoUsuario($_SESSION['idUsuario'], $conectar) != 'isapre')
					{
						?>
						<label>
						<input name="Button" type="image" src="<?php echo $IMAGENES; ?>/si.png" onclick="confirmarAsistenciaHora(<?php echo $idHora; ?>);" value="si"/>
					</label>
						<?php
					}	
					else
					{
						echo 'si';
					}
				}	
				else//No asiste
				{
					//Si el usuario no es prestador le pongo el botón
					if(tipoUsuario($_SESSION['idUsuario'], $conectar) != 'isapre')
					{
						?>
						<label>
						<input name="Button" type="image" src="<?php echo $IMAGENES; ?>/no.png" onclick="confirmarAsistenciaHora(<?php echo $idHora; ?>);" value="no"/>
					</label>
						<?php
					}	
					else
					{
						echo 'no';
					}
				}
			}
			else//Si NO está confirmada
			{
				echo 'no';
			}
				
			//FIN ASISTENCIA
				?></td>
        			<?php if (tipoUsuario($_SESSION['idUsuario'], $conectar) == 'administrador') 
					{ 
						$datosInforme = datosInformeHora($idHora, $conectar);					
					?><td align="center" class="letra7">
						<?php if (($datosInforme[fechaPublicacion] == '0000-00-00') &&  ($datosInforme[publicado] == 'NO'))
						{
							echo 'no';
						}elseif(($datosInforme[fechaPublicacion] != '0000-00-00') &&  ($datosInforme[publicado] == 'SI'))
						{
							echo 'si'; 
						}
						?></td>
			<?php } ?>	
			</tr>
			<?php 
		}
		//LA HORA NO TIENE PACIENTE
		//
		else
		{
			$ciudadNoPaciente = $row[ciudad];
			$nombreCompletoPrestadorApellidoPaterno = nombreCompletoPrestadorApellidoPaterno ($prestador, $conectar);
			if(tipoUsuario($_SESSION['idUsuario'], $conectar) == 'isapre')
			{
				$isapreUsuario = isapreUsuario($_SESSION['idUsuario'], $conectar);
				$mostrar = 'no';
			}
			else
			{
				//Muestro la hora sólo si no es usuario Isapre
				$mostrar = 'si';	
			}
			
			//Muestro las isapres vinculadas a la hora
			//Las asigno al título
			//Si es usuario isapre muestro la hora sólo si esta hora se le vincula
			$sqlIsapres = mysql_query("
			SELECT 
				i.`isapre` 
			FROM 
				isapres_hora i
			WHERE 
				i.`hora`=".$idHoraPrestador."
			", $conectar);
			
			$tituloIsapre = "header=[Isapres vinculadas] body=[";
			
			while($rowIsapres = mysql_fetch_array($sqlIsapres))
			{
				$isapre = $rowIsapres[isapre];
				if($isapre == $isapreUsuario)
				{
					$mostrar = 'si';
				}
				$tituloIsapre .= "- ".nombreIsapre($isapre, $conectar)."<br />";
			}
			
			//Si no tiene isapres vinculadas le doy Todas al título
			if(mysql_num_rows($sqlIsapres) == 0)
			{
				$tituloIsapre .= "Todas";
				$mostrar = 'si';
			}
			else //Si tiene isapres vinculadas, verifico si está vinculada a la del usuario
			{
				if(tipoUsuario($_SESSION['idUsuario'], $conectar) == 'isapre')
				{
					$sqlIsapres2 = mysql_query("
					SELECT 
						i.`isapre` 
					FROM 
						isapres_hora i
					WHERE 
						i.`hora`=".$idHoraPrestador." AND
						i.`isapre`=".$isapreUsuario."
					", $conectar);
					
					if(mysql_num_rows($sqlIsapres2) != 0)
					{
						$mostrar = 'si';
					}
				}
			}

			$tituloIsapre .= "]";

			//Muestro la hora sólo si está vinculada al usuario
			if($mostrar == 'si')
			{
				?>
				<tr <?php 
					if(tipoUsuario($_SESSION['idUsuario'], $conectar) != 'prestador')
					{
						?>
						onclick="popUp('<?php echo $MODULOS; ?>/agenda/agregarHora.php?fecha=<?php echo $fecha.' '.$horaActual; ?>&idPrestador=<?php echo $prestador; ?>&idCiudad=<?php echo $ciudadNoPaciente; ?>');"
						<?php 
					}	
				 ?> style="cursor:pointer;" <?php echo $tituloNo; ?>>
					<td align="center" class="letraTablaHoras"><?php echo $i; ?>&nbsp;</td>
					<td height="34" align="center" class="letraTablaHoras"><?php echo $horaActual; ?></td>
					<td align="left" class="letraTablaHoras" style="padding-left:5px;">&nbsp;</td>
					<td align="left" class="letraTablaHoras" style="padding-left:5px;">&nbsp;</td>
					<td align="left" class="letraTablaHoras" style="padding-left:5px;"><?php echo $nombreCompletoPrestadorApellidoPaterno; ?>&nbsp;</td>
					<td align="center" class="letraTablaHoras"><img src="<?php echo $IMAGENES; ?>/lupa.png" width="16" height="16" title="<?php echo $tituloIsapre; ?>"/></td>
					<td align="center" class="letraTablaHoras">&nbsp;</td>
					<td align="center" class="letraTablaHoras">&nbsp;</td>
                    <?php if(tipoUsuario($_SESSION['idUsuario'], $conectar) != 'administrador')
					{ ?>
						<td align="center" class="letraTablaHoras">&nbsp;</td>						
					<?php } ?>
				</tr>
				<?php 
			}//Si el usuario está vinculado a la isapre
		}
	
		$i++;
	}//FIN WHILE PRINCIPAL
	?>
</table>
<br />
