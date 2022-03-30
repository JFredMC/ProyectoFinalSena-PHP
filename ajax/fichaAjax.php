<?php
	$peticionAjax=true;
	require_once "../config/APP.php";

	if(isset($_POST['codigo_ficha']) || isset($_POST['ficha_del']) || isset($_POST['codigo_ficha_up'])){

		/*--------- Instancia al controlador ---------*/
		require_once "../controlador/fichaControlador.php";
		$ins_ficha = new fichaControlador();


		/*--------- Agregar una ficha ---------*/
		if(isset($_POST['codigo_ficha'])){
			echo $ins_ficha->agregar_ficha_controlador();
		}

		/*--------- Eliminar una ficha ---------*/
		if(isset($_POST['ficha_del'])){
			echo $ins_ficha->eliminar_ficha_controlador();
		}

		/*--------- Actualizar una ficha ---------*/
		if(isset($_POST['codigo_ficha_up'])){
			echo $ins_ficha->actualizar_ficha_controlador();
		}

		
	}else{
		session_start(['name'=>'SPM']);
		session_unset();
		session_destroy();
		header("Location: ".SERVERURL."login/");
		exit();
	}