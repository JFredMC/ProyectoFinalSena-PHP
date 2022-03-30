<?php
	$peticionAjax=true;
	require_once "../config/APP.php";

	if(isset($_POST['codigo_competencia']) || isset($_POST['competencia_del']) || isset($_POST['codigo_competencia_up'])){

		/*--------- Instancia al controlador ---------*/
		require_once "../controlador/competenciaControlador.php";
		$ins_competencia = new competenciaControlador();


		/*--------- Agregar un competencia ---------*/
		if(isset($_POST['codigo_competencia']) && isset($_POST['nombre_competencia'])){
			echo $ins_competencia->agregar_competencia_controlador();
		}

		/*--------- Eliminar un competencia ---------*/
		if(isset($_POST['competencia_del'])){
			echo $ins_competencia->eliminar_competencia_controlador();
		}

		/*--------- Actualizar un competencia ---------*/
		if(isset($_POST['codigo_competencia_up'])){
			echo $ins_competencia->actualizar_competencia_controlador();
		}
		

		
	}else{
		
	}