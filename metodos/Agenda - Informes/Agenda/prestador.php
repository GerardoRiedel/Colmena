<?php 
	include_once('lib/datos.php');
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
$conn=conectar();
$tabla="SiNo";
$arreglosino = cargar_combomul($tabla," "," ",$conn);
?>
<link href="<?php echo $TEMPLATE_DIR.'/'; ?>estilos.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="<?php echo $HOME; ?>/lib/bootstrap/font-awesome/css/font-awesome.css" />
<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
<script src="<?php echo $LIB; ?>/alertifyjs1.6/alertify.js" ></script>

<!-- include the core styles -->
<link rel="stylesheet" href="<?php echo $LIB; ?>/alertifyjs1.6/css/alertify.css" />
<!-- include a theme, can be included into the core instead of 2 separate files -->
<link rel="stylesheet" href="<?php echo $LIB; ?>/alertifyjs1.6/css/themes/bootstrap.rtl.css" />
<script>
	function popUp(URL) 
	{
		day = new Date();
		id = day.getTime();
		
		eval("page" + id + " = window.open(URL, 'ventana', 'toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=0,width=600,height=650,left=50,top=50');");
		location.reload();
	}
	
	function confirmarHora(idHora)
	{
		if(confirm('Esta seguro de confirmar esta hora?'))
		{
			day = new Date();
			id = day.getTime();
			
			eval("page" + id + " = window.open('<?php echo $MODULOS; ?>/agenda/chk_confirmarHora.php?hora='+idHora, 'ventana', 'toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=0,width=500,height=200,left=50,top=50');");
		}
	}

	function confirmarAsistenciaHora_old(idHora)
	{
		if(confirm('Esta seguro de cambiar el estado de asistencia?'))
		{
			day = new Date();
			id = day.getTime();
			
			eval("page" + id + " = window.open('<?php echo $MODULOS; ?>/agenda/chk_confirmarAsistenciaHora.php?hora='+idHora, 'ventana', 'toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=0,width=500,height=200,left=50,top=50');");
		}
	}

function confirmarAsistenciaHora(idHora,asiste) {


	//	var asiste = $('#asiste').val();

		$.ajax({
			type: "POST",
			url: "<?php echo $MODULOS; ?>/agenda/chk_confirmarAsistenciaHora.php",
			data: {hora: idHora,asiste : asiste} ,

			success: function (data) {


				alertify.confirm("<h3>Confirma la Asistencia ..?<h3>",
					function(){

						if (data == 1) {
							setTimeout(function(){ location.reload(); }, 1000);
							alertify.success("<span>Hora confirmada...!</span>");
							setTimeout(function(){ location.reload(); }, 3000);



							}else if(data== 0){
							alertify.success("<span>La hora ha sido confirmada...!</span>");
							setTimeout(function(){ location.reload(); }, 3000);


						}
						setTimeout(function(){ location.reload(); }, 2000);

					},
					function(){

						alertify.error("<span>La Confirmacion a sido  Cancelada...!</span>");
						setTimeout(function(){ location.reload(); }, 3000);
					}).setHeader('<span class="fa fa-exclamation fa-2x" '
					+    'style="vertical-align:middle;color:#e10000;">'
					+ '</span><em> Confirmación de Hora  </em> ');


			//	setTimeout(function(){ location.reload(); }, 3000);
			}
		});

	}


</script>
<style>
	.select {
		width:80px;
		border:1px solid red;
		-webkit-border-top-right-radius: 15px;
		-webkit-border-bottom-right-radius: 15px;
		-moz-border-radius-topright: 15px;
		-moz-border-radius-bottomright: 15px;
		border-top-right-radius: 15px;
		border-bottom-right-radius: 15px;
		padding:2px;
	}
</style>



<table width="95%" border="0" align="center" cellpadding="0" cellspacing="0" class="borde_tabla">
	<tr>
		<td height="27" align="center" class="tituloTablas">Fecha: <?php echo str_replace('-','/',VueltaFecha($fecha)); ?></td>
	</tr>
</table>
<table width="95%" border="0" align="center" cellpadding="0" cellspacing="0">
	<tr>
		<td width="24%" align="left" valign="middle" class="letra7">
			<span onclick="window.location.href='<?php echo $MODULOS; ?>/agenda/prestadorPrint2.php?fecha=<?php echo $fecha; ?>&ciudad=<?php echo $idCiudad; ?>'" style="cursor:pointer"><img src="<?php echo $IMAGENES2; ?>/excel.png" width="16" height="16" /> Exportar</span></td>
		<td width="76%" height="27"  class="letra7" style="padding-right:10px;"><span class="letra7" style="padding-right:10px;"><img src="<?php echo $IMAGENES; ?>/rojo.png" alt="no confirmado" width="15" height="15" /> No confirmado </span><span class="letra7" style="padding-right:10px;"><img src="<?php echo $IMAGENES; ?>/amarillo.png" alt="confirmado" width="15" height="15" /> Confirmado <span class="letra7" style="padding-right:10px;"><span class="letra7" style="padding-right:10px;"> </span><span class="letra7" style="padding-right:10px;"><img src="<?php echo $IMAGENES; ?>/verde.png" alt="confirmado" width="15" height="15" /> Asiste <span class="letra7" style="padding-right:10px;"><span class="letra7" style="padding-right:10px;"> </span><span class="letra7" style="padding-right:10px;"><img src="<?php echo $IMAGENES; ?>/morado.png" alt="confirmado" width="15" height="15" /> No asisti&oacute;
								
								<span class="letra7" style="padding-right:10px;"><img src="<?php echo $IMAGENES; ?>/Informe.png" alt="PreInforme" width="15" height="15" />
							 Informe</span>
								<span class="letra7" style="padding-right:10px;"><img src="<?php echo $IMAGENES; ?>/Inasistencia.png" alt="PreInforme" width="15" height="15" />
							 Inasistencia</span>

							</span></span></span></span></td>
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
        <?php
        if (tipoUsuario($_SESSION['idUsuario'], $conectar) != 'prestador' )
        {
        echo "<td width='6%' align='center' bgcolor='#DFEFFF' class='tituloTablas'>Conf.</td>";
         } ?>
        <td width="6%" align="center" bgcolor="#DFEFFF" class="tituloTablas">Asist.</td>

        <?php
		 if (tipoUsuario($_SESSION['idUsuario'], $conectar) == 'administrador' || tipoUsuario($_SESSION['idUsuario'], $conectar) == 'isapre')
		 {	?>
			<td width="6%" align="center" bgcolor="#DFEFFF" class="tituloTablas">Publicado.</td>
		<?php } ?>
         <?php
		 if (tipoUsuario($_SESSION['idUsuario'], $conectar) == 'isapre' ||tipoUsuario($_SESSION['idUsuario'], $conectar) == 'administrador'||tipoUsuario($_SESSION['idUsuario'], $conectar) == 'prestador'  )
		 {	?>
			<td width="6%" align="center" bgcolor="#DFEFFF" class="tituloTablas">Resumen/Informe.</td>
		<?php } ?>
        
	</tr>
	<?php 
	//Si seleccion� al prestador
	if($idPrestador != NULL)
	{
		$queryAddPrestador = "h.`prestador`=".$idPrestador." AND ";
		$condicion = $queryAddPrestador ;
	}
	if($idCiudad != NULL)
	{
		$queryAdd = "h.`ciudad`=".$idCiudad." AND ";
		$condicion .= $queryAdd ;
	}

	$sql =("
	SELECT
		h.`id`,
		h.`ciudad`,
		h.`prestador`,
		f_especialidad(h.`prestador`) AS especialidadPrestador,
		h.`hora` as fechaactual,
		DATE_FORMAT(h.`hora`, '%H:%i') AS hora
	FROM
		horas_prestadores h
	WHERE
		".$queryAddPrestador ." ".$queryAdd."
		date(h.`hora`) = '".$fecha."' AND
		h.`hora`=h.`hora`
	ORDER BY
		h.`hora` ASC
	" );
	
	$resul=	 mysql_query($sql ,$conectar);
	$i=1;
	
	//INICIO WHILE PRINCIPAL
	while($row = mysql_fetch_array($resul))
	{	
		$idHoraPrestador = $row['id'];
		$horaActual = $row['hora'];
		$fechaActual = $row['fechaactual'];
		$prestador = $row['prestador'];
		$especialidadPrestador= $row['especialidadPrestador'];
		$ciudadprestador =  $row['ciudad'];	
		$x = 0;
		/*
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
*/

		$sqlHora = mysql_query("
		SELECT 
			h.`id`, 
			h.`ciudad`, 
			h.`paciente`, 
			h.`prestador`, 
			f_especialidad(h.`prestador`) AS especialidadPrestador,
			h.`isapre`, 
			h.`confirmada`, 
			h.`asiste`,
			h.`urlExpedienteColmena`
		FROM 
			horas h
		WHERE
			h.`hora`='".$fechaActual."'AND 
			h.`ciudad`= ".$ciudadprestador." AND
			h.`prestador`=".$prestador."
		", $conectar);

		$rowHora = mysql_fetch_array($sqlHora);
		
		$idHora = $rowHora['id'];
		$idCiudad = $rowHora['ciudad'];
		$idPaciente = $rowHora['paciente'];
		$idIsapre = $rowHora['isapre'];
		$confirmada = $rowHora['confirmada'];
		$asiste = $rowHora['asiste'];
		$urlColmena = $rowHora['urlExpedienteColmena'];
		
		$especialidadPrestador= $rowHora['especialidadPrestador'];
		
		//Si el usuario es un prestador el link es para llenar la ficha adem�s cambio el titulo
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
			//Pongo un color amarillo si la hora esta confirmada, verde si asiste, rojo si no esta confirmada
			$color = '#FFFFFF';
			
			//Hora confirmada
			if(horaConfirmada($idHora, $conectar) == true || horaConfirmada($idHora, $conectar) == false)
			{
				
				if(asisteHora($idHora, $conectar) == true)
				{
					$color = '#8DFF8A';
				}
				else
				{
					//Si no asisti� ya que la fecha pas�, le pongo 
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
			else if(horaConfirmada($idHora, $conectar) == false  )
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
			if(tipoUsuario($_SESSION['idUsuario'], $conectar) == 'isapre' || tipoUsuario($_SESSION['idUsuario'], $conectar) == 'Compin' )
			{
				$isapreUsuario = isapreUsuario($_SESSION['idUsuario'], $conectar);
				
				//Muestro los datos s�lo de la isapre correspondiente
				if($isapreUsuario == $idIsapre)
				{
					$nombrePacienteApellido = utf8_encode(nombreCompletoPacienteApellido($idPaciente, $conectar));
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
				<td height="33" align="center" class="letraTablaHoras"><?php echo $horaActual ;?>&nbsp;</td>
				<td  class="letraTablaHoras" style="padding-left:5px;"
				<?php 
				if($especialidadPrestador == 1){	$url= $MODULOS."/agenda/agregarHora.php?hora=".$idHora."&idPrestador=".$prestador;}
				if($especialidadPrestador == 2){	$url= $MODULOS."/agenda/agregarHoraTrauma.php?hora=".$idHora."&idPrestador=".$prestador;}
					//var_dump($url);
						if(tipoUsuario($_SESSION['idUsuario'], $conectar) != 'prestador')
						{
						//Muestro los datos s�lo de la isapre correspondiente
						if(tipoUsuario($_SESSION['idUsuario'], $conectar) == 'isapre')
							{
								$isapreUsuario = isapreUsuario($_SESSION['idUsuario'], $conectar);
					
					//Muestro los datos solo de la isapre correspondiente
					if($isapreUsuario == $idIsapre)
					{
					
						?>onclick="popUp('<?php echo $url; ?>');"
						<?php	}	}else	{?>onclick="popUp('<?php echo $url; ?>');"
					<?php
				}
			}
			else if(tipoUsuario($_SESSION['idUsuario'], $conectar) == 'prestador')
			{ ?>
            onclick="popUp2('<?php echo $MODULOS; ?>/agenda/seleccionarDocumento.php?hora=<?php echo $idHora; ?>');"			           <?php	}?>
            
            >
			<?php 
				if(tipoUsuario($_SESSION['idUsuario'], $conectar) != 'isapre')
				{
					
				}
				echo $nombrePacienteApellido ;		 
				
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
				<td  class="letraTablaHoras" style="padding-right:5px;"><?php echo PonerPunto($rutPaciente).'-'.DigitoVerificador($rutPaciente);?></td>
				<td  class="letraTablaHoras" style="padding-left:5px;"><?php echo $nombreCompletoPrestadorApellidoPaterno; ?>&nbsp;</td>
				<td  class="letraTablaHoras" style="padding-left:5px;"><?php echo $nombreIsapre; ?>&nbsp;

<!--SI ES COLMENA TRAE EL EXPEDIENTE-->
					<?php 
						IF($nombreIsapre === 'Colmena')
							{
								//echo $urlColmena;
								IF($urlColmena !== '0'){echo '<a href="'.$urlColmena.'" target="_blank">Expediente</a> ';}
								//ELSE echo 'Sin Expediente';
								
							}

					?>
				</td>
                <?php if(tipoUsuario($_SESSION['idUsuario'], $conectar) != 'prestador') {?>
                <td align="center" class="letraTablaHoras">
				<?php if(horaConfirmada($idHora, $conectar) == false ) 	{
				//Si el usuario es isapre no le pongo el bot�n
				if(tipoUsuario($_SESSION['idUsuario'], $conectar) != 'isapre') 	{?>
					<label>
					<input name="Button" type="image" src="<?php echo $IMAGENES; ?>/no.png" onclick="confirmarHora(<?php echo $idHora; ?>);" value="no" title="header=[Confirmar Hora] body=[Presione para confirmar la hora]"/>
					</label>
					<?php }
                            else
                            {
                                echo 'no';
                            }
                        }
                        else
                        {
                            echo 'si';
                        }
                            ?>
                    </td>
            <?php }?>
			<td align="center" class="letra7">

				<?php
				//ASISTENCIA
				//Si la hora est� confirmada
				if(horaConfirmada($idHora, $conectar) == true ||horaConfirmada($idHora, $conectar) == false ){
					//Si asiste
					if(asisteHora($idHora, $conectar) == true)
					{
						//Si el usuario no es prestador le pongo el bot�n
						if(tipoUsuario($_SESSION['idUsuario'], $conectar) == 'prestador' && diferenciaHoraActualHora($idHora, $conectar) <= 24)
						{
							?>

							<select  name="asiste" id="asiste" class="select" onchange="confirmarAsistenciaHora(<?php echo $idHora; ?>,this.value);">
								<option value="" >Asistencia</option>
								<?php

								foreach($arreglosino as $f)

									if($asiste == $f['descripcion'])
									{
										?>
										<option  selected="selected" value="<?php echo $asiste; ?>" ><?php echo utf8_encode($f['descripcion']); ?> </option>
										<?php
									}
									else
									{
										?>
										<option value="<?php echo $f['descripcion']; ?>"><?php echo utf8_encode($f['descripcion']); ?></option>
										<?php
									}

								?>
							</select>



							<?php
							}elseif (tipoUsuario($_SESSION['idUsuario'], $conectar) != 'administrador'){
										echo $asiste ;
								}elseif (tipoUsuario($_SESSION['idUsuario'], $conectar) != 'isapre') {
										echo $asiste ;
						}else
						{
							echo  $asiste;
						}
					}
					else//No asiste
					{
						//Si el usuario no es prestador le pongo el bot�n
						if(tipoUsuario($_SESSION['idUsuario'], $conectar) == 'prestador' && diferenciaHoraActualHora($idHora, $conectar) <= 24 )
						{
							?>
							<select  name="asiste" id="asiste" class="select" onchange="confirmarAsistenciaHora(<?php echo $idHora; ?>,this.value);">
								<option value="" >Asistencia</option>
								<?php

								foreach($arreglosino as $f)

									if($asiste == $f['descripcion'])
									{
										?>
										<option  selected="selected" value="<?php echo $f['descripcion']; ?>" ><?php echo utf8_encode($f['descripcion']); ?> </option>
										<?php
									}
									else
									{
										?>
										<option value="<?php echo $f['descripcion']; ?>"><?php echo utf8_encode($f['descripcion']); ?></option>
										<?php
									}

								?>
							</select>
							<?php
						}elseif (tipoUsuario($_SESSION['idUsuario'], $conectar) == 'administrador'){
							echo $asiste ;
						}elseif (tipoUsuario($_SESSION['idUsuario'], $conectar) == 'isapre'){
							echo $asiste ;
						}
						else
						{
							echo $asiste ;
						}
					}
				}
				else//Si NO est� confirmada
				{
					echo $asiste;
				}

				//FIN ASISTENCIA

				?>

			</td>
		<?php if (tipoUsuario($_SESSION['idUsuario'], $conectar) == 'administrador' ||tipoUsuario($_SESSION['idUsuario'], $conectar) == 'isapre') 
        { 
            $datosInforme = datosInformeHora($idHora, $conectar);
			$datoshora = datosHora($idHora, $conectar);
        ?>
        <td align="center" class="letra7">

							<?php
							$datosInforme = datosInformeHora($idHora, $conectar);
							$datoshora = datosHora($idHora, $conectar);	
							if ((datosInformeHora($idHora, $conectar))== false){
								echo "";
							}
                            // y luego la especialidad de ese prestador		
                            $sql_especialidad = mysql_query("SELECT 
                              `f_especialidad`(prestador) AS   especialidad
                            FROM
                                prestadores, horas
                            WHERE horas.id='$idHora' ", $conectar);  
                            $res_especialidad = mysql_fetch_array($sql_especialidad);
                            $especialidad = $res_especialidad['especialidad'];
							//var_dump($datosinforme);
							//var_dump($datosinforme);
                            if ($especialidad == 1)
                            {
                                if (($datosInforme['fechaPublicacion'] == '0000-00-00') &&  ($datosInforme['publicado'] == 'NO' ))
                                {
									
                                    echo 'no';
                                }elseif(($datosInforme['fechaPublicacion'] != '0000-00-00') &&  ($datosInforme['publicado'] == 'SI'))
                                {
                                    echo 'si'; 
                                }

                             }elseif ($especialidad == 2)
                            {
                                $sqlPublica =  mysql_query("SELECT 
                                              `publicado`,
                                              `fechaPublicacion`
                                            FROM
                                              informe_traumatologico
                                              WHERE hora = '$idHora' 
                                            ", $conectar);
                                $res_publicado = mysql_fetch_array($sqlPublica);
                                $publicado = $res_publicado['publicado'];
                    
                                if ($publicado == 'NO' || is_null($publicado) )
                                {
                                    echo 'no';
                                }elseif($publicado == 'SI')
                                {
                                    echo 'si'; 
                                }
                            }
                            ?>
                </td>
			<?php } ?>
			<?php  //if (tipoUsuario($_SESSION['idUsuario'], $conectar) != 'prestador'){?>
            <td align="center">

				<?php 
				$datosInforme = datosInformeHora($idHora, $conectar);
				$datoshora = datosHora($idHora, $conectar);
				//echo 'isa'.isapreUsuario($_SESSION['idUsuario'], $conectar);
				if((tipoUsuario($_SESSION['idUsuario'], $conectar) == 'isapre' || tipoUsuario($_SESSION['idUsuario'], $conectar) == 'administrador') && $datoshora['asiste']== 'si'  )
				{
							
					if (
						($datosInforme['fechaPublicacion'] == '0000-00-00') &&  ($datosInforme['publicado'] == 'NO' ) && (isapreUsuario($_SESSION['idUsuario'], $conectar) != '4' || isapreUsuario($_SESSION['idUsuario'], $conectar) != '5' ))
					{?>

						<a href="" title="Estado Informe " rel="gb_page[700, 600]"><img src="<?php echo $IMAGENES; ?>/Informe.png" width="16" height="16" border="0" title="header=[Informe Sin Publicr] body=[]"/></a>

					<?php }elseif (
					($datosInforme['fechaPublicacion'] != '0000-00-00') &&  ($datosInforme['publicado'] == 'SI' ) && (isapreUsuario($_SESSION['idUsuario'], $conectar) != '4' || isapreUsuario($_SESSION['idUsuario'], $conectar) != '5' )&& $especialidad == 1)
					{?>

						<a href="<?php echo $MODULOS; ?>/agenda/chk_informeEntrevistaSegundaDescargaNuevo.php?id=<?php echo $idHora; ?>" title="VER Informe " rel="gb_page[700, 600]"><img src="<?php echo $IMAGENES; ?>/Informe.png" width="16" height="16" border="0" title="header=[Informe Publicado] body=[]"/></a>
				<?php }elseif (
					($datosInforme['fechaPublicacion'] != '0000-00-00') &&  ($publicado == 'SI' ) && (isapreUsuario($_SESSION['idUsuario'], $conectar) != '4' || isapreUsuario($_SESSION['idUsuario'], $conectar) != '5' ) && $especialidad == 2 ){?>

						<a href="<?php echo $MODULOS; ?>/agenda/chk_informeEntrevistaTraumatologicoDescarga.php?id=<?php echo $idHora; ?>" title="VER Informe " rel="gb_page[700, 600]"><img src="<?php echo $IMAGENES; ?>/Informe.png" width="16" height="16" border="0" title="header=[Informe Publicado] body=[]"/></a>

					<?php } else {	?>

				<?php	}	?>
								
				<?php	}elseif (diferenciaHoraActualHora($idHora, $conectar) >= 72 && $datoshora['asiste']== 'no' ) {	?>
					<a href="<?php echo $MODULOS; ?>/agenda/chk_certificadoInasistencia.php?id=<?php echo $idHora; ?>" title="VER Certificado " rel="gb_page[700, 600]"><img src="<?php echo $IMAGENES; ?>/Inasistencia.png" width="16" height="16" border="0" title="header=[Certificado Publicado] body=[]"/></a>

				<?php	} else {	?>

				<?php	}	?>

            </td>

  </tr>
			<?php 
		}
		//LA HORA NO TIENE PACIENTE
		//
		else
		{
			$ciudadNoPaciente = $row['ciudad'];
			$nombreCompletoPrestadorApellidoPaterno = nombreCompletoPrestadorApellidoPaterno ($prestador, $conectar);
			$especialidadNueva= $row['especialidadPrestador'];
			if(tipoUsuario($_SESSION['idUsuario'], $conectar) == 'isapre')
			{
				$isapreUsuario = isapreUsuario($_SESSION['idUsuario'], $conectar);
				$mostrar = 'no';
			}
			else
			{
				//Muestro la hora s�lo si no es usuario Isapre
				$mostrar = 'si';	
			}
			
			//Muestro las isapres vinculadas a la hora
			//Las asigno al t�tulo
			//Si es usuario isapre muestro la hora s�lo si esta hora se le vincula
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
				$isapre = $rowIsapres['isapre'];
				if($isapre == $isapreUsuario)
				{
					$mostrar = 'si';
				}
				$tituloIsapre .= "- ".nombreIsapre($isapre, $conectar)."<br />";
			}
			
			//Si no tiene isapres vinculadas le doy Todas al t�tulo
			if(mysql_num_rows($sqlIsapres) == 0)
			{
				$tituloIsapre .= "Todas";
				$mostrar = 'si';
			}
			else //Si tiene isapres vinculadas, verifico si est� vinculada a la del usuario
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
					}else{
						$mostrar = 'no';
					}
				}
			}

			$tituloIsapre .= "]";

			//Muestro la hora s�lo si est� vinculada al usuario
			if($mostrar == 'si')
			{
				?>
				<tr <?php 
					if(tipoUsuario($_SESSION['idUsuario'], $conectar) != 'prestador')
					{
					if($especialidadNueva==1){ $url2=$MODULOS."/agenda/agregarHora.php?fecha=".$fechaActual."&idPrestador=".$prestador."&idCiudad=".$ciudadNoPaciente;
					//$url2=str_replace(" ","%20",$cadena);
					
					}
					if($especialidadNueva==2){ $url2=$MODULOS."/agenda/agregarHoraTrauma.php?fecha=".$fechaActual."&idPrestador=".$prestador."&idCiudad=".$ciudadNoPaciente;}
					//var_dump($url2);						
						?>
						onclick="popUp('<?php echo $url2; ?>');"
						<?php 
					}	
				 ?> style="cursor:pointer;" <?php echo $tituloNo; ?>>
					<td align="center" class="letraTablaHoras"><?php echo $i; ?>&nbsp;</td>
					<td height="34" align="center" class="letraTablaHoras"><?php echo $horaActual; ?></td>
					<td  class="letraTablaHoras" style="padding-left:5px;">&nbsp;</td>
					<td  class="letraTablaHoras" style="padding-left:5px;">&nbsp;</td>
					<td class="letraTablaHoras" style="padding-left:5px;"><?php echo $nombreCompletoPrestadorApellidoPaterno; ?>&nbsp;</td>
					<td align="center" class="letraTablaHoras"><img src="<?php echo $IMAGENES; ?>/lupa.png" width="16" height="16" title="<?php echo $tituloIsapre; ?>"/></td>
					<td align="center" class="letraTablaHoras">&nbsp;</td>
					<td align="center" class="letraTablaHoras">&nbsp;</td>
                    <?php if(tipoUsuario($_SESSION['idUsuario'], $conectar) != 'administrador')
					{ ?>
						<!--td align="center" class="letraTablaHoras">xxx</td>
						<td align="center" class="letraTablaHoras">&nbsp;</td>
						<td align="center" class="letraTablaHoras">&nbsp;</td-->

					<?php } else {?>
						
						<td align="center" class="letraTablaHoras">&nbsp;</td>
						<td align="center" class="letraTablaHoras">&nbsp;</td>
					<?php }?>
					</tr>
				<?php 
			}//Si el usuario est� vinculado a la isapre
			
		}
	
		$i++;
	}//FIN WHILE PRINCIPAL
	?>

</table>
<br />
