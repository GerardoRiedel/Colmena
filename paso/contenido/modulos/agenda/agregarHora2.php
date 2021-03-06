<?php 
	session_name("agenda2");
	session_start();

	include('../../../lib/pacientes/funciones.php');
	include('../../../lib/isapres/funciones.php');
	include('../../../lib/usuarios/funciones.php');
	include('../../../lib/horas/funciones.php');
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

        $registrosHora = datosHora2($idHora,$conectar);

        $fecha= $registrosHora['hora'];
        $idpaciente = $registrosHora['paciente'];
        $rutPaciente = $registrosHora['rut'];
        $dv= $registrosHora['dv'];
        $nombresPaciente = $registrosHora['nombres'];
        $apellidoPaternoPaciente = $registrosHora['apellidoPaterno'];
        $apellidoMaternoPaciente = $registrosHora['apellidoMaterno'];
        $telefonoPaciente = $registrosHora['telefono'];
        $celularPaciente = $registrosHora['celular'];
        $emailPaciente = $registrosHora['email'];
        $direccionPaciente =$registrosHora['direccion'];
        $idComunaPaciente = $registrosHora['comuna'];
        $isapreHora = $registrosHora['isapre'];
        $observacionHora =$registrosHora['observacion'];

        $nombreUsuario =  $registrosHora['usuario'];
       // $usuario = usuarioHora($idHora, $conectar);
        $ciudad = $registrosHora['ciudad'];
        $numerolicencia = $registrosHora['numerolicencia'];
        $idPaciente = $registrosHora['paciente'];
       /*
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

        */
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
        $horadoble = siExisteHoraPrevia($paciente,$fechaAntes,$nuevafecha,  $conectar);

	}	
	else//La hora no tiene paciente
	{
		$nombreUsuario = nombreUsuario($_SESSION['idUsuario'], $conectar);
		$fecha = $_GET['fecha'];
		$usuario = $_SESSION['idUsuario'];
		$idCiudad = $_GET['idCiudad'];
		$ciudad = nombreCiudad($idCiudad, $conectar);
        $fechaAntes = strtotime ( '-7 day' , strtotime ( $fecha ) ) ;
        $fechaAntes=date ( 'Y-m-j' , $fechaAntes );
        $nuevafecha = strtotime ( '+7 day' , strtotime ( $fecha ) ) ;
        $nuevafecha = date ( 'Y-m-j' , $nuevafecha );
        $horadoble = siExisteHoraPrevia($paciente,$fechaAntes,$nuevafecha,  $conectar);
	}
?>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

<script language="javascript" src="../../../lib/jquery/jquery.min.js"></script>
<script language="javascript" src="../../../lib/numeros.js"></script>
<script language="javascript" src="../../../lib/validaforms.js"></script>

<script>
//autocompletar formulario
	jQuery(document).ready(function(){
        var fechaini = $("#fechahora").val;
		$("#rut").bind("blur", function(e){
		 
		$.getJSON("<?php echo $LIB; ?>/querys/pacientesAutocompletar.php?rut=" + $("#rut").val()+'&fecha='+ $("#fechahora").val ,
			function(data){ 
			  $.each(data, function(i,item){

				if (item.field == "nombres")
				  $("#nombres").val(item.value);
                else if (item.field == "idpaciente")
                    $("#idpaciente").val(item.value);
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
                else if (item.field == "numhoras")
                    $("#horaprevia").val(item.value);
				else if (item.field == "direccion")
					$("#direccion").val(item.value); 
			  }); 
			}); 
		});
	}
    );




	function confirmar()
	{
		if(confirm('¿Está seguro de eliminar esta hora?'))
		{
			window.location.href = '<?php echo $MODULOS; ?>/agenda/chk_eliminarHora.php?id=<?php echo $idHora; ?>';
		}
	}
	
	function validarForm(form)
	{
        indice = document.getElementById("isapre").selectedIndex;

        if(form.rut.value=='')
		{
			alert('Ingrese el RUT');
			return false;
		}
		else if(form.nombres.value=='')
		{
			alert('Ingrese los nombres');
			form.rut.focus();
            return false;
		}
		else if(form.apellidoPaterno.value=='')
		{
			alert('Ingrese el apellido paterno');
            form.apellidoPaterno.focus();
			return false;
		}
		else if(form.apellidoMaterno.value=='')
		{
			alert('Ingrese el apellido materno');
            form.apellidoMaterno.focus();
            return false;
		}
		else if(form.telefono.value=='' && form.celular.value=='')
		{
			alert('Ingrese por lo menos un teléfono');
            form.telefono.focus();
				return false;
		}
        else if( indice == null || indice == 0 )

        // if(form.isapre.options[form.isapre.selectIndex].value =='' )
        {
            alert('Debe especificar Isapre');
            form.isapre.focus();
            return false;
        }
        else if(form.horaprevia.value >= '1' )
        {
            alert('Paciente Tiene hora Previa');
            return false;
        }

		else
		{
			return true;
		}	
	}
	
	function dv(T)
	{
		var M=0,S=1;
		
		for(;T;T=Math.floor(T/10))
			S=(S+T%10*(9-M++%6))%11;
		return S?S-1:'K';
	}
function digito2(T) {
	nuevo_numero = T.toString().split("").reverse().join("");
	for(i=0,j=2,suma=0; i < nuevo_numero.length; i++, ((j==7) ? j=2 : j++)) {
		suma += (parseInt(nuevo_numero.charAt(i)) * j);
	}
	n_dv = 11 - (suma % 11);
	return ((n_dv == 11) ? 0 : ((n_dv == 10) ? "K" : n_dv));
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

function enviarpdf(idHora)
{
    window.location.href = '<?php echo $MODULOS; ?>/agenda/chk_informeEntrevistaSegundaNuevoxml.php?idHora='+ idHora;
}
/*
function llamadaHP(){
    $.ajax({
        type: "POST",
        url: "../../../lib/querys/horaprevia.php",
        data: {idpaciente: $('#idpaciente').val() , desde : $('#desde').val(),hasta : $('#hasta').val()},

        success: function( respuesta ){
        success: function( respuesta ){
            if (respuesta == '0')

                $("#horaprevia").val(respuesta);
            else
                $("#horaprevia").val(respuesta);
               /* alert ('Hora Previa');*/


	/*	}});*/




</script>

<link href="../../templates/defecto/estilos.css" rel="stylesheet" type="text/css">
</head>

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
								<td width="73%" align="left" valign="middle" class="letraDocumentoTitulo"><span onClick="popUp2('chk_informeEntrevistaSegundaDescargaNuevo.php?id=<?php echo $idHora; ?>'); window.close();" style="cursor:pointer;"><img src="<?php echo $IMAGENES2; ?>/pdf.png" width="16" height="16" border="0"/> VER Informe Entrevista Psiqui&aacute;trica de Peritaje</span>
                                </td>
                                
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
<body>
<form id="form" name="form" method="post" action="chk_agregarHora.php" onSubmit="return validarForm(this);">
	<table width="90%" border="0" align="center" cellpadding="0" cellspacing="0" class="borde_tabla" style="border-collapse:collapse;">
		<tr>
			<td height="29" colspan="2" align="center" bgcolor="#AACCFF" class="tituloTablas">Reserva de Hora (<?php echo $ciudad; ?>)</td>
		</tr>
		<tr>
			<td height="30" align="right" class="letra7" style="padding-right:10px;">Fecha y Hora: </td>
			<td class="letra7" style="padding-left:10px;"><?php echo formatearFechaHora ($fecha); ?><?php echo '-'.$especialidad;?></td>
		</tr>
		<tr>
			<td width="50%" height="30" align="right" class="letra7" style="padding-right:10px;">RUT:</td>
			<td class="letra7" style="padding-left:10px;"><?php 
				if($idHora != NULL and diferenciaHoraActualHora($idHora, $conectar) < 48  and tipoUsuario($_SESSION['idUsuario'], $conectar) != 'administrador')
				{
					?>
     				<label>
<input name="rut" type="text" class="letra7" id="rut"   onblur="digito2(<?php echo $rutPaciente; ?>);" value="<?php echo $rutPaciente; ?>" size="10" maxlength="10" readonly/>

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
                
                
                
          </td>
		</tr>
		<tr>
			<td height="30" align="right" class="letra7" style="padding-right:10px;">Nombres:</td>
			<td class="letra7" style="padding-left:10px;">
				<label>
				<input name="nombres" type="text" class="letra7" id="nombres" onClick="llamadaHP()" value="<?php echo utf8_encode($nombresPaciente); ?>" size="30" <?php
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
				<input name="telefono" type="text" class="letra7" id="telefono" size="10" value="<?php echo $telefonoPaciente; ?>"/>
				</label>
			</td>
		</tr>
		<tr>
		  <td height="30" align="right" class="letra7" style="padding-right:10px;">Numero de Licencia</td>
		  <td class="letra7" style="padding-left:10px;"><input name="numerolicencia" type="text" class="letra7" id="numerolicencia" size="10" value="<?php echo $numerolicencia; ?>"/></td>
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
						<select id="isapre" name="isapre" onclick="javascript:llamadaHP()" onmouseover="javascript:llamadaHP()" class="letra7" >
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
						<input name="isapre" type="text" id="isapre" value="<?php echo isapreUsuario($_SESSION['idUsuario'], $conectar); ?>"/>
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
                <input name="horaprevia" type="text" id="horaprevia" value="" />
                <input name="fechahora" type="hidden" id="fechahora" value="<?php echo substr($fecha,0,10) ;?>" />
                <input name="idpaciente" type="hidden" id="idpaciente" value="<?php echo $idPaciente; ?>" />
                <input name="desde" type="text" id="desde" value="<?php echo $fechaAntes; ?>" />
                <input name="hasta" type="text" id="hasta" value="<?php echo $nuevafecha; ?>" />
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
				<input name="Submit" type="submit" class="boton" onClick="javascript:llamadaHP()" onMouseOver="llamadaHP()" value="Reservar"/>
                    <input name="SubmitMod" type="submit" class="boton"   value="Modificar"/>


                </label>
			</td>
		</tr>
	</table>
</form>
</body>
</head>
