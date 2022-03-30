<?php
	if($_SESSION['privilegio_spm']!=1){
		echo $lc->forzar_cierre_sesion_controlador();
		exit();

}
?>

<div class="container">
    <div class="row">
        <div class="col-lg-12">
            
                <div class="card-header">
                    <h2 class="text-center">Listado de resultados de aprendizaje</h2>
                </div>
                
                <div class="card-body form-inline justify-content-center">
					        <a href="#" class="btn btn-table " data-toggle="modal" data-target="#agregarResultado"><i class="fas fa-plus fa-fw"></i> &nbsp; AGREGAR RESULTADOS</a>
					        <a class="btn btn-table" href="<?php echo SERVERURL; ?>resultado-buscar/"><i class="fas fa-search fa-fw"></i> &nbsp; BUSCAR RESULTADOS</a>
				      </div>
           


<!-- Modal -->
<div class="modal fade" id="agregarResultado" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title text-center" id="exampleModalLabel">Agregar nuevo resultado de aprendizaje</h3>
        
      </div>
      <div class="modal-body">
      <form class="form-neon FormularioAjax" action="<?php echo SERVERURL; ?>ajax/resultadoAjax.php" method="POST" data-form="save" autocomplete="off" >

            <label for="CodigoResul"></label>
            <input type="text" pattern="[0-9-]{1,20}" class="form-control" name="codigo_resul" id="CodigoResul"  required="" placeholder="Codigo del resultado">

            <label for="rel_resultado_competencia"><b></b></label>
              <input class="form-control" name="rel_resultado_competencia" list="rel_resultado_competencia" id="exampleDataList" placeholder="Competencia asociada">
                <datalist id="rel_resultado_competencia" required>
                  <option value="">-Seleccione-</option>
                  <?php include "rel-resultado-competencia.php" ?>  
                </datalist>

            <label for="nombre_resul"></label>
            <input type="text" class="form-control input-sm" id="nombre_resul" name="nombre_resul" placeholder="Nombre" required="">

            <label for="hora_resul"></label>
            <input type="text" class="form-control input-sm" id="hora_resul" name="hora_resul" placeholder="Horas" required="">
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">&nbsp; Cerrar</button>
        <button type="submit" id="btnAgregar" class="btn btn-primary">Agregar</button>
      </div>
      </form>
    </div>
  </div>
</div>

<div class="container">
	<?php
		require_once "./controlador/resultadoControlador.php";
		$ins_resultado= new resultadoControlador();

		echo $ins_resultado->paginador_resultado_controlador($pagina[1],5,$_SESSION['privilegio_spm'],$_SESSION['id_spm'],$pagina[0],"");
	?>
		
</div>







