<?php 
session_start();


if (empty($_SESSION['Usuario_Nombre']) ) {
    header('Location: cerrarsesion.php');
    exit;

}

if ($_SESSION['Usuario_Id_Nivel'] != 2)
{
    header('Location: index.php');
    exit;

}

require_once 'funciones/insertar_turno.php';
require_once 'funciones/validarIngreso.php';


require_once 'funciones/conexion.php';
$MiConexion=ConexionBD(); 

require_once 'funciones/selectPrestaciones.php';
$ListadoPrestaciones = Listar_Prestaciones($MiConexion);
$CantidadPrestaciones = count($ListadoPrestaciones);

require_once 'funciones/selectUsuarios.php';
$ListadoUsuarios = Listar_Usuarios($MiConexion);
$CantidadUsuarios = count($ListadoUsuarios);

$Mensaje='';


if (!empty($_POST['botonRegistrar'])) {
     // Verifica si el botón fue presionado y si hay datos enviados mediante POST

    $Mensaje=Validar_Ingreso();
     // Llama a la función para validar los datos ingresados.
    if (empty($Mensaje)) {
        // Si el mensaje de validación está vacío, significa que no hay errores.

        if (InsertarTurno($MiConexion) != false) {
            // Llama a la función para insertar un turno en la base.

            $Mensaje = 'Se han registrado los datos ingresados.';
    
            $_POST = array(); 
         
       }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<?php require_once 'secciones/head.php'; ?>
<body class="">
	<!-- [ Pre-loader ] start -->
	<div class="loader-bg">
		<div class="loader-track">
			<div class="loader-fill"></div>
		</div>
	</div>
	<!-- [ Pre-loader ] End -->
	<!-- [ Mobile header ] start -->
	<div class="pc-mob-header pc-header">
		<div class="pcm-logo">
			<img src="assets/images/logo.svg" alt="" class="logo logo-lg">
		</div>
		<div class="pcm-toolbar">
			<a href="#!" class="pc-head-link" id="mobile-collapse">
				<div class="hamburger hamburger--arrowturn">
					<div class="hamburger-box">
						<div class="hamburger-inner"></div>
					</div>
				</div>
				<!-- <i data-feather="menu"></i> -->
			</a>

			<a href="#!" class="pc-head-link" id="header-collapse">
				<i data-feather="more-vertical"></i>
			</a>
		</div>
	</div>
	<!-- [ Mobile header ] End -->

	<!-- [ navigation menu ] start -->
	<?php require_once 'secciones/navegador.php'; ?>
	<!-- [ navigation menu ] end -->
	<!-- [ Header ] start -->
	<?php require_once 'secciones/header.php'; ?>

	<!-- [ Header ] end -->

<!-- [ Main Content ] start -->
<section class="pc-container">
    <div class="pcoded-content">
        <!-- [ breadcrumb ] start -->
        <div class="page-header">
            <div class="page-block">
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <div class="page-header-title">
                            <h5 class="m-b-10">Solicitudes</h5>
                        </div>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                            <li class="breadcrumb-item"><a href="#!">Prestaciones</a></li>
                            <li class="breadcrumb-item">Cargar nueva</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <!-- [ breadcrumb ] end -->
        <!-- [ Main Content ] start -->
        <div class="row">
            <!-- [ form-element ] start -->
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <h5>Cargar Solicitud </h5>
                        <hr>
                        <?php if(!empty($Mensaje)) {?>
                        '<div class="alert alert-success" role="alert">
            <i data-feather="check-circle"></i><?php echo $Mensaje;?></div> <?php }?>

                        <div class="alert alert-info" role="alert">
                        <i data-feather="info"></i> 
							Los campos con * son obligatorios. 
						</div>

                        <form role="form" method="post">
                        <div class="row">
                            <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="Paciente">Indique el Paciente (*)
                                        </label>
                                        <select class="form-control" id="Paciente" name = "Paciente">
                                            <option>Selecciona una opción...</option>
                                            <?php 
                                                $selected='';
                                                for ($i=0 ; $i < $CantidadUsuarios ; $i++) {
                                                    if (!empty($_POST['Paciente']) && $_POST['Paciente'] ==  $ListadoUsuarios[$i]['ID']) {
                                                        $selected = 'selected';
                                                    }else {
                                                        $selected='';
                                                    }
                                                    ?>
                                                    <option value="<?php echo $ListadoUsuarios[$i]['ID']; ?>" <?php echo $selected; ?>  >
                                                        <?php echo $ListadoUsuarios[$i]['NOMBRE'] . ' ' . $ListadoUsuarios[$i]['APELLIDO'] 
                                                        . ' (' . $ListadoUsuarios[$i]['DNI'].')'; ?>
                                                    </option>
                                                <?php } ?>
                                            
                                        </select>
                                    </div>
                            </div>
                            <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="Prestacion">Seleccione Prestación (*)</label>
                                        <select class="form-control" id="Prestacion" name = "Prestacion">
                                        <option value="">Selecciona...</option>
                                                <?php 
                                                $selected='';
                                                for ($i=0 ; $i < $CantidadPrestaciones ; $i++) {
                                                    if (!empty($_POST['Prestacion']) && $_POST['Prestacion'] ==  $ListadoPrestaciones[$i]['ID']) {
                                                        $selected = 'selected';
                                                    }else {
                                                        $selected='';
                                                    }
                                                    ?>
                                                    <option value="<?php echo $ListadoPrestaciones[$i]['ID']; ?>" <?php echo $selected; ?>  >
                                                        <?php echo $ListadoPrestaciones[$i]['DENOMINACION']; ?>
                                                    </option>
                                                <?php } ?>
                                        </select>
                                    </div>
                                    
                            </div>
                            <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampleFormControlTextarea1">Ingrese el Diagnóstico</label>
                                        <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="Diagnostico"></textarea>
                                    </div>

                            </div>
                            <div class="col-md-6">
                                    <label for="datepicker">Ingresa Fecha y Hora (*)</label>
                                <div class="col-md-3">
                                    <div class="md-form md-outline input-with-post-icon datepicker">
                                        <input class="form-control" value="<?php echo isset($_POST['Fecha']) ? $_POST['Fecha'] : ''; ?>" type="date" id="datepicker" placeholder="Selecciona fecha" name="Fecha" >
                                    </div>
                               
                                    <div class="md-form md-outline input-with-post-icon datepicker" >
                                        <input class="form-control" value="<?php echo isset($_POST['Hora']) ? $_POST['Hora'] : ''; ?>" placeholder="Selecciona hora" type="text" id="datetime" name="Hora"/>
                                    </div>
                                </div>
                                
                            </div>
                            
                            <div class="col-md-12">
                                    <button type = "submit" class="btn  btn-primary" value="registrar" name= "botonRegistrar">Registrar</button> 
                                    <input class="btn btn-secondary" type="reset" value="Limpiar datos">
                                    <a class="btn btn-light" href="index.php" role="button">Volver a Home</a>
                            </div>
                            
                        </div>
                        </form>
                       

                        <script>
                            $('#datetime').datetimepicker({
                                format: 'HH:mm:ss'
                            });
                        </script>
                    </div>
                </div>
            </div>
            <!-- [ form-element ] end -->
        </div>
        <!-- [ Main Content ] end -->

    </div>
</section>

    <!-- Required Js -->
    <script src="assets/js/vendor-all.min.js"></script>
    <script src="assets/js/plugins/bootstrap.min.js"></script>
    <script src="assets/js/plugins/feather.min.js"></script>
    <script src="assets/js/pcoded.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/9.12.0/highlight.min.js"></script>
    <script src="assets/js/plugins/clipboard.min.js"></script>
    <script src="assets/js/uikit.min.js"></script>

<script>


    // header option
    $('#pct-toggler').on('click', function() {
        $('.pct-customizer').toggleClass('active');

    });
    // header option
    $('#cust-sidebrand').change(function() {
        if ($(this).is(":checked")) {
            $('.theme-color.brand-color').removeClass('d-none');
            $('.m-header').addClass('bg-dark');
        } else {
            $('.m-header').removeClassPrefix('bg-');
            $('.m-header > .b-brand > .logo-lg').attr('src', 'assets/images/logo-dark.svg');
            $('.theme-color.brand-color').addClass('d-none');
        }
    });
    // Header Color
    $('.brand-color > a').on('click', function() {
        var temp = $(this).attr('data-value');
        // $('.header-color > a').removeClass('active');
        // $('.pcoded-header').removeClassPrefix('brand-');
        // $(this).addClass('active');
        if (temp == "bg-default") {
            $('.m-header').removeClassPrefix('bg-');
        } else {
            $('.m-header').removeClassPrefix('bg-');
            $('.m-header > .b-brand > .logo-lg').attr('src', 'assets/images/logo.svg');
            $('.m-header').addClass(temp);
        }
    });
    // Header Color
    $('.header-color > a').on('click', function() {
        var temp = $(this).attr('data-value');
        // $('.header-color > a').removeClass('active');
        // $('.pcoded-header').removeClassPrefix('brand-');
        // $(this).addClass('active');
        if (temp == "bg-default") {
            $('.pc-header').removeClassPrefix('bg-');
        } else {
            $('.pc-header').removeClassPrefix('bg-');
            $('.pc-header').addClass(temp);
        }
    });
    // sidebar option
    $('#cust-sidebar').change(function() {
        if ($(this).is(":checked")) {
            $('.pc-sidebar').addClass('light-sidebar');
            $('.pc-horizontal .topbar').addClass('light-sidebar');
            // $('.m-header > .b-brand > .logo-lg').attr('src', 'assets/images/logo-dark.svg');
        } else {
            $('.pc-sidebar').removeClass('light-sidebar');
            $('.pc-horizontal .topbar').removeClass('light-sidebar');
            // $('.m-header > .b-brand > .logo-lg').attr('src', 'assets/images/logo.svg');
        }
    });
    $.fn.removeClassPrefix = function(prefix) {
        this.each(function(i, it) {
            var classes = it.className.split(" ").map(function(item) {
                return item.indexOf(prefix) === 0 ? "" : item;
            });
            it.className = classes.join(" ");
        });
        return this;
    };
</script>
</body>

</html>
