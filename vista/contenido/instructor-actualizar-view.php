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
        <h3 class="text-center" >Actualizar datos de instructor</h3>
        <?php if($_SESSION['privilegio_spm']==1){ ?>
        <div class="card-body form-inline mx-sm-5 justify-content-center" >
            <a class="btn btn-table" href="<?php echo SERVERURL; ?>instructor/"><i class="fas fa-chalkboard-teacher fa-fw"></i> &nbsp; LISTA INSTRUCTOR</a>
		    <a class="btn btn-table" href="<?php echo SERVERURL; ?>instructor-buscar/"><i class="fas fa-search fa-fw"></i> &nbsp; BUSCAR INSTRUCTOR</a>
	    </div>
        <?php } ?>
        
      </div>

<div class="container-fluid">

<?php
require_once "./controlador/instructorControlador.php";
$ins_instructor= new instructorControlador();
$datos_instructor=$ins_instructor->datos_instructor_controlador("Unico", $pagina[1]);
if($datos_instructor->rowCount()==1){
	$campos=$datos_instructor->fetch();

?>


	<form  class="form-neon justify-content-center FormularioAjax" action="<?php echo SERVERURL; ?>ajax/instructorAjax.php" method="POST" data-form="update" autocomplete="off">
	    <input type="hidden" name="instructor_id_up" value="<?php  echo $pagina[1];?>">
		<fieldset>
			<legend><i class="far fa-address-card"></i> &nbsp; Información personal</legend>
			<div class="container-fluid">
				<div class="row">
					<div class="col-12 col-md-4">
						<div class="form-group">
							<label for="instructor_dni" class="bmd-label-floating">DNI</label>
							<input type="text" pattern="[0-9-]{7,20}" class="form-control" name="instructor_dni_up" id="instructor_dni" maxlength="20" value="<?php echo $campos['InsIdentificacion']; ?>">
						</div>
					</div>
					
					<div class="col-12 col-md-4">
						<div class="form-group">
							<label for="instructor_nombre" class="bmd-label-floating">Nombres</label>
							<input type="text" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{1,35}" class="form-control" name="instructor_nombre_up" id="instructor_nombre" maxlength="35" value="<?php echo $campos['InsNombres']; ?>">
						</div>
					</div>
					<div class="col-12 col-md-4">
						<div class="form-group">
							<label for="instructor_apellido" class="bmd-label-floating">Apellidos</label>
							<input type="text" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{1,35}" class="form-control" name="instructor_apellido_up" id="instructor_apellido" maxlength="35" value="<?php echo $campos['InsApellidos']; ?>">
						</div>
					</div>
                    <div class="col-12 col-md-6">
						<div class="form-group">
							<label for="instructor_email" class="bmd-label-floating">Email</label>
							<input type="email" class="form-control" name="instructor_email_up" id="instructor_email" maxlength="70" value="<?php echo $campos['InsEmail']; ?>">
						</div>
					</div>
					<div class="col-12 col-md-6">
						<div class="form-group">
							<label for="instructor_telefono" class="bmd-label-floating">Teléfono</label>
							<input type="text" pattern="[0-9()+]{8,20}" class="form-control" name="instructor_telefono_up" id="instructor_telefono" maxlength="20"value="<?php echo $campos['InsTelefono']; ?>">
						</div>
					</div>
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