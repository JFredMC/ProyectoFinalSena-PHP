
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
        <h3 class="text-center" >Actualizar datos de la ficha</h3>
        <?php if($_SESSION['privilegio_spm']==1){ ?>
        <div class="card-body form-inline mx-sm-5" >
            <a class="btn btn-table" href="<?php echo SERVERURL; ?>ficha/"><i class="fas fa-clipboard fa-fw"></i> &nbsp; LISTA FICHA</a>
		    <a class="btn btn-table" href="<?php echo SERVERURL; ?>ficha-buscar/"><i class="fas fa-search fa-fw"></i> &nbsp; BUSCAR FICHA</a>
	    </div>
        <?php } ?>
        
      </div>

<div class="container-fluid">

<?php
require_once "./controlador/fichaControlador.php";
$ins_ficha= new fichaControlador();
$datos_ficha=$ins_ficha->datos_ficha_controlador("Unico", $pagina[1]);
if($datos_ficha->rowCount()==1){
	$campos=$datos_ficha->fetch();

?>
		
	<form  class="form-neon justify-content-center FormularioAjax" action="<?php echo SERVERURL; ?>ajax/fichaAjax.php" method="POST" data-form="update" autocomplete="off">
	    <input type="hidden" name="ficha_id_up" value="<?php  echo $pagina[1];?>">
		<fieldset>
			<legend><i class="far fa-address-card"></i> &nbsp; Información de la ficha</legend>
			<div class="container-fluid">
				<div class="row">
					<div class="col-12 col-md-4">
						<div class="form-group">
							<label for="codigo_ficha" class="bmd-label-floating">Codigo Ficha</label>
							<input type="text" pattern="[0-9-]{5,20}" class="form-control" name="codigo_ficha_up" id="codigo_ficha" maxlength="20" value="<?php echo $campos['FiCodigoFicha']; ?>">
						</div>
					</div>
					
					

					<div class="col-12 col-md-4">
						<div class="form-group">
							<label for="fechainicio_ficha" class="bmd-label-floating">Fecha Inicio</label>
            				<input type="date" class="form-control input-sm" id="fechainicio_ficha" name="fechainicio_ficha_up" required="" value="<?php echo $campos['FiFechaInicio']; ?>">
						</div>
					</div>

					<div class="col-12 col-md-4">
						<div class="form-group">
							<label for="fechafin_ficha" class="bmd-label-floating">Fecha Fin</label>
            				<input type="date" class="form-control input-sm" id="fechafin_ficha" name="fechafin_ficha_up" required=""  value="<?php echo $campos['FiFechaFin']; ?>">
						</div>
					</div>
					<div class="col-12 col-md-4">
						<div class="form-group">
						<label for="fechafin_ficha" class="bmd-label-floating">Jornada</label>
							<select class="form-control" name="jornada_ficha_up" id="jornada_ficha">
							<option value="Mañana" <?php if($campos['FiJornada']=='Mañana') {
									echo' selected=""';} ?>>Mañana<?php if($campos['FiJornada']=='Mañana') {
										echo'(Actual) ';} ?></option>
									<option value="Tarde" <?php if($campos['FiJornada']=='Tarde') {
									echo' selected=""';} ?>>Tarde<?php if($campos['FiJornada']=='Tarde') {
										echo'(Actual) ';} ?></option>
							</select>
						</div>
					</div>

					<div class="col-12 col-md-4">
						<div class="form-group">
							<label for="horainicio_ficha" class="bmd-label-floating">Hora Inicio</label>
            					<select class="form-control" name="horainicio_ficha_up" id="horainicio_ficha">
									<option value="">-Seleccione-</option>
									<option value="07:00:00" <?php if($campos['FiHoraInicio']=='07:00:00') {
									echo' selected=""';} ?>>07:00 a. m. <?php if($campos['FiHoraInicio']=='07:00:00') {
										echo'(Actual) ';} ?></option>
									<option value="13:00:00" <?php if($campos['FiHoraInicio']=='13:00:00') {
									echo' selected=""';} ?>>13:00 p. m. <?php if($campos['FiHoraInicio']=='13:00:00') {
										echo'(Actual) ';} ?></option>
								</select>
						</div>
					</div>

					<div class="col-12 col-md-4">
						<div class="form-group">
							<label for="horafin_ficha" class="bmd-label-floating">Hora Fin</label>
            					<select class="form-control" name="horafin_ficha_up" id="horafin_ficha">
									<option value="">-Seleccione-</option>
									<option value="13:00:00" <?php if($campos['FiHoraFin']=='13:00:00') {
									echo' selected=""';} ?>>13:00 p. m. <?php if($campos['FiHoraFin']=='13:00:00') {
										echo'(Actual) ';} ?></option>
									<option value="19:00:00" <?php if($campos['FiHoraFin']=='19:00:00') {
									echo' selected=""';} ?>>19:00 p. m. <?php if($campos['FiHoraFin']=='19:00:00') {
										echo'(Actual) ';} ?></option>
								</select>
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