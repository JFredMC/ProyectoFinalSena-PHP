<?php 
if ($lc->encryption ($_SESSION['id_spm'])!=$pagina[1] )
{
	if  ($_SESSION['privilegio_spm']!=1){

		echo $lc->forzar_cierre_sesion_controlador();
		exit();
	}
	
}

?>



<div class="container">
    <div class="row">
      <div class="col-md-12">
        <h3 class="text-center" >Actualizar datos de la competencia</h3>
        <?php if($_SESSION['privilegio_spm']==1){ ?>
        <div class="card-body form-inline mx-sm-5" >
            <a class="btn btn-table" href="<?php echo SERVERURL; ?>competencia-lista/"><i class="fas fa-book-open fa-fw"></i> &nbsp; LISTA COMPETENCIA</a>
		    <a class="btn btn-table" href="<?php echo SERVERURL; ?>competencia-buscar/"><i class="fas fa-search fa-fw"></i> &nbsp; BUSCAR COMPETENCIA</a>
	    </div>
        <?php } ?>
        
      </div>

<div class="container-fluid">

<?php
require_once "./controlador/competenciaControlador.php";
$ins_competencia= new competenciaControlador();
$datos_competencia=$ins_competencia->datos_competencia_controlador("Unico", $pagina[1]);
if($datos_competencia->rowCount()==1){
	$campos=$datos_competencia->fetch();

?>




	<form  class="form-neon justify-content-center FormularioAjax" action="<?php echo SERVERURL; ?>ajax/competenciaAjax.php" method="POST" data-form="update" autocomplete="off">
	    <input type="hidden" name="competencia_id_up" value="<?php  echo $pagina[1];?>">
		<fieldset>
			<legend><i class="far fa-address-card"></i> &nbsp; Información de la competencia</legend>
			<div class="container-fluid">
				<div class="row">
					<div class="col-12 col-md-4">
						<div class="form-group">
							<label for="codigo_competencia" class="bmd-label-floating">Codigo de la competencia</label>
							<input type="text" pattern="[0-9-]{4,20}" class="form-control" name="codigo_competencia_up" id="codigo_competencia"  value="<?php echo $campos['ComCodigoCompetencia']; ?>">
						</div>
					</div>
					

					<div class="col-12 col-md-8">
						<div class="form-group">
							<label for="nombre_competencia" class="bmd-label-floating">Nombre</label>
							<input type="text" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{1,200}" class="form-control" name="nombre_competencia_up" id="nombre_competencia"  value="<?php echo $campos['ComNombre']; ?>">
						</div>
					</div>
		</fieldset>
		<br><br>

		<p class="text-center" style="margin-top: 40px;">
			<button type="submit" class="btn btn-table btn-raised btn-sm"><i class="fas fa-sync-alt"></i> &nbsp; ACTUALIZAR</button>
		</p>
	</form>
<?php }else{ ?>

	<div class="alert alert-danger text-center" role="alert">
		<p><i class="fas fa-exclamation-triangle fa-5x"></i></p>
		<h4 class="alert-heading">¡Ocurrió un error inesperado!</h4>
		<p class="mb-0">Lo sentimos, no podemos mostrar la información solicitada debido a un error.</p>
	</div>
	<?php } ?>
	
</div>