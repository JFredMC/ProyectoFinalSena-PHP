<?php
	$peticionAjax=true;
	require_once "../config/APP.php";

	if(isset($_POST['identificacion_ins']) || isset($_POST['instructor_del']) || isset($_POST['instructor_id_up'])){

		/*--------- Instancia al controlador ---------*/
		require_once "../controlador/instructorControlador.php";
		$ins_instructor = new instructorControlador();


		/*--------- Agregar un instructor ---------*/
		if(isset($_POST['identificacion_ins']) && isset($_POST['nombres_ins'])){
			echo $ins_instructor->agregar_instructor_controlador();
		}

		/*--------- Eliminar un instructor ---------*/
		if(isset($_POST['instructor_del'])){
			echo $ins_instructor->eliminar_instructor_controlador();
		}

		/*--------- Actualizar un instructor ---------*/
		if(isset($_POST['instructor_id_up'])){
			echo $ins_instructor->actualizar_instructor_controlador();
		}
		

		
	}else{
		
	}