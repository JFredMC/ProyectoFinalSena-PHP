<?php 
if ($lc->encryption ($_SESSION['id_spm'])!=$pagina[1] ){
	if  ($_SESSION['privilegio_spm']!=1){

		echo $lc->forzar_cierre_sesion_controlador();
		exit();
	}
	
}

?>

<div class="container-fluid">

<?php
require_once "./controlador/usuarioControlador.php";
$ins_usuario= new usuarioControlador();
$datos_usuario=$ins_usuario->datos_usuario_controlador("Unico", $pagina[1]);
if($datos_usuario->rowCount()==1){
	$campos=$datos_usuario->fetch();

?>


    
<div class="container">
  
  <div class="row">
    <div class="col-md-6 col-sm-12 mb-5">
      <div class="tab-content" id="v-pills-tabContent">
        <div class="tab-pane fade show active" id="profile" role="tabpanel" aria-labbelledby="profile-tab">
          <div class="row">
            <div class="col-md"><img src="<?php echo SERVERURL ?>vista/assets/avatar/avatar.png" width="150px" alt="imagen de perfil">
                <h3 class=""><?php echo $campos['usuario_nombre']?></h3>
                
            </div>
    
            <div class="col-lg-10 col-md-10 col-sm-12 py-5">
              <h4> Informacion de usuario</h4>
              <hr/>
              <form class="form-row FormularioAjax justify-content-center" action="<?php echo SERVERURL; ?>ajax/usuarioAjax.php" method="POST" data-form="update" autocomplete="off">
                <input type="hidden" name="usuario_perfil_up" id="userId" value="<?php echo $pagina[1]?>">
                <div class="form-group col-lg-6 col-md-12">
                  <label for="text">Identificacion</label>
                  <input class="form-control" pattern="[0-9-]{7,20}" id="identificacion" name="usuario_dni_up" <?php if  ($_SESSION['privilegio_spm']!=1){  ?> readonly="readonly"<?php }?> value="<?php echo $campos['usuario_dni']?>">
                </div>
                <div class="form-group col-lg-6 col-md-12">
                  <label for="text">Nombres</label>
                  <input class="form-control" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{1,35}" name="usuario_nombre_up" id="nombres" value="<?php echo $campos['usuario_nombre']?>">
                </div>
                <div class="form-group col-lg-6 col-md-12">
                  <label for="text">Apellidos</label>
                  <input class="form-control" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{1,35}" name="usuario_apellido_up" id="apellidos" value="<?php echo $campos['usuario_apellido']?>">
                </div>
                <div class="form-group col-lg-6 col-md-12">
                  <label for="email">Correo</label>
                  <input class="form-control" name="usuario_email_up" id="usuario_email" id="correo" value="<?php echo $campos['usuario_email']?>">
                </div>
                <div class="form-group col-lg-6 col-md-12">
                  <label for="phone">Telefono</label>
                  <input class="form-control" pattern="[0-9()+]{8,20}" name="usuario_telefono_up" id="telefono" value="<?php echo $campos['usuario_telefono']?>">
                </div>
                
                <div class="form-group col-lg-6 col-md-12">
                  <label for="text">Usuario</label>
                  <input class="form-control" pattern="[a-zA-Z0-9]{1,35}" name="usuario_usuario_up" id="usuario" <?php if  ($_SESSION['privilegio_spm']!=1){  ?> readonly="readonly"<?php }?>  value="<?php echo $campos['usuario_usuario']?>">
                </div>
                <div class="form-group col-lg-6 col-md-12">
                  <label for="password">Contraseña</label>
                  <input type="password" class="form-control" name="usuario_clave_nueva_1" id="usuario_clave_nueva_1" pattern="[a-zA-Z0-9$@.-]{7,100}" id="password" value="">
                </div>
                <div class="form-group col-lg-6 col-md-12">
                  <label for="password">Repetir contraseña</label>
                  <input type="password" class="form-control" name="usuario_clave_nueva_2" id="usuario_clave_nueva_2" pattern="[a-zA-Z0-9$@.-]{7,100}" id="password" value="">
                </div>
                <button type="submit" class="btn btn-block btn-table col-md-6 my-3"><span class="fa fa-pencil-square-o fa-x1"></span></button>

              </form>
            </div>
                <div class="col-md-2 py-5 ">
                    <img src="<?php echo SERVERURL ?>vista/assets/img/informacion.svg" width="600px" class="text-left" alt="">
                </div>
          </div>
        </div>
        
        <?php } ?>