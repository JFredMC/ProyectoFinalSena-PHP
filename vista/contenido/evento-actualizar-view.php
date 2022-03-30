<script>
function mostrarselect(str) {
    if (str.length == 0) {
        document.getElementById("txtHint").innerHTML = "";
        return;
    } else {
        var conexion = new XMLHttpRequest();
        conexion.onreadystatechange = function() {
            if (conexion.readyState == 4 && conexion.status == 200) {
                document.getElementById("evento_resultado").innerHTML = conexion.responseText;
            }
        };
        conexion.open("GET", "http://localhost/programaciondeinstructores/vista/contenido/evento-resul.php?c=" + str, true);
        conexion.send();
    }
}
</script>
<?php 
if ($lc->encryption ($_SESSION['id_spm'])!=$pagina[1] ){

	
}

?>
    <?php
        	if  ($_SESSION['privilegio_spm']!=1){

            echo '<a class="btn btn-table" href="'.SERVERURL.'evento-lista/"><i class="fas fa-search fa-fw"></i> &nbsp; LISTA HORARIO</a>';
            echo '<h1 class="text-center">No tienes los permisos para ver esta pantalla</h1>';
            exit();
          }
    ?>


<div class="container">
    <div class="row">
      <div class="col-md-12">
        <h3 class="text-center" >Actualizar datos del horario</h3>
        <?php if($_SESSION['privilegio_spm']==1){ ?>
        <div class="card-body form-inline mx-sm-5" >
            <a class="btn btn-table" href="<?php echo SERVERURL; ?>evento-lista/"><i class="fas fa-search fa-fw"></i> &nbsp; LISTA HORARIO</a>
		    <a class="btn btn-table" href="<?php echo SERVERURL; ?>evento-buscar/"><i class="fas fa-search fa-fw"></i> &nbsp; BUSCAR HORARIO</a>
	    </div>
        <?php } ?>
        
      </div>

<div class="container-fluid">

<?php
require_once "./controlador/eventoControlador.php";
$ins_evento= new eventoControlador();
$datos_evento=$ins_evento->datos_evento_controlador("Unico", $pagina[1]);
if($datos_evento->rowCount()==1){
	$campos=$datos_evento->fetch();

?>


	    
        <div class="container ">
  <div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 py-2">
      <div class="tab-content" id="v-pills-tabContent">
        <div class="tab-pane fade show active" id="profile" role="tabpanel" aria-labbelledby="profile-tab">
          <div class="row">
              
              <form class="form-neon form-row justify-content-center FormularioAjax" action="<?php echo SERVERURL; ?>ajax/eventoAjax.php" method="POST" data-form="update" autocomplete="off" >
              <input type="hidden" name="evento_id_up" value="<?php  echo $pagina[1];?>">
              
              <div class="form-group col-lg-7 col-md-12 py-2">
                  <label for="evento_instructor"><b>Instructor</b></label>
                  <input name="instructor_even_up" id="evento_instructor_up" class="form-select form-select-lg form-control" pattern="[0-9-]{5,20}" value="<?php  echo $campos['EveInstructor'];?>" required="" autocomplete="">
              </div>
              <div  class="form-group col-lg-6 col-md-12 text-left py-2 ">
                  <label for="evento_programa"><b>Programa de formacion</b></label>
                  <input class="form-control" name="programa_even_up" list="evento_programa" id="exampleDataList" onchange="mostrarficha(this.value);mostrarcompetencia(this.value)" placeholder="Seleccionar programa de formacion">
                    <datalist id="evento_programa" required>
                      <option value="<?php  echo $campos['EveProgramaDeFormacion'];?>"<?php if($campos['EveProgramaDeFormacion']==$campos['EveProgramaDeFormacion']) {
									echo' selected=""';} ?>><?php echo $campos['EveProgramaDeFormacion'] ?><?php if($campos['EveProgramaDeFormacion']==$campos['EveProgramaDeFormacion']) {
										echo'(Actual) ';} ?></option> 
                      <?php include "evento-programa-formacion.php" ?>
                    </datalist>
              </div>

              <div class="form-group col-lg-6 col-md-12 text-left py-2">
                    <label for="evento_ficha"><b>Seleccionar Ficha</b></label>
                    <input class="form-control" name="ficha_even_up" list="evento_ficha" id="exampleDataList" placeholder="Seleccionar ficha">
                    <datalist name="ficha_even" id="evento_ficha"  pattern="[0-9-]{15,20}"  required>
                        <option value="<?php  echo $campos['EveFicha'];?>"<?php if($campos['EveFicha']==$campos['EveFicha']) {
									echo' selected=""';} ?>><?php echo $campos['EveFicha'] ?><?php if($campos['EveFicha']==$campos['EveFicha']) {
										echo'(Actual) ';} ?></option>
                        
                  </datalist>
              </div>
              <div  class="form-group col-lg-6 col-md-12 text-left py-2 ">
                  <label for="evento_competencia"><b>Competencia</b></label>
                  <input class="form-control" name="competencia_even_up" list="evento_competencia" id="exampleDataList" onchange="mostrarresultado(this.value)" placeholder="Seleccionar competencia">
                  <datalist id="evento_competencia" required>
                      <option value="<?php  echo $campos['EveCompetencia'];?>"<?php if($campos['EveCompetencia']==$campos['EveCompetencia']) {
									echo' selected=""';} ?>><?php echo $campos['EveCompetencia'] ?><?php if($campos['EveCompetencia']==$campos['EveCompetencia']) {
										echo'(Actual) ';} ?></option> 
                  </datalist>
              </div>
              <div  class="form-group col-lg-6 col-md-12 text-left py-2 ">
                  <label for="evento_resultado"><b>Resultado de aprendizaje</b></label>
                  <input class="form-control" name="resultado_even_up" list="evento_resultado" id="exampleDataList" placeholder="Seleccionar resultado">
                  <datalist id="evento_resultado" required>
                      <option value="<?php  echo $campos['EveResultado'];?>"<?php if($campos['EveResultado']==$campos['EveResultado']) {
									echo' selected=""';} ?>><?php echo $campos['EveResultado'] ?><?php if($campos['EveResultado']==$campos['EveResultado']) {
										echo'(Actual) ';} ?></option> 
                  </datalist>
              </div>
              <div class="form-group col-lg-5 col-md-12 text-left py-2">
                  <label for="evento_fechainicio"><b>Fecha inicio</b></label>
                  <input type="date" class="form-control" name="fechainicio_even_up" id="evento_fechainicio" required value="<?php  echo $campos['EveFechaInicio'];?>"<?php if($campos['EveFechaInicio']==$campos['EveFechaInicio']) {
									echo' selected=""';} ?>> 
              </div>
              <div class="form-group col-lg-5 col-md-12 text-left py-2">
                  <label for="evento_fechafin"><b>Fecha fin</b></label>
                  <input type="date" class="form-control" name="fechafin_even_up" id="evento_fechafin" required value="<?php  echo $campos['EveFechaFin'];?>"<?php if($campos['EveFechaFin']==$campos['EveFechaFin']) {
									echo' selected=""';} ?>>
              </div>
              <div class="form-group col-lg-4 col-md-12 text-left py-2">
                  <label for="evento_horainicio"><b>Hora inicio</b></label>
                  <input type="time" class="form-control" name="horainicio_even_up" id="evento_fechainicio" required value="<?php  echo $campos['EveHoraInicio'];?>"<?php if($campos['EveHoraInicio']==$campos['EveHoraInicio']) {
									echo' selected=""';} ?>> 
              </div>
              <div class="form-group col-lg-4 col-md-12 text-left py-2">
                  <label for="evento_horafin"><b>Hora fin</b></label>
                  <input type="time" class="form-control" name="horafin_even_up" id="evento_fechafin" required value="<?php  echo $campos['EveHoraFin'];?>"<?php if($campos['EveHoraFin']==$campos['EveHoraFin']) {
									echo' selected=""';} ?>>
              </div>
              <div class="form-group col-lg-7 col-md-12 py-2">
                  <label for="evento_dia"><b>Dias de clases</b></label>
                  <select name="dia_even_up" id="evento_dia" class="form-select form-select-lg form-control" required>
                      <option value="">-Seleccione-</option>
                      <option value="Lunes" <?php if($campos['EveDia']=='Lunes') {
									echo' selected=""';} ?>>Lunes <?php if($campos['EveDia']=='Lunes') {
										echo'(Actual) ';} ?></option>

                      <option value="Martes" <?php if($campos['EveDia']=='Martes') {
									echo' selected=""';} ?>>Martes <?php if($campos['EveDia']=='Martes') {
										echo'(Actual) ';} ?></option>

                      <option value="Miercoles" <?php if($campos['EveDia']=='Miercoles') {
									echo' selected=""';} ?>>Miercoles <?php if($campos['EveDia']=='Miercoles') {
										echo'(Actual) ';} ?></option>

                      <option value="Jueves" <?php if($campos['EveDia']=='Jueves') {
									echo' selected=""';} ?>>Jueves <?php if($campos['EveDia']=='Jueves') {
										echo'(Actual) ';} ?></option>

                      <option value="Viernes" <?php if($campos['EveDia']=='Viernes') {
									echo' selected=""';} ?>>Viernes <?php if($campos['EveDia']=='Viernes') {
										echo'(Actual) ';} ?></option>
                </select>
              </div>
              <div class="form-group col-lg-2 col-md-12 text-left py-2">
                  <label for="evento_horas"><b>Total horas</b></label>
                  <input type="text" class="form-control" name="horas_even_up" id="evento__horas" required value="<?php  echo $campos['EveTotalHoras'];?>"<?php if($campos['EveTotalHoras']==$campos['EveTotalHoras']) {
									echo' selected=""';} ?>>
              </div>
              
                          <div class="col-lg-12 col-md-12 col-sm-12 py-5 text-center form-group">
                          <button type="submit" id="btnAgregar" class="btn btn-table">&nbsp; Actualizar</button>
                          </div>
                  </div>

              </form>
            </div>
          </div>
        </div>
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