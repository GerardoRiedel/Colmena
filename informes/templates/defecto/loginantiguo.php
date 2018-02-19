<?php 
////////////////////////////////////////////////////
//Login
//Autor: cetep
//Fecha Creación: 31-1-2008
//Fecha Modificación:
//Autor Modificación: 
////////////////////////////////////////////////////

?>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link href="assets/css/bootstrap.css" type="text/css" rel="stylesheet" />
<script src="assets/js/jquery.min.js" type="text/javascript" language="javascript"></script>
<link href="<?php echo $TEMPLATE_DIR.'/'; ?>estilos.css" rel="stylesheet" type="text/css">
<title><?php echo $NOMBRE_SITIO; ?></title>
<link href="estilos.css" rel="stylesheet" type="text/css" />

<div class="container-fluid">

<form class="form-horizontal" method="post" action="chk_login2.php" id="login_form" style="border:1px solid #eee;padding-left: 200px;padding-top:50px;margin-top:15px">
					  <div class="control-group">
						<label class="control-label" for="usuario">Usuario</label>
						<div class="controls">
						  <input type="text" id="usuario" placeholder="Usuario" required>
						</div>
					  </div>
					  <div class="control-group">
						<label class="control-label" for="password">Password</label>
						<div class="controls">
						  <input type="password" id="pass" placeholder="Password" required>
						</div>
					  </div>
					  <div class="control-group">
						<div class="controls">
						  <label class="checkbox">
							<input type="checkbox"> Recuerdame
						  </label>
						  <input name="Submit" type="submit" id="submit" value="Login" class="btn btn-success"/>
						  <input type="reset" name="Reset" value="Reset" class="btn"/>
						</div>
					  </div>
  </form>

</div>


