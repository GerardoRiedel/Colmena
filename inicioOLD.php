<?php
        $clave_aplicacion = "cetep_";
	$clave_compartida = "Colmena";
	$paso1 = $clave_compartida . date("d-m-Y");
        //ESTAS LINEA SON DE PRUEBA PARA GENERAR TOKEN VALIDO
        $paso2 = hash_hmac("sha256", $paso1, $clave_compartida);
        $paso3 = base64_encode($paso2);
        $paso4 = $clave_aplicacion . $paso3;
        $tok = $paso4;
?>
<html>
    <head>
        
    </head>
    <body>
        <b>TOKEN: </b><?php echo $tok; ?><br><br>
        <form method='post' onSubmit="ConsultarListaEspera(this)">
            <b>Consultar Lista de Espera</b><br>  
            <input type="submit" value="ConsultarListaEspera"><br>
        </form>
        <form method='post' name='SincronizarAgenda' onSubmit="obtenerSincronizarAgenda(this)">
            <b>Sincronización de agenda</b><br>    
            Fecha de Inicio: <input type="date" name="fechaI"><br>
            Fecha de Termino: <input type="date" name="fechaF"><br>
            <input type="submit" value="SincronizarAgenda"><br>
        </form>
        <form method='post' name='ConsultarHoraExterna' onSubmit="obtenerConsultarHoraExterna(this)">
            <b>Consulta de Horas Externa</b><br>
            Ciudad: <select name="ciudad">
                <option value="13101">Santiago CTU:13101</option>
                <option value="8101">Concepcion CTU:8101</option>
            </select><br>
            Fecha Termino Licencia: <input type="date" name="fechaF"><br>
            Seleccion fuera de plazo:   <select name="estado">
                                            <option value="1">1: Fuera de plazo</option>
                                            <option value="0">0: Dentro de plazo</option>
                                        </select><br>
            <input type="submit" value="ConsultarHoraExterna"><br>
        </form>
        <form method='post' name='RecepcionInforme' onSubmit="obtenerRecepcionInforme(this)">
            <b>Recepcion de Informe</b><br>
            Id Hora: <input type="number" name="hora"><br>
            N° Licencia: <input type="number" name="licencia"><br>
            IOR: <input type="number" name="estado" value="3" style="width: 40px"><br>
            URL de Informe: <input type="text" name="url" ><br>
            <input type="submit" value="RecepcionInforme"><br>
        </form>
        <form method='post' name='consultaExpediente' onSubmit="obtenerConsultaExpediente(this)">
            <b>Consulta Expediente</b><br>
            Id Hora: <input type="number" name="hora"><br>
            N° Licencia: <input type="number" name="licencia"><br>
            IOR: <input type="number" name="estado" value="3" style="width: 40px"><br>
            <input type="submit" value="ConsultaExpediente"><br>
        </form>
        <form method='post' onSubmit="obtenerAnularHora(this)">
            <b>Anulacion de Hora</b><br>
            Id Hora: <input type="number" name="hora"><br>
            N° Licencia: <input type="number" name="licencia"><br>
            IOR: <input type="number" name="estado" value="3" style="width: 40px"><br>
            <input type="submit" value="AnularHora"><br>
        </form>
        <form method='post' onSubmit="obtenerEstadoListaEsperaColmena(this)">
            <b>Lista de Espera</b><br>
            Fecha: <input type="date" name="fecha"><br>
            IOR: <input type="number" name="estado" value="3" style="width: 40px"><br>
            <input type="submit" value="EstadoListaEspera"><br>
        </form>
        <form method='post' onSubmit="reagendarHora(this)">
            <b>Reagendamiento</b><br>
            Rut Paciente: <input type="text" name="paciente"><br>
            Hora a anular: <input type="datetime" name="horaVieja"><br>
            Hora a agendar: <input type="datetime" name="horaNueva"><br>
            <input type="submit" value="ReagendarHora">
        </form>
        
        <form method='post' onSubmit="agendarHora(this)">
            <b>Agendar Hora Nueva</b><br>
            Id Hora: <input type="number" name="hora"><br>
            Rut: <input type="text" name="paciente"><br>
            Nombre: <input type="text" name="nombre"><br>
            Apellido Paterno: <input type="text" name="apePat"><br>
            Apellido Materno: <input type="text" name="apeMat"><br>
            Fecha de Nacimiento<input type="date" name="fechaNac"><br>
            Dirección: <input type="text" name="direccion"><br>
            Ciudad: <select name="ciudad">
                <option value="13101">Santiago CTU:13101</option>
                <option value="8101">Concepcion CTU:8101</option>
            </select><br>
            Telefono: <input type="tel" name="fijo"><br>
            Celular: <input type="tel" name="celu"><br>
            Correo: <input type="text" name="mail"><br>
            Fecha Inicio Licencia: <input type="date" name="licInicio"><br>
            Fecha Fin Licencia: <input type="date" name="licFin"><br>
            URL Expediente: <input type="text" name="url"><br>
            <input type="submit" value="AgendarHora">
        </form>
        
        
    </body>
</html>


<script>
function obtenerSincronizarAgenda(formulario){

	var fechaI = formulario.fechaI.value
	var fechaF = formulario.fechaF.value
        window.open("http://10.0.0.155/apirestcolmena/index.php/SincronizarAgenda/"+fechaI+"/"+fechaF+"/<?php echo $tok; ?>");
    }
function obtenerConsultarHoraExterna(formulario){

	var ciudad = formulario.ciudad.value
	var fechaF = formulario.fechaF.value
        var estado = formulario.estado.value
        window.open("http://10.0.0.155/apirestcolmena/index.php/ConsultarHoraExterna/"+ciudad+"/"+fechaF+"/"+estado+"/<?php echo $tok; ?>");
    }
function obtenerRecepcionInforme(formulario){

	var hora = formulario.hora.value
	var licencia = formulario.licencia.value
        var estado = formulario.estado.value
        var url = formulario.url.value
        window.open("http://10.0.0.155/apirestcolmena/index.php/RecepcionInforme/"+hora+"/"+licencia+"/"+estado+"/"+url+"/<?php echo $tok; ?>");
    }
function obtenerConsultaExpediente(formulario){

	var hora = formulario.hora.value
	var licencia = formulario.licencia.value
        var estado = formulario.estado.value
        window.open("http://10.0.0.155/apirestcolmena/index.php/ConsultaExpediente/"+hora+"/"+licencia+"/"+estado+"/<?php echo $tok; ?>");
    }
function obtenerAnularHora(formulario){

	var hora = formulario.hora.value
	var licencia = formulario.licencia.value
        var estado = formulario.estado.value
        window.open("http://10.0.0.155/apirestcolmena/index.php/AnularHora/"+estado+"/"+hora+"/"+licencia+"/<?php echo $tok; ?>");
    }
function obtenerEstadoListaEsperaColmena(formulario){

	var fecha = formulario.fecha.value
        var estado = formulario.estado.value
        window.open("http://10.0.0.155/apirestcolmena/index.php/EstadoListaEsperaColmena/"+estado+"/"+fecha+"/<?php echo $tok; ?>");
    }
function reagendarHora(formulario){

	var paciente = formulario.paciente.value
        var horaNueva = formulario.horaNueva.value
        var horaVieja = formulario.horaVieja.value
        window.open("http://10.0.0.155/apirestcolmena/index.php/ReagendamientoHora/"+paciente+"/1/2/3/4/5/6/7/8/9/"+horaVieja+"/"+horaNueva+"/<?php echo $tok; ?>");
    }
function ConsultarListaEspera(formulario){

        window.open("http://10.0.0.155/apirestcolmena/index.php/ConsultarListaEspera/<?php echo $tok; ?>");
    }
function agendarHora(formulario){

	var paciente = formulario.paciente.value
        var hora = formulario.hora.value
        var nombre = formulario.nombre.value
        var apePat = formulario.apePat.value
        var apeMat = formulario.apeMat.value
        var fechaNac = formulario.fechaNac.value
        var direccion = formulario.direccion.value
        var ciudad = formulario.ciudad.value
        var fijo = formulario.fijo.value
        var celu = formulario.celu.value
        var mail = formulario.mail.value
        var licInicio = formulario.licInicio.value
        var licFin = formulario.licFin.value
        var url = formulario.url.value
        window.open("http://10.0.0.155/apirestcolmena/index.php/AgendarHoraSegunHoraDisponible/"+hora+"/"+paciente+"/"+nombre+"/"+apePat+"/"+apeMat+"/1/"+fechaNac+"/"+direccion+"/"+ciudad+"/"+fijo+"/"+celu+"/"+mail+"/3/"+licInicio+"/"+licFin+"/"+url+"/<?php echo $tok; ?>");
    }
    
</script>
    