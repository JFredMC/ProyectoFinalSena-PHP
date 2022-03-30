<?php

	if($peticionAjax){
		require_once "../modelo/competenciaModelo.php";
	}else{
		require_once "./modelo/competenciaModelo.php";
	}

	class competenciaControlador extends competenciaModelo{

		/*--------- Controlador agregar usuario ---------*/
		public function agregar_competencia_controlador(){
			$codigoCom=mainModel::limpiar_cadena($_POST['codigo_competencia']);
			$relCompetenciaPrograma=mainModel::limpiar_cadena($_POST['rel_competencia_programa']);
			$nombre=mainModel::limpiar_cadena($_POST['nombre_competencia']);



			/*== comprobar campos vacios ==*/
			if($codigoCom=="" || $nombre=="" || $relCompetenciaPrograma==""){
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
			if(mainModel::verificar_datos("[0-9-]{1,20}",$codigoCom)){
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"El CODIGO DE LA COMPETENCIA no coincide con el formato solicitado",
					"Tipo"=>"error"
				];
				echo json_encode($alerta);
				exit();
			}

			if(mainModel::verificar_datos("[a-zA-ZáéíóúÁÉÍÓÚñÑ, ]{1,500}",$nombre)){
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"El NOMBRE no coincide con el formato solicitado",
					"Tipo"=>"error"
				];
				echo json_encode($alerta);
				exit();
			}

			/*== Comprobando DNI ==*/
			$check_codigo=mainModel::ejecutar_consulta_simple("SELECT ComCodigoCompetencia FROM tblcompetencias WHERE ComCodigoCompetencia='$codigoCom'");
			if($check_codigo->rowCount()>0){
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"El CODIGO DE LA COMPETENCIA encuentra registrado en el sistema",
					"Tipo"=>"error"
				];
				echo json_encode($alerta);
				exit();
			}

			$check_nombre=mainModel::ejecutar_consulta_simple("SELECT ComNombre FROM tblcompetencias WHERE ComNombre='$nombre'");
			if($check_nombre->rowCount()>0){
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"EL NOMBRE DE LA COMPETENCIA encuentra registrado en el sistema",
					"Tipo"=>"error"
				];
				echo json_encode($alerta);
				exit();
			}

			$datos_competencia_reg=[
				"CodigoCompetencia"=>$codigoCom,
				"RelCompetenciaPrograma"=>$relCompetenciaPrograma,
				"Nombre"=>$nombre
			];

			$agregar_competencia=competenciaModelo::agregar_competencia_modelo($datos_competencia_reg);

			if($agregar_competencia->rowCount()==1){
				$alerta=[
					"Alerta"=>"limpiar",
					"Titulo"=>"Competencia registrada",
					"Texto"=>"Los datos de la competencia han sido registrados con exito",
					"Tipo"=>"success"
				];
			}else{
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"No hemos podido registrar la competencia",
					"Tipo"=>"error"
				];
			}
			echo json_encode($alerta);
		} /* Fin controlador */

		/* PAGINADOR USUARIO*/
		public function paginador_competencia_controlador($pagina,$registros,$privilegio,$id,$url,$busqueda){
			
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
				$consulta="SELECT SQL_CALC_FOUND_ROWS * FROM tblcompetencias WHERE ((ComCodigo!='$id') AND (ComCodigoCompetencia LIKE '%$busqueda%' OR ComNombre LIKE '%$busqueda%')) ORDER BY ComNombre ASC LIMIT $inicio,$registros";

			}else{
				$consulta="SELECT SQL_CALC_FOUND_ROWS * FROM tblcompetencias WHERE ComCodigo ORDER BY ComCodigoCompetencia ASC LIMIT $inicio,$registros";
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
								<td class="text-nowrap">Codigo del programa de formacion</td>
								<td class="text-nowrap">Codigo de la competencia</td>
								<td class="text-center">Nombre de la competencia</td>
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
								<td>'.$rows['FkRelCompetencia_Programa'].'</td>
								<td>'.$rows['ComCodigoCompetencia'].'</td>
								<td>'.$rows['ComNombre'].'</td>
								<td class="row align-items-startrow align-items-start">
									<a href="'.SERVERURL.'competencia-actualizar/'.mainModel::encryption($rows['ComCodigo']).'/" class="btn btn-primary ml-1" data-bs-toggle="tooltip" data-bs-placement="top" title="Actualizar">
											<i class="fas fa-sync-alt"></i>	
									</a>
								
									<form class="FormularioAjax ml-1" action="'.SERVERURL.'ajax/competenciaAjax.php" method="POST" data-form="delete" autocomplete="off">
									<input type="hidden" name="competencia_del" value="'.mainModel::encryption($rows['ComCodigo']).'">
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
				$tabla.='<p class="text-right py-2">Mostrando competencia '.$reg_inicio.' al '.$reg_final.' de un total de '.$total.'</p>';
				$tabla.=mainModel::paginador_tablas($pagina,$Npaginas,$url,7);

			}

			return $tabla;

		}
		

		public function eliminar_competencia_controlador(){

			/* RECIBIENDO ID DEL USUARIO*/
			$id=mainModel::decryption($_POST['competencia_del']);
			$id=mainModel::limpiar_cadena($id);
		

			/* COMPROBANDO EL USUARIO EN LA BASE DE DATOS*/
			$check_competencia=mainModel::ejecutar_consulta_simple("SELECT ComCodigo FROM tblcompetencias WHERE ComCodigo='$id'");
			if($check_competencia->rowCount()<=0){
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrio un error inesperado",
					"Texto"=>"La COMPETENCIA que intenta eliminar no existe en la base de datos",
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

			$eliminar_competencia=competenciaModelo::eliminar_competencia_modelo($id);
			
			if($eliminar_competencia->rowCount()==1){
				$alerta=[
					"Alerta"=>"recargar",
					"Titulo"=>"Competencia eliminada",
					"Texto"=>"Competencia eliminada con exito",
					"Tipo"=>"success"
				];

			}else{
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrio un error inesperado",
					"Texto"=>"No hemos podido eliminar la competencia, intenta nuevamente",
					"Tipo"=>"error"
				];
			
			}
			echo json_encode($alerta);

		}	/* Fin controlador */

		/* CONTROLADOR DATOS USUARIO */
		public function datos_competencia_controlador($tipo,$id){
			$tipo=mainModel::limpiar_cadena($tipo);

			$id=mainModel::decryption($id);
			$id=mainModel::limpiar_cadena($id);

			return competenciaModelo::datos_competencia_modelo($tipo,$id);

		}/* Fin controlador */

		public function actualizar_competencia_controlador(){
            //recibiendo id
            $id=mainModel::decryption($_POST['competencia_id_up']);
            $id=mainModel::limpiar_cadena($id);

            //Comprobar el usuario en la BD

            $check_codigo=mainModel::ejecutar_consulta_simple("SELECT * FROM tblcompetencias WHERE ComCodigo='$id'");
                if ( $check_codigo->rowCount()<=0) {
                    $alerta = [
                        "Alerta" => "simple",
                        "Titulo" => "Ocurrió un error inesperado",
                        "Texto"  => "No hemos encontrado la COMPETENCIA en el sistema",
                        "Tipo"   => "error"
                    ];
                    echo json_encode($alerta);
                     exit();
                }else{
                     $campos=$check_codigo->fetch();
                     
                }

                /**/
                $codigoCom=mainModel::limpiar_cadena($_POST['codigo_competencia_up']);
                $nombre=mainModel::limpiar_cadena($_POST['nombre_competencia_up']);


				/* comprobar campos vacios */
				if ($codigoCom == "" || $nombre == "") {
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
            if (mainModel::verificar_datos("[0-9-]{4,20}", $codigoCom)) {
                $alerta = [
                    "Alerta" => "simple",
                    "Titulo" => "Ocurrió un error inesperado",
                    "Texto"  => "El CODIGO DE LA COMPETENCIA no coincide con el formato solicitado",
                    "Tipo"   => "error"
                ];
                echo json_encode($alerta);
                exit();
            }

            if (mainModel::verificar_datos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{1,500}", $nombre)) {
                $alerta = [
                    "Alerta" => "simple",
                    "Titulo" => "Ocurrió un error inesperado",
                    "Texto"  => "El NOMBRE DE LA COMPETENCIA no coincide con el formato solicitado",
                    "Tipo"   => "error"
                ];
                echo json_encode($alerta);
                exit();
            }

       			/* Comprobando CODIGO COMPETENCIA */
                if ($codigoCom!=$campos['ComCodigoCompetencia']) {
                    
                
                $check_codigo = mainModel::ejecutar_consulta_simple("SELECT ComCodigoCompetencia FROM tblcompetencias WHERE ComCodigoCompetencia='$codigoCom'");
                if ($check_codigo->rowCount() > 0) {
                    $alerta = [
                        "Alerta" => "simple",
                        "Titulo" => "Ocurrió un error inesperado",
                        "Texto"  => "El CODIGO DE LA COMPETENCIA $codigoCom encuentra registrado en el sistema",
                        "Tipo"   => "error"
                    ];

                    echo json_encode($alerta);
                    exit();
                 }
                

                }

				/* Comprobando nOMBRE COMPETENCIA */
                if ($nombre!=$campos['ComNombre']) {
                    
                
					$check_nombre = mainModel::ejecutar_consulta_simple("SELECT ComNombre FROM tblcompetencias WHERE ComNombre='$nombre'");
					if ($check_nombre->rowCount() > 0) {
						$alerta = [
							"Alerta" => "simple",
							"Titulo" => "Ocurrió un error inesperado",
							"Texto"  => "El NOMBRE DE LA COMPETENCIA $nombre encuentra registrado en el sistema",
							"Tipo"   => "error"
						];
	
						echo json_encode($alerta);
						exit();
					 }
					
	
					}
           
            /* Preparandos datos para  enviarlos al modelo */

            $datos_competencia_up=[
				"CodigoCompetencia"=>$codigoCom,
				"Nombre"=>$nombre,
				"ID"=>$id
				];

                if(competenciaModelo::actualizar_competencia_modelo($datos_competencia_up)){
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