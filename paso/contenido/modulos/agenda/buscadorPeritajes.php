<?php 
	session_name("agenda2");
	session_start();

	include('../../../lib/datos.php');
	include('../../../lib/funciones.php');
	include('../../../lib/conectar.php');
	
	$conectar = conectar();
	
?>

<script>
	function validar(form)
	{
		if(form.rut.value == '')
		{
			alert("Ingrese el RUT");
			return false;
		}
		else
		{
			form.submit();
		}
	}
</script>

<script language="javascript" src="<?php echo $LIB; ?>/numeros.js"></script>

<link href="../../templates/defecto/estilos.css" rel="stylesheet" type="text/css">

<br />
<br />
<br />
<form id="form1" name="form1" method="post" action="buscadorPeritajes2.php" onsubmit="return validar(this);">
	<table width="400" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF" class="bordeTabla1">
		<tr>
		  <td height="23" colspan="2" align="center" class="campoTituloTabla">Buscador de peritajes</td>
	  </tr>
		<tr>
			<td width="41%" height="41" align="right" class="letra7" style="padding-right:10px;">RUT del paciente:</td>
			<td width="59%" align="left">
				<label>
				<input name="rut" type="text" class="letra7" id="rut" onKeyUp="puntitos(this,this.value.charAt(this.value.length -1))"/>
				</label>
	        <span class="letra7">sin dv </span></td>
		</tr>
		<tr align="right">
			<td colspan="2" align="center" style="padding-left:10px;">
				<br />
				<input name="Submit" type="submit" class="boton" value="Siguiente" />
				<br />
				<br />
			</td>
		</tr>
	</table>
</form>
