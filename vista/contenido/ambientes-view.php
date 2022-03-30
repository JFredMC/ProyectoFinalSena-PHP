<?php
	$servername="localhost";
	$username="root";
	$password="";
	$dbname="programaciondeinstructores";

	$conexion = mysqli_connect($servername, $username, $password, $dbname);

	if(!$conexion){
		echo"Error en la conexion con el servidor";
	}

	
?>
<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <div class="card text-left">
                <div class="card-header">
                    <h2>Listado de ambientes</h2>
                </div>
                <div class="card-body">
                <div class="card-body form-inline mx-sm-5" >
					<a href="#" class="btn btn-table" data-toggle="modal" data-target="#agregarFicha"><i class="fas fa-plus fa-fw"></i> &nbsp; AGREGAR AMBIENTES</a>
					<a class="btn btn-table" href="<?php echo SERVERURL; ?>ficha-buscar/"><i class="fas fa-search fa-fw"></i> &nbsp; BUSCAR AMBIENTES</a>
				</div>
                    <div>
                        <table class="table table-hover table-condensed" id="iddatetable">
                            <thead>
                                <tr class="">
                                    <td>Codigo</td>
                                    <td>Nombre</td>
                                    <td>Cupo</td>
                                    <td></td>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    
                                </tr>
                            </tfoot>
                            <tbody>
                                <tr>
                                <?php
                                    $sql="SELECT * FROM tblambiente";
                                    $result=mysqli_query($conexion,$sql);

                                    while($mostrar=mysqli_fetch_array($result)){

                                    
                                    ?>
                                    <tr>
                                        <td><?php echo $mostrar['AmbCodigo'] ?></td>
                                        <td><?php echo $mostrar['AmbNombre'] ?></td>
                                        <td><?php echo $mostrar['AmbCupo'] ?></td>
                                        <td style="text-align: center;">
                                            <span class="btn btn-warning btn-lg" data-toggle="modal" data-target="#modalEditar" onclick="agregaFrmActualizar('<?php echo $mostrar[0] ?>')">
                                            <span class="fa fa-pencil-square-o"></span>
                                            </span>
                                        </td>
                                        <td>
                                            <span class="btn btn-danger btn-lg" onclick="eliminarDatos('<?php echo $mostrar[0] ?>')">
                                            <span class="fa fa-trash"></span>
                                            </span>
                                        </td>
                                    </tr>
                                    <?php
                                    }
                                    ?>
                                </tr>
                            </tbody>
                            
                            </table>
                            <nav aria-label="Page navigation example">
                                <ul class="pagination justify-content-end">
                                    <li class="page-item disabled">
                                    <a class="page-link" href="#" tabindex="-1" aria-disabled="true">Previous</a>
                                    </li>
                                    <li class="page-item"><a class="page-link" href="#">1</a></li>
                                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                                    <li class="page-item">
                                    <a class="page-link" href="#">Next</a>
                                    </li>
                                </ul>
                            </nav>
                    </div>
                </div>
                <div class="card-footer text-muted">
            
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Modal -->
<div class="modal fade" id="agregarInstructor" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title" id="exampleModalLabel">Agregar nuevo ambiente</h3>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <form id="insnuevo" method="POST" >
            <label for="identificacion"></label>
            <input type="text" class="form-control input-sm" id="identificacion" name="identificacion" placeholder="Identificacion" required="">
            <label for="nombres"></label>
            <input type="text" class="form-control input-sm" id="nombres" name="nombres" placeholder="Nombres" required="">
            <label for="apellidos"></label>
            <input type="text" class="form-control input-sm" id="apellidos" name="apellidos" placeholder="Apellidos" required="">
            <label for="correo"></label>
            <input type="text" class="form-control input-sm" id="correo" name="correo" placeholder="Correo" required="">
            <label for="telefono"></label>
            <input type="text" class="form-control input-sm" id="telefono" name="telefono" placeholder="Telefono" required="">
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">&nbsp; Cerrar</button>
        <button type="submit" id="btnAgregar" class="btn btn-primary">&nbsp; Agregar</button>
      </div>
    </div>
  </div>
</div>

<script>
    $(document).ready(function(){
        $('#btnAgregar').click(function(){
            $datos=$('#insnuevo').serialize();

            $.ajax({
                type:"POST",
                data:datos,
                url:"procesos/agregar.php",
                success:function(r){
                    if(r==1){
                        alertify.success("Instructor agregado con exito");
                    }else{
                        alertify.error("Error al agregar Instructor");
                    }
                }
            });
        });
    });
</script>
   





