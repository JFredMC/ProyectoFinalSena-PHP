<?php
	$peticionAjax=true;
	require_once "../config/APP.php";

	if(isset($_POST['codigo_programa']) || isset($_POST['programa_del']) || isset($_POST['codigo_programa_up'])){

		/*--------- Instancia al controlador ---------*/
		require_once "../controlador/programaControlador.php";
		$ins_programa = new programaControlador();


		/*--------- Agregar un programa ---------*/
		if(isset($_POST['codigo_programa']) && isset($_POST['nombre_programa'])){
			echo $ins_programa->agregar_programa_controlador();
		}

		/*--------- Eliminar un programa ---------*/
		if(isset($_POST['programa_del'])){
			echo $ins_programa->eliminar_programa_controlador();
		}

		/*--------- Actualizar un programa ---------*/
		if(isset($_POST['codigo_programa_up'])){
			echo $ins_programa->actualizar_programa_controlador();
		}
		

		
	}else{
		session_start(['name'=>'SPM']);
		session_unset();
		session_destroy();
		header("Location: ".SERVERURL."login/");
		exit();
	}