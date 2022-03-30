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
					<h2 class="text-center">Listado de usuarios</h2>
				</div>
				<div class="card-body form-inline justify-content-center" >
					<a href="#" class="btn btn-table" data-toggle="modal" data-target="#agregarUsuario"><i class="fas fa-plus fa-fw"></i> &nbsp; AGREGAR USUARIO</a>
					<a class="btn btn-table" href="<?php echo SERVERURL; ?>usuario-buscar/"><i class="fas fa-search fa-fw"></i> &nbsp; BUSCAR USUARIO</a>
				</div>
</form>

<div class="modal fade" id="agregarUsuario" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title" id="exampleModalLabel">Agregar nuevo usuario</h3>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <form class="form-neon FormularioAjax" action="<?php echo SERVERURL; ?>ajax/usuarioAjax.php" method="POST" data-form="save" autocomplete="off" >
            <label for="usuario_dni"></label>
		    <input type="text" pattern="[0-9-]{7,20}" class="form-control" name="usuario_dni_reg" id="usuario_dni" maxlength="20" required="" placeholder="Identificacion">
            <label for="usuario_nombre"></label>
			<input type="text" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{1,35}" class="form-control" name="usuario_nombre_reg" id="usuario_nombre" maxlength="35" required="" placeholder="Nombres">
            <label for="usuario_apellido"></label>
			<input type="text" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{1,35}" class="form-control" name="usuario_apellido_reg" id="usuario_apellido" maxlength="35" required="" placeholder="Apellidos">
            
            
            <label for="usuario_telefono"></label>
			<input type="text" pattern="[0-9()+]{8,20}" class="form-control" name="usuario_telefono_reg" id="usuario_telefono" maxlength="20" placeholder="Telefono">
        
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
							<label for="usuario_email" class="bmd-label-floating">Email</label>
							<input type="email" class="form-control" name="usuario_email_reg" id="usuario_email" maxlength="70">
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
            
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <button type="submit" id="btnAgregar" class="btn btn-primary">&nbsp; Agregar</button>
      </div>
      </form>
    </div>
  </div>
</div>
<div class="container">
	<?php
		require_once "./controlador/usuarioControlador.php";
		$ins_usuario= new usuarioControlador();

		echo $ins_usuario->paginador_usuario_controlador($pagina[1],5,$_SESSION['privilegio_spm'],$_SESSION['id_spm'],$pagina[0],"");
	?>
		
</div>