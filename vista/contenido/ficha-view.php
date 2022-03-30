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
                    <h2 class="text-center">Fichas</h2>
                </div>
                
                <div class="card-body form-inline justify-content-center">
					        <a href="#" class="btn btn-table" data-toggle="modal" data-target="#agregarFicha"><i class="fas fa-plus fa-fw"></i> &nbsp; AGREGAR FICHA</a>
					        <a class="btn btn-table" href="<?php echo SERVERURL; ?>ficha-buscar/"><i class="fas fa-search fa-fw"></i> &nbsp; BUSCAR FICHA</a>
				        </div>



<!-- Modal -->
<div class="modal fade" id="agregarFicha" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title" id="exampleModalLabel">Agregar nueva ficha</h3>
      </div>
      <div class="modal-body">
      <form class="form-neon FormularioAjax" action="<?php echo SERVERURL; ?>ajax/fichaAjax.php" method="POST" data-form="save" autocomplete="off" >
            <label for="codigo_ficha"></label>
            <input type="text" class="form-control input-sm" id="codigo_ficha" name="codigo_ficha" placeholder="Codigo de la ficha" required="">
            
            <label for="rel_ficha_programa"><b></b></label>
            <input class="form-control" name="rel_ficha_programa" list="rel_ficha_programa" id="exampleDataList" placeholder="Programa de formacion asociado">
              <datalist id="rel_ficha_programa" required>
                <option value="">-Seleccione-</option>
                      <?php include "rel-ficha-programa.php" ?>  
              </datalist>

            <label for="fechainicio_ficha" class="mt-2">Fecha Inicio</label>
            <input type="date" class="form-control input-sm" id="fechainicio_ficha" name="fechainicio_ficha" required="">

            <label for="fechafin_ficha" class="mt-2">Fecha Fin</label>
            <input type="date" class="form-control input-sm" id="fechafin_ficha" name="fechafin_ficha" required="">

            <label for="fechafin_ficha" class="mt-2">Jornada</label>
            <select class="form-control" name="jornada_ficha" id="jornada_ficha">
              <option value="">-Seleccione-</option>
              <option value="Mañana">Mañana</option>
              <option value="Tarde">Tarde</option>
            </select>

            <label for="horainicio_ficha" class="mt-2">Hora Inicio</label>
            <select class="form-control" name="horainicio_ficha" id="horainicio_ficha">
              <option value="">-Seleccione-</option>
              <option value="07:00:00">07:00 a. m.</option>
              <option value="13:00:00">13:00 p. m.</option>
            </select>

            <label for="horafin_ficha" class="mt-2">Hora Fin</label>
            <select class="form-control" name="horafin_ficha" id="horafin_ficha">
              <option value="">-Seleccione-</option>
              <option value="13:00:00">13:00 p. m.</option>
              <option value="19:00:00">19:00 p. m.</option>
            </select>

        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">&nbsp; Cerrar</button>
        <button type="submit" id="btnAgregar" class="btn btn-primary">&nbsp; Agregar</button>
      </div>
      </form>
    </div>
  </div>
</div>

<div class="container">
	<?php
		require_once "./controlador/fichaControlador.php";
		$ins_ficha= new fichaControlador();

		echo $ins_ficha->paginador_ficha_controlador($pagina[1],5,$_SESSION['privilegio_spm'],$_SESSION['id_spm'],$pagina[0],"");
	?>
		
</div>






