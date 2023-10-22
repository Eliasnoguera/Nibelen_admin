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

$ListadoTurnos = Listado_Turnos($MiConexion);
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
                            <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                            <li class="breadcrumb-item"><a href="#!">Listados</a></li>
                            <li class="breadcrumb-item"><?php echo $titulos; ?></li>
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
                        <h5><?php echo $titulos; ?> (<?php echo $CantidadTurnos;?>)</h5>
                    </div>
                     <!-- ver los titulos solicitados en el pdf y en (xx) poder ver la cantidad de registros visualizados-->

                    <div class="card-body table-border-style">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <!-- ver columnas y datos solicitados para cada nivel -->
                                    <tr>
                                        <th>#</th>
                                        <th>Fecha</th>
                                        <th>Paciente</th>
                                        <th>Obra social</th>
                                        <th>Solicitante</th>
                                        <th>Prestación</th>
                                        <?php if($_SESSION['Usuario_Id_Nivel'] == 4) {?>
                                        <th>Acciones</th> <?php }?>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php for ($i=0; $i<$CantidadTurnos; $i++) { 
                                    $leyendaMonto = '';
                                
                                 $interes = CalcularInteresPrestacion($ListadoTurnos[$i]['PRECIO'], $ListadoTurnos[$i]['PORCENTAJE']);
                                  
                                if($ListadoTurnos[$i]['COMPLEJO'] === 'SI' ){
                                    $leyendaMonto = 'Monto a abonar: $'.$interes.'';
                                    $CantComplejas = $CantComplejas +1;
                                    $SumaComplejas = $SumaComplejas + $interes;

                                }

                                    ?>


                                    <tr 
                                    <?php if ($ListadoTurnos[$i]['ESTADO'] == 'No Asistido') {?>
                                    class="table-warning" 
                                    <?php }?>
                                    <?php if ($ListadoTurnos[$i]['ESTADO'] == 'Asistido') {?>
                                    class="table-success" 
                                    <?php }?>
                                    <?php if ($ListadoTurnos[$i]['ESTADO'] == 'Cargado') {?>
                                    class="table" 
                                    <?php }?>
                                    
                                    title="Este turno figura <?php echo $ListadoTurnos[$i]['ESTADO']?>">
                                        <td><?php echo $ListadoTurnos[$i]['IDTURNO'];?></td>
                                        <td><?php echo $ListadoTurnos[$i]['FECHA'];?><br /><?php echo $ListadoTurnos[$i]['HORA'];?></td>
                                        <td><?php echo $ListadoTurnos[$i]['PACIENTE'];?></td>
                                        <td><?php echo $ListadoTurnos[$i]['OBRASOCIAL'];?></td>
                                        <td><?php echo $ListadoTurnos[$i]['MEDICO'];?></td>
                                        <td><?php echo $ListadoTurnos[$i]['PRESTACION']; 
                                        if($_SESSION['Usuario_Id_Nivel'] !=2) {?>
                                        <br /><?php echo $leyendaMonto ?></td>
                                      <?php } if($_SESSION['Usuario_Id_Nivel'] == 4) {?>
                                        <td>
                                            <a href="#!" title="Asistencia/Inasistencia Turno"><i class="icon feather icon-clock f-20  text-success"></i></a>
                                            <a href="#!" title="Cancelar turno"><i class="feather icon-trash-2 ml-3 f-20 text-danger"></i></a>
                                        </td>
                                        <?php }?>
                                    </tr>

                                  
                                    <?php }?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
        </div>
            <!-- [ Contextual-table ] end -->


               
            <!-- support-section start -->
            <?php  if($_SESSION['Usuario_Id_Nivel'] == 1) {?>
            <div class="col-xl-6 col-md-12">
                <div class="card flat-card">
                    <div class="row-table">
                    <div class="col-sm-6">
                        <div class="card prod-p-card background-pattern">
                            <div class="card-body">
                                <div class="row align-items-center m-b-0">
                                    <div class="col">
                                        <h6 class="m-b-5">Cantidad de Prestaciones Complejas</h6>
                                        <h3 class="m-b-0"><?php echo  $CantComplejas ;?></h3>
                                 
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
                                        <h3 class="m-b-0 text-white">$ <?php echo $SumaComplejas;?></h3>
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
            </div>
<?php }?>
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


</body>

</html>
