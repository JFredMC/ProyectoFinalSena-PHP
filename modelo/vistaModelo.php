<?php
	
	class vistaModelo{

		/*--------- Modelo obtener vistas ---------*/
		protected static function obtener_vista_modelo($vistas){
			$listaBlanca=["usuario-asignar","usuario-registro","usuario-buscar","usuario-lista","usuario-actualizar","instructor", "instructor-buscar", "instructor-actualizar", "home", "calendario", "ambientes", "ficha", "ficha-buscar", "ficha-actualizar", "programa-formacion-lista","programa-formacion-buscar","programa-formacion-actualizar","competencia-lista","competencia-buscar","competencia-actualizar","resultados-de-aprendizaje", "resultado-actualizar", "resultado-buscar", "perfil", "evento-asignacion", "evento-lista","evento-buscar","evento-actualizar"];
			if(in_array($vistas, $listaBlanca)){
				if(is_file("./vista/contenido/".$vistas."-view.php")){
					$contenido="./vista/contenido/".$vistas."-view.php";
				}else{
					$contenido="404";
				}
			}elseif($vistas=="login" || $vistas=="index"){
				$contenido="login";
			}else{
				$contenido="404";
			}
			return $contenido;
		}
	}