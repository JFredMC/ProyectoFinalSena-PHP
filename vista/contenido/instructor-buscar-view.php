<?php
	if($_SESSION['privilegio_spm']!=1){
		echo $lc->forzar_cierre_sesion_controlador();
		exit();

}
?>


<form class="form-neon">
	<div class="container">
	<div class="row">
		<div class="col-lg-12">
			
				<div class="card-header">
					<h2 class="text-center">Buscar instructor</h2>
				</div>
				<div class="card-body form-inline mx-sm-5 justify-content-center">
					<a class="btn btn-table" href="<?php echo SERVERURL; ?>instructor/"><i class="fas fa-chalkboard-teacher fa-fw"></i> &nbsp; LISTA INSTRUCTOR</a>
				</div>
</form>

<?php
	if(!isset($_SESSION['busqueda_instructor']) && empty($_SESSION['busqueda_instructor'])){
?>

<div class="container-fluid">
	<form class="form-neon FormularioAjax" action="<?php echo SERVERURL; ?>ajax/buscadorAjax.php" method="POST" data-form="default" autocomplete="off" >
        <input type="hidden" name="modulo" value="instructor">
		<div class="container-fluid">
			<div class="row justify-content-md-center">
				<div class="col-12 col-md-6">
					<div class="form-group">
						
						<input type="text" class="form-control" name="busqueda_inicial" id="inputSearch" maxlength="30" placeholder="Buscar instructor">
					</div>
				</div>
				<div class="col-12">
					<p class="text-center" style="margin-top: 40px;">
						<button type="submit" class="btn btn-raised btn-info"><i class="fas fa-search"></i> &nbsp; BUSCAR</button>
					</p>
				</div>
			</div>
		</div>
	</form>
</div>

<?php }else{ ?>

<div class="container-fluid">
	<form class="FormularioAjax" action="<?php echo SERVERURL; ?>ajax/buscadorAjax.php" method="POST" data-form="default" autocomplete="off" >
        <input type="hidden" name="modulo" value="instructor">
		<input type="hidden" name="eliminar_busqueda" value="eliminar">
		<div class="container-fluid">
			<div class="row justify-content-md-center">
				<div class="col-12 col-md-6">
					<p class="text-center" style="font-size: 20px;">
						Resultados de la busqueda <strong>“<?php echo $_SESSION['busqueda_instructor']; ?>”</strong>
					</p>
				</div>
				<div class="col-12">
					<p class="text-center" style="margin-top: 20px;">
						<button type="submit" class="btn btn-raised btn-danger"><i class="far fa-trash-alt"></i> &nbsp; ELIMINAR BÚSQUEDA</button>
					</p>
				</div>
			</div>
		</div>
	</form>
</div>


<div class="container-fluid">
<?php
		require_once "./controlador/instructorControlador.php";
		$ins_instructor= new instructorControlador();

		echo $ins_instructor->paginador_instructor_controlador($pagina[1],5,$_SESSION['privilegio_spm'],$_SESSION['id_spm'],$pagina[0],$_SESSION['busqueda_instructor']);
	?>
</div>
<?php } ?>