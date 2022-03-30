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
					<h2 class="text-center">Listado de programas de formacion</h2>
				</div>
				<div class="card-body form-inline justify-content-center">
					<a href="#" class="btn btn-table" data-toggle="modal" data-target="#agregarPrograma"><i class="fas fa-plus fa-fw"></i> &nbsp; AGREGAR PROGRAMAS</a>
					<a class="btn btn-table" href="<?php echo SERVERURL; ?>programa-formacion-buscar/"><i class="fas fa-search fa-fw"></i> &nbsp; BUSCAR PROGRAMAS</a>
				</div>
</form>

<!-- Modal -->
<div class="modal fade" id="agregarPrograma" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title" id="exampleModalLabel">Agregar nuevo Programa</h3>
      </div>
      <div class="modal-body">
      <form class="form-neon FormularioAjax" action="<?php echo SERVERURL; ?>ajax/programaAjax.php" method="POST" data-form="save" autocomplete="off" >
            <label for="ProCodigoPrograma"></label>
		        <input type="text" pattern="[0-9-]{1,20}" class="form-control" name="codigo_programa" id="ProCodigoPrograma"  required="" placeholder="Codigo programa de formacion">
            
            <label for="ProNombrePrograma"></label>
			      <input type="text" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{1,500}" class="form-control" name="nombre_programa" id="ProNombrePrograma" required="" placeholder="Nombre programa de formacion">
        
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
		require_once "./controlador/programaControlador.php";
		$ins_programa= new programaControlador();

		echo $ins_programa->paginador_programa_controlador($pagina[1],5,$_SESSION['privilegio_spm'],$_SESSION['id_spm'],$pagina[0],"");
	?>
		
</div>
