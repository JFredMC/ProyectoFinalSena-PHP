<div class="container">
	<div class="row">
		<div class="col-lg-12">	
			<div class="card-header justify-content-center">
				<h2 class="text-center">Listado de eventos</h2>
                	<?php if($_SESSION['privilegio_spm']==1){ ?>
				<a class="btn btn-table" href="<?php echo SERVERURL ?>evento-asignacion/"><i class="fas fa-plus fa-fw"></i> &nbsp; ASIGNACION DE HORARIOS</a>
                    <?php } ?>
                <a class="btn btn-table" href="<?php echo SERVERURL; ?>evento-buscar/"><i class="fas fa-search fa-fw"></i> &nbsp; BUSCAR HORARIO</a>
			</div>
						

					  

<div class="container-fluid">
	<?php
		require_once "./controlador/eventoControlador.php";
		$ins_evento= new eventoControlador();

		echo $ins_evento->paginador_evento_controlador($pagina[1],5,$_SESSION['id_spm'],$pagina[0],"");
	?>
		
</div>