<?php 
ini_set('session.bug_compat_warn', 0);
ini_set('session.bug_compat_42', 0);
	session_name("agenda2");
	session_start();
	include_once('../../../lib/funciones.php');
	include('../../../lib/datos.php');
	include('../../../lib/usuarios/funciones.php');
	include('../../../lib/horas/funciones.php');
	include('../../../lib/pacientes/funciones.php');
	include('../../../lib/conectar.php');
	date_default_timezone_set('America/Santiago');	 
	$conectar = conectar();
	if(siEstaLogueado() == false)
	{
	header('Location: '.$HOME);
	}
	$idHora = $_REQUEST['idHora'];
	$rut = SacarPunto($_REQUEST['rut']);
	$nombres = $_REQUEST['nombres'];
	$apellidoPaterno =$_REQUEST['apellidoPaterno'];
	$apellidoMaterno =  $_REQUEST['apellidoMaterno'];
	$telefono = $_REQUEST['telefono'];
	$celular = $_REQUEST['celular'];
	$email = $_REQUEST['email'];
	$direccion = $_REQUEST['direccion'];
	$comuna = $_REQUEST['comuna'];
	$isapre = $_REQUEST['isapre'];
	$usuario = $_REQUEST['idUsuario'];
	$numerolicencia = $_REQUEST['numerolicencia'];
	$observacion = $_REQUEST['observacion'];
	$prestador = $_REQUEST['idPrestador'];
	$idCiudad = $_REQUEST['idCiudad'];
   	$fechahora = $_REQUEST['fecha'];
    //Incrementando 7 dias
//include('../../../ws/colmena/metodos/reagendamientoHoraColmena.php');

$msj ='';
$desde = date('Y-m-d H:i:s',strtotime('-30 day +0 hour +0 minutes +0 seconds',strtotime($fechahora)));
$hasta = date('Y-m-d H:i:s',strtotime('+30 day +0 hour +0 minutes +0 seconds',strtotime($fechahora)));
if (empty($_REQUEST['idpaciente'])){
    $idpaciente = idPaciente($rut,$conectar);
}else{
    $idpaciente = $_REQUEST['idpaciente'];
}
if (!empty($idHora) ) {
    editarPaciente($paciente, $rut, $nombres, $apellidoPaterno, $apellidoMaterno, $direccion, $comuna, $telefono, $celular, $email, $isapre , $conectar);

    if (empty($numerolicencia)) {
        $numerolicencia = 0 ;
    }else {
        $numerolicencia = $numerolicencia ;
    }
    editarHora2($idHora, $paciente, $isapre, $observacion,$numerolicencia, $conectar);
    editarIsapreHora($idHora, $isapre, $conectar);
    agregarLog($_SERVER['HTTP_REFERER'], $_SESSION['idUsuario'], nombreUsuario($_SESSION['idUsuario'], $conectar), date('Y-m-d H:i:s'), 'Editar hora - hora: '.$idHora, $conectar);
    $msj .= nl2br("Hora editada\n");
$duplicado= siExisteHoraPrevia($idpaciente,$desde,$hasta,$conectar) ;
if ($duplicado >=1 ){
	$msj .= nl2br("Paciente tiene Hora Previa\n");
}

//$resuenvio = emailreserva ($idHora,$conectar);
//    $msj .= nl2br($resuenvio);

} elseif (isset($idHora)){
    $hora = $_REQUEST['fecha'];
    $paciente = idPaciente($rut, $conectar);
    date_default_timezone_set ('America/Santiago');
    $time = time();
    $hora_agendamiento =  date("Y-m-d H:i:s", $time);
       
        if(siExisteHora($hora, $idCiudad, $prestador, $conectar) != false)
        {
           $msj .= nl2br('ERROR: La hora ya fue tomada');
            exit;
        }
        crearPaciente($rut, $nombres, $apellidoPaterno, $apellidoMaterno, $direccion, $comuna, $telefono, $celular, $email, $isapre , $conectar);
    
       $idHora = crearHora($usuario, $hora,$hora_agendamiento , $idCiudad, $paciente, $prestador, $isapre, '', $observacion,$numerolicencia, $conectar);
        
    agregarLog($_SERVER['HTTP_REFERER'], $_SESSION['idUsuario'], nombreUsuario($_SESSION['idUsuario'], $conectar), $hora_agendamiento, 'Agregar hora - hora: '.$idHora, $conectar);
        $msj  .= nl2br("Nueva Hora se ha Tomada\n" );

$duplicado= siExisteHoraPrevia($paciente,$desde,$hasta,$conectar) ;

if ($duplicado >=1 ){

	$msj .= nl2br("Paciente tiene Hora Previa\n");

}		
//	header('Location: '.$TEMPLATE_DIR2.'/mensajesPopup.php');
        //$resuenvio = emailreserva ($idHora,$conectar) ;
        //$msj  .= nl2br('Nro. Hora'.$resuenvio);

}else{
	$msj  = nl2br("error en los datos" );
}

//METODO PARA REAGENDAMIENTO EN COLMENA, LUEGO DE HABER REALIZADO EL PROCESO DE REAGENDAMIENTO CORRESPONDIENTE
        include('../../../ws/colmena/metodos/reagendamientoHoraColmena.php');
//$msj = $data_string;
echo $msj ;

?>