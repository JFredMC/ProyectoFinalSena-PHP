<!--MOSTRAR FICHAS DE LA BASE DE DATOS -->
<script>
function mostrarficha(str) {
    if (str.length == 0) {
        document.getElementById("txtHint").innerHTML = "";
        return;
    } else {
        var conexion = new XMLHttpRequest();
        conexion.onreadystatechange = function() {
            if (conexion.readyState == 4 && conexion.status == 200) {
                document.getElementById("evento_ficha").innerHTML = conexion.responseText;
            }
        };
        conexion.open("GET", "http://localhost/programaciondeinstructores/vista/contenido/evento-consulta-ficha.php?c=" + str, true);
        conexion.send();
    }
}
</script>

<!--MOSTRAR COMPETENCIAS DE LA BASE DE DATOS -->
<script>
function mostrarcompetencia(str) {
    if (str.length == 0) {
        document.getElementById("txtHint").innerHTML = "";
        return;
    } else {
        var conexion = new XMLHttpRequest();
        conexion.onreadystatechange = function() {
            if (conexion.readyState == 4 && conexion.status == 200) {
                document.getElementById("evento_competencia").innerHTML = conexion.responseText;
            }
        };
        conexion.open("GET", "http://localhost/programaciondeinstructores/vista/contenido/evento-competencia.php?c=" + str, true);
        conexion.send();
    }
}
</script>

<!--MOSTRAR RESULTADOS DE APRENDIZAJE DE LA BASE DE DATOS -->
<script>
function mostrarresultado(str) {
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

<script>
function mostrarhorainicio(str) {
    if (str.length == 0) {
        document.getElementById("txtHint").innerHTML = "";
        return;
    } else {
        var conexion = new XMLHttpRequest();
        conexion.onreadystatechange = function() {
            if (conexion.readyState == 4 && conexion.status == 200) {
                document.getElementById("evento_horainicio").innerHTML = conexion.responseText;
            }
        };
        conexion.open("GET", "http://localhost/programaciondeinstructores/vista/contenido/evento-hora-inicio.php?c=" + str, true);
        conexion.send();
    }
}
</script>
<script>
function mostrarhorafin(str) {
    if (str.length == 0) {
        document.getElementById("txtHint").innerHTML = "";
        return;
    } else {
        var conexion = new XMLHttpRequest();
        conexion.onreadystatechange = function() {
            if (conexion.readyState == 4 && conexion.status == 200) {
                document.getElementById("evento_horafin").innerHTML = conexion.responseText;
            }
        };
        conexion.open("GET", "http://localhost/programaciondeinstructores/vista/contenido/evento-hora-fin.php?c=" + str, true);
        conexion.send();
    }
}
</script>





<div class="container-fluid">

<?php
require_once "./controlador/instructorControlador.php";
$ins_instructor= new instructorControlador();
$datos_instructor=$ins_instructor->datos_instructor_controlador("Unico", $pagina[1]);
if($datos_instructor->rowCount()==1){
	$campos=$datos_instructor->fetch();

?>


<div class="container ">
  <div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 py-2">
      <div class="tab-content" id="v-pills-tabContent">
        <div class="tab-pane fade show active" id="profile" role="tabpanel" aria-labbelledby="profile-tab">
          <div class="row">
            <div class="col-lg-12 col-md-8 ">
                <h3 class="text-center">Asignacion de horarios</h3>
                <a class="btn btn-table" href="<?php echo SERVERURL; ?>evento-lista/"><i class="fas fa-calendar-alt fa-fw"></i> &nbsp; LISTA DE HORARIOS</a>
            </div>
    
            <div class="col-lg-12 col-md-12 col-sm-12 py-5 text-center">
              <h4 class="text-left"></h4>
              
              <hr/>
              <form class="form-neon form-row justify-content-center FormularioAjax" action="<?php echo SERVERURL; ?>ajax/eventoAjax.php" method="POST" data-form="save" autocomplete="off" >
              <input type="hidden" name="instructor_id_up" value="<?php  echo $pagina[1];?>">
              <div class="form-group col-lg-7 col-md-12 py-2">
                  <label for="evento_instructor"><b>Instructor</b></label>
                  <input name="instructor_even" id="evento_instructor" class="form-select form-select-lg form-control" pattern="[0-9-]{5,20}" value="<?php  echo $campos['InsIdentificacion'];?>" required="" autocomplete="">
              </div>
              
              <div class="form-group col-lg-2 col-md-12 text-left py-2">
                  <label for="evento_horas"><b>Total horas</b></label>
                  <input type="text" class="form-control" name="horas_even" id="evento__horas" required>
              </div>
                          <div class="col-lg-12 col-md-12 col-sm-12 py-5 text-center form-group">
                          <button type="submit" id="btnAgregar" class="btn btn-table">&nbsp; Asignar horario</button>
                          </div>
                  </div>

              </form>
            </div>
          </div>
        </div>




        <?php }else{
                
           
            ?>
            <div class="container ">
  <div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 py-2">
      <div class="tab-content" id="v-pills-tabContent">
        <div class="tab-pane fade show active" id="profile" role="tabpanel" aria-labbelledby="profile-tab">
          <div class="row">
            <div class="col-lg-12 col-md-8">
                <h3 class="text-center">Asignacion de horarios</h3>
                <a class="btn btn-table" href="<?php echo SERVERURL; ?>evento-lista/"><i class="fas fa-calendar-alt fa-fw"></i> &nbsp; LISTA DE HORARIOS</a>
            </div>
    
            <div class="col-lg-12 col-md-12 col-sm-12 py-5 text-center">
              <h4 class="text-left"></h4>
              
              <hr/>
              <form class="form-neon form-row justify-content-center FormularioAjax" action="<?php echo SERVERURL; ?>ajax/eventoAjax.php" method="POST" data-form="save" autocomplete="off" >
              
              <div class="form-group col-lg-7 col-md-12 py-2">
                  <label for="evento_instructor" class="form-label"><b>Instructor</b></label>
                        <input class="form-control" name="instructor_even" list="evento_instructor" id="exampleDataList"  placeholder="Seleccionar instructor">
                            <datalist   id="evento_instructor"  pattern="[0-9-]{5,20}" required>
                                <option value="">-Seleccione-</option>
                                <?php include "evento-instructor.php" ?>
                            </datalist>
              </div>
              
              
              <div  class="form-group col-lg-6 col-md-12 text-left py-2 ">
                  <label for="evento_programa"><b>Programa de formacion</b></label>
                  <input class="form-control" name="programa_even" list="evento_programa" id="exampleDataList" onchange="mostrarficha(this.value);mostrarcompetencia(this.value)" placeholder="Seleccionar programa de formacion">
                    <datalist id="evento_programa" required>
                      <option value="">-Seleccione-</option> 
                      <?php include "evento-programa-formacion.php" ?>
                    </datalist>
              </div>

              <div class="form-group col-lg-6 col-md-12 text-left py-2">
                    <label for="evento_ficha"><b>Seleccionar Ficha</b></label>
                    <input class="form-control" name="ficha_even" list="evento_ficha" id="exampleDataList" onchange="mostrarhorainicio(this.value);mostrarhorafin(this.value)" placeholder="Seleccionar ficha">
                    <datalist id="evento_ficha"  pattern="[0-9-]{15,20}"  required>
                        <option value="">-Seleccione-</option>
                        
                  </datalist>
              </div>
              <div  class="form-group col-lg-6 col-md-12 text-left py-2 ">
                  <label for="evento_competencia"><b>Competencia</b></label>
                  <input class="form-control" name="competencia_even" list="evento_competencia" id="exampleDataList" onchange="mostrarresultado(this.value)" placeholder="Seleccionar competencia">
                  <datalist id="evento_competencia" required>
                      <option value="">-Seleccione-</option> 
                  </datalist>
              </div>
              <div  class="form-group col-lg-6 col-md-12 text-left py-2 ">
                  <label for="evento_resultado"><b>Resultado de aprendizaje</b></label>
                  <input class="form-control" name="resultado_even" list="evento_resultado" id="exampleDataList" placeholder="Seleccionar resultado">
                  <datalist id="evento_resultado" required>
                      <option value="">-Seleccione-</option> 
                  </datalist>
              </div>
              <div class="form-group col-lg-5 col-md-12 text-left py-2">
                  <label for="evento_fechainicio"><b>Fecha inicio</b></label>
                  <input type="date" class="form-control" name="fechainicio_even" id="evento_fechainicio" required> 
              </div>
              <div class="form-group col-lg-5 col-md-12 text-left py-2">
                  <label for="evento_fechafin"><b>Fecha fin</b></label>
                  <input type="date" class="form-control" name="fechafin_even" id="evento_fechafin" required>
              </div>
              <div class="form-group col-lg-4 col-md-12 text-left py-2">
                  <label for="evento_horainicio"><b>Hora inicio</b></label>
                  <select class="form-control" name="horainicio_even" id="evento_horainicio" required>
                      <option value=""></option>
                  </select>
                  
              </div>
              <div class="form-group col-lg-4 col-md-12 text-left py-2">
                  <label for="evento_horafin"><b>Hora fin</b></label>
                  <select class="form-control" name="horafin_even" id="evento_horafin" required>
                      <option value=""></option>
                  </select>
              </div>

              <div class="form-group col-lg-6 col-md-10 mt-3">
                  <label for="evento_dia"><b>Dias de clases</b></label>
                  <br>
                    
                  <label for="Lunes">Lunes</label>
                  <input type="checkbox" name="dia_even" id="Lunes" value="Lunes"">
                  
                  <label for="Martes">Martes</label>
                  <input type="checkbox" name="dia_even" id="Martes" value="Martes">

                  <label for="Miercoles">Miercoles</label>
                  <input type="checkbox" name="dia_even" id="Miercoles" value="Miercoles">

                  <label for="Jueves">Jueves</label>
                  <input type="checkbox" name="dia_even" id="Jueves" value="Jueves">

                  <label for="Viernes">Viernes</label>
                  <input type="checkbox" name="dia_even" id="Viernes" value="Viernes">
                
              </div>
              
              <div class="form-group col-lg-2 col-md-12 text-left py-2">
                  <label for="evento_horas"><b>Total horas</b></label>
                  <input type="text" class="form-control" name="horas_even" id="evento__horas" required>
              </div>

                          <div class="col-lg-12 col-md-12 col-sm-12 py-5 text-center form-group">
                          <button type="submit" id="btnAgregar" class="btn btn-table">&nbsp; Asignar horario</button>
                          </div>
                  </div>

              </form>
            </div>
          </div>
        </div>

	<?php }?>
</div>

</div>









