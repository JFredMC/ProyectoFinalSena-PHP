<?php

	if($peticionAjax){
		require_once "../modelo/usuarioModelo.php";
	}else{
		require_once "./modelo/usuarioModelo.php";
	}

	class usuarioControlador extends usuarioModelo{

		/*--------- Controlador agregar usuario ---------*/
		public function agregar_usuario_controlador(){
			$dni=mainModel::limpiar_cadena($_POST['usuario_dni_reg']);
			$nombre=mainModel::limpiar_cadena($_POST['usuario_nombre_reg']);
			$apellido=mainModel::limpiar_cadena($_POST['usuario_apellido_reg']);
			$telefono=mainModel::limpiar_cadena($_POST['usuario_telefono_reg']);

			$usuario=mainModel::limpiar_cadena($_POST['usuario_usuario_reg']);
			$email=mainModel::limpiar_cadena($_POST['usuario_email_reg']);
			$clave1=mainModel::limpiar_cadena($_POST['usuario_clave_1_reg']);
			$clave2=mainModel::limpiar_cadena($_POST['usuario_clave_2_reg']);
			$estado=mainModel::limpiar_cadena($_POST['usuario_estado_reg']);

			$cargo=mainModel::limpiar_cadena($_POST['usuario_cargo_reg']);
			$privilegio=mainModel::limpiar_cadena($_POST['usuario_privilegio_reg']);


			/*== comprobar campos vacios ==*/
			if($dni=="" || $nombre=="" || $apellido=="" || $usuario=="" || $clave1=="" || $clave2==""){
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"No has llenado todos los campos que son obligatorios",
					"Tipo"=>"error"
				];
				echo json_encode($alerta);
				exit();
			}


			/*== Verificando integridad de los datos ==*/
			if(mainModel::verificar_datos("[0-9-]{7,20}",$dni)){
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"El NUMERO DE IDENTIFICACION no coincide con el formato solicitado",
					"Tipo"=>"error"
				];
				echo json_encode($alerta);
				exit();
			}

			if(mainModel::verificar_datos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{1,35}",$nombre)){
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"El NOMBRE no coincide con el formato solicitado",
					"Tipo"=>"error"
				];
				echo json_encode($alerta);
				exit();
			}

			if(mainModel::verificar_datos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{1,35}",$apellido)){
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"El APELLIDO no coincide con el formato solicitado",
					"Tipo"=>"error"
				];
				echo json_encode($alerta);
				exit();
			}

			if($telefono!=""){
				if(mainModel::verificar_datos("[0-9()+]{8,20}",$telefono)){
					$alerta=[
						"Alerta"=>"simple",
						"Titulo"=>"Ocurrió un error inesperado",
						"Texto"=>"El TELEFONO no coincide con el formato solicitado",
						"Tipo"=>"error"
					];
					echo json_encode($alerta);
					exit();
				}
			}


			if(mainModel::verificar_datos("[a-zA-Z0-9]{1,35}",$usuario)){
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"El NOMBRE DE USUARIO no coincide con el formato solicitado",
					"Tipo"=>"error"
				];
				echo json_encode($alerta);
				exit();
			}

			if(mainModel::verificar_datos("[a-zA-Z0-9$@.-]{7,100}",$clave1) || mainModel::verificar_datos("[a-zA-Z0-9$@.-]{7,100}",$clave2)){
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"Las CLAVES no coinciden con el formato solicitado",
					"Tipo"=>"error"
				];
				echo json_encode($alerta);
				exit();
			}

			/*== Comprobando DNI ==*/
			$check_dni=mainModel::ejecutar_consulta_simple("SELECT usuario_dni FROM tblusuario WHERE usuario_dni='$dni'");
			if($check_dni->rowCount()>0){
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"El NUMERO DE IDENTIFICACION $dni ya se encuentra registrado en el sistema",
					"Tipo"=>"error"
				];
				echo json_encode($alerta);
				exit();
			}

			/*== Comprobando usuario ==*/
			$check_user=mainModel::ejecutar_consulta_simple("SELECT usuario_usuario FROM tblusuario WHERE usuario_usuario='$usuario'");
			if($check_user->rowCount()>0){
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"El NOMBRE DE USUARIO $usuario ya se encuentra registrado en el sistema",
					"Tipo"=>"error"
				];
				echo json_encode($alerta);
				exit();
			}

			/*== Comprobando email ==*/
			if($email!=""){
				if(filter_var($email,FILTER_VALIDATE_EMAIL)){
					$check_email=mainModel::ejecutar_consulta_simple("SELECT usuario_email FROM tblusuario WHERE usuario_email='$email'");
					if($check_email->rowCount()>0){
						$alerta=[
							"Alerta"=>"simple",
							"Titulo"=>"Ocurrió un error inesperado",
							"Texto"=>"El Email $email ya se encuentra registrado en el sistema",
							"Tipo"=>"error"
						];
						echo json_encode($alerta);
						exit();
					}
				}else{
					$alerta=[
						"Alerta"=>"simple",
						"Titulo"=>"Ocurrió un error inesperado",
						"Texto"=>"Ha ingresado un correo no valido",
						"Tipo"=>"error"
					];
					echo json_encode($alerta);
					exit();
				}
			}

			$check_telefono=mainModel::ejecutar_consulta_simple("SELECT usuario_telefono FROM tblusuario WHERE usuario_telefono='$telefono'");
			if($check_telefono->rowCount()>0){
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"El Numero de telefono $telefono  ya se encuentra registrado en el sistema",
					"Tipo"=>"error"
				];
				echo json_encode($alerta);
				exit();
			}


			/*== Comprobando claves ==*/
			if($clave1!=$clave2){
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"Las claves que acaba de ingresar no coinciden",
					"Tipo"=>"error"
				];
				echo json_encode($alerta);
				exit();
			}else{
				$clave=mainModel::encryption($clave1);
			}

			/*== Comprobando privilegio ==*/
			if($privilegio<1 || $privilegio>2){
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"El privilegio seleccionado no es valido",
					"Tipo"=>"error"
				];
				echo json_encode($alerta);
				exit();
			}

			$datos_usuario_reg=[
				"DNI"=>$dni,
				"Nombre"=>$nombre,
				"Apellido"=>$apellido,
				"Telefono"=>$telefono,
				"Email"=>$email,
				"Usuario"=>$usuario,
				"Clave"=>$clave,
				"Estado"=>$estado,
				"Cargo"=>$cargo,
				"Privilegio"=>$privilegio
			];

			$agregar_usuario=usuarioModelo::agregar_usuario_modelo($datos_usuario_reg);

			if($agregar_usuario->rowCount()==1){
				$alerta=[
					"Alerta"=>"limpiar",
					"Titulo"=>"usuario registrado",
					"Texto"=>"Los datos del usuario han sido registrados con exito",
					"Tipo"=>"success"
				];
			}else{
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"No hemos podido registrar el usuario",
					"Tipo"=>"error"
				];
			}
			echo json_encode($alerta);
		} /* Fin controlador */

		/* PAGINADOR USUARIO*/
		public function paginador_usuario_controlador($pagina,$registros,$privilegio,$id,$url,$busqueda){
			
			$pagina=mainModel::limpiar_cadena($pagina);
			$registros=mainModel::limpiar_cadena($registros);
			$privilegio=mainModel::limpiar_cadena($privilegio);
			$id=mainModel::limpiar_cadena($id);

			$url=mainModel::limpiar_cadena($url);
			$url=SERVERURL.$url."/";

			$busqueda=mainModel::limpiar_cadena($busqueda);
			$tabla="";

			$pagina= (isset($pagina) && $pagina>0) ? (int) $pagina : 1 ;
			$inicio= ($pagina>0) ? (($pagina*$registros)-$registros) : 0 ;

			if(isset($busqueda) && $busqueda!=""){
				$consulta="SELECT SQL_CALC_FOUND_ROWS * FROM tblusuario WHERE ((usuario_id!='$id' AND usuario_id!='1') AND (usuario_dni LIKE '%$busqueda%' OR usuario_nombre LIKE '%$busqueda%' OR usuario_apellido LIKE '%$busqueda%' OR usuario_email LIKE '%$busqueda%' OR usuario_telefono LIKE '%$busqueda%' OR usuario_cargo LIKE '%$busqueda%')) ORDER BY usuario_nombre ASC LIMIT $inicio,$registros";

			}else{
				$consulta="SELECT SQL_CALC_FOUND_ROWS * FROM tblusuario WHERE usuario_id!='$id' AND usuario_id!='1' ORDER BY usuario_nombre ASC LIMIT $inicio,$registros";
			}

			$conexion = mainModel::conectar();

			$datos = $conexion->query($consulta);
			$datos = $datos->fetchAll();
			
			$total = $conexion->query("SELECT FOUND_ROWS()");
			$total = (int) $total->fetchColumn();

			$Npaginas=ceil($total/$registros);
			$tabla.='
						<table class="table table-hover " id="iddatetable">
							<thead>
								<tr class="">
									<td>#</td>
									<td>Identificacion</td>
									<td>Nombres</td>
									<td>Apellidos</td>
									<td>Cargo</td>
									<td>Telefono</td>
									<td>Correo</td>
									<td>Acciones</td>
								</tr>
							</thead>
							<tbody>';
			if($total>=1 && $pagina<=$Npaginas){
				$contador=$inicio+1;
				$reg_inicio=$inicio+1;
				foreach($datos as $rows){
					$tabla.='
							<tr class="text-center">
								<td>'.$contador.'</td>
								<td>'.$rows['usuario_dni'].'</td>
								<td>'.$rows['usuario_nombre'].'</td>
								<td>'.$rows['usuario_apellido'].'</td>
								<td>'.$rows['usuario_cargo'].'</td>
								<td>'.$rows['usuario_telefono'].'</td>
								<td>'.$rows['usuario_email'].'</td>
								<td class="row align-items-start">
									<a href="'.SERVERURL.'usuario-actualizar/'.mainModel::encryption($rows['usuario_id']).'/" class="btn btn-primary data-bs-toggle="tooltip" data-bs-placement="top" title="Actualizar"">
											<i class="fas fa-sync-alt"></i>	
									</a>
								
									<form class="FormularioAjax ml-1" action="'.SERVERURL.'ajax/usuarioAjax.php" method="POST" data-form="delete" autocomplete="off">
									<input type="hidden" name="usuario_id_del" value="'.mainModel::encryption($rows['usuario_id']).'">
										<button type="submit" class="btn btn-danger data-bs-toggle="tooltip" data-bs-placement="top" title="Eliminar"">
												<i class="far fa-trash-alt"></i>
										</button>
									</form>
								</td>
							</tr>';
							$contador++;
				}
				$reg_final=$contador-1;
			}else{
				if($total>=1){
					$tabla.='<tr class="text-center" ><td colspan="9">
					<a href="'.$url.'" class="btn btn-raised btn-primary btn-sm">Haga click aca para recargar el listado</a>
					</td></tr>';
				}else{
					$tabla.='<tr class="text-center"><td colspan="9">No hay registros en el sistema</td></tr>';
				}
			}
			$tabla.='</tbody></table></div>';

			if($total>=1 && $pagina<=$Npaginas){
				$tabla.='<p class="text-right py-2">Mostrando usuario '.$reg_inicio.' al '.$reg_final.' de un total de '.$total.'</p>';
				$tabla.=mainModel::paginador_tablas($pagina,$Npaginas,$url,7);

			}

			return $tabla;

		}
		

		public function eliminar_usuario_controlador(){

			/* RECIBIENDO ID DEL USUARIO*/
			$id=mainModel::decryption($_POST['usuario_id_del']);
			$id=mainModel::limpiar_cadena($id);
		
			/* COMPROBANDO EL USUARIO PRINCIPAL*/
			if($id==1){
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrio un error inesperado",
					"Texto"=>"No es permitido eliminar el usuario principal",
					"Tipo"=>"error"
				];
				echo json_encode($alerta);
				exit();
			}

			/* COMPROBANDO EL USUARIO EN LA BASE DE DATOS*/
			$check_usuario=mainModel::ejecutar_consulta_simple("SELECT usuario_id FROM tblusuario WHERE usuario_id='$id'");
			if($check_usuario->rowCount()<=0){
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrio un error inesperado",
					"Texto"=>"El usuario que intenta eliminar no existe en la base de datos",
					"Tipo"=>"error"
				];
				echo json_encode($alerta);
				exit();
			}

			/* COMPROBANDO PRIVILEGIOS*/
			session_start(['name'=>'SPM']);
			if($_SESSION['privilegio_spm']!=1){
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrio un error inesperado",
					"Texto"=>"No tienes los permisos para realizar esta accion",
					"Tipo"=>"error"
				];
				echo json_encode($alerta);
				exit();
			}

			$eliminar_usuario=usuarioModelo::eliminar_usuario_modelo($id);
			
			if($eliminar_usuario->rowCount()==1){
				$alerta=[
					"Alerta"=>"recargar",
					"Titulo"=>"Usuario eliminado",
					"Texto"=>"Usuario eliminado con exito",
					"Tipo"=>"success"
				];

			}else{
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrio un error inesperado",
					"Texto"=>"No hemos podido eliminar el usuario, intenta nuevamente",
					"Tipo"=>"error"
				];
			
			}
			echo json_encode($alerta);

		}	/* Fin controlador */

		/* CONTROLADOR DATOS USUARIO */
		public function datos_usuario_controlador($tipo,$id){
			$tipo=mainModel::limpiar_cadena($tipo);

			$id=mainModel::decryption($id);
			$id=mainModel::limpiar_cadena($id);

			return usuarioModelo::datos_usuario_modelo($tipo,$id);

		}/* Fin controlador */

		/* CONTROLADOR ACTUALIZAR USUARIO */
		public function actualizar_usuario_controlador(){
            //recibiendo id
            $id=mainModel::decryption($_POST['usuario_id_up']);
            $id=mainModel::limpiar_cadena($id);

            //Comprobar el usuario en la BD

            $check_user=mainModel::ejecutar_consulta_simple("SELECT * FROM tblusuario WHERE usuario_id='$id'");
                if ( $check_user->rowCount()<=0) {
                    $alerta = [
                        "Alerta" => "simple",
                        "Titulo" => "Ocurrió un error inesperado",
                        "Texto"  => "No hemos encontrado el usuario en el sistema",
                        "Tipo"   => "error"
                    ];
                    echo json_encode($alerta);
                     exit();
                }else{
                     $campos=$check_user->fetch();
                     
                }

                /**/
                $dni=mainModel::limpiar_cadena($_POST['usuario_dni_up']);
                $nombre=mainModel::limpiar_cadena($_POST['usuario_nombre_up']);
                $apellido=mainModel::limpiar_cadena($_POST['usuario_apellido_up']);
                $telefono=mainModel::limpiar_cadena($_POST['usuario_telefono_up']);
                $usuario=mainModel::limpiar_cadena($_POST['usuario_usuario_up']);
                $email=mainModel::limpiar_cadena($_POST['usuario_email_up']);
                
                if (isset($_POST['usuario_estado_up'])){
                	$estado=mainModel::limpiar_cadena($_POST['usuario_estado_up']);
                
				}else{
                    $estado=$campos['usuario_estado'];
                } 

                if (isset($_POST['usuario_privilegio_up'])){
                	$privilegio=mainModel::limpiar_cadena($_POST['usuario_privilegio_up']);
                
				}else{
                    $privilegio=$campos['usuario_privilegio'];
                }

				if (isset($_POST['usuario_cargo_up'])){
                	$cargo=mainModel::limpiar_cadena($_POST['usuario_cargo_up']);
                
				}else{
                    $cargo=$campos['usuario_cargo'];
                } 

                 
				$admin_usuario=mainModel::limpiar_cadena($_POST['usuario_admin']); 
				$admin_clave=mainModel::limpiar_cadena($_POST['clave_admin']); 
				$tipo_cuenta=mainModel::limpiar_cadena($_POST['tipo_cuenta']);

				/* comprobar campos vacios */
				if ($dni == "" || $nombre == "" || $apellido == "" || $usuario == "" || $admin_usuario == "" || $admin_clave == "") {
					$alerta = [
						"Alerta" => "simple",
						"Titulo" => "Ocurrió un error inesperado",
						"Texto"  => "No has llenado todos los campos que son obligatorios",
						"Tipo"   => "error"
					];
					echo json_encode($alerta);
					exit();
				}

              /* Verificando integridad de los datos */
            	if (mainModel::verificar_datos("[0-9-]{7,20}", $dni)) {
                $alerta = [
                    "Alerta" => "simple",
                    "Titulo" => "Ocurrió un error inesperado",
                    "Texto"  => "El DNI no coincide con el formato solicitado",
                    "Tipo"   => "error"
                ];
                echo json_encode($alerta);
                exit();
            	}

            	if (mainModel::verificar_datos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{1,35}", $nombre)) {
                $alerta = [
                    "Alerta" => "simple",
                    "Titulo" => "Ocurrió un error inesperado",
                    "Texto"  => "El NOMBRE no coincide con el formato solicitado",
                    "Tipo"   => "error"
                ];
                echo json_encode($alerta);
                exit();
            	}

            	if (mainModel::verificar_datos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{1,35}", $apellido)) {
                $alerta = [
                    "Alerta" => "simple",
                    "Titulo" => "Ocurrió un error inesperado",
                    "Texto"  => "El APELLIDO no coincide con el formato solicitado",
                    "Tipo"   => "error"
                ];
                echo json_encode($alerta);
                exit();
            	}

            	if ($telefono != "") {
                if (mainModel::verificar_datos("[0-9()+]{8,20}", $telefono)) {
                    $alerta = [
                        "Alerta" => "simple",
                        "Titulo" => "Ocurrió un error inesperado",
                        "Texto"  => "El TELEFONO no coincide con el formato solicitado",
                        "Tipo"   => "error"
                    ];
                    echo json_encode($alerta);
                    exit();
                	}
            	}


            	if (mainModel::verificar_datos("[a-zA-Z0-9]{1,35}", $usuario)) {
                $alerta = [
                    "Alerta" => "simple",
                    "Titulo" => "Ocurrió un error inesperado",
                    "Texto"  => "El NOMBRE DE USUARIO no coincide con el formato solicitado",
                    "Tipo"   => "error"
                ];
                echo json_encode($alerta);
                exit();
            	}


            	if (mainModel::verificar_datos("[a-zA-Z0-9]{1,35}", $admin_usuario)) {
                $alerta = [
                    "Alerta" => "simple",
                    "Titulo" => "Ocurrió un error inesperado",
                    "Texto"  => "El NOMBRE DE USUARIO no coincide con el formato solicitado",
                    "Tipo"   => "error"
                ];
                echo json_encode($alerta);
                exit();
            	}
             

            	if (mainModel::verificar_datos("[a-zA-Z0-9$@.-]{7,100}", $admin_clave)) {
                $alerta = [
                    "Alerta" => "simple",
                    "Titulo" => "Ocurrió un error inesperado",
                    "Texto"  => "Tu CLAVE no coincide con el formato solicitado",
                    "Tipo"   => "error"
                ];
                echo json_encode($alerta);
                exit();
            	}

             	$admin_clave=mainModel::encryption($admin_clave);
             	if ($privilegio <1 || $privilegio>2) {
                 $alerta = [
                    "Alerta" => "simple",
                    "Titulo" => "Ocurrió un error inesperado",
                    "Texto"  => "El privilegio no corresponde a un valor valido",
                    "Tipo"   => "error"
                ];
                echo json_encode($alerta);
                exit();
             	}

             	if ($estado!= "Activa" && $estado!= "Deshabilitado") {
                 $alerta = [
                    "Alerta" => "simple",
                    "Titulo" => "Ocurrió un error inesperado",
                    "Texto"  => "El estado de la cuenta no coincide con el formato solicitado",
                    "Tipo"   => "error"
                ];
                echo json_encode($alerta);
                exit();
             	}

			 	if ($cargo!= "Coordinador" && $cargo!= "Instructor") {
				$alerta = [
				   "Alerta" => "simple",
				   "Titulo" => "Ocurrió un error inesperado",
				   "Texto"  => "El cargo de la cuenta no coincide con el formato solicitado",
				   "Tipo"   => "error"
			   ];
			   echo json_encode($alerta);
			   exit();
				}
                      /* Comprobando DNI */
                if ($dni!=$campos['usuario_dni']) {
                    
                
                $check_dni = mainModel::ejecutar_consulta_simple("SELECT usuario_dni FROM tblusuario WHERE usuario_dni='$dni'");
                if ($check_dni->rowCount() > 0) {
                    $alerta = [
                        "Alerta" => "simple",
                        "Titulo" => "Ocurrió un error inesperado",
                        "Texto"  => "El DNI ingresado ya se encuentra registrado en el sistema",
                        "Tipo"   => "error"
                    ];

                    echo json_encode($alerta);
                    exit();
                 }
                }

                /* Comprobando usuario */
                if($usuario!=$campos['usuario_usuario']){

                $check_user = mainModel::ejecutar_consulta_simple("SELECT usuario_usuario FROM tblusuario WHERE usuario_usuario='$usuario'");
                if ($check_user->rowCount() > 0) {
                    $alerta = [
                        "Alerta" => "simple",
                        "Titulo" => "Ocurrió un error inesperado",
                        "Texto"  => "El Nombre de Usuario ingresado ya se encuentra registrado en el sistema",
                        "Tipo"   => "error"
                    ];
                    echo json_encode($alerta);
                    exit();

                 }
                }
                /* Comprobando Email =*/
                if ($email!=$campos['usuario_email'] && $email!=""){
                    if(filter_var($email,FILTER_VALIDATE_EMAIL)){
                        $check_email = mainModel::ejecutar_consulta_simple("SELECT usuario_email FROM tblusuario WHERE usuario_email='$email'");
                        if ($check_email->rowCount()>0) {
                        $alerta = [
                            "Alerta" => "simple",
                            "Titulo" => "Ocurrió un error inesperado",
                            "Texto"  => "El nuevo email ingresado ya se encuentra registrado en el sistema",
                            "Tipo"   => "error"
                    ];
                    echo json_encode($alerta);
                    exit();

                    }
                    }else{
                        $alerta = [
                        "Alerta" => "simple",
                        "Titulo" => "Ocurrió un error inesperado",
                        "Texto"  => "Ha ingresado un correo no valido",
                        "Tipo"   => "error"
                    ];
                    echo json_encode($alerta);
                    exit();

                    }
                    
                }

				/* Comprobando telefono*/
                if($telefono!=$campos['usuario_telefono']){

				$check_telefono=mainModel::ejecutar_consulta_simple("SELECT usuario_telefono FROM tblusuario WHERE usuario_telefono='$telefono'");
					if($check_telefono->rowCount()>0){
						$alerta=[
							"Alerta"=>"simple",
							"Titulo"=>"Ocurrió un error inesperado",
							"Texto"=>"El Numero de telefono $telefono  ya se encuentra registrado en el sistema",
							"Tipo"=>"error"
						];
						echo json_encode($alerta);
						exit();
					}

				}

           		/* Comprobando claves */
           		if ($_POST['usuario_clave_nueva_1']!= "" || $_POST['usuario_clave_nueva_2']!= "") {
               if($_POST['usuario_clave_nueva_1']!=$_POST['usuario_clave_nueva_2']){
                $alerta = [
                        "Alerta" => "simple",
                        "Titulo" => "Ocurrió un error inesperado",
                        "Texto"  => "Las nuevas claves ingresadas no coinciden",
                        "Tipo"   => "error"
                    ];
                    echo json_encode($alerta);
                    exit();
               	}
               	else{
               	if(mainModel::verificar_datos("[a-zA-Z0-9$@.-]{7,100}",$_POST['usuario_clave_nueva_1']) || mainModel::verificar_datos("[a-zA-Z0-9$@.-]{7,100}",$_POST['usuario_clave_nueva_2'])){
                $alerta = [
                        "Alerta" => "simple",
                        "Titulo" => "Ocurrió un error inesperado",
                        "Texto"  => "Las nuevas claves no coinciden  con el formato solicitado",
                        "Tipo"   => "error"
                    ];
                    echo json_encode($alerta);
                    exit();

               }
               $clave=mainModel::encryption($_POST['usuario_clave_nueva_1']);
               }
           	}
           	else{
            $clave=$campos['usuario_clave'];

           	}
          /* COMPROBANDO LAS CREDIDENCIALES PARA ACTUALIZACION DATOS */
           	if($tipo_cuenta=="propia"){
               $check_cuenta=mainModel::ejecutar_consulta_simple("SELECT usuario_id FROM tblusuario WHERE usuario_usuario='$admin_usuario' AND usuario_clave='$admin_clave' AND usuario_id='$id'");
           }else{
            session_start(['name'=>'SPM']);
            if($_SESSION['privilegio_spm']!=1){
                $alerta = [
                        "Alerta" => "simple",
                        "Titulo" => "Ocurrió un error inesperado",
                        "Texto"  => "No tienes los permisos necesarios para realizar esta operacion",
                        "Tipo"   => "error"
                    ];
                    echo json_encode($alerta);
                    exit();

            	}
            	$check_cuenta=mainModel::ejecutar_consulta_simple("SELECT usuario_id FROM tblusuario WHERE usuario_usuario='$admin_usuario' AND usuario_clave='$admin_clave'");
           }

           if($check_cuenta->rowCount()<=0){
             $alerta = [
                        "Alerta" => "simple",
                        "Titulo" => "Ocurrió un error inesperado",
                        "Texto"  => "Nombre y Clave de administrador no validos",
                        "Tipo"   => "error"
                    ];
                    echo json_encode($alerta);
                    exit();
           }
            /* Preparandos datos para  enviarlos al modelo */

            $datos_usuario_up=[
				"DNI"=>$dni,
				"Nombre"=>$nombre,
				"Apellido"=>$apellido,
				"Telefono"=>$telefono,
				"Email"=>$email,
				"Usuario"=>$usuario,
				"Clave"=>$clave,
				"Estado"=>$estado,
				"Cargo"=>$cargo,
				"Privilegio"=>$privilegio,
				"ID"=>$id
				];

                if(usuarioModelo::actualizar_usuario_modelo($datos_usuario_up)){
                  $alerta = [
                    "Alerta"  => "recargar",
                    "Titulo" => "Datos actualizados",
                    "Texto"  => "Los datos han sido actualizados con exito",
                    "Tipo"   => "success"
                    ];
                    }else{
                      $alerta = [
                        "Alerta" => "simple",
                        "Titulo" => "Ocurrió un error inesperado",
                        "Texto"  => "No hemos podido actualizar los datos, por favor intenta nuevamente",
                        "Tipo"   => "error"
                    ];
               }
                    echo json_encode($alerta);


      }/*fin de controlador*/

	  	/* CONTROLADOR ACTUALIZAR PERFIL DE USUARIO */
	  public function actualizar_perfil_usuario_controlador(){
		  //recibiendo id
		  $id=mainModel::decryption($_POST['usuario_perfil_up']);
		  $id=mainModel::limpiar_cadena($id);

		  //Comprobar el usuario en la BD

		  $check_user=mainModel::ejecutar_consulta_simple("SELECT * FROM tblusuario WHERE usuario_id='$id'");
			  if ( $check_user->rowCount()<=0) {
				  $alerta = [
					  "Alerta" => "simple",
					  "Titulo" => "Ocurrió un error inesperado",
					  "Texto"  => "No hemos encontrado el usuario en el sistema",
					  "Tipo"   => "error"
				  ];
				  echo json_encode($alerta);
				   exit();
			  }else{
				   $campos=$check_user->fetch();
				   
			  }

			  /**/
			  $dni=mainModel::limpiar_cadena($_POST['usuario_dni_up']);
			  $nombre=mainModel::limpiar_cadena($_POST['usuario_nombre_up']);
			  $apellido=mainModel::limpiar_cadena($_POST['usuario_apellido_up']);
			  $telefono=mainModel::limpiar_cadena($_POST['usuario_telefono_up']);
			  $usuario=mainModel::limpiar_cadena($_POST['usuario_usuario_up']);
			  $email=mainModel::limpiar_cadena($_POST['usuario_email_up']);
	
			  /* comprobar campos vacios */
			  if ($dni == "" || $nombre == "" || $apellido == "" || $usuario == "") {
				  $alerta = [
					  "Alerta" => "simple",
					  "Titulo" => "Ocurrió un error inesperado",
					  "Texto"  => "No has llenado todos los campos que son obligatorios",
					  "Tipo"   => "error"
				  ];
				  echo json_encode($alerta);
				  exit();
			  }

			/* Verificando integridad de los datos */
		  if (mainModel::verificar_datos("[0-9-]{7,20}", $dni)) {
			  $alerta = [
				  "Alerta" => "simple",
				  "Titulo" => "Ocurrió un error inesperado",
				  "Texto"  => "El DNI no coincide con el formato solicitado",
				  "Tipo"   => "error"
			  ];
			  echo json_encode($alerta);
			  exit();
		  }

		  if (mainModel::verificar_datos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{1,35}", $nombre)) {
			  $alerta = [
				  "Alerta" => "simple",
				  "Titulo" => "Ocurrió un error inesperado",
				  "Texto"  => "El NOMBRE no coincide con el formato solicitado",
				  "Tipo"   => "error"
			  ];
			  echo json_encode($alerta);
			  exit();
		  }

		  if (mainModel::verificar_datos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{1,35}", $apellido)) {
			  $alerta = [
				  "Alerta" => "simple",
				  "Titulo" => "Ocurrió un error inesperado",
				  "Texto"  => "El APELLIDO no coincide con el formato solicitado",
				  "Tipo"   => "error"
			  ];
			  echo json_encode($alerta);
			  exit();
		  }

		  if ($telefono != "") {
			  if (mainModel::verificar_datos("[0-9()+]{8,20}", $telefono)) {
				  $alerta = [
					  "Alerta" => "simple",
					  "Titulo" => "Ocurrió un error inesperado",
					  "Texto"  => "El TELEFONO no coincide con el formato solicitado",
					  "Tipo"   => "error"
				  ];
				  echo json_encode($alerta);
				  exit();
			  }
		  }


		  if (mainModel::verificar_datos("[a-zA-Z0-9]{1,35}", $usuario)) {
			  $alerta = [
				  "Alerta" => "simple",
				  "Titulo" => "Ocurrió un error inesperado",
				  "Texto"  => "El NOMBRE DE USUARIO no coincide con el formato solicitado",
				  "Tipo"   => "error"
			  ];
			  echo json_encode($alerta);
			  exit();
		  }


		  
					/* Comprobando DNI */
			  if ($dni!=$campos['usuario_dni']) {
				  
			  
			  $check_dni = mainModel::ejecutar_consulta_simple("SELECT usuario_dni FROM tblusuario WHERE usuario_dni='$dni'");
			  if ($check_dni->rowCount() > 0) {
				  $alerta = [
					  "Alerta" => "simple",
					  "Titulo" => "Ocurrió un error inesperado",
					  "Texto"  => "El DNI ingresado encuentra registrado en el sistema",
					  "Tipo"   => "error"
				  ];

				  echo json_encode($alerta);
				  exit();
			   }
			  }

			  /* Comprobando usuario */
			  if($usuario!=$campos['usuario_usuario']){

			  $check_user = mainModel::ejecutar_consulta_simple("SELECT usuario_usuario FROM tblusuario WHERE usuario_usuario='$usuario'");
			  if ($check_user->rowCount() > 0) {
				  $alerta = [
					  "Alerta" => "simple",
					  "Titulo" => "Ocurrió un error inesperado",
					  "Texto"  => "El Nombre de Usuario ingresado encuentra registrado en el sistema",
					  "Tipo"   => "error"
				  ];
				  echo json_encode($alerta);
				  exit();

			   }
			  }
			  /* Comprobando Email =*/
			  if ($email!=$campos['usuario_email'] && $email!=""){
				  if(filter_var($email,FILTER_VALIDATE_EMAIL)){
					  $check_email = mainModel::ejecutar_consulta_simple("SELECT usuario_email FROM tblusuario WHERE usuario_email='$email'");
					  if ($check_email->rowCount()>0) {
					  $alerta = [
						  "Alerta" => "simple",
						  "Titulo" => "Ocurrió un error inesperado",
						  "Texto"  => "El nuevo EMAIL $email ingresado encuentra registrado en el sistema",
						  "Tipo"   => "error"
				  ];
				  echo json_encode($alerta);
				  exit();

				  }
				  }else{
					  $alerta = [
					  "Alerta" => "simple",
					  "Titulo" => "Ocurrió un error inesperado",
					  "Texto"  => "Ha ingresado un correo no valido",
					  "Tipo"   => "error"
				  ];
				  echo json_encode($alerta);
				  exit();

				  }
				  
			  }

			  /* Comprobando telefono*/
			  if($telefono!=$campos['usuario_telefono']){

			  $check_telefono=mainModel::ejecutar_consulta_simple("SELECT usuario_telefono FROM tblusuario WHERE usuario_telefono='$telefono'");
				  if($check_telefono->rowCount()>0){
					  $alerta=[
						  "Alerta"=>"simple",
						  "Titulo"=>"Ocurrió un error inesperado",
						  "Texto"=>"El Numero de telefono $telefono encuentra registrado en el sistema",
						  "Tipo"=>"error"
					  ];
					  echo json_encode($alerta);
					  exit();
		 		 }

	  		}

		 	/* Comprobando claves */
		 	if ($_POST['usuario_clave_nueva_1']!= "" || $_POST['usuario_clave_nueva_2']!= "") {
			 	if($_POST['usuario_clave_nueva_1']!=$_POST['usuario_clave_nueva_2']){
			  		$alerta = [
						"Alerta" => "simple",
						"Titulo" => "Ocurrió un error inesperado",
						"Texto"  => "Las nuevas claves ingresadas no coinciden",
						"Tipo"   => "error"
					];
					echo json_encode($alerta);
					exit();
				}
				else{
				if(mainModel::verificar_datos("[a-zA-Z0-9$@.-]{7,100}",$_POST['usuario_clave_nueva_1']) || mainModel::verificar_datos("[a-zA-Z0-9$@.-]{7,100}",$_POST['usuario_clave_nueva_2'])){
				$alerta = [
						"Alerta" => "simple",
						"Titulo" => "Ocurrió un error inesperado",
						"Texto"  => "Las nuevas claves no coinciden  con el formato solicitado",
						"Tipo"   => "error"
					];
					echo json_encode($alerta);
					exit();

				}
				$clave=mainModel::encryption($_POST['usuario_clave_nueva_1']);
				}
			}
			else{
			$clave=$campos['usuario_clave'];

			}

		  /* Preparandos datos para  enviarlos al modelo */

			$datos_usuario_up=[
				"DNI"=>$dni,
				"Nombre"=>$nombre,
				"Apellido"=>$apellido,
				"Telefono"=>$telefono,
				"Email"=>$email,
				"Usuario"=>$usuario,
				"Clave"=>$clave,
				"ID"=>$id
				];

			  if(usuarioModelo::actualizar_perfil_usuario_modelo($datos_usuario_up)){
				$alerta = [
				  "Alerta"  => "recargar",
				  "Titulo" => "Datos actualizados",
				  "Texto"  => "Los datos han sido actualizados con exito",
				  "Tipo"   => "success"
				  ];
				  }else{
					$alerta = [
					  "Alerta" => "simple",
					  "Titulo" => "Ocurrió un error inesperado",
					  "Texto"  => "No hemos podido actualizar los datos, por favor intenta nuevamente",
					  "Tipo"   => "error"
				  ];
			 	}
				  echo json_encode($alerta);

	 	 }

	}

?>