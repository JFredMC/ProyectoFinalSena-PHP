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
					<h2 class="text-center">Asignar usuarios</h2>
				</div>
				<div class="card-body form-inline mx-sm-5 justify-content-center" >
					<a class="btn btn-table" href="<?php echo SERVERURL; ?>usuario-lista/"><i class="fas fa-user fa-fw"></i> &nbsp; LISTA USUARIO</a>
				</div>
</form>

<?php
require_once "./controlador/asignarControlador.php";
$ins_asignar= new asignarControlador();
$datos_asignar=$ins_asignar->datos_asignar_controlador("Unico", $pagina[1]);
if($datos_asignar->rowCount()==1){
	$campos=$datos_asignar->fetch();

?>
<div class="container">
  <div class="row">
    <div class="col-md-12">
      <div class="modal-header">

      </div>
      <div class="modal-body">
      
      <form class="form-neon FormularioAjax" action="<?php echo SERVERURL; ?>ajax/usuarioAsignarAjax.php" method="POST" data-form="save" autocomplete="off">
	  <input type="hidden" name="usuario_id_asig" value="<?php  echo $pagina[1];?>">
      <div class="container-fluid">
				<div class="row">
					<div class="col-12 col-md-6">
						<div class="form-group">
							
							<input type="text" readonly="readonly" pattern="[0-9-]{7,20}" class="form-control" name="usuario_dni_reg" id="usuario_dni" value="<?php echo $campos['InsIdentificacion']; ?>" required="" >
					
							<input type="hidden" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{1,35}" class="form-control" name="usuario_nombre_reg" id="usuario_nombre" maxlength="70" value="<?php echo $campos['InsNombres']; ?>">
					
					
							
							<input type="hidden" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{1,35}" class="form-control" name="usuario_apellido_reg" id="usuario_apellido" maxlength="70" value="<?php echo $campos['InsApellidos']; ?>">
						
					
							
							<input type="hidden" pattern="[0-9()+]{8,20}" class="form-control" name="usuario_telefono_reg" id="usuario_telefono" pattern="[a-zA-Z0-9$@.-]{7,100}" maxlength="100" required="" value="<?php echo $campos['InsTelefono']; ?>">
						
					</div>
				</div>
			</div>
        
      </div>
      <legend>&nbsp; Información de la cuenta</legend>
			<div class="container-fluid">
				<div class="row">
					<div class="col-12 col-md-6">
						<div class="form-group">
							<label for="usuario_usuario" class="bmd-label-floating">Nombre de usuario</label>
							<input type="text" pattern="[a-zA-Z0-9]{1,35}" class="form-control" name="usuario_usuario_reg" id="usuario_usuario" maxlength="35" required="" >
						</div>
					</div>
					<div class="col-12 col-md-6">
						<div class="form-group">
							<label for="usuario_email" class="bmd-label-floating"></label>
							<input type="hidden" class="form-control" name="usuario_email_reg" id="usuario_email" maxlength="150" value="<?php echo $campos['InsEmail']; ?>">
						</div>
					</div>
					<div class="col-12 col-md-6">
						<div class="form-group">
							<label for="usuario_clave_1" class="bmd-label-floating">Contraseña</label>
							<input type="password" class="form-control" name="usuario_clave_1_reg" id="usuario_clave_1" pattern="[a-zA-Z0-9$@.-]{7,100}" maxlength="100" required="" >
						</div>
					</div>
					<div class="col-12 col-md-6">
						<div class="form-group">
							<label for="usuario_clave_2" class="bmd-label-floating">Repetir contraseña</label>
							<input type="password" class="form-control" name="usuario_clave_2_reg" id="usuario_clave_2" pattern="[a-zA-Z0-9$@.-]{7,100}" maxlength="100" required="" >
						</div>
					</div>
				</div>
			</div>
            </fieldset>
			<div class="col-12">
						<div class="form-group">
							<span>Estado de la cuenta &nbsp;
							<span class="badge badge-info">Activa</span>
							<span class="badge badge-danger">Deshabilitada</span></span>
							<select class="form-control" name="usuario_estado_reg">
								<option value="Activa" selected="">-Seleccione-</option>
								<option value="Activa">Activa</option>
								<option value="Deshabilitada">Deshabilitada</option>
							</select>
						</div>
					</div>
		<br><br>
        <fieldset>
			<legend><i class="fas fa-id-badge"></i> &nbsp; Cargo</legend>
			<div class="container-fluid">
				<div class="row">
					<div class="col-12">
						<div class="form-group">
							<select class="form-control" name="usuario_cargo_reg">
								<option value="" selected="" disabled="">Seleccione una opción</option>
								<option value="Coordinador">Coordinador</option>
								<option value="Instructor">Instructor</option>
							</select>
						</div>
					</div>
				</div>
			</div>
		</fieldset>
		<br><br>
        <fieldset>
			<legend><i class="fas fa-medal"></i> &nbsp; Nivel de privilegio</legend>
			<div class="container-fluid">
				<div class="row">
					<div class="col-12">
						<p><span class="badge badge-info">Administrador</span> Permisos para registrar, modificar y eliminar</p>
						<p><span class="badge badge-success">Estandar</span> Permisos para ver su horario</p>
						<div class="form-group">
							<select class="form-control" name="usuario_privilegio_reg">
								<option value="" selected="" disabled="">Seleccione una opción</option>
								<option value="1">1-Administrador</option>
								<option value="2">2-Estandar</option>
							</select>
						</div>
					</div>
				</div>
			</div>
            
			<p class="text-center" style="margin-top: 40px;">
			<button type="submit" class="btn btn-table btn-raised btn-sm"><i class="fas fa-sync-alt"></i> &nbsp; ACTUALIZAR</button>
		</p>
        
        
      
      </form>
    </div>
  </div>
  <?php }else{ ?>

<div class="alert alert-danger text-center" role="alert">
	<p><i class="fas fa-exclamation-triangle fa-5x"></i></p>
	<h4 class="alert-heading">¡Ocurrió un error inesperado!</h4>
	<p class="mb-0">Lo sentimos, no podemos mostrar la información solicitada debido a un error.</p>
</div>
<?php } ?>
</div>