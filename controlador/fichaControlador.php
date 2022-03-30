<?php

	if($peticionAjax){
		require_once "../modelo/fichaModelo.php";
	}else{
		require_once "./modelo/fichaModelo.php";
	}

	

	class fichaControlador extends fichaModelo{

		/*--------- Controlador agregar FICHA ---------*/
		public function agregar_ficha_controlador(){
			$codigoFicha=mainModel::limpiar_cadena($_POST['codigo_ficha']);
			$relFichaPrograma=mainModel::limpiar_cadena($_POST['rel_ficha_programa']);
			$fechainicio=mainModel::limpiar_cadena($_POST['fechainicio_ficha']);
			$fechafin=mainModel::limpiar_cadena($_POST['fechafin_ficha']);
			$jornada=mainModel::limpiar_cadena($_POST['jornada_ficha']);
			$horainicio=mainModel::limpiar_cadena($_POST['horainicio_ficha']);
			$horafin=mainModel::limpiar_cadena($_POST['horafin_ficha']);
			


			/*== comprobar campos vacios ==*/
			if($codigoFicha=="" || $fechainicio=="" || $fechafin=="" || $jornada=="" || $horainicio=="" || $horafin=="" || $relFichaPrograma==""){
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"No has llenado todos los campos que son obligatorios",
					"Tipo"=>"error"
				];
				echo json_encode($alerta);
				exit();
			}

			if(mainModel::verificar_datos("[0-9-]{5,20}",$codigoFicha)){
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"El CODIGO DE LA FICHA no coincide con el formato solicitado",
					"Tipo"=>"error"
				];
				echo json_encode($alerta);
				exit();
			}

			if(mainModel::verificar_datos("[a-zA-ZáéíóúÁÉÍÓÚñÑ, ]{1,20}",$jornada)){
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"La Jornada no coincide con el formato solicitado",
					"Tipo"=>"error"
				];
				echo json_encode($alerta);
				exit();
			}
			
            $check_codigo=mainModel::ejecutar_consulta_simple("SELECT FiCodigoFicha FROM tblficha WHERE FiCodigoFicha='$codigoFicha'");
			if($check_codigo->rowCount()>0){
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"El CODIGO DE LA FICHA encuentra registrado en el sistema",
					"Tipo"=>"error"
				];
				echo json_encode($alerta);
				exit();
			}

			if(mainModel::verificar_fecha($fechainicio)){
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"La FECHA INICIO no coincide con el formato solicitado",
					"Tipo"=>"error"
				];
				echo json_encode($alerta);
				exit();
			}

			if(mainModel::verificar_fecha($fechafin)){
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"La FECHA FIN no coincide con el formato solicitado",
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

			$datos_ficha_reg=[
				"CodigoFicha"=>$codigoFicha,
				"RelFichaPrograma"=>$relFichaPrograma,
				"FechaInicio"=>$fechainicio,
				"FechaFin"=>$fechafin,
				"Jornada"=>$jornada,
				"HoraInicio"=>$horainicio,
				"HoraFin"=>$horafin
				
			];

			$agregar_ficha=fichaModelo::agregar_ficha_modelo($datos_ficha_reg);

			if($agregar_ficha->rowCount()==1){
				$alerta=[
					"Alerta"=>"limpiar",
					"Titulo"=>"Ficha registrada",
					"Texto"=>"Los datos de la ficha han sido registrados con exito",
					"Tipo"=>"success"
				];
			}else{
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"No hemos podido registrar la ficha",
					"Tipo"=>"error"
				];
			}
			echo json_encode($alerta);
		} /* Fin controlador */

		/* PAGINADOR USUARIO*/
		public function paginador_ficha_controlador($pagina,$registros,$privilegio,$id,$url,$busqueda){
			
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
				$consulta="SELECT SQL_CALC_FOUND_ROWS * FROM tblficha WHERE ((FiCodigo!='$id') AND (FiCodigoFicha LIKE '%$busqueda%' OR FiFechaInicio LIKE '%$busqueda%' OR FiFechaFin LIKE '%$busqueda%' OR FiJornada LIKE '%$busqueda%' OR FiHoraInicio LIKE '%$busqueda%' OR FiHoraFin LIKE '%$busqueda%')) ORDER BY FiFechaInicio ASC LIMIT $inicio,$registros";

			}else{
				$consulta="SELECT SQL_CALC_FOUND_ROWS * FROM tblficha WHERE FiCodigo ORDER BY FiCodigoFicha ASC LIMIT $inicio,$registros";
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
                    <td>Codigo Ficha</td>
                    <td>Fecha Inicio</td>
                    <td>Fecha Fin</td>
                    <td>Jornada</td>
                    <td>Hora Inicio</td>
                    <td>Hora Fin</td>
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
                    <td>'.$rows['FiCodigoFicha'].'</td>
                    <td>'.$rows['FiFechaInicio'].'</td>
                    <td>'.$rows['FiFechaFin'].'</td>
                    <td>'.$rows['FiJornada'].'</td>
                    <td>'.$rows['FiHoraInicio'].'</td>
                    <td>'.$rows['FiHoraFin'].'</td>
                    <td class="row align-items-start">
                        <a href="'.SERVERURL.'ficha-actualizar/'.mainModel::encryption($rows['FiCodigo']).'/" class="btn btn-primary" data-bs-toggle="tooltip" data-bs-placement="top" title="Actualizar">
                                <i class="fas fa-sync-alt"></i>	
                        </a>
                    
                        <form class="FormularioAjax ml-1" action="'.SERVERURL.'ajax/fichaAjax.php" method="POST" data-form="delete" autocomplete="off">
                        <input type="hidden" name="ficha_del" value="'.mainModel::encryption($rows['FiCodigo']).'">
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
				$tabla.='<p class="text-right py-2">Mostrando ficha '.$reg_inicio.' al '.$reg_final.' de un total de '.$total.'</p>';
				$tabla.=mainModel::paginador_tablas($pagina,$Npaginas,$url,5);

			}

			return $tabla;

		}
		

		public function eliminar_ficha_controlador(){

			/* RECIBIENDO ID DEL EVENTO*/
			$id=mainModel::decryption($_POST['ficha_del']);
			$id=mainModel::limpiar_cadena($id);
		

			/* COMPROBANDO EL EVENTO EN LA BASE DE DATOS*/
			$check_evento=mainModel::ejecutar_consulta_simple("SELECT FiCodigo FROM tblficha WHERE FiCodigo='$id'");
			if($check_evento->rowCount()<=0){
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrio un error inesperado",
					"Texto"=>"La ficha que intenta eliminar no existe en la base de datos",
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

			$eliminar_ficha=fichaModelo::eliminar_ficha_modelo($id);
			
			if($eliminar_ficha->rowCount()==1){
				$alerta=[
					"Alerta"=>"recargar",
					"Titulo"=>"Ficha eliminada",
					"Texto"=>"Ficha eliminada con exito",
					"Tipo"=>"success"
				];

			}else{
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrio un error inesperado",
					"Texto"=>"No hemos podido eliminar la ficha, intenta nuevamente",
					"Tipo"=>"error"
				];
			
			}
			echo json_encode($alerta);

		}	/* Fin controlador */

		/* CONTROLADOR DATOS USUARIO */
		public function datos_ficha_controlador($tipo,$id){
			$tipo=mainModel::limpiar_cadena($tipo);

			$id=mainModel::decryption($id);
			$id=mainModel::limpiar_cadena($id);
			return fichaModelo::datos_ficha_modelo($tipo,$id);

		}/* Fin controlador */

		/* CONTROLADOR ACTUALIZAR USUARIO */
		public function actualizar_ficha_controlador(){
            //recibiendo id
            $id=mainModel::decryption($_POST['ficha_id_up']);
            $id=mainModel::limpiar_cadena($id);

            //Comprobar el usuario en la BD

            $check_ficha=mainModel::ejecutar_consulta_simple("SELECT * FROM tblficha WHERE FiCodigo='$id'");
                if ( $check_ficha->rowCount()<=0) {
                    $alerta = [
                        "Alerta" => "simple",
                        "Titulo" => "Ocurrió un error inesperado",
                        "Texto"  => "No hemos encontrado la ficha en el sistema",
                        "Tipo"   => "error"
                    ];
                    echo json_encode($alerta);
                     exit();
                }else{
                     $campos=$check_ficha->fetch();
                     
                }

                /**/
                $codigoFicha=mainModel::limpiar_cadena($_POST['codigo_ficha_up']);
				
				$fechainicio=mainModel::limpiar_cadena($_POST['fechainicio_ficha_up']);
				$fechafin=mainModel::limpiar_cadena($_POST['fechafin_ficha_up']);
				$jornada=mainModel::limpiar_cadena($_POST['jornada_ficha_up']);
				$horainicio=mainModel::limpiar_cadena($_POST['horainicio_ficha_up']);
				$horafin=mainModel::limpiar_cadena($_POST['horafin_ficha_up']);
                

				/* comprobar campos vacios */
				if ($codigoFicha=="" || $fechainicio=="" || $fechafin=="" || $jornada=="" || $horainicio=="" || $horafin=="" ) {
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
            if (mainModel::verificar_datos("[0-9-]{5,20}", $codigoFicha)) {
                $alerta = [
                    "Alerta" => "simple",
                    "Titulo" => "Ocurrió un error inesperado",
                    "Texto"  => "El codigo de la ficha no coincide con el formato solicitado",
                    "Tipo"   => "error"
                ];
                echo json_encode($alerta);
                exit();
            }

			if(mainModel::verificar_datos("[a-zA-ZáéíóúÁÉÍÓÚñÑ, ]{1,20}",$jornada)){
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"La Jornada no coincide con el formato solicitado",
					"Tipo"=>"error"
				];
				echo json_encode($alerta);
				exit();
			}

            if ($codigoFicha!=$campos['FiCodigoFicha']) {
			
			$check_codigo=mainModel::ejecutar_consulta_simple("SELECT FiCodigoFicha FROM tblficha WHERE FiCodigoFicha='$codigoFicha'");
			if($check_codigo->rowCount()>0){
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"El nuevo CODIGO de la ficha $codigoFicha ya se encuentra registrado en el sistema",
					"Tipo"=>"error"
				];
				echo json_encode($alerta);
				exit();
			}
		}

            /* Preparandos datos para  enviarlos al modelo */

            $datos_ficha_up=[
				"CodigoFicha"=>$codigoFicha,
				
				"FechaInicio"=>$fechainicio,
				"FechaFin"=>$fechafin,
				"Jornada"=>$jornada,
				"HoraInicio"=>$horainicio,
				"HoraFin"=>$horafin,
				"ID"=>$id
				];

                if(fichaModelo::actualizar_ficha_modelo($datos_ficha_up)){
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