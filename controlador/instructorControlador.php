<?php

	if($peticionAjax){
		require_once "../modelo/instructorModelo.php";
	}else{
		require_once "./modelo/instructorModelo.php";
	}

	class instructorControlador extends instructorModelo{

		/*--------- Controlador agregar usuario ---------*/
		public function agregar_instructor_controlador(){
			$dni=mainModel::limpiar_cadena($_POST['identificacion_ins']);
			$nombres=mainModel::limpiar_cadena($_POST['nombres_ins']);
			$apellidos=mainModel::limpiar_cadena($_POST['apellidos_ins']);
            $email=mainModel::limpiar_cadena($_POST['email_ins']);
			$telefono=mainModel::limpiar_cadena($_POST['telefono_ins']);
			


			/*== comprobar campos vacios ==*/
			if($dni=="" || $nombres=="" || $apellidos=="" || $email=="" || $telefono==""){
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
			if(mainModel::verificar_datos("[0-9-]{8,20}",$dni)){
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"El NUMERO DE IDENTIFICACION no coincide con el formato solicitado",
					"Tipo"=>"error"
				];
				echo json_encode($alerta);
				exit();
			}

			if(mainModel::verificar_datos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{1,35}",$nombres)){
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"El NOMBRE no coincide con el formato solicitado",
					"Tipo"=>"error"
				];
				echo json_encode($alerta);
				exit();
			}

			if(mainModel::verificar_datos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{1,35}",$apellidos)){
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


			/*== Comprobando DNI ==*/
			$check_id=mainModel::ejecutar_consulta_simple("SELECT InsIdentificacion FROM tblinstructor WHERE InsIdentificacion='$dni'");
			if($check_id->rowCount()>0){
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"El NUMERO DE IDENTIFICACION $dni encuentra registrado en el sistema",
					"Tipo"=>"error"
				];
				echo json_encode($alerta);
				exit();
			}


			/*== Comprobando email ==*/
			if($email!=""){
				if(filter_var($email,FILTER_VALIDATE_EMAIL)){
					$check_email=mainModel::ejecutar_consulta_simple("SELECT InsEmail FROM tblinstructor WHERE InsEmail='$email'");
					if($check_email->rowCount()>0){
						$alerta=[
							"Alerta"=>"simple",
							"Titulo"=>"Ocurrió un error inesperado",
							"Texto"=>"El EMAIL $email encuentra registrado en el sistema",
							"Tipo"=>"error"
						];
						echo json_encode($alerta);
						exit();
					}
				}else{
					$alerta=[
						"Alerta"=>"simple",
						"Titulo"=>"Ocurrió un error inesperado",
						"Texto"=>"Ha ingresado un EMAIL no valido",
						"Tipo"=>"error"
					];
					echo json_encode($alerta);
					exit();
				}
			}

			$check_telefono=mainModel::ejecutar_consulta_simple("SELECT InsTelefono FROM tblinstructor WHERE InsTelefono='$telefono'");
			if($check_telefono->rowCount()>0){
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"El TELEFONO $telefono encuentra registrado en el sistema",
					"Tipo"=>"error"
				];
				echo json_encode($alerta);
				exit();
			}

			$datos_instructor_reg=[
				"Identificacion"=>$dni,
				"Nombres"=>$nombres,
				"Apellidos"=>$apellidos,
                "Email"=>$email,
				"Telefono"=>$telefono
			];

			$agregar_instructor=instructorModelo::agregar_instructor_modelo($datos_instructor_reg);

			if($agregar_instructor->rowCount()==1){
				$alerta=[
					"Alerta"=>"limpiar",
					"Titulo"=>"instructor registrado",
					"Texto"=>"Los datos del instructor han sido registrados con exito",
					"Tipo"=>"success"
				];
			}else{
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"No hemos podido registrar el instructor",
					"Tipo"=>"error"
				];
			}
			echo json_encode($alerta);
		} /* Fin controlador */

		/* PAGINADOR USUARIO*/
		public function paginador_instructor_controlador($pagina,$registros,$privilegio,$id,$url,$busqueda){
			
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
				$consulta="SELECT SQL_CALC_FOUND_ROWS * FROM tblinstructor WHERE ((InsId!='$id') AND (InsIdentificacion LIKE '%$busqueda%' OR InsNombres LIKE '%$busqueda%' OR InsApellidos LIKE '%$busqueda%' OR InsEmail LIKE '%$busqueda%' OR InsTelefono LIKE '%$busqueda%')) ORDER BY InsNombres ASC LIMIT $inicio,$registros";

			}else{
				$consulta="SELECT SQL_CALC_FOUND_ROWS * FROM tblinstructor WHERE InsId ORDER BY InsNombres ASC LIMIT $inicio,$registros";
			}

			$conexion = mainModel::conectar();

			$datos = $conexion->query($consulta);
			$datos = $datos->fetchALL();
			
			$total = $conexion->query("SELECT FOUND_ROWS()");
			$total = (int) $total->fetchColumn();

			$Npaginas=ceil($total/$registros);
			$tabla.='<table class="table table-hover table-condensed" id="iddatetable">
						<thead>
							<tr class="">
								<td>#</td>
								<td>Identificacion</td>
								<td>Nombres</td>
								<td>Apellidos</td>
								<td>Email</td>
								<td>Telefono</td>
								<td>Acciones</td>
							</tr>
						</thead>
						<tbody>
						</form>';
			if($total>=1 && $pagina<=$Npaginas){
				$contador=$inicio+1;
				$reg_inicio=$inicio+1;
				foreach($datos as $rows){
					$tabla.='<tr class="text-center">
								<tr>
								<td>'.$contador.'</td>
								<td>'.$rows['InsIdentificacion'].'</td>
								<td>'.$rows['InsNombres'].'</td>
								<td>'.$rows['InsApellidos'].'</td>
								<td>'.$rows['InsEmail'].'</td>
								<td>'.$rows['InsTelefono'].'</td>
								<td class="row align-items-startrow align-items-start">
									<a href="'.SERVERURL.'usuario-asignar/'.mainModel::encryption($rows['InsId']).'/" class="btn btn-table ml-1" data-bs-toggle="tooltip" data-bs-placement="top" title="Asignar usuario"><i class="fas fa-user"></i>	
									</a>

									<a href="'.SERVERURL.'evento-asignacion/'.mainModel::encryption($rows['InsId']).'/" class="btn btn-warning" data-bs-toggle="tooltip" data-bs-placement="top" title="Asignar horario"><i class="fas fa-plus"></i>	
									</a>

									<a href="'.SERVERURL.'instructor-actualizar/'.mainModel::encryption($rows['InsId']).'/" class="btn btn-primary ml-1" data-bs-toggle="tooltip" data-bs-placement="top" title="Actualizar">
											<i class="fas fa-sync-alt"></i>	
									</a>
								
									<form class="FormularioAjax ml-1" action="'.SERVERURL.'ajax/instructorAjax.php" method="POST" data-form="delete" autocomplete="off">
									<input type="hidden" name="instructor_del" value="'.mainModel::encryption($rows['InsId']).'">
										<button type="submit" class="btn btn-danger" data-bs-toggle="tooltip" data-bs-placement="top" title="Eliminar">
												<i class="far fa-trash-alt"></i>
										</button>
									</form>
								</td>
							</tr>
							</tr>';
							$contador++;
				}
				$reg_final=$contador-1;
			}else{
				if($total>=1){
					$tabla.='<tr class="text-center" ><td colspan="9"><a href="'.$url.'" class="btn btn-raised btn-danger btn-sm">Haga click aca para recargar el listado</a></td></tr>';
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
		

		public function eliminar_instructor_controlador(){

			/* RECIBIENDO ID DEL USUARIO*/
			$id=mainModel::decryption($_POST['instructor_del']);
			$id=mainModel::limpiar_cadena($id);
		

			/* COMPROBANDO EL USUARIO EN LA BASE DE DATOS*/
			$check_isntructor=mainModel::ejecutar_consulta_simple("SELECT InsId FROM tblinstructor WHERE InsId='$id'");
			if($check_isntructor->rowCount()<=0){
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrio un error inesperado",
					"Texto"=>"El instructor que intenta eliminar no existe en la base de datos",
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

			$eliminar_instructor=instructorModelo::eliminar_instructor_modelo($id);
			
			if($eliminar_instructor->rowCount()==1){
				$alerta=[
					"Alerta"=>"recargar",
					"Titulo"=>"Instructor eliminado",
					"Texto"=>"Instructor eliminado con exito",
					"Tipo"=>"success"
				];

			}else{
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrio un error inesperado",
					"Texto"=>"No hemos podido eliminar el instructor, intenta nuevamente",
					"Tipo"=>"error"
				];
			
			}
			echo json_encode($alerta);

		}	/* Fin controlador */

		/* CONTROLADOR DATOS USUARIO */
		public function datos_instructor_controlador($tipo,$id){
			$tipo=mainModel::limpiar_cadena($tipo);

			$id=mainModel::decryption($id);
			$id=mainModel::limpiar_cadena($id);

			return instructorModelo::datos_instructor_modelo($tipo,$id);

		}/* Fin controlador */

		public function actualizar_instructor_controlador(){
            //recibiendo id
            $id=mainModel::decryption($_POST['instructor_id_up']);
            $id=mainModel::limpiar_cadena($id);

            //Comprobar el usuario en la BD

            $check_user=mainModel::ejecutar_consulta_simple("SELECT * FROM tblinstructor WHERE InsId='$id'");
                if ( $check_user->rowCount()<=0) {
                    $alerta = [
                        "Alerta" => "simple",
                        "Titulo" => "Ocurrió un error inesperado",
                        "Texto"  => "No hemos encontrado el instructor en el sistema",
                        "Tipo"   => "error"
                    ];
                    echo json_encode($alerta);
                     exit();
                }else{
                     $campos=$check_user->fetch();
                     
                }

                /**/
                $dni=mainModel::limpiar_cadena($_POST['instructor_dni_up']);
                $nombre=mainModel::limpiar_cadena($_POST['instructor_nombre_up']);
                $apellido=mainModel::limpiar_cadena($_POST['instructor_apellido_up']);
				$email=mainModel::limpiar_cadena($_POST['instructor_email_up']);
                $telefono=mainModel::limpiar_cadena($_POST['instructor_telefono_up']); 


				/* comprobar campos vacios */
				if ($dni == "" || $nombre == "" || $apellido == "" || $email == "") {
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

             

       			/* Comprobando DNI */
                if ($dni!=$campos['InsIdentificacion']) {
                    
                
                $check_dni = mainModel::ejecutar_consulta_simple("SELECT InsIdentificacion FROM tblinstructor WHERE InsIdentificacion='$dni'");
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
                /* Comprobando Email =*/
                if ($email!=$campos['InsEmail'] && $email!=""){
                    if(filter_var($email,FILTER_VALIDATE_EMAIL)){
                        $check_email = mainModel::ejecutar_consulta_simple("SELECT InsEmail FROM tblinstructor WHERE InsEmail='$email'");
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
           
            /* Preparandos datos para  enviarlos al modelo */

            $datos_instructor_up=[
				"DNI"=>$dni,
				"Nombre"=>$nombre,
				"Apellido"=>$apellido,
				"Telefono"=>$telefono,
				"Email"=>$email,
				"ID"=>$id
				];

                if(instructorModelo::actualizar_instructor_modelo($datos_instructor_up)){
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
	}

	?>