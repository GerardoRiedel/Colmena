<?php 
	session_name("agenda2");
	session_start();

	include('../../../lib/pacientes/funciones.php');
	include('../../../lib/isapres/funciones.php');
	include('../../../lib/usuarios/funciones.php');
	include('../../../lib/horas/funciones.php');
	include('../../../lib/prestadores/funciones.php');
	include('../../../lib/informe_trauma/funciones.php');
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
        $nombresPaciente = utf8_decode(caracteres_html_inversa($registrosHora['nombres']));
        $apellidoPaternoPaciente = $registrosHora['apellidoPaterno'];
        $apellidoMaternoPaciente = $registrosHora['apellidoMaterno'];
        $telefonoPaciente = $registrosHora['telefono'];
        $celularPaciente = $registrosHora['celular'];
        $emailPaciente = $registrosHora['email'];
        $direccionPaciente =$registrosHora['direccion'];
        $idComunaPaciente = $registrosHora['comuna'];
        $isapreHora = $registrosHora['isapre'];
        $observacionHora =$registrosHora['observacion'];
        $idCiudad = $registrosHora['ciudad'];
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
			$link[url] = 'informeEntrevistaTraumatologico';
			$link[urlIsapre] = 'chk_informeEntrevistaTraumatologicoNuevo';
		}
		else
		{
			$link[url] = 'informeEntrevistaTraumatologico';
			$link[urlIsapre] = 'chk_informeEntrevistaTraumatologicoNuevo';
		}
		//LINK PARA AGENDA ANTIGUA
		/////////////////////////////////////////////////////////////////////
		
		$datosInforme = datosInformeHora($idHora, $conectar);
		$fechaAntes = strtotime ( '-7 day' , strtotime ( $fecha ) ) ;
		$fechaAntes=date ( 'Y-m-d' , $fechaAntes );
		$nuevafecha = strtotime ( '+7 day' , strtotime ( $fecha ) ) ;
		$nuevafecha = date ( 'Y-m-d' , $nuevafecha );
	}
	else//La hora no tiene paciente
	{
        $nombreUsuario = nombreUsuario($_SESSION['idUsuario'], $conectar);
        $fecha = $_GET['fecha'];
        $usuario = $_SESSION['idUsuario'];
        $idCiudad = $_GET['idCiudad'];
        $ciudad = nombreCiudad($idCiudad, $conectar);
        // $ciudad = $_GET['idCiudad'];
        $fechaAntes = strtotime ( '-7 day' , strtotime ( $fecha ) ) ;
        $fechaAntes=date ( 'Y-m-d' , $fechaAntes );
        $nuevafecha = strtotime ( '+7 day' , strtotime ( $fecha ) ) ;
        $nuevafecha = date ( 'Y-m-d' , $nuevafecha );
	}
?>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">


<script language="javascript" src="../../../lib/jquery/1.11.1/jquery-1.11.1.min.js"></script>
<script language="javascript" src="../../../lib/jquery-validation/js/jquery.validate.min.js"></script>
<script language="javascript" src="../../../lib/validajs/formagregarhora.js"></script>

<script type="text/javascript" src="../../../lib/alertifyjs1.6/alertify.min.js"></script>

<link rel="stylesheet" href="../../../lib/alertifyjs1.6/css/alertify.min.css" />
<link rel="stylesheet" href="../../../lib/alertifyjs1.6/css/themes/default.min.css" />

<style>
    .error {
        color:red;
        display:none;
    }
</style>



<script>
//autocompletar formulario
	jQuery(document).ready(function(){
		$("#rut").bind("blur", function(e){

		$.getJSON("<?php echo $LIB; ?>/querys/pacientesAutocompletar.php?rut=" + $("#rut").val(),
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
				else if (item.field == "direccion")
					$("#direccion").val(item.value);
			  });
			});
		});
	});
function nombre_valido(valor) {
    var reg = /^([a-z ñáéíóú]{2,60})$/i;
    if (reg.test(valor)) return true;
    else return false;
}
	function confirmar()
	{
		if(confirm('¿Está seguro de eliminar esta hora?'))
		{
			window.location.href = '<?php echo $MODULOS; ?>/agenda/chk_eliminarHora.php?id=<?php echo $idHora; ?>';
		}
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
	function digito2(T) {
	nuevo_numero = T.toString().split("").reverse().join("");
	for(i=0,j=2,suma=0; i < nuevo_numero.length; i++, ((j==7) ? j=2 : j++)) {
		suma += (parseInt(nuevo_numero.charAt(i)) * j);
	}
	n_dv = 11 - (suma % 11);
	return ((n_dv == 11) ? 0 : ((n_dv == 10) ? "K" : n_dv));
}
	
	
	
	function popUp2(URL)
	{
		day = new Date();
		id = day.getTime();
		
		eval("page" + id + " = window.open(URL, 'popUp2', 'toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=0,width=900,height=700,left=150,top=50');");
	}


function validarIngreso(form)
{

	if (form.rut.value.length >'0')

		document.getElementById("rut").required = true;





}
function reservarHoraTruma(){

    var data = $("#formtmt").serialize();
    alertify.confirm('Reserva Hora',"<h1>Confirma Reserva.</h1>",
        function(){
            $.ajax({
                type: "POST",
                url: "chk_agregarHoratrauma.php",
                data : data,
                success: function( respuesta ){
                    var largo = respuesta.length;

                    //  alert (largo);
                    // $('#mensaje').html(respuesta);
                    if (largo < '21'){
                        alertify.error('<h2>'+respuesta+'</h2>');

                    }else{
                        alertify.success("Hora Agendada...!");
                        enviarcorreo();
                    }

                }});
            ModificaPaciente();
            
        },
        function(){
            alertify.error('Cancel');
        });


    //  window.location.reload(true);
    // var ventana = window.self;
    // ventana.opener=window.self;
    //  window.close();
}
function enviarcorreo(){

    var data = $("#formtmt").serialize();


    $.ajax({
        type: "POST",
        url: "../envioemail/reservahora.php",
        data: data,

        success: function( respuesta ){
            //  $('#mensaje').html(respuesta);
            alertify.warning("<span>"+respuesta+"</span>");

        }});
}


	function llamadaHP(){
		var id = document.getElementById("idpaciente").value;
		var desde = document.getElementById("desde").value;
		var hasta = document.getElementById("hasta").value;
		$.ajax({
			type: "POST",
			url: "../../../lib/querys/horaprevia.php",
			data: "idpaciente="+id+"&desde="+desde+"&hasta="+hasta,

				success: function( respuesta ){
					if (respuesta == '0')

						$("#horaprevia").val(respuesta);
					else
						$("#horaprevia").val(respuesta);
					// alert ('Hora Previa');


				}});

	}
function ModificaPaciente(){

    var idHora = document.getElementById("idHora").value;
    var rut = document.getElementById("rut").value;
    var nombres = document.getElementById("nombres").value;
    var apellidoPaterno = document.getElementById("apellidoPaterno").value;
    var apellidoMaterno = document.getElementById("apellidoMaterno").value;
    var telefono = document.getElementById("telefono").value;
    var celular = document.getElementById("celular").value;
    var email = document.getElementById("email").value;
    var direccion = document.getElementById("direccion").value;
    var comuna = document.getElementById("comuna").value;
    var isapre = document.getElementById("isapre").value;
    var usuario = document.getElementById("idUsuario").value;
    var numerolicencia = document.getElementById("numerolicencia").value;
    var observacion = document.getElementById("observacion").value;
    var prestador = document.getElementById("idPrestador").value;
    var idCiudad = document.getElementById("idCiudad").value;
    var total = document.getElementById("horaprevia").value;
    var hora = document.getElementById("idHora").value ;


    $.ajax({
        type: "POST",
        url: "chk_PacienteHora.php",
        data: "idHora="+idHora+"&rut="+rut+"&nombres="+nombres+"&apellidoPaterno="+apellidoPaterno+"&apellidoMaterno="+apellidoMaterno+"&telefono="+telefono+"&celular="+celular+"&email="+email+"&direccion="+direccion+"&comuna="+comuna+"&isapre="+isapre+"&usuario="+usuario+"&numerolicencia="+numerolicencia+"&observacion="+observacion+"&prestador="+prestador+"&idCiudad="+idCiudad,

        success: function( respuesta ){
            alertify.success("<span>"+respuesta+"</span>");
            window.opener.location.reload();
        }

    });
}
function actualizatmp(){

	var idHora = document.getElementById("idHora").value;
	var rut = document.getElementById("rut").value;
	var nombres = document.getElementById("nombres").value;
	var apellidoPaterno = document.getElementById("apellidoPaterno").value;
	var apellidoMaterno = document.getElementById("apellidoMaterno").value;
	var telefono = document.getElementById("telefono").value;
	var celular = document.getElementById("celular").value;
	var email = document.getElementById("email").value;
	var direccion = document.getElementById("direccion").value;
	var comuna = document.getElementById("comuna").value;
	var isapre = document.getElementById("isapre").value;
	var usuario = document.getElementById("idUsuario").value;
	var numerolicencia = document.getElementById("numerolicencia").value;
	var observacion = document.getElementById("observacion").value;
	var prestador = document.getElementById("idPrestador").value;
	var idCiudad = document.getElementById("idCiudad").value;
	$.ajax({
		type: "POST",
		url: "chk_agregarHora.php",
		data: "idHora="+idHora+"&rut="+rut+"&nombres="+nombres+"&apellidoPaterno="+apellidoPaterno+"&apellidoMaterno="+apellidoMaterno+"&telefono="+telefono+"&celular="+celular+"&email="+email+"&direccion="+direccion+"&comuna="+comuna+"&isapre="+isapre+"&usuario="+usuario+"&numerolicencia="+numerolicencia+"&observacion="+observacion+"&prestador="+prestador+"&idCiudad="+idCiudad,

		success: function( respuesta ){

				var ventana = window.self;
				ventana.opener=window.self;
				alert("registro actualizado..");
			window.close();

		}});

}

$(document).ready(function() {
    /*$('#btreserva').click(function() {
        // Recargo la página
        
        window.opener.location.reload(); //to refresh parent window.
    });*/
});

</script>




<link href="../../templates/defecto/estilos.css" rel="stylesheet" type="text/css">
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
								
								<td width="73%" align="left" valign="middle" class="letraDocumentoTitulo"><span onclick="popUp2('<?php echo $link[url]; ?>.php?hora=<?php echo $idHora; ?>'); window.close();" style="cursor:pointer;"><img src="<?php echo $IMAGENES2; ?>/edit.png" width="16" height="16" border="0"/> EDITAR Informe Entrevista Traumatologico de Peritaje</span></td>
							</tr>
                        <?php //preguntar si existe informe
						$sqlExiste = mysql_query("SELECT id	FROM informe_traumatologico WHERE hora='".$idHora."'", $conectar);
						$total = mysql_num_rows($sqlExiste);					
						if ($total > 0)
						{
						?>
							<!--<tr>
								<td width="73%" align="left" valign="middle" class="letraDocumentoTitulo"><span onclick="popUp2('chk_informeEntrevistaSegundaDescargaNuevo.php?id=<?php// echo $idHora; ?>'); window.close();" style="cursor:pointer;"><img src="<?php// echo $IMAGENES2; ?>/pdf.png" width="16" height="16" border="0"/> VER Informe Entrevista Traumatologico de Peritaje</span></td>
							</tr>-->
<tr>
								<td width="73%" align="left" valign="middle" class="letraDocumentoTitulo"><span onclick="popUp2('chk_informeEntrevistaTraumatologicoDescarga.php?id=<?php echo $idHora; ?>'); window.close();" style="cursor:pointer;"><img src="<?php echo $IMAGENES2; ?>/pdf.png" width="16" height="16" border="0"/> VER Informe Entrevista Traumatologico de Peritaje</span></td>
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
					if(tipoUsuario($_SESSION['idUsuario'], $conectar) == 'isapre' and $datosInforme['publicado'] == 'SI')
					{
						?>
						<table width="426" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td width="73%" align="left" valign="middle" class="letraDocumentoTitulo"><span onclick="popUp2('chk_informeEntrevistaTraumatologicoDescarga.php?id=<?php echo $idHora; ?>'); window.close();" style="cursor:pointer;"><img src="<?php echo $IMAGENES2; ?>/edit.png" width="16" height="16" border="0"/> Informe Entrevista Traumatologico de Peritaje</span></td>
							</tr>
						</table>
					<?php 
					}
					if(asisteHora($idHora, $conectar) == false && diferenciaHoraActualHora($idHora, $conectar) >= 72)
					{
						?>
						<table width="426" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td width="73%" align="left" valign="middle" class="letraDocumentoTitulo"><span onclick="window.location.href='chk_certificadoInasistencia.php?id=<?php echo $idHora; ?>'" style="cursor:pointer;"><img src="<?php echo $IMAGENES2; ?>/date_magnify.png" width="16" height="16" border="0"/> Certificado de inasistencia</span></td>
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
						<a onclick="confirmar();" style="cursor:pointer;">Eliminar <img src="<?php echo $IMAGENES2; ?>/eliminar.png" width="16" height="16" border="0" /></a>
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
						<span class="letraDocumentoTitulo" style="cursor:pointer;" onclick="window.location.href='isapreHora.php?hora=<?php echo $idHoraPrestador; ?>'"> <img src="<?php echo $IMAGENES2; ?>/arrow_refresh.png" width="16" height="16" border="0"/> Vinculación con Isapre</span>
					</td>
					<td width="50%">&nbsp;</td>
				</tr>
			</table>					
			<?php 
		}
	}
?>
		<br />
<form id="formtmt" name="formtmt" method="post"  action="">
	<table width="90%" border="0" align="center" cellpadding="0" cellspacing="0" class="borde_tabla" style="border-collapse:collapse;">
		<tr>
			<td height="29" colspan="2" align="center" bgcolor="#AACCFF" class="tituloTablas">Reserva de Hora (<?php echo $ciudad; ?>)</td>
		</tr>
		<tr>
			<td height="30" align="right" class="letra7" style="padding-right:10px;">Fecha y Hora: </td>
			<td class="letra7" style="padding-left:10px;"><?php echo formatearFechaHora ($fecha); ?></td>
		</tr>
		<tr>
			<td width="50%" height="30" align="right" class="letra7" style="padding-right:10px;">RUT:</td>
			<td class="letra7" style="padding-left:10px;"><?php
                if($idHora != NULL and diferenciaHoraActualHora($idHora, $conectar) < 48  and tipoUsuario($_SESSION['idUsuario'], $conectar) != 'administrador')
                {
                    ?>
                    <label>
                        <input name="rut" type="text" class="letra7" id="rut" onblur="digito(this.form);llamadaHP()"  value="<?php echo $rutPaciente; ?>" size="10" maxlength="10" readonly/>
                    </label>-
                    <label>
                        <input name="dv" type="text" id="dv" size="1" readonly value="<?php echo $dv; ?>"/>
                    </label>
                    <?php
                }
                else
                {
                    ?>
                    <input name="rut" type="text" class="letra7" id="rut"  onblur="digito(this.form)" value="<?php echo $rutPaciente; ?>" size="10" maxlength="10" />
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
				<input name="nombres" type="text" class="letra7" id="nombres" value="<?php echo utf8_encode($nombresPaciente); ?>" size="30" <?php
				if($idHora != NULL and diferenciaHoraActualHora($idHora, $conectar) > 48 and tipoUsuario($_SESSION['idUsuario'], $conectar) != 'administrador')
				{
					?>readonly="readonly"<?php
				}
?> onblur="llamadaHP()"/>
				</label>
			</td>
		</tr>
		<tr>
			<td height="30" align="right" class="letra7" style="padding-right:10px;">Apellido Paterno: </td>
			<td class="letra7" style="padding-left:10px;">
				<label>
				<input name="apellidoPaterno" type="text" class="letra7" id="apellidoPaterno" onclick="llamadaHP()" value="<?php echo utf8_encode($apellidoPaternoPaciente); ?>" size="30" <?php
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
						<select name="isapre" class="letra7" id="isapre" onmouseover="llamadaHP();" onclick="llamadaHP()">
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
                <input name="desde" type="hidden" id="desde" value="<?php echo $fechaAntes; ?>" />
                <input name="hasta" type="hidden" id="hasta" value="<?php echo $nuevafecha; ?>" />
                <input name="horaprevia" type="hidden"  id="horaprevia" value="" />

                <input name="perfil" type="hidden" id="perfil" value="<?php echo tipoUsuario($_SESSION['idUsuario'], $conectar) ; ?>" />
                <input name="idHora" type="hidden" id="idHora" value="<?php echo $idHora; ?>" >
                <input name="fecha" type="hidden" id="fecha" value="<?php echo $fecha; ?>" >
                <input name="idCiudad" type="hidden" id="idCiudad" value="<?php echo $idCiudad; ?>" >
                <input name="idPrestador" type="hidden" id="idPrestador" value="<?php echo $idPrestador; ?>" >
                <input name="idUsuario" type="hidden" id="idUsuario" value="<?php echo  $_SESSION['idUsuario']; ?>" >
                <input name="idpaciente" type="hidden" id="idpaciente" value="<?php echo $idPaciente; ?>" >
								
				<label>

                    <input id="btreserva" name="btreserva" type="submit" value="Reservar"  onmouseover="llamadaHP()" class="boton"   />

                </label>
			</td>
		</tr>
	</table>
</form>
<div id="result"></div>
