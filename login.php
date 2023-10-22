<?php 
session_start();
//print_r($_SESSION);
require_once 'funciones/conexion.php';
$MiConexion=ConexionBD();



$Mensaje='';
if (!empty($_POST['BotonLogin'])) {

    require_once 'funciones/login.php';
    $UsuarioLogueado = DatosLogin($_POST['email'], md5($_POST['password']), $MiConexion);

    //la consulta con la BD para que encuentre un usuario registrado con el usuario y clave brindados
    if ( !empty($UsuarioLogueado)) {
       // $Mensaje ='ok! ya puedes ingresar';

       //generar los valores del usuario (esto va a venir de mi BD)
	    $_SESSION['Id_Usuario']     =   $UsuarioLogueado['ID'];
        $_SESSION['Usuario_Nombre']     =   $UsuarioLogueado['NOMBRE'];
        $_SESSION['Usuario_Apellido']   =   $UsuarioLogueado['APELLIDO'];
		$_SESSION['Usuario_Id_Nivel']      =   $UsuarioLogueado['IDNIVEL'];
        $_SESSION['Usuario_Nivel']      =   $UsuarioLogueado['NIVEL'];
        $_SESSION['Usuario_Img']        =   $UsuarioLogueado['IMG'];
    
		header('Location: index.php');
		exit;
 

    }else {
        $Mensaje='Los Datos son incorrectos, intenta nuevamente.';
    }

}
?>
<!DOCTYPE html>
<html lang="en">

<?php require_once 'secciones/head.php'; ?>

<!-- [ auth-signin ] start -->
<div class="auth-wrapper">
	<div class="auth-content">
		<div class="card">
			<div class="row align-items-center text-center">
				<div class="col-md-12">
					<div class="card-body">
						<img src="assets/images/nibelenlogo.svg" alt="" class="img-fluid mb-4"> 
						
                        <!--<h2>Nibelen Software</h2>
						<h4 class="mb-3 f-w-400">Login</h4>-->
						<!--
						<div class="form-group text-left mt-2">
							<div class="alert alert-danger" role="alert">
                                Los datos son incorrectos. Intenta nuevamente. 
                            </div>
						</div>-->
						<form role="form" method='post'>
						<div class="form-group text-left mt-2">
						<?php if (!empty ($Mensaje)) { ?>
                                <div class="alert alert-danger" role="alert">
                                    <?php echo $Mensaje; ?>
                                </div>
                            <?php } ?>
							<div class="alert alert-info" role="alert">
                                Usuario y clave son requeridos.
                            </div>
						</div><div class="input-group mb-3">
							<div class="input-group-prepend">
								<span class="input-group-text"><i data-feather="mail"></i></span>
							</div>
							<input type="email" class="form-control" placeholder="Email address" name="email" >
						</div>
						<div class="input-group mb-4">
							<div class="input-group-prepend">
								<span class="input-group-text"><i data-feather="lock"></i></span>
							</div>
							<input type="password" class="form-control" placeholder="Password" name="password">
						</div>
						<button class="btn btn-block btn-primary mb-4" value="login" name="BotonLogin">Ingresa</button>
						
					</div>
						</form>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- [ auth-signin ] end -->

<!-- Required Js -->
<script src="assets/js/vendor-all.min.js"></script>
<script src="assets/js/plugins/bootstrap.min.js"></script>
<script src="assets/js/plugins/feather.min.js"></script>
<script src="assets/js/pcoded.min.js"></script>

</body>

</html>
