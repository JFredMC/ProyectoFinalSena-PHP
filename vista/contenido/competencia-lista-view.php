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
					<h2 class="text-center">Listado de competencias</h2>
				</div>
				<div class="card-body form-inline justify-content-center" >
					<a href="#" class="btn btn-table" data-toggle="modal" data-target="#agregarCompetencia"><i class="fas fa-plus fa-fw"></i> &nbsp; AGREGAR COMPETENCIA</a>
					<a class="btn btn-table" href="<?php echo SERVERURL; ?>competencia-buscar/"><i class="fas fa-search fa-fw"></i> &nbsp; BUSCAR COMPETENCIA</a>
				</div>
</form>

<!-- Modal -->
<div class="modal fade" id="agregarCompetencia" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title text-center" id="exampleModalLabel">Agregar nueva competencia</h3>
      </div>
      <div class="modal-body">
        <form class="form-neon FormularioAjax" action="<?php echo SERVERURL; ?>ajax/competenciaAjax.php" method="POST" data-form="save" autocomplete="off" >
              <label for="CodigoCompetencia"></label>
              <input type="text" pattern="[0-9-]{4,20}" class="form-control" name="codigo_competencia" id="CodigoCompetencia"  required="" placeholder="Codigo de la competencia">

              <label for="rel_competencia_programa"><b></b></label>
              <input class="form-control" name="rel_competencia_programa" list="rel_competencia_programa" id="exampleDataList" placeholder="Programa de formacion asociado">
                <datalist id="rel_competencia_programa" required>
                  <option value="">-Seleccione-</option>
                  <?php include "rel-competencia-programa.php" ?>  
                </datalist>
              
              <label for="NombreCompetencia"></label>
              <input type="text" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ, ]{1,1000}" class="form-control" name="nombre_competencia" id="NombreCompetencia"  required="" placeholder="Nombre de la competencia">
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
		require_once "./controlador/competenciaControlador.php";
		$ins_competencia= new competenciaControlador();

		echo $ins_competencia->paginador_competencia_controlador($pagina[1],5,$_SESSION['privilegio_spm'],$_SESSION['id_spm'],$pagina[0],"");
	?>
		
</div>