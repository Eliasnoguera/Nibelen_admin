<?php 
$titulos='';

if($_SESSION['Usuario_Id_Nivel'] == 1 || $_SESSION['Usuario_Id_Nivel'] == 4) {
   $titulos = 'Todas las Prestaciones cargadas'; }
  if($_SESSION['Usuario_Id_Nivel'] == 2 ) {
	   $titulos = 'Mis Turnos Cargados'; } 
   if($_SESSION['Usuario_Id_Nivel'] == 3 ) {
	   $titulos = 'Mis Turnos Asignados';
   }

?>
<nav class="pc-sidebar ">
		<div class="navbar-wrapper">
			<div class="m-header">
				<a href="index.php" class="b-brand">
					<!-- ========   change your logo hear   ============ -->
					<img src="assets/images/LOGOCS.png" alt="" class="logo logo-lg">
					<img src="assets/images/logo-sm.svg" alt="" class="logo logo-sm">
				</a>
			</div>
			<div class="navbar-content">
				<ul class="pc-navbar">
					<li class="pc-item pc-caption">
						<label>Navegación</label>

					</li>

				
					<li class="pc-item pc-caption">
						<label>Prestaciones</label>
					</li>

                    <?php if( $_SESSION['Usuario_Id_Nivel'] == 2 ) {?>
                    <li class="pc-item"><a href="carga.php" class="pc-link ">
                        <span class="pc-micon"><i data-feather="layout"></i></span>
                    
                        <span class="pc-mtext">Cargar nueva</span></a>
                    </li>
					<?php }?>
	
					<li class="pc-item pc-caption">
						<label>Listados</label>
					</li>
					<li class="pc-item"><a href="listado.php" class="pc-link ">
                        <span class="pc-micon"><i data-feather="list"></i></span>
                        <span class="pc-mtext"><?php echo $titulos;?></span></a>
                        <!--
                        <span class="pc-mtext">Listado mis turnos</span></a>
                        <span class="pc-mtext">Listado de mis cargas</span></a>
                        -->
                    </li>

					<li class="pc-item"><a href="carga.php" class="pc-link ">
                        <span class="pc-micon"><i data-feather="layout"></i></span>
                    
                        <span class="pc-mtext">Turnos</span></a>
                    </li>

					<li class="pc-item"><a href="carga.php" class="pc-link ">
                        <span class="pc-micon"><i data-feather="layout"></i></span>
                    
                        <span class="pc-mtext">Pacientes</span></a>
                    </li>

					<li class="pc-item"><a href="carga.php" class="pc-link ">
                        <span class="pc-micon"><i data-feather="layout"></i></span>
                    
                        <span class="pc-mtext">Inventario</span></a>
                    </li>

					<li class="pc-item"><a href="carga.php" class="pc-link ">
                        <span class="pc-micon"><i data-feather="layout"></i></span>
                    
                        <span class="pc-mtext">Proveedores</span></a>
                    </li>

					<li class="pc-item"><a href="carga.php" class="pc-link ">
                        <span class="pc-micon"><i data-feather="layout"></i></span>
                    
                        <span class="pc-mtext">Obras sociales</span></a>
                    </li>

					<li class="pc-item"><a href="carga.php" class="pc-link ">
                        <span class="pc-micon"><i data-feather="layout"></i></span>
                    
                        <span class="pc-mtext">Reportes</span></a>
                    </li>
   
				</ul>
			</div>
		</div>
	</nav>