<?php

	if($peticionAjax){
		require_once "../modelo/resultadoModelo.php";
	}else{
		require_once "./modelo/resultadoModelo.php";
	}

	

	class resultadoControlador extends resultadoModelo{

		/*--------- Controlador agregar evento ---------*/
		public function agregar_resultado_controlador(){
			$codigoResul=mainModel::limpiar_cadena($_POST['codigo_resul']);
			$relResulCompe=mainModel::limpiar_cadena($_POST['rel_resultado_competencia']);
			$nombre=mainModel::limpiar_cadena($_POST['nombre_resul']);
			$hora=mainModel::limpiar_cadena($_POST['hora_resul']);
			


			/*== comprobar campos vacios ==*/
			if($codigoResul=="" || $nombre=="" || $hora=="" || $relResulCompe==""){
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"No has llenado todos los campos que son obligatorios",
					"Tipo"=>"error"
				];
				echo json_encode($alerta);
				exit();
			}

			if(mainModel::verificar_datos("[0-9-]{1,20}",$codigoResul)){
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"El dato del resultado de aprendizaje no coincide con el formato solicitado",
					"Tipo"=>"error"
				];
				echo json_encode($alerta);
				exit();
			}

			if(mainModel::verificar_datos("[a-zA-ZáéíóúÁÉÍÓÚñÑ., ]{1,1000}",$nombre)){
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"El NOMBRE no coincide con el formato solicitado",
					"Tipo"=>"error"
				];
				echo json_encode($alerta);
				exit();
			}

			$check_codigo=mainModel::ejecutar_consulta_simple("SELECT ResCodigo FROM tblresultadodeaprendizaje WHERE ResCodigo='$codigoResul'");
			if($check_codigo->rowCount()>0){
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"El CODIGO del resultado de aprendizaje ya se encuentra registrado en esa ficha",
					"Tipo"=>"error"
				];
				echo json_encode($alerta);
				exit();
			}
			
            $check_nombre=mainModel::ejecutar_consulta_simple("SELECT ResCodigo FROM tblresultadodeaprendizaje WHERE ResNombre='$nombre'");
			if($check_nombre->rowCount()>0){
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"El NOMBRE del resultado de aprendizaje ya se encuentra registrado en esa ficha",
					"Tipo"=>"error"
				];
				echo json_encode($alerta);
				exit();
			}

			$datos_resultado_reg=[
				"CodigoResul"=>$codigoResul,
				"RelResultadoCompetencia"=>$relResulCompe,
				"Nombre"=>$nombre,
				"Hora"=>$hora
			];

			$agregar_resultado=resultadoModelo::agregar_resultado_modelo($datos_resultado_reg);

			if($agregar_resultado->rowCount()==1){
				$alerta=[
					"Alerta"=>"limpiar",
					"Titulo"=>"Resultado registrado",
					"Texto"=>"Los datos del resultado de aprendizaje han sido registrados con exito",
					"Tipo"=>"success"
				];
			}else{
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"No hemos podido registrar el resultado de aprendizaje",
					"Tipo"=>"error"
				];
			}
			echo json_encode($alerta);
		} /* Fin controlador */

		/* PAGINADOR USUARIO*/
		public function paginador_resultado_controlador($pagina,$registros,$privilegio,$id,$url,$busqueda){
			
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
				$consulta="SELECT SQL_CALC_FOUND_ROWS * FROM tblresultadodeaprendizaje WHERE ((ResId!='$id') AND (ResId LIKE '%$busqueda%' OR ResCodigo LIKE '%$busqueda%' OR ResNombre LIKE '%$busqueda%' OR ResHoras LIKE '%$busqueda%')) ORDER BY ResNombre ASC LIMIT $inicio,$registros";

			}else{
				$consulta="SELECT SQL_CALC_FOUND_ROWS * FROM tblresultadodeaprendizaje WHERE ResCodigo ORDER BY ResCodigo ASC LIMIT $inicio,$registros";
			}

			$conexion = mainModel::conectar();

			$datos = $conexion->query($consulta);
			$datos = $datos->fetchALL();
			
			$total = $conexion->query("SELECT FOUND_ROWS()");
			$total = (int) $total->fetchColumn();

			$Npaginas=ceil($total/$registros);
			$tabla.='<table class="table table-hover " id="iddatetable">
            <thead>
                <tr class="">
                    <td>#</td>
                    <td class="text-nowrap">Codigo Resultado</td>
                    <td class="text-center">Nombre</td>
                    <td>Horas</td>
                    <td>Acciones</td>
                </tr>
            </thead>
            <tbody>';
			if($total>=1 && $pagina<=$Npaginas){
				$contador=$inicio+1;
				$reg_inicio=$inicio+1;
				foreach($datos as $rows){
					$tabla.='<tr class="text-center">
                    <td>'.$contador.'</td>
                    <td>'.$rows['ResCodigo'].'</td>
                    <td>'.$rows['ResNombre'].'</td>
                    <td>'.$rows['ResHoras'].'</td>
                    <td class="row align-items-start">
                        <a href="'.SERVERURL.'resultado-actualizar/'.mainModel::encryption($rows['ResId']).'/" class="btn btn-primary" data-bs-toggle="tooltip" data-bs-placement="top" title="Actualizar">
                                <i class="fas fa-sync-alt"></i>	
                        </a>
                    
                        <form class="FormularioAjax ml-1" action="'.SERVERURL.'ajax/resultadoAjax.php" method="POST" data-form="delete" autocomplete="off">
                        <input type="hidden" name="resultado_del" value="'.mainModel::encryption($rows['ResId']).'">
                            <button type="submit" class="btn btn-danger" data-bs-toggle="tooltip" data-bs-placement="top" title="Eliminar">
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
					$tabla.='<tr class="text-center" ><td colspan="9"><a href="'.$url.'" class="btn btn-raised btn-danger btn-sm">Haga click aca para recargar el listado</a></td></tr>';
				}else{
					$tabla.='<tr class="text-center"><td colspan="9">No hay registros en el sistema</td></tr>';
				}
			}
			$tabla.='</tbody></table></div>';

			if($total>=1 && $pagina<=$Npaginas){
				$tabla.='<p class="text-right py-2">Mostrando resultado de aprendizaje '.$reg_inicio.' al '.$reg_final.' de un total de '.$total.'</p>';
				$tabla.=mainModel::paginador_tablas($pagina,$Npaginas,$url,5);

			}

			return $tabla;

		}
		

		public function eliminar_resultado_controlador(){

			/* RECIBIENDO ID DEL EVENTO*/
			$id=mainModel::decryption($_POST['resultado_del']);
			$id=mainModel::limpiar_cadena($id);
		

			/* COMPROBANDO EL EVENTO EN LA BASE DE DATOS*/
			$check_resultado=mainModel::ejecutar_consulta_simple("SELECT ResId FROM tblresultadodeaprendizaje WHERE ResId='$id'");
			if($check_resultado->rowCount()<=0){
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrio un error inesperado",
					"Texto"=>"El resultado de aprendizaje que intenta eliminar no existe en la base de datos",
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

			$eliminar_resultado=resultadoModelo::eliminar_resultado_modelo($id);
			
			if($eliminar_resultado->rowCount()==1){
				$alerta=[
					"Alerta"=>"recargar",
					"Titulo"=>"Resultado eliminada",
					"Texto"=>"Resultado de aprendizaje eliminado con exito",
					"Tipo"=>"success"
				];

			}else{
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrio un error inesperado",
					"Texto"=>"No hemos podido eliminar el resultado de aprendizaje, intenta nuevamente",
					"Tipo"=>"error"
				];
			
			}
			echo json_encode($alerta);

		}	/* Fin controlador */

		/* CONTROLADOR DATOS USUARIO */
		public function datos_resultado_controlador($tipo,$id){
			$tipo=mainModel::limpiar_cadena($tipo);

			$id=mainModel::decryption($id);
			$id=mainModel::limpiar_cadena($id);
			return resultadoModelo::datos_resultado_modelo($tipo,$id);

		}/* Fin controlador */

		/* CONTROLADOR ACTUALIZAR USUARIO */
		public function actualizar_resultado_controlador(){
            //recibiendo id
            $id=mainModel::decryption($_POST['resultado_id_up']);
            $id=mainModel::limpiar_cadena($id);

            //Comprobar el usuario en la BD

            $check_resultado=mainModel::ejecutar_consulta_simple("SELECT * FROM tblresultadodeaprendizaje WHERE ResId='$id'");
                if ( $check_resultado->rowCount()<=0) {
                    $alerta = [
                        "Alerta" => "simple",
                        "Titulo" => "Ocurrió un error inesperado",
                        "Texto"  => "No hemos encontrado el resultado de aprendizaje en el sistema",
                        "Tipo"   => "error"
                    ];
                    echo json_encode($alerta);
                     exit();
                }else{
                     $campos=$check_resultado->fetch();
                     
                }

                /**/
                $codigoResul=mainModel::limpiar_cadena($_POST['codigo_resul_up']);
                $nombre=mainModel::limpiar_cadena($_POST['nombre_resul_up']);
                $hora=mainModel::limpiar_cadena($_POST['hora_resul_up']);

				/* comprobar campos vacios */
				if ($codigoResul == "" || $nombre == "" || $hora == "") {
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
            if (mainModel::verificar_datos("[0-9-]{1,20}", $codigoResul)) {
                $alerta = [
                    "Alerta" => "simple",
                    "Titulo" => "Ocurrió un error inesperado",
                    "Texto"  => "El Codigo no coincide con el formato solicitado",
                    "Tipo"   => "error"
                ];
                echo json_encode($alerta);
                exit();
            }

            

			if (mainModel::verificar_datos("[0-9-]{1,5}", $hora)) {
                $alerta = [
                    "Alerta" => "simple",
                    "Titulo" => "Ocurrió un error inesperado",
                    "Texto"  => "La hora no coincide con el formato solicitado",
                    "Tipo"   => "error"
                ];
                echo json_encode($alerta);
                exit();
            }
                      /* Comprobando NOMBRE*/
                if ($codigoResul!=$campos['ResCodigo']) {
                    
                
					$check_nombre=mainModel::ejecutar_consulta_simple("SELECT ResCodigo FROM tblresultadodeaprendizaje WHERE ResCodigo='$codigoResul' AND ResNombre='$nombre'");
						if($check_nombre->rowCount()>0){
						$alerta=[
							"Alerta"=>"simple",
							"Titulo"=>"Ocurrió un error inesperado",
							"Texto"=>"El nombre del resultado de aprendizaje ingresado ya se encuentra registrado en esa ficha",
							"Tipo"=>"error"
						];
						echo json_encode($alerta);
						exit();
					}
				}

            /* Preparandos datos para  enviarlos al modelo */

            $datos_resultado_up=[
				"CodigoResul"=>$codigoResul,
				"Nombre"=>$nombre,
				"Hora"=>$hora,
				"ID"=>$id
				];

                if(resultadoModelo::actualizar_resultado_modelo($datos_resultado_up)){
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