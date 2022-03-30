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
					<h2 class="text-center">Listado de instructores</h2>
				</div>
				<div class="card-body form-inline justify-content-center">
					<a href="#" class="btn btn-table" data-toggle="modal" data-target="#agregarInstructor"><i class="fas fa-plus fa-fw"></i> &nbsp; AGREGAR INSTRUCTOR</a>
					<a class="btn btn-table" href="<?php echo SERVERURL; ?>instructor-buscar/"><i class="fas fa-search fa-fw"></i> &nbsp; BUSCAR INSTRUCTOR</a>
				</div>
</form>

<!-- Modal -->
<div class="modal fade" id="agregarInstructor" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title" id="exampleModalLabel">Agregar nuevo instructor</h3>
      </div>
      <div class="modal-body">
      <form class="form-neon FormularioAjax" action="<?php echo SERVERURL; ?>ajax/instructorAjax.php" method="POST" data-form="save" autocomplete="off" >
            <label for="InsIdentificacion"></label>
		  <input type="text" pattern="[0-9-]{7,20}" class="form-control" name="identificacion_ins" id="InsIdentificacion" maxlength="20" required="" placeholder="Identificacion">
            <label for="InsNombres"></label>
			<input type="text" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{1,35}" class="form-control" name="nombres_ins" id="InsNombres" maxlength="35" required="" placeholder="Nombres">
            <label for="InsApellidos"></label>
			<input type="text" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{1,35}" class="form-control" name="apellidos_ins" id="InsApellidos" maxlength="35" required="" placeholder="Apellidos">
            <label for="InsEmail" class="bmd-label-floating"></label>
			<input type="email" class="form-control" name="email_ins" id="InsEmail" maxlength="70" id="InsEmail" placeholder="Email">
            <label for="InsTelefono"></label>
			<input type="text" pattern="[0-9()+]{8,20}" class="form-control" name="telefono_ins" id="InsTelefono" maxlength="20" placeholder="Telefono">
        
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
		require_once "./controlador/instructorControlador.php";
		$ins_instructor= new instructorControlador();

		echo $ins_instructor->paginador_instructor_controlador($pagina[1],5,$_SESSION['privilegio_spm'],$_SESSION['id_spm'],$pagina[0],"");
	?>
		
</div>


   





