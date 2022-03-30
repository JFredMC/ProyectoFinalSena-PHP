<?php

	if($peticionAjax){
		require_once "../modelo/programaModelo.php";
	}else{
		require_once "./modelo/programaModelo.php";
	}

	class programaControlador extends programaModelo{

		/*--------- Controlador agregar programa formacion ---------*/
		public function agregar_programa_controlador(){
			$codigoPro=mainModel::limpiar_cadena($_POST['codigo_programa']);
			$nombre=mainModel::limpiar_cadena($_POST['nombre_programa']);
			

			/*== comprobar campos vacios ==*/
			if($codigoPro=="" || $nombre==""){
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
			if(mainModel::verificar_datos("[0-9-]{1,20}",$codigoPro)){
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"El CODIGO DEL PROGRAMA no coincide con el formato solicitado",
					"Tipo"=>"error"
				];
				echo json_encode($alerta);
				exit();
			}

			if(mainModel::verificar_datos("[a-zA-ZáéíóúÁÉÍÓÚñÑ, ]{1,500}",$nombre)){
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"El NOMBRE DEL PROGRAMA no coincide con el formato solicitado",
					"Tipo"=>"error"
				];
				echo json_encode($alerta);
				exit();
			}

			$check_codigo=mainModel::ejecutar_consulta_simple("SELECT ProCodigoPrograma FROM tblprogramaformacion WHERE ProCodigoPrograma='$codigoPro'");
			if($check_codigo->rowCount()>0){
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"El CODIGO del programa de formacion $codigoPro encuentra registrado en el sistema",
					"Tipo"=>"error"
				];
				echo json_encode($alerta);
				exit();
			}

			$check_nombre=mainModel::ejecutar_consulta_simple("SELECT ProNombre FROM tblprogramaformacion WHERE ProNombre='$nombre'");
			if($check_nombre->rowCount()>0){
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"El NOMBRE del programa de formacion encuentra registrado en el sistema",
					"Tipo"=>"error"
				];
				echo json_encode($alerta);
				exit();
			}


			$datos_programa_reg=[
				"CodigoPrograma"=>$codigoPro,
				"Nombre"=>$nombre
			];

			$agregar_programa=programaModelo::agregar_programa_modelo($datos_programa_reg);

			if($agregar_programa->rowCount()==1){
				$alerta=[
					"Alerta"=>"limpiar",
					"Titulo"=>"programa registrado",
					"Texto"=>"Los datos del programa han sido registrados con exito",
					"Tipo"=>"success"
				];
			}else{
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"No hemos podido registrar el programa",
					"Tipo"=>"error"
				];
			}
			echo json_encode($alerta);
		} /* Fin controlador */

		/* PAGINADOR USUARIO*/
		public function paginador_programa_controlador($pagina,$registros,$privilegio,$id,$url,$busqueda){
			
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
				$consulta="SELECT SQL_CALC_FOUND_ROWS * FROM tblprogramaformacion WHERE ((ProCodigo!='$id') AND (ProCodigoPrograma LIKE '%$busqueda%' OR ProNombre LIKE '%$busqueda%')) ORDER BY ProNombre ASC LIMIT $inicio,$registros";

			}else{
				$consulta="SELECT SQL_CALC_FOUND_ROWS * FROM tblprogramaformacion WHERE ProCodigo ORDER BY ProCodigoPrograma ASC LIMIT $inicio,$registros";
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
								<td>Codigo del programa</td>
								<td>Nombre del programa</td>
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
								<td>'.$rows['ProCodigoPrograma'].'</td>
								<td>'.$rows['ProNombre'].'</td>
								<td class="row">

									<a href="'.SERVERURL.'programa-formacion-actualizar/'.mainModel::encryption($rows['ProCodigo']).'/" class="btn btn-primary ml-1" data-bs-toggle="tooltip" data-bs-placement="top" title="Actualizar">
											<i class="fas fa-sync-alt"></i>	
									</a>
								
									<form class="FormularioAjax ml-1" action="'.SERVERURL.'ajax/programaAjax.php" method="POST" data-form="delete" autocomplete="off">
									<input type="hidden" name="programa_del" value="'.mainModel::encryption($rows['ProCodigo']).'">
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
				$tabla.='<p class="text-right py-2">Mostrando programa de formacion '.$reg_inicio.' al '.$reg_final.' de un total de '.$total.'</p>';
				$tabla.=mainModel::paginador_tablas($pagina,$Npaginas,$url,7);

			}

			return $tabla;

		}
		

		public function eliminar_programa_controlador(){

			/* RECIBIENDO ID DEL USUARIO*/
			$id=mainModel::decryption($_POST['programa_del']);
			$id=mainModel::limpiar_cadena($id);
		

			/* COMPROBANDO EL USUARIO EN LA BASE DE DATOS*/
			$check_programa=mainModel::ejecutar_consulta_simple("SELECT ProCodigo FROM tblprogramaformacion WHERE ProCodigo='$id'");
			if($check_programa->rowCount()<=0){
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrio un error inesperado",
					"Texto"=>"El PROGRAMA DE FORMACION que intenta eliminar no existe en la base de datos",
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

			$eliminar_programa=programaModelo::eliminar_programa_modelo($id);
			
			if($eliminar_programa->rowCount()==1){
				$alerta=[
					"Alerta"=>"recargar",
					"Titulo"=>"Programa eliminado",
					"Texto"=>"Programa eliminado con exito",
					"Tipo"=>"success"
				];

			}else{
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrio un error inesperado",
					"Texto"=>"No hemos podido eliminar el programa, intenta nuevamente",
					"Tipo"=>"error"
				];
			
			}
			echo json_encode($alerta);

		}	/* Fin controlador */

		/* CONTROLADOR DATOS USUARIO */
		public function datos_programa_controlador($tipo,$id){
			$tipo=mainModel::limpiar_cadena($tipo);

			$id=mainModel::decryption($id);
			$id=mainModel::limpiar_cadena($id);

			return programaModelo::datos_programa_modelo($tipo,$id);

		}/* Fin controlador */

		public function actualizar_programa_controlador(){
            //recibiendo id
            $id=mainModel::decryption($_POST['programa_id_up']);
            $id=mainModel::limpiar_cadena($id);

            //Comprobar el usuario en la BD

            $check_programa=mainModel::ejecutar_consulta_simple("SELECT * FROM tblprogramaformacion WHERE ProCodigo='$id'");
                if ( $check_programa->rowCount()<=0) {
                    $alerta = [
                        "Alerta" => "simple",
                        "Titulo" => "Ocurrió un error inesperado",
                        "Texto"  => "No hemos encontrado el programa de formacion en el sistema",
                        "Tipo"   => "error"
                    ];
                    echo json_encode($alerta);
                     exit();
                }else{
                     $campos=$check_programa->fetch();
                     
                }

                /**/
                $codigoPro=mainModel::limpiar_cadena($_POST['codigo_programa_up']);
                $nombre=mainModel::limpiar_cadena($_POST['nombre_programa_up']);


				/* comprobar campos vacios */
				if ($codigoPro == "" || $nombre == "") {
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
            if (mainModel::verificar_datos("[0-9-]{4,20}", $codigoPro)) {
                $alerta = [
                    "Alerta" => "simple",
                    "Titulo" => "Ocurrió un error inesperado",
                    "Texto"  => "El CODIGO DEL PROGRAMA no coincide con el formato solicitado",
                    "Tipo"   => "error"
                ];
                echo json_encode($alerta);
                exit();
            }

            if (mainModel::verificar_datos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{1,500}", $nombre)) {
                $alerta = [
                    "Alerta" => "simple",
                    "Titulo" => "Ocurrió un error inesperado",
                    "Texto"  => "El NOMBRE DEL PROGRAMA no coincide con el formato solicitado",
                    "Tipo"   => "error"
                ];
                echo json_encode($alerta);
                exit();
            }


       			/* Comprobando DNI */
                if ($codigoPro!=$campos['ProCodigoPrograma']) {
                    
                
                $check_codigoPro = mainModel::ejecutar_consulta_simple("SELECT ProCodigoPrograma FROM tblprogramaformacion WHERE ProCodigoPrograma='$codigoPro'");
                if ($check_codigoPro->rowCount() > 0) {
                    $alerta = [
                        "Alerta" => "simple",
                        "Titulo" => "Ocurrió un error inesperado",
                        "Texto"  => "El CODIGO DEL PROGRAMA $codigoPro encuentra registrado en el sistema",
                        "Tipo"   => "error"
                    ];

                    echo json_encode($alerta);
                    exit();
                 }
                

                }

                if ($nombre!=$campos['ProNombre']) {

				$check_nombre=mainModel::ejecutar_consulta_simple("SELECT ProNombre FROM tblprogramaformacion WHERE ProNombre='$nombre'");
					if($check_nombre->rowCount()>0){
						$alerta=[
							"Alerta"=>"simple",
							"Titulo"=>"Ocurrió un error inesperado",
							"Texto"=>"El NOMBRE del programade formacion se encuentra registrado en el sistema",
							"Tipo"=>"error"
						];
						echo json_encode($alerta);
						exit();
					}
				}
           
            /* Preparandos datos para  enviarlos al modelo */

            $datos_programa_up=[
				"CodigoPrograma"=>$codigoPro,
				"Nombre"=>$nombre,
				"ID"=>$id
				];

                if(programaModelo::actualizar_programa_modelo($datos_programa_up)){
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