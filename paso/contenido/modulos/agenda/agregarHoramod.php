<?php 
	session_name("agenda2");
	session_start();

	include('../../../lib/pacientes/funciones.php');
	include('../../../lib/isapres/funciones.php');
	include('../../../lib/usuarios/funciones.php');
	include('../../../lib/horas/funciones.php');
	include('../../../lib/prestadores/funciones.php');
	include('../../../lib/informe_entrevista/funciones.php');
	include('../../../lib/querys/comunas.php');
	include('../../../lib/querys/ciudades.php');
	include('../../../lib/datos.php');
	include('../../../lib/funciones.php');
	include('../../../lib/conectar.php');
	
	$conectar = conectar();
	
	//Verifico si el usuario es prestador y lo saco
	if(tipoUsuario($_SESSION['idUsuario'], $conectar) == 'prestador')
	{
		$_SESSION['msj'] = 'No tiene acceso';
		
		header('Location: '.$TEMPLATE_DIR2.'/mensajes.php');
		die();
	}
	
	$idHora = $_GET['hora'];
	$idPrestador = $_GET['idPrestador'];
	
	if($idHora != NULL)//La hora ya tiene un paciente
	{
		$fecha = fechaHora($idHora, $conectar);
		$idPaciente = idPacienteHora($idHora, $conectar);
		
		$rutPaciente = rutPaciente($idPaciente, $conectar);
		$dv = DigitoVerificador($rutPaciente);
		$rutPaciente = PonerPunto($rutPaciente);
		
		$nombresPaciente = nombresPaciente($idPaciente, $conectar);
		$apellidoPaternoPaciente = apellidoPaternoPaciente($idPaciente, $conectar);
		$apellidoMaternoPaciente = apellidoMaternoPaciente($idPaciente, $conectar);
		$telefonoPaciente = telefonoPaciente($idPaciente, $conectar);
		$celularPaciente = celularPaciente($idPaciente, $conectar);
		$emailPaciente = emailPaciente($idPaciente, $conectar);
		$direccionPaciente = direccionPaciente($idPaciente, $conectar);
		$idComunaPaciente = idComunaPaciente($idPaciente, $conectar);
		$isapreHora = isapreHora($idHora, $conectar);
		$observacionHora = observacionHora($idHora, $conectar);
		
		$nombreUsuario = nombreUsuario(usuarioHora($idHora, $conectar), $conectar);
		$usuario = usuarioHora($idHora, $conectar);
		
		$ciudad = nombreCiudad(ciudadHora($idHora, $conectar), $conectar);

		if($nombreUsuario == NULL)
		{
			$nombreUsuario = nombreUsuario($_SESSION['idUsuario'], $conectar);
			$usuario = $_SESSION['idUsuario'];
		}
		
		/////////////////////////////////////////////////////////////////////
		//LINK PARA AGENDA ANTIGUA
		$link[fecha] = explode(' ', $fecha);
		$link[fecha] = VueltaFecha($link[fecha][0]);
		
		//Si el resultado es positivo, muestra la agenda antigua
		if(restaDosFechas($FECHA_NUEVO, $link[fecha]) > 0)
		{
			$link[url] = 'informeEntrevistaSegunda';
			$link[urlIsapre] = 'chk_informeEntrevistaSegundaDescarga';
		}
		else
		{
			$link[url] = 'informeEntrevistaSegundaNuevo';
			$link[urlIsapre] = 'chk_informeEntrevistaSegundaDescargaNuevo';
		}
		//LINK PARA AGENDA ANTIGUA
		/////////////////////////////////////////////////////////////////////
		
		$datosInforme = datosInformeHora($idHora, $conectar);
        $fechaAntes = strtotime ( '-7 day' , strtotime ( $fecha ) ) ;
        $fechaAntes=date ( 'Y-m-j' , $fechaAntes );
        $nuevafecha = strtotime ( '+7 day' , strtotime ( $fecha ) ) ;
        $nuevafecha = date ( 'Y-m-j' , $nuevafecha );
        $horadoble = siExisteHoraPrevia($hora, $paciente,$fechaAntes,$nuevafecha,  $conectar);
	}	
	else//La hora no tiene paciente
	{
			$nombreUsuario = nombreUsuario($_SESSION['idUsuario'], $conectar);
			$fecha = $_GET['fecha'];
            $fechaAntes = strtotime ( '-7 day' , strtotime ( $fecha ) ) ;
            $fechaAntes=date ( 'Y-m-j' , $fechaAntes );
            $nuevafecha = strtotime ( '+7 day' , strtotime ( $fecha ) ) ;
            $nuevafecha = date ( 'Y-m-j' , $nuevafecha );
			$usuario = $_SESSION['idUsuario'];
			$idCiudad = $_GET['idCiudad'];
			$ciudad = nombreCiudad($idCiudad, $conectar);
        $horadoble = siExisteHoraPrevia($hora, $paciente,$fechaAntes,$nuevafecha,  $conectar);
	}
?>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

<!--script language="javascript" src="../../../lib/jquery/11/jquery.min.js"></script-->
<script language="javascript" src="../../../lib/numeros.js"></script>
<script language="javascript" src="../../../lib/validaforms.js"></script>

<script>
//autocompletar formulario
	jQuery(document).ready(function(){
		$("#rut").bind("blur", function(e){ 
		 
		$.getJSON("<?php echo $LIB; ?>/querys/pacientesAutocompletar.php?rut=" + $("#rut").val(), 
			function(data){ 
			  $.each(data, function(i,item){ 
				if (item.field == "nombres")
				  $("#nombres").val(item.value); 
				else if (item.field == "apellidoPaterno")
				  $("#apellidoPaterno").val(item.value); 
				else if (item.field == "apellidoMaterno")
				  $("#apellidoMaterno").val(item.value); 
				else if (item.field == "telefono")
				  $("#telefono").val(item.value); 
				else if (item.field == "celular")
				  $("#celular").val(item.value); 
				else if (item.field == "comuna")
					$("#comuna option[value="+ item.value +"]").attr("selected",true);
				else if (item.field == "email")
					$("#email").val(item.value);
				else if (item.field == "direccion")
					$("#direccion").val(item.value); 
			  }); 
			}); 
		}); 
	}); 

	function confirmar()
	{
		if(confirm('¿Está seguro de eliminar esta hora?'))
		{
			window.location.href = '<?php echo $MODULOS; ?>/agenda/chk_eliminarHora.php?id=<?php echo $idHora; ?>';
		}
	}
	
	function validarForm(form)
	{
        var bool true ;
        valor = document.getElementById('doble').value;

         if($("#rut").val().length < 1)

         {
			alert('Ingrese el RUT');
            bool = false;
		}
            if($("#nombres").val().length <1 )
		{
			alert('Ingrese los nombres');
            bool = false;
		}
		if($("#apellidoPaterno").val().length < 1)
		{
			alert('Ingrese el apellido paterno');
            bool = false;
		}
		if($("#apellidoMaterno").val().length < 1)
		{
			alert('Ingrese el apellido materno');
            bool = false;
		}
		if($("#telefono").val().length < 1) && $("#celular").val().length < 1))
		{
			alert('Ingrese por lo menos un teléfono');
            bool = false;
		}
        if ($("#doble").val() < 1 )){
            alert('hora duplicada');
            bool = false;

		}
        return bool;
        }
	
	function dv(T)
	{
		var M=0,S=1;
		
		for(;T;T=Math.floor(T/10))
			S=(S+T%10*(9-M++%6))%11;
		
		return S?S-1:'K';
	} 
	
	function digito(form)
	{
		var	nuevo = form.rut.value.replace('.','');
		
		for(i=1; i<=4; i++)
		{
			nuevo = nuevo.replace('.','');
		}
		form.dv.value = dv(nuevo);
	}
	
	function popUp2(URL) 
	{
		day = new Date();
		id = day.getTime();
		
		eval("page" + id + " = window.open(URL, 'popUp2', 'toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=0,width=900,height=700,left=150,top=50');");
	}

</script>

<link href="../../templates/defecto/estilos.css" rel="stylesheet" type="text/css">

</head>
<body>
<?php
	//La hora tiene paciente
	if($idHora != NULL)
	{
		?>
		<table width="90%" border="0" align="center" cellpadding="0" cellspacing="0">
			<tr>
				<td align="left" valign="middle" class="letraDocumentoTitulo">
					<?php 
					if(tipoUsuario($_SESSION['idUsuario'], $conectar) == 'administrador' or tipoUsuario($_SESSION['idUsuario'], $conectar) == 'secretaria')
					{
						?>
						<table width="426" border="0" cellspacing="0" cellpadding="0">
							<tr>
								
								<td width="73%" align="left" valign="middle" class="letraDocumentoTitulo"><span onClick="popUp2('<?php echo $link[url]; ?>.php?hora=<?php echo $idHora; ?>'); window.close();" style="cursor:pointer;"><img src="<?php echo $IMAGENES2; ?>/edit.png" width="16" height="16" border="0"/> EDITAR Informe Entrevista Psiqui&aacute;trica de Peritaje</span></td>
							</tr>
                        <?php //preguntar si existe informe
						$sqlExiste = mysql_query("SELECT id	FROM informe_entrevista WHERE hora='".$idHora."'", $conectar);
						$total = mysql_num_rows($sqlExiste);					
						if ($total > 0)
						{
						?>
							<tr>
								<td width="73%" align="left" valign="middle" class="letraDocumentoTitulo"><span onClick="popUp2('chk_informeEntrevistaSegundaDescargaNuevo.php?id=<?php echo $idHora; ?>'); window.close();" style="cursor:pointer;"><img src="<?php echo $IMAGENES2; ?>/pdf.png" width="16" height="16" border="0"/> VER Informe Entrevista Psiqui&aacute;trica de Peritaje</span></td>
							</tr>
						<?php 
						} 
						?>
						</table>
						<?php 
					}
					
					//Si el usuario es una isapre no puede ver el informe antes de 72 horas
	/*				if(tipoUsuario($_SESSION['idUsuario'], $conectar) == 'isapre' and diferenciaHoraActualHora($idHora, $conectar) >= 72 and $datosInforme['confirmado'] == 1)
*/					//Si el usuario es una isapre puede ver el informe sólo si está úblicado.
					//if(tipoUsuario($_SESSION['idUsuario'], $conectar) == 'isapre' and ($datosInforme['publicado'] == 'SI'))
					//si el usuario es una isapre no puede ver el informe antes de 72 horas sino está publicado.
					if(tipoUsuario($_SESSION['idUsuario'], $conectar) == 'isapre' and diferenciaHoraActualHora($idHora, $conectar) >= 72 and 
					$datosInforme['publicado'] == 'SI')
					{
						?>
						<table width="426" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td width="73%" align="left" valign="middle" class="letraDocumentoTitulo"><span onClick="window.location.href='<?php echo $link[urlIsapre]; ?>.php?id=<?php echo $idHora; ?>'" style="cursor:pointer;"><img src="<?php echo $IMAGENES2; ?>/edit.png" width="16" height="16" border="0"/> Informe Entrevista Psiqui&aacute;trica de Peritaje</span></td>
							</tr>
						</table>
					<?php 
					}
					if(asisteHora($idHora, $conectar) == false && diferenciaHoraActualHora($idHora, $conectar) >= 72)
					{
						?>
						<table width="426" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td width="73%" align="left" valign="middle" class="letraDocumentoTitulo"><span onClick="window.location.href='chk_certificadoInasistencia.php?id=<?php echo $idHora; ?>'" style="cursor:pointer;"><img src="<?php echo $IMAGENES2; ?>/date_magnify.png" width="16" height="16" border="0"/> Certificado de inasistencia</span></td>
							</tr>
						</table>
						<?php 
					}
					?>
				</td>
				<td width="47%" align="right" valign="middle" class="letraDocumentoTitulo">
				<?php 
				if(existeInformeEntrevista($idHora, $conectar) == false)
				{
					if(tipoUsuario($_SESSION['idUsuario'], $conectar) == 'isapre' && abs(diferenciaHoraActualHora($idHora, $conectar)) < 120)
					{

					}
					else
					{
						?>
						<a onClick="confirmar();" style="cursor:pointer;">Eliminar <img src="<?php echo $IMAGENES2; ?>/eliminar.png" width="16" height="16" border="0" /></a>
						<?php
					}
				}
				?>
				<br />
				
				</td>
			</tr>
		</table>
		<?php 
		
		//Si el paciente ya tiene informe de visita anterior
		if(siPacienteAntiguo($idPaciente, $conectar) == true)
		{
			echo hola;
		}
	}
	//La hora no tiene paciente
	else
	{
		if(tipoUsuario($_SESSION['idUsuario'], $conectar) == 'administrador' or tipoUsuario($_SESSION['idUsuario'], $conectar) == 'secretaria')
		{	
			$idHoraPrestador = idFechaPrestadorCiudad($idPrestador, $fecha, $idCiudad, $conectar);
			?>
			<table width="90%" border="0" align="center" cellpadding="0" cellspacing="0">
				<tr>
					<td width="50%">
						<span class="letraDocumentoTitulo" style="cursor:pointer;" onClick="window.location.href='isapreHora.php?hora=<?php echo $idHoraPrestador; ?>'"> <img src="<?php echo $IMAGENES2; ?>/arrow_refresh.png" width="16" height="16" border="0"/> Vinculación con Isapre</span>
					</td>
					<td width="50%">&nbsp;</td>
				</tr>
			</table>					
			<?php 
		}
	}
?>
		<br />
<body>
<form id="form" name="form" method="post" action="chk_agregarHora.php" onSubmit="return validarForm(this);">
	<table width="90%" border="0" align="center" cellpadding="0" cellspacing="0" class="borde_tabla" style="border-collapse:collapse;">
		<tr>
			<td height="29" colspan="2" align="center" bgcolor="#AACCFF" class="tituloTablas">Reserva de Hora (<?php echo $ciudad; ?>)</td>
		</tr>
		<tr>
			<td height="30" align="right" class="letra7" style="padding-right:10px;">Fecha y Hora: </td>
			<td class="letra7" style="padding-left:10px;"><?php echo formatearFechaHora ($fecha);echo '+7'.$nuevafecha.'-7'.$fechaAntes ; ?></td>
		</tr>
		<tr>
			<td width="50%" height="30" align="right" class="letra7" style="padding-right:10px;">RUT:</td>
			<td class="letra7" style="padding-left:10px;"><?php 
				if($idHora != NULL and diferenciaHoraActualHora($idHora, $conectar) < 48  and tipoUsuario($_SESSION['idUsuario'], $conectar) != 'administrador')
				{
					?>
     				<label>
<input name="rut" type="text" class="letra7" id="rut"  onblur="digito(this.form);" value="<?php echo $rutPaciente; ?>" size="10" maxlength="10" readonly/>
</label>-
<label>
				<input name="dv" type="text" id="dv" size="1" readonly value="<?php echo $dv; ?>"/>
			  </label> 
					<?php 
				}
				else
				{
					?>
<input name="rut" type="text" class="letra7" id="rut" onKeyUp="puntitos(this,this.value.charAt(this.value.length -1))" onBlur="digito(this.form);" value="<?php echo $rutPaciente; ?>" size="10" maxlength="10" />
</label> -
				<label>
				<input name="dv" type="text" id="dv" size="1" readonly value="<?php echo $dv; ?>"/>
				</label> 
					<?php 
				}
				?>
                <input name="id" value="<?php echo $idPaciente;?>">
                
          </td>
		</tr>
		<tr>
			<td height="30" align="right" class="letra7" style="padding-right:10px;">Nombres:</td>
			<td class="letra7" style="padding-left:10px;">
				<label>
				<input name="nombres" type="text" class="letra7" id="nombres" value="<?php echo utf8_encode($nombresPaciente); ?>" size="30" <?php 				
				if($idHora != NULL and diferenciaHoraActualHora($idHora, $conectar) > 48 and tipoUsuario($_SESSION['idUsuario'], $conectar) != 'administrador')
				{
					?>readonly="readonly"<?php
				}
?>/>
				</label>
			</td>
		</tr>
		<tr>
			<td height="30" align="right" class="letra7" style="padding-right:10px;">Apellido Paterno: </td>
			<td class="letra7" style="padding-left:10px;">
				<label>
				<input name="apellidoPaterno" type="text" class="letra7" id="apellidoPaterno" value="<?php echo utf8_encode($apellidoPaternoPaciente); ?>" size="30" <?php 				
				if($idHora != NULL and diferenciaHoraActualHora($idHora, $conectar) > 48 and tipoUsuario($_SESSION['idUsuario'], $conectar) != 'administrador')
				{
					?>readonly="readonly"<?php
				}
?>/>
				</label>
			</td>
		</tr>
		<tr>
			<td height="30" align="right" class="letra7" style="padding-right:10px;">Apellido Materno: </td>
			<td class="letra7" style="padding-left:10px;">
				<label>
				<input name="apellidoMaterno" type="text" class="letra7" id="apellidoMaterno" size="30" value="<?php echo utf8_encode($apellidoMaternoPaciente); ?>" <?php 				
				if($idHora != NULL and diferenciaHoraActualHora($idHora, $conectar) > 48  and tipoUsuario($_SESSION['idUsuario'], $conectar) != 'administrador')
				{
					?>readonly="readonly"<?php
				}
?>/>
				</label>
			</td>
		</tr>
		<tr>
			<td height="30" align="right" class="letra7" style="padding-right:10px;">Tel&eacute;fono:</td>
			<td class="letra7" style="padding-left:10px;">
				<label>
				<input name="telefono" type="text" data-type="text" data-importance="important" placeholder="Text important" class="letra7" id="telefono" size="10" value="<?php echo $telefonoPaciente; ?>"/>
				</label>
			</td>
		</tr>
		<tr>
		  <td height="30" align="right" class="letra7" style="padding-right:10px;">Numero de Licencia</td>
		  <td class="letra7" style="padding-left:10px;"><input name="numerolicencia" type="text" class="letra7" id="numerolicencia" size="10" value="<?php //echo $telefonoPaciente; ?>"/></td>
	  </tr>
		<tr>
			<td height="30" align="right" class="letra7" style="padding-right:10px;">Celular:</td>
			<td class="letra7" style="padding-left:10px;">
				<label>
				<input name="celular" type="text" class="letra7" id="celular" size="10" value="<?php echo $celularPaciente; ?>"/>
				</label>
			</td>
		</tr>
		<tr>
			<td height="30" align="right" class="letra7" style="padding-right:10px;">Email:</td>
			<td class="letra7" style="padding-left:10px;">
				<label>
				<input name="email" type="text" id="email" size="30" onKeyUp="soloCaracteresMail(this)" value="<?php echo $emailPaciente; ?>"/>
				</label>
			</td>
		</tr>
		<tr>
			<td height="30" align="right" class="letra7" style="padding-right:10px;">Direcci&oacute;n:</td>
			<td class="letra7" style="padding-left:10px; padding-right:10px;">
				<label>
				<input name="direccion" type="text" class="letra7" id="direccion" size="45" value="<?php echo utf8_encode($direccionPaciente); ?>"/>
				</label>
			</td>
		</tr>
		<tr>
			<td height="30" align="right" class="letra7" style="padding-right:10px;">Comuna:</td>
			<td class="letra7" style="padding-left:10px;">
				<label>
				<select name="comuna" id="comuna" class="letra7">
					<?php 
					if($idComunaPaciente != NULL)
					{
						?>
						<option value="<?php echo $idComunaPaciente; ?>"><?php echo retornaComuna($idComunaPaciente, $conectar); ?></option>
						<?php
					}
					?>
					<?php comunasOptions($conectar); ?>
				</select>
				</label>
			</td>
		</tr>
		<tr>
			<td height="30" align="right" class="letra7" style="padding-right:10px;">Seguro de salud:</td>
			<td class="letra7" style="padding-left:10px;">
				<?php 
					if(tipoUsuario($_SESSION['idUsuario'], $conectar) != 'isapre')
					{
						?>
						<label>
						<select name="isapre" class="letra7" id="isapre">
							<?php 
							if($isapreHora != NULL)
							{
								?>
								<option value="<?php echo $isapreHora; ?>"><?php echo nombreIsapre($isapreHora, $conectar); ?></option>
								<?php
							}
							?>
							<?php echo isapresOptions($conectar); ?>
						</select>
						</label>
						<?php 
					}
					else
					{
						?>
						<?php echo nombreIsapre(isapreUsuario($_SESSION['idUsuario'], $conectar), $conectar); ?>
						<input name="isapre" type="hidden" id="isapre" value="<?php echo isapreUsuario($_SESSION['idUsuario'], $conectar); ?>"/>
						<?php 
					}	
				?>		
			</td>
		</tr>
		<tr>
			<td height="30" align="right" class="letra7" style="padding-right:10px;">Usuario</td>
			<td class="letra7" style="padding-left:10px;">
				<?php 
					echo $nombreUsuario; 
				?>
			</td>
		</tr>
		<tr>
			<td height="30" align="right" valign="top" class="letra7" style="padding-right:10px; padding-top:5px;">Observaci&oacute;n:</td>
			<td class="letra7" style="padding-left:10px; padding-top:5px; padding-bottom:5px;">
				<label>
				<textarea name="observacion" cols="40" rows="7" class="letra7" id="observacion"><?php echo utf8_encode($observacionHora); ?></textarea>
				</label>
			</td>
		</tr>
	</table>
	<br />
	<table width="90%" border="0" align="center" cellpadding="0" cellspacing="0">
		<tr>
		  <td align="center">
				<input name="idCiudad" type="hidden" id="idCiudad" value="<?php echo $idCiudad; ?>" />
				<input name="idPrestador" type="hidden" id="idPrestador" value="<?php echo $idPrestador; ?>" />
				<input name="idUsuario" type="hidden" id="idUsuario" value="<?php echo $usuario; ?>" />
              <input name="horaexiste" type="text" id="horaexiste" value="<?php echo $horadoble; ?>" />

			  <?php
				if($idHora != NULL)
				{
					?>
					<input name="idHora" type="hidden" id="idHora" value="<?php echo $idHora; ?>" />
					<?php 
				}
				else
				{
					?>
					<input name="fecha" type="hidden" id="fecha" value="<?php echo $fecha; ?>" />
					<?php 
				}
				?>
				
			<label>
				<input name="Submit" type="submit" class="boton" value="Reservar" onClick="this.disabled=true; this.form.submit();"/>
			  </label>
		    <input name="doble" type="text" size="4" id="doble" value="<?php echo $horadoble ;?>"></td>
		</tr>
	</table>
</form>
</body>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>

<script type="text/javascript" src="../../../lib/jvalidate/jquery.Jvalidate.js"></script>
<script type="text/javascript">
    $('#form1').Jvalidate({
        language: 'es',
        submit: '#submit',
        success: function(){
            alert('send!');
            return false;
        }
    });
</script>