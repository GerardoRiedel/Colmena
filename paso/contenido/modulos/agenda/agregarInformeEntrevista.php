<?php 
	session_name("agenda2");
session_start();
	
	include('../../../lib/pacientes/funciones.php');
	include('../../../lib/isapres/funciones.php');
	include('../../../lib/usuarios/funciones.php');
	include('../../../lib/horas/funciones.php');
	include('../../../lib/encuesta_peritaje/funciones.php');
	include('../../../lib/querys/comunas.php');
	include('../../../lib/datos.php');
	include('../../../lib/funciones.php');
	include('../../../lib/conectar.php');
	
	$conectar = conectar();
	
	//Verifico si el usuario es prestador y lo saco
	if(tipoUsuario($_SESSION['idUsuario'], $conectar) == 'isapre')
	{
		$_SESSION['msj'] = 'No tiene acceso';
		
		header('Location: '.$TEMPLATE_DIR2.'/mensajes.php');
		die();
	}
	
	$idHora = $_GET['hora'];
	
	$existe = false;

	if(existeEncuestaPeritaje($idHora, $conectar) != false)
	{
		$existe = true;
		
		$id = existeEncuestaPeritaje($idHora, $conectar);
	}
	
?>

<script language="javascript" src="../../../lib/numeros.js"></script>
<script language="javascript" src="../../../lib/validaforms.js"></script>

<script>
	function validarForm(form)
	{
		if(form.edad.value=='')
		{
			alert('Ingrese la edad');
			return false;
		}
		else if(form.actividad.value=='')
		{
			alert('Ingrese la actividad');
			return false;
		}
		else if(form.tiempoDeLM.value=='')
		{
			alert('Ingrese el tiempo de LM');
			return false;
		}
		else if(form.diagnosticoLM.value=='')
		{
			alert('Ingrese el diagnóstico LM');
			return false;
		}
		else if(form.opinionTratamiento.value=='')
		{
			alert('Ingrese la opinión');
			return false;
		}
		else
		{
			return true;
		}	
	}
</script>

<link href="../../templates/defecto/estilos.css" rel="stylesheet" type="text/css">
<br />
<form id="form1" name="form1" method="post" action="chk_agregarInformeEntrevista.php" onsubmit="return validarForm(this);">
	<table width="90%" border="0" align="center" cellpadding="0" cellspacing="0" class="borde_tabla">
		<tr>
			<td height="29" colspan="2" align="center" bgcolor="#AACCFF" class="tituloTablas">Encuesta Peritaje Psiqui&aacute;trico </td>
		</tr>
		<tr>
			<td width="50%" height="30" align="right" class="letra7" style="padding-right:10px;">Sexo:</td>
			<td class="letra7" style="padding-left:10px;">
				<label>
				<select name="sexo" class="letra7" id="sexo">
					<?php 
					if($existe == true)
					{
						?>
						<option value="<?php echo sexoEncuestaPeritaje($id, $conectar); ?>"><?php echo sexoEncuestaPeritaje($id, $conectar); ?></option>
						<?php 
					}
					?>
					<option value="M">M</option>
					<option value="F">F</option>
				</select>
				</label>
			</td>
		</tr>
		<tr>
			<td height="30" align="right" class="letra7" style="padding-right:10px;">Edad:</td>
			<td class="letra7" style="padding-left:10px;">
				<label>
				<?php 
				if($existe == true)
				{
					?>
					<input name="edad" type="text" class="letra7" id="edad" size="3" maxlength="3" onKeyUp="soloNumerosReales(this)" value="<?php echo edadEncuestaPeritaje($id, $conectar); ?>"/>
					<?php 
				}
				else
				{
					?>
					<input name="edad" type="text" class="letra7" id="edad" size="3" maxlength="3" onKeyUp="soloNumerosReales(this)"/>
					<?php 
				}
				?>
				</label>
			a&ntilde;os</td>
		</tr>
		<tr>
			<td height="30" align="right" class="letra7" style="padding-right:10px;">Actividad:</td>
			<td class="letra7" style="padding-left:10px;">
				<label>
				<?php 
				if($existe == true)
				{
					?>
					<input name="actividad" type="text" class="letra7" id="actividad" size="60" value="<?php echo actividadEncuestaPeritaje($id, $conectar); ?>"/>
					<?php 
				}
				else
				{
					?>
					<input name="actividad" type="text" class="letra7" id="actividad" size="60"/>
					<?php 
				}
				?>
				</label>
			</td>
		</tr>
		<tr>
			<td height="30" align="right" class="letra7" style="padding-right:10px;">Tiempo de LM :</td>
			<td class="letra7" style="padding-left:10px;">
				<label>
				<?php 
				if($existe == true)
				{
					?>
					<input name="tiempoDeLM" type="text" class="letra7" id="tiempoDeLM" onKeyUp="soloNumerosReales(this)" size="5" maxlength="5" value="<?php echo tiempoDeLMEncuestaPeritaje($id, $conectar); ?>"/>
					<?php 
				}
				else
				{
					?>
					<input name="tiempoDeLM" type="text" class="letra7" id="tiempoDeLM" onKeyUp="soloNumerosReales(this)" size="5" maxlength="5"/>
					<?php 
				}
				?>
				</label>
d&iacute;as</td>
		</tr>
		<tr>
			<td height="30" align="right" valign="top" class="letra7" style="padding-right:10px; padding-top:5px;">Diagn&oacute;stico LM:</td>
			<td class="letra7" style="padding-left:10px; padding-top:5px; padding-bottom:5px;">
				<label>
				<textarea name="diagnosticoLM" cols="50" rows="5" class="letra7" id="diagnosticoLM"><?php 
				if($existe == true)
				{
					echo diagnosticoLMEncuestaPeritaje($id, $conectar);
				}
				?></textarea>
				</label>
			</td>
		</tr>
		<tr>
			<td height="30" align="right" class="letra7" style="padding-right:10px;">Opini&oacute;n sobre Diagn&oacute;stico:</td>
			<td class="letra7" style="padding-left:10px; padding-right:10px;">
				<label>
				<select name="opinionDiagnostico" class="letra7" id="opinionDiagnostico">
					<?php 
					if($existe == true)
					{
						?>
						<option value="<?php echo opinionDiagnosticoEncuestaPeritaje($id, $conectar); ?>"><?php echo opinionDiagnosticoEncuestaPeritaje($id, $conectar); ?></option>
						<?php 
					}
					?>
					<option value="De acuerdo">De acuerdo</option>
					<option value="De acuerdo con otro diagn&oacute;stico">De acuerdo con otro diagn&oacute;stico</option>
					<option value="Sin diagn&oacute;stico psiqui&aacute;trico">Sin diagn&oacute;stico psiqui&aacute;trico</option>
				</select>
				</label>
			</td>
		</tr>
		<tr>
			<td height="30" align="right" class="letra7" style="padding-right:10px;">Corresponde reposo actual:</td>
			<td class="letra7" style="padding-left:10px;">
				<label>
				<select name="correspondeReposo" class="letra7" id="correspondeReposo">
					<?php 
					if($existe == true)
					{
						?>
						<option value="<?php echo correspondeReposoEncuestaPeritaje($id, $conectar); ?>"><?php echo correspondeReposoEncuestaPeritaje($id, $conectar); ?></option>
						<?php 
					}
					?>
					<option value="Si">Si</option>
					<option value="No">No</option>
					<option value="Se prolonga por tratamiento insuficiente">Se prolonga por tratamiento insuficiente</option>
				</select>
				</label>
			</td>
		</tr>
		<tr>
			<td height="30" align="right" class="letra7" style="padding-right:10px;">Tratante:</td>
			<td class="letra7" style="padding-left:10px;">
				<label>
				<select name="tratante" class="letra7" id="tratante">
					<?php 
					if($existe == true)
					{
						?>
						<option value="<?php echo tratanteEncuestaPeritaje($id, $conectar); ?>"><?php echo tratanteEncuestaPeritaje($id, $conectar); ?></option>
						<?php 
					}
					?>
					<option value="Psiquiatra">Psiquiatra</option>
					<option value="Neur&oacute;logo">Neur&oacute;logo</option>
					<option value="Otro">Otro</option>
				</select>
				</label>
			</td>
		</tr>
		<tr>
			<td height="30" align="right" valign="top" class="letra7" style="padding-right:10px; padding-top:5px;">Opini&oacute;n sobre tratamiento:</td>
			<td class="letra7" style="padding-left:10px; padding-top:5px; padding-bottom:5px;">
				<label>
					<select name="opinionTratamiento" class="letra7" id="opinionTratamiento">
						<?php 
						if($existe == true)
						{
							?>
							<option value="<?php echo opinionTratamientoEncuestaPeritaje($id, $conectar); ?>"><?php echo opinionTratamientoEncuestaPeritaje($id, $conectar); ?></option>
							<?php 
						}
						?>
						<option value="Corresponde">Corresponde</option>
						<option value="No corresponde">No corresponde</option>
						<option value="Insuficiente">Insuficiente</option>
						<option value="P. no cumple indicaciones">P. no cumple indicaciones</option>
					</select>
				</label>
			</td>
		</tr>
	</table>
	<br />
	<table width="90%" border="0" align="center" cellpadding="0" cellspacing="0">
		<tr>
			<td align="center">
				<?php 
				if($existe == true)
				{
					?>
					<input name="id" type="hidden" id="id" value="<?php echo $id; ?>" />
					<?php
				}
				?>			
				<input name="idHora" type="hidden" id="idHora" value="<?php echo $idHora; ?>" />
				<label>
				<input name="Submit" type="submit" class="boton" value="Guardar" />
				</label>
			</td>
		</tr>
	</table>
</form>
