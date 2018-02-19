<?php 
	session_name("agenda2");
	session_start();
	
	include('../../../lib/html2pdf/html2pdf.class.php');
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

 	ob_start();
	
	$conectar = conectar();
	
	//Verifico si el usuario es prestador y lo saco
//	if(tipoUsuario($_SESSION['idUsuario'], $conectar) == 'isapre')
//	{
//		$_SESSION['msj'] = 'No tiene acceso';
//		
//		header('Location: '.$TEMPLATE_DIR2.'/mensajes.php');
//		die();
//	}
	
	$idHora = $_GET['id'];
	
	$id = existeInformeEntrevista($idHora, $conectar);
	
	$sqlDatos = mysql_query("
	SELECT 
		i.`id`, 
		i.`paciente`, 
		i.`prestador`, 
		i.`hora`, 
		i.`fecha`, 
		i.`ocupacion`, 
		i.`sexo`, 
		i.`edad`, 
		i.`tiempoLicencia`, 
		i.`medicoTratante`, 
		i.`nombreMedicoTratante`, 
		i.`antecedentesPersonales`, 
		i.`antecedentesMorbidos`, 
		i.`factoresEstresantes`, 
		i.`existeEstresLaboral`, 
		i.`anamnesis`, 
		i.`examenMental`, 
		i.`tratamientoActual`, 
		i.`opinionTratamiento`, 
		i.`comentarios`, 
		i.`diagnosticoLicenciaMedica`, 
		i.`opinionSobreDiagnostico`, 
		i.`eje1`, 
		i.`eje2`, 
		i.`eje3`, 
		i.`eje4`, 
		i.`eje5`, 
		i.`opinionReposoMedico`, 
		i.`siReposoCorresponde`, 
		i.`cuantosDiasReposo`, 
		i.`comentarios2` 
	FROM 
		informe_entrevista i
	WHERE 
		i.`hora`=".$idHora."
	", $conectar);
	
	$rowDatos = mysql_fetch_array($sqlDatos);
	
	$hora = $rowDatos[hora];
	
	$isapre = nombreIsapre(isapreHora($hora, $conectar), $conectar);

	$idPaciente = $rowDatos[paciente];
	$idPrestador = $rowDatos[prestador];
	$fecha = VueltaFecha($rowDatos[fecha]);
	$ocupacion = $rowDatos[ocupacion];
	$sexo = $rowDatos[sexo];
	$edad = $rowDatos[edad];
	$tiempoLicencia = $rowDatos[tiempoLicencia];
	$medicoTratante = utf8_decode(nl2br(caracteres_html_inversa($rowDatos[medicoTratante])));
	$nombreMedicoTratante = utf8_decode(nl2br(caracteres_html_inversa($rowDatos[nombreMedicoTratante])));
	$antecedentesPersonales = utf8_decode(nl2br(caracteres_html_inversa($rowDatos[antecedentesPersonales])));
	$antecedentesMorbidos = utf8_decode(nl2br(caracteres_html_inversa($rowDatos[antecedentesMorbidos])));
	$factoresEstresantes = utf8_decode(nl2br(caracteres_html_inversa($rowDatos[factoresEstresantes])));
	$existeEstresLaboral = utf8_decode(nl2br(caracteres_html_inversa($rowDatos[existeEstresLaboral])));
	$anamnesis = utf8_decode(nl2br(caracteres_html_inversa($rowDatos[anamnesis])));
	$examenMental = utf8_decode(nl2br(caracteres_html_inversa($rowDatos[examenMental])));
	$tratamientoActual = utf8_decode(nl2br(caracteres_html_inversa($rowDatos[tratamientoActual])));
	$opinionTratamiento = utf8_decode(nl2br(caracteres_html_inversa($rowDatos[opinionTratamiento])));
	$comentarios = utf8_decode(nl2br(caracteres_html_inversa($rowDatos[comentarios])));
	$diagnosticoLicenciaMedica = utf8_decode(nl2br(caracteres_html_inversa($rowDatos[diagnosticoLicenciaMedica])));
	$opinionSobreDiagnostico = utf8_decode(nl2br(caracteres_html_inversa($rowDatos[opinionSobreDiagnostico])));
	$eje1 = utf8_decode(nl2br(caracteres_html_inversa($rowDatos[eje1])));
	$eje2 = utf8_decode(nl2br(caracteres_html_inversa($rowDatos[eje2])));
	$eje3 = utf8_decode(nl2br(caracteres_html_inversa($rowDatos[eje3])));
	$eje4 = utf8_decode(nl2br(caracteres_html_inversa($rowDatos[eje4])));
	$eje5 = utf8_decode(nl2br(caracteres_html_inversa($rowDatos[eje5])));
	$opinionReposoMedico = utf8_decode(nl2br(caracteres_html_inversa($rowDatos[opinionReposoMedico])));
	$siReposoCorresponde = utf8_decode(nl2br(caracteres_html_inversa($rowDatos[siReposoCorresponde])));
	$cuantosDiasReposo = utf8_decode(nl2br(caracteres_html_inversa($rowDatos[cuantosDiasReposo])));
	$comentarios2 = utf8_decode(nl2br(caracteres_html_inversa($rowDatos[comentarios2])));

	$nombreCompletoPaciente = nombreCompletoPaciente($idPaciente, $conectar);
	$rutPaciente = rutPaciente($idPaciente, $conectar);
	$dvPaciente = DigitoVerificador($rutPaciente);
	$rutPaciente = PonerPunto($rutPaciente).'-'.$dvPaciente;
	$direccion = direccionPaciente($idPaciente, $conectar);
	$comuna = retornaComuna(idComunaPaciente($idPaciente, $conectar), $conectar);
	$ciudad = strtoupper(nombreCiudad(ciudadHora($hora, $conectar), $conectar));
	
	$nombreCompletoPrestador = nombreCompletoPrestador ($idPrestador, $conectar);
	$rutPrestador = rutPrestador ($idPrestador, $conectar);
	$dvPrestador = DigitoVerificador($rutPrestador);
	$rutPrestador = PonerPunto($rutPrestador).'-'.$dvPrestador;
?>
<style type="text/css">
<!--
.tituloDocumento {	font-family:Arial, Tahoma, Verdana;
	color:#000000;
	font-size:18px;
	font-weight:bolder;
}
.letraDocumento {	font-family: Arial, Helvetica, sans-serif;
	font-size: 15px;
	color: #000000;
}
.letraDocumentoTitulo {	font-family: Arial, Helvetica, sans-serif;
	font-size: 14px;
	color: #000000;
	font-weight:bolder;
}
.letraDocumento1 {	font-family: Arial, Helvetica, sans-serif;
	font-size: 13px;
	color: #000000;
	line-height:10px;
}
-->
</style>


<page>
<table width="738" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td><table width="738" border="0" cellspacing="0" cellpadding="0">
			<tr>
				<td width="125"><span class="tituloDocumento"><img src="<?php echo $IMAGENES2; ?>/logoDocumentos.jpg" alt="" width="124" height="93" /></span></td>
				<td width="409" rowspan="2" align="center" valign="middle"><span class="tituloDocumento">Informe de Entrevista Psiqui&aacute;trica de Peritaje</span></td>
				<td width="204" rowspan="2" align="right" valign="top"><span class="letraDocumento" style="padding-left:15;"><?php echo ucfirst(strtolower($ciudad)); ?></span></td>
			</tr>
			<tr>
			  <td><span class="tituloDocumento"><img src="<?php echo $IMAGENES2; ?>/iso_blanco.jpg" alt="" width="124" height="93" /></span></td>
		  </tr>
		</table></td>
	</tr>
	<tr>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td><table width="738" border="0" cellspacing="0" cellpadding="0">
			<tr>
				<td width="366" height="20" align="right"><span class="letraDocumentoTitulo">FECHA:</span></td>
				<td align="right">&nbsp;</td>
				<td width="362" align="left"><span class="letraDocumento" style="padding-left:15;"><?php echo $fecha; ?></span></td>
			</tr>
			<tr>
				<td height="20" align="right"><span class="letraDocumentoTitulo">NOMBRE:</span></td>
				<td align="right">&nbsp;</td>
				<td align="left"><span class="letraDocumento" style="padding-left:15;"><?php echo $nombreCompletoPaciente; ?></span></td>
			</tr>
			<tr>
				<td height="20" align="right"><span class="letraDocumentoTitulo">RUT:</span></td>
				<td align="right">&nbsp;</td>
				<td align="left"><span class="letraDocumento" style="padding-left:15;"><?php echo $rutPaciente; ?></span></td>
			</tr>
			<tr>
				<td height="20" align="right"><span class="letraDocumentoTitulo">SEGURO DE SALUD:</span></td>
				<td align="right">&nbsp;</td>
				<td align="left"><span class="letraDocumento" style="padding-left:15;"><?php echo $isapre; ?></span></td>
			</tr>
			<tr>
				<td height="20" align="right"><span class="letraDocumentoTitulo">OCUPACI&Oacute;N: </span></td>
				<td align="right">&nbsp;</td>
				<td align="left"><span class="letraDocumento" style="padding-left:15;"><?php echo ucfirst(strtolower($ocupacion)); ?></span></td>
			</tr>
			<tr>
				<td height="20" align="right"><span class="letraDocumentoTitulo">SEXO: </span></td>
				<td align="right">&nbsp;</td>
				<td align="left"><span class="letraDocumento" style="padding-left:15;"><?php echo $sexo; ?></span></td>
			</tr>
			<tr>
				<td height="20" align="right"><span class="letraDocumentoTitulo">EDAD:</span></td>
				<td align="right">&nbsp;</td>
				<td align="left"><span class="letraDocumento" style="padding-left:15;"><?php echo $edad; ?></span></td>
			</tr>
			<tr>
				<td height="20" align="right"><span class="letraDocumentoTitulo">DIRECCI&Oacute;N:</span></td>
				<td align="right">&nbsp;</td>
				<td align="left"><span class="letraDocumento" style="padding-left:15;"><?php echo $direccion; ?></span></td>
			</tr>
			<tr>
				<td height="20" align="right"><span class="letraDocumentoTitulo">COMUNA:</span></td>
				<td align="right">&nbsp;</td>
				<td align="left"><span class="letraDocumento" style="padding-left:15;"><?php echo ucwords(strtolower($comuna)); ?></span></td>
			</tr>
			<tr>
				<td height="20" align="right"><span class="letraDocumentoTitulo">CIUDAD:</span></td>
				<td align="right">&nbsp;</td>
				<td align="left"><span class="letraDocumento" style="padding-left:15;"><?php echo ucfirst(strtolower($ciudad)); ?></span></td>
			</tr>
			<tr>
				<td height="20" align="right"><span class="letraDocumentoTitulo">TIEMPO DE LICENCIA:</span></td>
				<td align="right">&nbsp;</td>
				<td align="left"><span class="letraDocumento" style="padding-left:15;"><?php echo $tiempoLicencia; ?></span></td>
			</tr>
			<tr>
				<td height="20" align="right"><span class="letraDocumentoTitulo">M&Eacute;DICO TRATANTE:</span></td>
				<td align="right">&nbsp;</td>
				<td align="left"><span class="letraDocumento" style="padding-left:15;"><?php echo ucfirst(strtolower($medicoTratante)); ?></span></td>
			</tr>
			<tr>
				<td height="20" align="right"><span class="letraDocumentoTitulo">NOMBRE M&Eacute;DICO TRATANTE:</span></td>
				<td align="right">&nbsp;</td>
				<td align="left"><span class="letraDocumento" style="padding-left:15;"><?php echo $nombreMedicoTratante; ?></span></td>
			</tr>
		</table></td>
	</tr>
	<tr>
		<td><table width="100%" border="0" cellspacing="0" cellpadding="0">
			<tr>
				<td height="36" align="left" valign="bottom" class="letraDocumentoTitulo"><strong>Antecedentes Personales</strong></td>
			</tr>
			<tr>
				<td height="28" valign="bottom" class="letraDocumento" style="padding-left:10px;"><div align="justify" class="letraDocumento"><span class="letraDocumento" style="padding-left:10px;"><?php echo $antecedentesPersonales; ?></span></div></td>
				</tr>
		</table></td>
	</tr>
	<tr>
		<td><table width="100%" border="0" cellspacing="0" cellpadding="0">
			<tr>
				<td height="36" align="left" valign="bottom" class="letraDocumentoTitulo"><strong>Antecedentes M&oacute;rbidos (incluye antecedentes psiqui&aacute;tricos)</strong></td>
			</tr>
			<tr>
				<td height="28" valign="bottom" style="padding-left:10px;"><div align="justify" class="letraDocumento"><?php echo $antecedentesMorbidos; ?></div></td>
				</tr>
		</table></td>
	</tr>
	<tr>
		<td><table width="100%" border="0" cellspacing="0" cellpadding="0">
			<tr>
				<td height="36" align="left" valign="bottom" class="letraDocumentoTitulo"><strong>Factores estresantes</strong></td>
			</tr>
			<tr>
				<td height="28" valign="bottom" style="padding-left:10px;"><div align="justify" class="letraDocumento"><?php echo $factoresEstresantes; ?></div></td>
				</tr>
		</table></td>
	</tr>
	<tr>
		<td><table width="100%" border="0" cellspacing="0" cellpadding="0">
			<tr>
				<td height="36" align="left" valign="bottom" class="letraDocumentoTitulo"><strong>&iquest;Existe alg&uacute;n grado de estr&eacute;s laboral?</strong></td>
			</tr>
			<tr>
				<td height="28" valign="bottom" class="letraDocumento" style="padding-left:10px;"><?php echo ucfirst(strtolower($existeEstresLaboral)); ?>&nbsp;</td>
				</tr>
		</table></td>
	</tr>
	<tr>
		<td><table width="100%" border="0" cellspacing="0" cellpadding="0">
			<tr>
				<td height="36" align="left" valign="bottom" class="letraDocumentoTitulo"><strong>Anamnesis</strong></td>
			</tr>
			<tr>
				<td height="28" valign="bottom" style="padding-left:10px;"><div align="justify" class="letraDocumento"><?php echo $anamnesis; ?></div></td>
				</tr>
		</table></td>
	</tr>
	<tr>
		<td><table width="100%" border="0" cellspacing="0" cellpadding="0">
			<tr>
				<td height="36" align="left" valign="bottom" class="letraDocumentoTitulo"><strong> Examen Mental </strong></td>
			</tr>
			<tr>
				<td height="28" valign="bottom" style="padding-left:10px;"><div align="justify" class="letraDocumento"><?php echo $examenMental; ?></div></td>
				</tr>
		</table></td>
	</tr>
	<tr>
		<td><table width="100%" border="0" cellspacing="0" cellpadding="0">
			<tr>
				<td height="36" align="left" valign="bottom" class="letraDocumentoTitulo"><strong> Tratamiento	Actual	(detallar	f&aacute;rmacos	y	dosis) </strong></td>
			</tr>
			<tr>
				<td height="28" valign="bottom" style="padding-left:10px;"><div align="justify" class="letraDocumento"><?php echo $tratamientoActual; ?></div></td>
				</tr>
		</table></td>
	</tr>
	<tr>
		<td><table width="100%" border="0" cellspacing="0" cellpadding="0">
			<tr>
				<td height="36" align="left" valign="bottom" class="letraDocumentoTitulo"><strong>Opini&oacute;n Sobre Tratamiento Actual</strong></td>
			</tr>
			<tr>
				<td height="28" valign="bottom" style="padding-left:10px;"><div align="justify" class="letraDocumento"><?php echo ucfirst(strtolower($opinionTratamiento)); ?></div></td>
				</tr>
		</table></td>
	</tr>
	<tr>
		<td><table width="100%" border="0" cellspacing="0" cellpadding="0">
			<tr>
				<td height="36" align="left" valign="bottom" class="letraDocumentoTitulo"><strong>Comentario Sobre Tratamiento Actual</strong></td>
			</tr>
			<tr>
				<td height="28" valign="bottom" style="padding-left:10px;"><div align="justify" class="letraDocumento"><?php echo $comentarios; ?></div></td>
				</tr>
		</table></td>
	</tr>
	<tr>
		<td><table width="100%" border="0" cellspacing="0" cellpadding="0">
			<tr>
				<td height="36" align="left" valign="bottom" class="letraDocumentoTitulo"><strong> Diagn&oacute;stico	de	Licencia	M&eacute;dica </strong></td>
			</tr>
			<tr>
				<td height="28" valign="bottom" style="padding-left:10px;"><div align="justify" class="letraDocumento"><?php echo $diagnosticoLicenciaMedica; ?></div></td>
				</tr>
		</table></td>
	</tr>
	<tr>
		<td><table width="100%" border="0" cellspacing="0" cellpadding="0">
			<tr>
				<td height="36" align="left" valign="bottom" class="letraDocumentoTitulo"><strong> Opini&oacute;n Sobre el Diagn&oacute;stico de la Licencia M&eacute;dica</strong></td>
			</tr>
			<tr>
				<td height="28" valign="bottom" style="padding-left:10px;"><div align="justify" class="letraDocumento"><?php echo ucfirst(strtolower($opinionSobreDiagnostico)); ?></div></td>
				</tr>
		</table></td>
	</tr>
	<tr>
		<td><table width="100%" border="0" cellspacing="0" cellpadding="0">
			<tr>
				<td height="36" align="left" valign="bottom" class="letraDocumentoTitulo"><strong> Diagn&oacute;stico del Perito</strong></td>
			</tr>
			<tr>
				<td height="36" align="left" valign="bottom" class="letraDocumentoTitulo" style="padding-left:5px;"><strong>Eje I</strong></td>
			</tr>
			<tr>
				<td height="28" valign="bottom" style="padding-left:10px;"><div align="justify" class="letraDocumento"><?php echo $eje1; ?></div></td>
				</tr>
		</table></td>
	</tr>
	<tr>
		<td><table width="100%" border="0" cellspacing="0" cellpadding="0">
			<tr>
				<td height="36" align="left" valign="bottom" class="letraDocumentoTitulo" style="padding-left:5px;"><strong>Eje II</strong></td>
			</tr>
			<tr>
				<td height="28" valign="bottom" style="padding-left:10px;"><div align="justify" class="letraDocumento"><?php echo $eje2; ?></div></td>
				</tr>
			<tr>
				<td height="36" align="left" valign="bottom" class="letraDocumentoTitulo" style="padding-left:5px;"><strong>Eje III</strong></td>
			</tr>
			<tr>
				<td height="28" valign="bottom" style="padding-left:10px;"><div align="justify" class="letraDocumento"><?php echo $eje3; ?></div></td>
				</tr>
			<tr>
				<td height="36" align="left" valign="bottom" class="letraDocumentoTitulo" style="padding-left:5px;"><strong>Eje IV</strong></td>
			</tr>
			<tr>
				<td height="28" valign="bottom" style="padding-left:10px;"><div align="justify" class="letraDocumento"><?php echo $eje4; ?></div></td>
				</tr>
			<tr>
				<td height="36" align="left" valign="bottom" class="letraDocumentoTitulo" style="padding-left:5px;"><strong>Eje V</strong></td>
			</tr>
			<tr>
				<td height="28" valign="bottom" style="padding-left:10px;"><div align="justify" class="letraDocumento"><?php echo $eje5; ?></div></td>
				</tr>
			<tr>
				<td height="36" align="left" valign="bottom" class="letraDocumentoTitulo"><strong>Opini&oacute;n Sobre el Reposo M&eacute;dico</strong></td>
			</tr>
			<tr>
				<td height="28" valign="bottom" style="padding-left:10px;"><div align="justify" class="letraDocumento"><?php echo ucfirst(strtolower($opinionReposoMedico)); ?></div></td>
				</tr>
		</table></td>
	</tr>
	<tr>
		<td><table width="100%" border="0" cellspacing="0" cellpadding="0">
			<tr>
				<td height="36" align="left" valign="bottom" class="letraDocumentoTitulo"><strong>Si el Reposo Corresponde, Especifique</strong></td>
			</tr>
			<tr>
				<td height="28" valign="bottom" style="padding-left:10px;"><div align="justify" class="letraDocumento"><?php echo ucfirst(strtolower($siReposoCorresponde)); ?></div></td>
				</tr>
		</table></td>
	</tr>
	<tr>
		<td><table width="100%" border="0" cellspacing="0" cellpadding="0">
			<tr>
				<td height="36" align="left" valign="bottom" class="letraDocumentoTitulo"><strong>Cu&aacute;ntos D&iacute;as de Reposo Corresponden a Partir de Esta Fecha</strong></td>
			</tr>
			<tr>
				<td height="28" valign="bottom" style="padding-left:10px;"><div align="justify" class="letraDocumento"><?php echo $cuantosDiasReposo; ?></div></td>
				</tr>
		</table></td>
	</tr>
	<tr>
		<td><table width="100%" border="0" cellspacing="0" cellpadding="0">
			<tr>
				<td height="36" align="left" valign="bottom" class="letraDocumentoTitulo"><strong>Comentario Sobre el Reposo</strong></td>
			</tr>
			<tr>
				<td height="28" valign="bottom" style="padding-left:10px;"><div align="justify" class="letraDocumento"><?php echo $comentarios2; ?></div></td>
				</tr>
		</table></td>
	</tr>
	<tr>
		<td height="143" align="center" valign="bottom">
			<br />
			<?php
			$nombreImagen = $idPrestador.'.jpg';
			
			if(file_exists('../../templates/defecto/imagenes/firmas/'.$nombreImagen) == true)
			{
				redimensionar_jpeg('../../templates/defecto/imagenes/firmas/'.$nombreImagen, '../../templates/defecto/imagenes/firmas/'.$nombreImagen, 354, 170, 100);
				?>
				<img src="../../templates/defecto/imagenes/firmas/<?php echo $nombreImagen; ?>"/>
				<?php 
			}
			?>
		</td>
	</tr>
	<tr>
		<td align="center">
		
		<table width="300" border="0" align="center" cellpadding="0" cellspacing="0">
			<tr>
				<td><img src="<?php echo $IMAGENES2; ?>/linea.gif" width="300" height="1" /></td>
			</tr>
		</table>
		
		<table width="289" height="20" border="0" align="center" cellpadding="0" cellspacing="0" class="letraDocumento1">
			<tr>
				<td align="center">Dr(a). <?php echo $nombreCompletoPrestador; ?><br />
					<?php echo $rutPrestador; ?></td>
			</tr>
		</table></td>
	</tr>
</table>
</page>

<?php 
	$content = ob_get_clean();
	$html2pdf = new HTML2PDF('P','Letter','es', array(10, 10, 10, 10));
	$html2pdf->WriteHTML($content, isset($_GET['vuehtml']));
	$html2pdf->Output('Informe.pdf');
?>