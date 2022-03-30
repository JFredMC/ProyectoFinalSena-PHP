<?php
	$peticionAjax=true;
	require_once "../config/APP.php";

	if(isset($_POST['codigo_resul']) || isset($_POST['resultado_del']) || isset($_POST['resultado_id_up'])){

		/*--------- Instancia al controlador ---------*/
		require_once "../controlador/resultadoControlador.php";
		$ins_resultado = new resultadoControlador();


		/*--------- Agregar una ficha ---------*/
		if(isset($_POST['codigo_resul'])){
			echo $ins_resultado->agregar_resultado_controlador();
		}

		/*--------- Eliminar una ficha ---------*/
		if(isset($_POST['resultado_del'])){
			echo $ins_resultado->eliminar_resultado_controlador();
		}

		/*--------- Actualizar una ficha ---------*/
		if(isset($_POST['resultado_id_up'])){
			echo $ins_resultado->actualizar_resultado_controlador();
		}

		
	}else{
		
	}