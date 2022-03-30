<div class="container">
<div class="title">
    <h1>SISTEMA DE GESTION DE HORARIOS</h1>
</div>
</div>
<div class="container">
    <div class="row">
        <div class="col-lg-12">

        <?php 
        if($_SESSION['privilegio_spm']==1){ 
            require_once "./controlador/instructorControlador.php";
            $ins_instructor = new instructorControlador();

            $total_instructores=$ins_instructor->datos_instructor_controlador("Conteo",0)
        ?>
		<div class="row">
		<div class="full-box tile-container col-lg-4 ">
			<a href="<?php echo SERVERURL; ?>instructor/" class="tile">
        	<div class="card border-info mb-2" style="max-width: 18rem;">
  				<div class="card-header tile-tittle">Instructores</div>
  					<div class="card-body tile-icon">
					<i class="fas fa-chalkboard-teacher fa-fw"></i>
					<p><?php echo $total_instructores->rowCount(); ?> Registrados</p>
  				</div>
			</div>
			</a>
		</div>
		
    <?php } ?>

    <?php 
        if($_SESSION['privilegio_spm']==1){ 
            require_once "./controlador/programaControlador.php";
            $ins_programa = new programaControlador();

            $total_programas=$ins_programa->datos_programa_controlador("Conteo",0)
        ?>
	
	<div class="full-box tile-container col-lg-4">
			<a href="<?php echo SERVERURL; ?>programa-formacion-lista/" class="tile">
        	<div class="card border-info mb-2" style="max-width: 18rem;">
  				<div class="card-header tile-tittle">Programas</div>
  					<div class="card-body tile-icon">
					<i class="fas fa-book fa-fw"></i>
					<p><?php echo $total_programas->rowCount(); ?> Registrados</p>
  				</div>
			</div>
			</a>
		</div>
		
    <?php } ?>
	
    <?php 
        if($_SESSION['privilegio_spm']==1){ 
            require_once "./controlador/fichaControlador.php";
            $ins_ficha = new fichaControlador();

            $total_fichas=$ins_ficha->datos_ficha_controlador("Conteo",0)
        ?>
		<div class="full-box tile-container col-lg-4">
			<a href="<?php echo SERVERURL; ?>ficha/" class="tile">
        	<div class="card border-info mb-2" style="max-width: 18rem;">
  				<div class="card-header tile-tittle">Fichas</div>
  					<div class="card-body tile-icon">
						<i class="fas fa-clipboard fa-fw"></i>
						<p><?php echo $total_fichas->rowCount(); ?> Registrados</p>
  					</div>
				</div>
			</a>
		</div>
		
    <?php } ?>
	
    <?php 
        if($_SESSION['privilegio_spm']==1){ 
            require_once "./controlador/competenciaControlador.php";
            $ins_competencia = new competenciaControlador();

            $total_competencias=$ins_competencia->datos_competencia_controlador("Conteo",0)
        ?>
	<div class="full-box tile-container col-lg-4">
		<a href="<?php echo SERVERURL; ?>competencia-lista/" class="tile">
        	<div class="card border-info mb-2" style="max-width: 18rem;">
  				<div class="card-header tile-tittle">Competencias</div>
  					<div class="card-body tile-icon">
						<i class="fas fa-book-open fa-fw"></i>
						<p><?php echo $total_competencias->rowCount(); ?> Registrados</p>
  					</div>
				</div>
			</a>
		</div>
	
    <?php } ?>

    <?php 
        if($_SESSION['privilegio_spm']==1){ 
            require_once "./controlador/resultadoControlador.php";
            $ins_resultado = new resultadoControlador();

            $total_resultados=$ins_resultado->datos_resultado_controlador("Conteo",0)
        ?>
<div class="full-box tile-container col-lg-4">
		<a href="<?php echo SERVERURL; ?>resultados-de-aprendizaje/" class="tile">
        	<div class="card border-info mb-2" style="max-width: 18rem;">
  				<div class="card-header tile-tittle">Resultados</div>
  					<div class="card-body tile-icon">
						<i class="fas fa-list fa-fw"></i>
						<p><?php echo $total_resultados->rowCount(); ?> Registrados</p>
  					</div>
				</div>
			</a>
		</div>
	
    <?php } ?>

	<?php 
	if($_SESSION['privilegio_spm']==1){ 
		require_once "./controlador/usuarioControlador.php";
		$ins_usuario = new usuarioControlador();

		$total_usuarios=$ins_usuario->datos_usuario_controlador("Conteo",0)
	?>
<div class="full-box tile-container col-lg-4">
		<a href="<?php echo SERVERURL; ?>usuario-lista/" class="tile">
        	<div class="card border-info mb-2" style="max-width: 18rem;">
  				<div class="card-header tile-tittle">Usuarios</div>
  					<div class="card-body tile-icon">
						<i class="fas fa-user fa-fw"></i>
						<p><?php echo $total_usuarios->rowCount(); ?> Registrados</p>
  					</div>
				</div>
			</a>
		</div>
	<?php } ?>

    <?php 
	if($_SESSION['privilegio_spm']==1){ 
		require_once "./controlador/eventoControlador.php";
		$ins_evento = new eventoControlador();

		$total_eventos=$ins_evento->datos_evento_controlador("Conteo",0)
	?>
	<div class="full-box tile-container col-lg-4">
		<a href="<?php echo SERVERURL; ?>evento-lista/" class="tile">
        	<div class="card border-info mb-2" style="max-width: 18rem;">
  				<div class="card-header tile-tittle">Horarios</div>
  					<div class="card-body tile-icon">
						<i class="fas fa-calendar fa-fw"></i>
						<p><?php echo $total_eventos->rowCount(); ?> Registrados</p>
  					</div>
				</div>
			</a>
		</div>
		<?php }else{ ?>
		<div class="full-box tile-container col-lg-4">
		<a href="<?php echo SERVERURL; ?>evento-lista/" class="tile">
        	<div class="card border-info mb-2" style="max-width: 18rem;">
  				<div class="card-header tile-tittle">Horarios</div>
  					<div class="card-body tile-icon">
						<i class="fas fa-calendar fa-fw"></i>
						<p>Ver horarios</p>
  					</div>
				</div>
			</a>
		</div>
	</div>
</div>
<?php } ?>
    </div>
</div>


