
<?php

	if($peticionAjax){
		require_once "../modelo/eventoModelo.php";
	}else{
		require_once "./modelo/eventoModelo.php";
	}

	

	class eventoControlador extends eventoModelo{

		/*--------- Controlador agregar evento ---------*/
		public function agregar_evento_controlador(){
			$instructor=mainModel::limpiar_cadena($_POST['instructor_even']);
			$programa=mainModel::limpiar_cadena($_POST['programa_even']);
			$ficha=mainModel::limpiar_cadena($_POST['ficha_even']);
			$competencia=mainModel::limpiar_cadena($_POST['competencia_even']);
			$resultado=mainModel::limpiar_cadena($_POST['resultado_even']);
            $fechainicio=mainModel::limpiar_cadena($_POST['fechainicio_even']);
			$fechafin=mainModel::limpiar_cadena($_POST['fechafin_even']);
			$horainicio=mainModel::limpiar_cadena($_POST['horainicio_even']);
			$horafin=mainModel::limpiar_cadena($_POST['horafin_even']);
			$dia=mainModel::limpiar_cadena($_POST['dia_even']);
			$hora=mainModel::limpiar_cadena($_POST['horas_even']);
			


			/*== comprobar campos vacios ==*/
			if($instructor=="" || $programa=="" || $ficha=="" || $competencia=="" || $resultado=="" || $fechainicio=="" || $fechafin=="" || $horainicio=="" || $horafin=="" || $dia=="" || $hora=="" ){
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"No has llenado todos los campos que son obligatorios",
					"Tipo"=>"error"
				];
				echo json_encode($alerta);
				exit();
			}

			if(mainModel::verificar_datos("[0-9-]{5,20}",$instructor)){
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"La IDENTIFICACION DEL INSTRUCTOR no coincide con el formato solicitado",
					"Tipo"=>"error"
				];
				echo json_encode($alerta);
				exit();
			}
			
			if(mainModel::verificar_datos("[0-9-]{5,20}",$ficha)){
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"El codigo de la FICHA no coincide con el formato solicitado",
					"Tipo"=>"error"
				];
				echo json_encode($alerta);
				exit();
			}

			if(mainModel::verificar_datos("[0-9-]{1,20}",$hora)){
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"El Formato de la HORA no coincide con el formato solicitado",
					"Tipo"=>"error"
				];
				echo json_encode($alerta);
				exit();
			}

			

			$check_resultado=mainModel::ejecutar_consulta_simple("SELECT EveCodigo FROM tblevento WHERE EveInstructor='$instructor' AND EveFicha='$ficha' AND EveResultado='$resultado'");
			if($check_resultado->rowCount()>0){
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"El resultado de aprendizaje perteneciente a la ficha $ficha ya fue asignado a el instructor $instructor",
					"Tipo"=>"error"
				];
				echo json_encode($alerta);
				exit();
			}

			$check_dia=mainModel::ejecutar_consulta_simple("SELECT EveCodigo FROM tblevento WHERE EveFicha='$ficha' AND EveDia='$dia'");
			if($check_dia->rowCount()>0){
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"Para el dia $dia ya fue asignado un horario a la ficha $ficha",
					"Tipo"=>"error"
				];
				echo json_encode($alerta);
				exit();
			}

			$check_instructor=mainModel::ejecutar_consulta_simple("SELECT EveCodigo FROM tblevento WHERE EveInstructor='$instructor' AND EveDia='$dia'");
			if($check_instructor->rowCount()>0){
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"El instructor $instructor ya tiene un horario asignado para el dia $dia",
					"Tipo"=>"error"
				];
				echo json_encode($alerta);
				exit();
			}

			/*== Verificando integridad de los datos ==*/
			if(mainModel::verificar_fecha($fechainicio)){
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"La fecha de inicio no coincide con el formato solicitado",
					"Tipo"=>"error"
				];
				echo json_encode($alerta);
				exit();
			}

			if(mainModel::verificar_fecha($fechafin)){
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"La fecha de fin no coincide con el formato solicitado",
					"Tipo"=>"error"
				];
				echo json_encode($alerta);
				exit();
			}

			/* COMPROBANDO FECHAS*/
			if(strtotime($fechafin) < strtotime($fechainicio)){
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"La fecha de final no puede ser menor a la fecha de inicio",
					"Tipo"=>"error"
				];
				echo json_encode($alerta);
				exit();
			}

			/* COMPROBANDO HORAS*/
			if(strtotime($horafin) < strtotime($horainicio)){
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"La hora de final no puede ser menor a la hora de inicio",
					"Tipo"=>"error"
				];
				echo json_encode($alerta);
				exit();
			}

			/* FORMATEAR FECHAS */
			$fechainicio=date("Y-m-d", strtotime($fechainicio));
			$fechafin=date("Y-m-d", strtotime($fechafin));
			
			/* FORMATEAR HORAS */
			$horainicio = date("H:i:s", strtotime($horainicio));
			$horafin = date("H:i:s", strtotime($horafin));

			


			$datos_evento_reg=[
				"Instructor"=>$instructor,
				"ProgramaFormacion"=>$programa,
				"Ficha"=>$ficha,
				"Competencia"=>$competencia,
				"Resultado"=>$resultado,
                "FechaInicio"=>$fechainicio,
				"FechaFin"=>$fechafin,
				"HoraInicio"=>$horainicio,
				"HoraFin"=>$horafin,
				"Dia"=>$dia,
				"Hora"=>$hora
			];

			$agregar_evento=eventoModelo::agregar_evento_modelo($datos_evento_reg);

			if($agregar_evento->rowCount()==1){
				$alerta=[
					"Alerta"=>"limpiar",
					"Titulo"=>"evento registrado",
					"Texto"=>"Los datos del evento han sido registrados con exito",
					"Tipo"=>"success"
				];
			}else{
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"No hemos podido registrar el evento",
					"Tipo"=>"error"
				];
			}
			echo json_encode($alerta);
		} /* Fin controlador */

		/* PAGINADOR USUARIO*/
		public function paginador_evento_controlador($pagina,$registros,$id,$url,$busqueda){
			
			$pagina=mainModel::limpiar_cadena($pagina);
			$registros=mainModel::limpiar_cadena($registros);
			
			$id=mainModel::limpiar_cadena($id);

			$url=mainModel::limpiar_cadena($url);
			$url=SERVERURL.$url."/";

			$busqueda=mainModel::limpiar_cadena($busqueda);
			$tabla="";

			$pagina= (isset($pagina) && $pagina>0) ? (int) $pagina : 1 ;
			$inicio= ($pagina>0) ? (($pagina*$registros)-$registros) : 0 ;

			if(isset($busqueda) && $busqueda!=""){
				$consulta="SELECT SQL_CALC_FOUND_ROWS * FROM tblevento WHERE ((EveInstructor='".$_SESSION['cargo_spm']."'='Coordinador' OR EveCodigo!='$id') AND (EveDia LIKE '%$busqueda%' OR EveInstructor LIKE '%$busqueda%' OR EveResultado LIKE '%$busqueda%' OR EveFechaInicio LIKE '%$busqueda%' OR EveFechaFin LIKE '%$busqueda%' OR EveHoraInicio LIKE '%$busqueda%' OR EveHoraFin LIKE '%$busqueda%' OR EveTotalHoras LIKE '%$busqueda%')) ORDER BY EveDia DESC LIMIT $inicio,$registros";

			}else{
				$consulta="SELECT SQL_CALC_FOUND_ROWS * FROM tblevento WHERE EveInstructor='".$_SESSION['dni_spm']."' OR '".$_SESSION['cargo_spm']."'='Coordinador' ORDER BY CASE 
				WHEN EveDia - DAYOFWEEK(CURDATE()) < 0 THEN 
				   EveDia + DAYOFWEEK(CURDATE())
				ELSE
				   EveDia - DAYOFWEEK(CURDATE())
			 END;";
			}

			$conexion = mainModel::conectar();

			$datos = $conexion->query($consulta);
			$datos = $datos->fetchALL();
			
			$total = $conexion->query("SELECT FOUND_ROWS()");
			$total = (int) $total->fetchColumn();

			$Npaginas=ceil($total/$registros);

			
			$tabla.='
			<div class="">
					<table class="table table-hover  " id="evento_tabla">
								<thead class="">
									<tr class="">
										
										<td class="align-middle">Dia</td>
										<td class="align-middle">Instructor</td>
										
										<td class="align-middle">Ficha</td>
										
										<td class="align-middle text-nowrap">Resultado de aprendizaje</td>
										<td class="align-middle text-nowrap">Fecha inicio</td>
										<td class="align-middle text-nowrap">Fecha fin</td>
										<td class="align-middle text-nowrap">Hora inicio</td>
										<td class="align-middle text-nowrap">Hora fin</td>
										<td class="align-middle text-nowrap">Horas</td>
										
										<td class="align-middle">Acciones</td>
									</tr>
								</thead>
										
								<tbody>';
								
						if($total>=1 && $pagina<=$Npaginas){
							$contador=$inicio+1;
							$reg_inicio=$inicio+1;
							foreach($datos as $rows){
							
								$tabla.='<tr class="text-center">
											<td>'.$rows['EveDia'].'</td>
											<td>'.$rows['EveInstructor'].'</td>
											
											<td>'.$rows['EveFicha'].'</td>
											
											<td class="">'.$rows['EveResultado'].'</td>
											<td>'.$rows['EveFechaInicio'].'</td>
											<td>'.$rows['EveFechaFin'].'</td>
											<td>'.$rows['EveHoraInicio'].'</td>
											<td>'.$rows['EveHoraFin'].'</td>
											<td>'.$rows['EveTotalHoras'].'</td>
											<td class="row align-items-start">													
											
												<a href="'.SERVERURL.'evento-actualizar/'.mainModel::encryption($rows['EveCodigo']).'/" class="btn btn-primary" data-bs-toggle="tooltip" data-bs-placement="top" title="Actualizar">
														<i class="fas fa-sync-alt"></i>	
												</a>
												
												<form class="FormularioAjax ml-1" action="'.SERVERURL.'ajax/eventoAjax.php" method="POST" data-form="delete" autocomplete="off">
												<input type="hidden" name="evento_del" value="'.mainModel::encryption($rows['EveCodigo']).'">
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
						$tabla.='</tbody></table></div></div>';

						if($total>=1 && $pagina<=$Npaginas){
							$tabla.='<p class="text-right py-2">Mostrando evento '.$reg_inicio.' al '.$reg_final.' de un total de '.$total.'</p>';
							$tabla.=mainModel::paginador_tablas($pagina,$Npaginas,$url,5);

						}

						return $tabla;

			
	}
		

		public function eliminar_evento_controlador(){

			/* RECIBIENDO ID DEL EVENTO*/
			$id=mainModel::decryption($_POST['evento_del']);
			$id=mainModel::limpiar_cadena($id);
		

			/* COMPROBANDO EL EVENTO EN LA BASE DE DATOS*/
			$check_evento=mainModel::ejecutar_consulta_simple("SELECT EveCodigo FROM tblevento WHERE EveCodigo='$id'");
			if($check_evento->rowCount()<=0){
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrio un error inesperado",
					"Texto"=>"El horario que intenta eliminar no existe en la base de datos",
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

			$eliminar_evento=eventoModelo::eliminar_evento_modelo($id);
			
			if($eliminar_evento->rowCount()==1){
				$alerta=[
					"Alerta"=>"recargar",
					"Titulo"=>"Horario eliminado",
					"Texto"=>"Horario eliminado con exito",
					"Tipo"=>"success"
				];

			}else{
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrio un error inesperado",
					"Texto"=>"No hemos podido eliminar el horario, intenta nuevamente",
					"Tipo"=>"error"
				];
			
			}
			echo json_encode($alerta);

		}	/* Fin controlador */

		/* CONTROLADOR DATOS USUARIO */
		public function datos_evento_controlador($tipo,$id){
			$tipo=mainModel::limpiar_cadena($tipo);

			$id=mainModel::decryption($id);
			$id=mainModel::limpiar_cadena($id);
			return eventoModelo::datos_evento_modelo($tipo,$id);

		}/* Fin controlador */

		public function actualizar_evento_controlador(){
            //recibiendo id
            $id=mainModel::decryption($_POST['evento_id_up']);
            $id=mainModel::limpiar_cadena($id);
			

            //Comprobar el usuario en la BD

            $check_user=mainModel::ejecutar_consulta_simple("SELECT * FROM tblevento WHERE EveCodigo='$id'");
                if ( $check_user->rowCount()<=0) {
                    $alerta = [
                        "Alerta" => "simple",
                        "Titulo" => "Ocurrió un error inesperado",
                        "Texto"  => "No hemos encontrado el evento en el sistema",
                        "Tipo"   => "error"
                    ];
                    echo json_encode($alerta);
                     exit();
                }else{
                     $campos=$check_user->fetch();
                     
                }

				
				/* COMPROBANDO PRIVILEGIOS*/
			

				$instructor=mainModel::limpiar_cadena($_POST['instructor_even_up']);
				$programa=mainModel::limpiar_cadena($_POST['programa_even_up']);
				$ficha=mainModel::limpiar_cadena($_POST['ficha_even_up']);
				$competencia=mainModel::limpiar_cadena($_POST['competencia_even_up']);
				$resultado=mainModel::limpiar_cadena($_POST['resultado_even_up']);
				$fechainicio=mainModel::limpiar_cadena($_POST['fechainicio_even_up']);
				$fechafin=mainModel::limpiar_cadena($_POST['fechafin_even_up']);
				$horainicio=mainModel::limpiar_cadena($_POST['horainicio_even_up']);
				$horafin=mainModel::limpiar_cadena($_POST['horafin_even_up']);
				$dia=mainModel::limpiar_cadena($_POST['dia_even_up']);
				$hora=mainModel::limpiar_cadena($_POST['horas_even_up']);
			


			/*== comprobar campos vacios ==*/
			if($instructor=="" || $programa=="" || $ficha=="" || $competencia=="" || $resultado=="" || $fechainicio=="" || $fechafin=="" || $horainicio=="" || $horafin=="" || $dia=="" || $hora=="" ){
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"No has llenado todos los campos que son obligatorios",
					"Tipo"=>"error"
				];
				echo json_encode($alerta);
				exit();
			}

			if(mainModel::verificar_datos("[0-9-]{5,20}",$instructor)){
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"El dato de INSTRUCTOR no coincide con el formato solicitado",
					"Tipo"=>"error"
				];
				echo json_encode($alerta);
				exit();
			}
			
			if(mainModel::verificar_datos("[0-9-]{5,20}",$ficha)){
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"El codigo de la FICHA no coincide con el formato solicitado",
					"Tipo"=>"error"
				];
				echo json_encode($alerta);
				exit();
			}

			if ($resultado!=$campos['EveResultado']) {

			$check_resultado=mainModel::ejecutar_consulta_simple("SELECT EveCodigo FROM tblevento WHERE EveInstructor='$instructor' AND EveFicha='$ficha' AND EveResultado='$resultado'");
			if($check_resultado->rowCount()>0){
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"El resultado de aprendizaje perteneciente a la ficha $ficha ya fue asignado a el instructor $instructor",
					"Tipo"=>"error"
				];
				echo json_encode($alerta);
				exit();
				}
			}

			if ($ficha!=$campos['EveFicha']) {

			$check_dia=mainModel::ejecutar_consulta_simple("SELECT EveCodigo FROM tblevento WHERE EveFicha='$ficha' AND EveDia='$dia'");
			if($check_dia->rowCount()>0){
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"Para el dia $dia ya fue asignado un horario a la ficha $ficha",
					"Tipo"=>"error"
				];
				echo json_encode($alerta);
				exit();
				}

			}

			if ($instructor!=$campos['EveInstructor']) {

			$check_instructor=mainModel::ejecutar_consulta_simple("SELECT EveCodigo FROM tblevento WHERE EveInstructor='$instructor' AND EveDia='$dia'");
			if($check_instructor->rowCount()>0){
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"El instructor $instructor ya tiene un horario asignado para el dia $dia",
					"Tipo"=>"error"
				];
				echo json_encode($alerta);
				exit();
				}
			}

			/*== Verificando integridad de los datos ==*/
			if(mainModel::verificar_fecha($fechainicio)){
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"La fecha de inicio no coincide con el formato solicitado",
					"Tipo"=>"error"
				];
				echo json_encode($alerta);
				exit();
			}

			if(mainModel::verificar_fecha($fechafin)){
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"La fecha de fin no coincide con el formato solicitado",
					"Tipo"=>"error"
				];
				echo json_encode($alerta);
				exit();
			}

			/* COMPROBANDO FECHAS*/
			if(strtotime($fechafin) < strtotime($fechainicio)){
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"La fecha de final no puede ser menor a la fecha de inicio",
					"Tipo"=>"error"
				];
				echo json_encode($alerta);
				exit();
			}
			/* FORMATEAR FECHAS */
			$fechainicio=date("Y-m-d", strtotime($fechainicio));
			$fechafin=date("Y-m-d", strtotime($fechafin));

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


           
            /* Preparandos datos para  enviarlos al modelo */

            $datos_evento_up=[
				"Instructor"=>$instructor,
				"ProgramaFormacion"=>$programa,
				"Ficha"=>$ficha,
				"Competencia"=>$competencia,
				"Resultado"=>$resultado,
                "FechaInicio"=>$fechainicio,
				"FechaFin"=>$fechafin,
				"HoraInicio"=>$horainicio,
				"HoraFin"=>$horafin,
				"Dia"=>$dia,
				"ID"=>$id
				];

                if(eventoModelo::actualizar_evento_modelo($datos_evento_up)){
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