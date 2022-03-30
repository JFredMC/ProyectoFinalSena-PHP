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
        <h3 class="text-center" >Actualizar datos del resultado de aprendizaje</h3>
        <?php if($_SESSION['privilegio_spm']==1){ ?>
        <div class="card-body form-inline mx-sm-5 justify-content-center" >
            <a class="btn btn-table" href="<?php echo SERVERURL; ?>resultados-de-aprendizaje/"><i class="fas fa-list fa-fw"></i> &nbsp; LISTA RESULTADOS</a>
		    <a class="btn btn-table" href="<?php echo SERVERURL; ?>resultado-buscar/"><i class="fas fa-search fa-fw"></i> &nbsp; BUSCAR RESULTADOS</a>
	    </div>
        <?php } ?>
        
      </div>

<div class="container-fluid">

<?php
require_once "./controlador/resultadoControlador.php";
$ins_resultado= new resultadoControlador();
$datos_resultado=$ins_resultado->datos_resultado_controlador("Unico", $pagina[1]);
if($datos_resultado->rowCount()==1){
	$campos=$datos_resultado->fetch();

?>


	<form  class="form-neon justify-content-center FormularioAjax" action="<?php echo SERVERURL; ?>ajax/resultadoAjax.php" method="POST" data-form="update" autocomplete="off">
	    <input type="hidden" name="resultado_id_up" value="<?php  echo $pagina[1];?>">
		<fieldset>
			<legend><i class="far fa-address-card"></i> &nbsp; Información del resultado de aprendizaje</legend>
			<div class="container-fluid">
				<div class="row">
					<div class="col-12 col-md-4">
						<div class="form-group">
                        <label for="codigo_resul" class="bmd-label-floating">Codigo resultado</label>
							<input type="text" pattern="[0-9-]{1,20}" class="form-control" name="codigo_resul_up" id="codigo_resul"  value="<?php echo $campos['ResCodigo']; ?>">
						</div>
					</div>
					
					<div class="col-12 col-md-8">
						<div class="form-group">
							<label for="nombre_resul" class="bmd-label-floating">Nombre</label>
							<input type="text"  class="form-control" name="nombre_resul_up" id="nombre_resul"  value="<?php echo $campos['ResNombre']; ?>">
						</div>
					</div>

                    <div class="col-12 col-md-4">
						<div class="form-group">
							<label for="hora_resul" class="bmd-label-floating">Horas</label>
							<input type="text" pattern="[0-9-]{1,20}" class="form-control" name="hora_resul_up" id="hora_resul"  value="<?php echo $campos['ResHoras']; ?>">
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