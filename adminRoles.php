<?php 
session_start();


if (empty($_SESSION['Usuario_Nombre']) ) {
    header('Location: cerrarsesion.php');
    exit;
}

require_once 'funciones/conexion.php';

$MiConexion = ConexionBD();

require_once 'funciones/calcularPrestacion.php';
require_once 'funciones/insertar_turno.php';
require_once 'funciones/selectUsuarios.php';

$ListadoTurnos = Listado_Turnos($MiConexion);
$ListadoDeUsuarios = listado_completo($MiConexion);
$CantidadTurnos = count($ListadoTurnos);
$CantComplejas = 0;
$SumaComplejas = 0;

$titulos='';

 if($_SESSION['Usuario_Id_Nivel'] == 1 || $_SESSION['Usuario_Id_Nivel'] == 4) {
    $titulos = 'Todas las Prestaciones cargadas'; }
   if($_SESSION['Usuario_Id_Nivel'] == 2 ) {
        $titulos = 'Mis Turnos Cargados'; } 
    if($_SESSION['Usuario_Id_Nivel'] == 3 ) {
        $titulos = 'Mis Turnos Asignados';
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
                            <h5 class="m-b-10">Prestaciones</h5>
                        </div>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                            <li class="breadcrumb-item"><a href="#!">Listados</a></li>
                            <li class="breadcrumb-item">Todas las Prestaciones cargadas</li>
                            <!-- ver los titulos solicitados en el pdf-->
                            
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <!-- [ breadcrumb ] end -->
        <!-- [ Contextual-table ] start -->
        <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4>USUARIOS</h4>
                    </div>
                     <!-- ver los titulos solicitados en el pdf y en (xx) poder ver la cantidad de registros visualizados-->

                     <?php
// Comprobar si la variable $ListadoDeUsuarios está definida y no está vacía

// Comprobar si la variable $ListadoDeUsuarios está definida y no está vacía
if (!empty($ListadoDeUsuarios) && is_array($ListadoDeUsuarios)) {
    echo '<div class="card-body table-border-style">';
    echo '<div class="table-responsive">';
    echo '<table class="table">';
    echo '<thead>';
    echo '<tr>';
    echo '<th>Nombre</th>';
    echo '<th>Apellido</th>';
    echo '<th>Rol</th>';
    echo '<th>Acciones</th>'; // Agregamos una columna para las acciones
    echo '</tr>';
    echo '</thead>';
    echo '<tbody>';

    // Iterar a través de los datos y generar las filas de la tabla
    foreach ($ListadoDeUsuarios as $usuario) {
        echo '<tr>';
        echo '<td>' . $usuario['NOMBRE'] . '</td>';
        echo '<td>' . $usuario['APELLIDO'] . '</td>';
        echo '<td>' . $usuario['ROL'] . '</td>';
        
        // Agregamos iconos de Bootstrap para actualizar y eliminar
        echo '<td>';
        echo '<a href="#" title="Modificar"><i class="fa fa-edit f-18"></i></a>'; // Icono de edición
        echo '&nbsp;';
    
        echo '<a href="#!" title="Cancelar turno"><i class="feather icon-trash-2 ml-3 f-20 text-danger"></i></a>'; // Icono de eliminación
        echo '</td>';
        
        echo '</tr>';
    }

    echo '</tbody>';
    echo '</table>';
    echo '</div>';
    echo '</div>';
} else {
    echo 'No se encontraron usuarios y roles.';
}
?>



                    </div>
                </div>
        </div>
            <!-- [ Contextual-table ] end -->


               
            <!-- support-section start -->
            <!--
            <div class="col-xl-6 col-md-12">
                <div class="card flat-card">
                    <div class="row-table">
                    <div class="col-sm-6">
                        <div class="card prod-p-card background-pattern">
                            <div class="card-body">
                                <div class="row align-items-center m-b-0">
                                    <div class="col">
                                        <h6 class="m-b-5">Cantidad de Prestaciones Complejas</h6>
                                        <h3 class="m-b-0">4</h3>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-tags text-primary"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                        <div class="col-sm-6">
                        <div class="card prod-p-card bg-primary background-pattern-white">
                            <div class="card-body">
                                <div class="row align-items-center m-b-0">
                                    <div class="col">
                                        <h6 class="m-b-5 text-white">Total Recaudación</h6>
                                        <h3 class="m-b-0 text-white">$ 8000</h3>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-money-bill-alt text-white"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    </div>   
                </div>
            </div> -->

                </div>


       

</section>>

    <!-- Required Js -->
    <script src="assets/js/vendor-all.min.js"></script>
    <script src="assets/js/plugins/bootstrap.min.js"></script>
    <script src="assets/js/plugins/feather.min.js"></script>
    <script src="assets/js/pcoded.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/9.12.0/highlight.min.js"></script>
    <script src="assets/js/plugins/clipboard.min.js"></script>
    <script src="assets/js/uikit.min.js"></script>


</body>

</html>
