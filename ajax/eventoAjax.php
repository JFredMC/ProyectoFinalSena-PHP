<?php
	$peticionAjax=true;
	require_once "../config/APP.php";

	if(isset($_POST['instructor_even']) || isset($_POST['evento_del']) || isset($_POST['evento_id_up'])){

		/*--------- Instancia al controlador ---------*/
		require_once "../controlador/eventoControlador.php";
		$ins_evento = new eventoControlador();


		/*--------- Agregar un evento ---------*/
		if(isset($_POST['instructor_even']) && isset($_POST['ficha_even'])){
			echo $ins_evento->agregar_evento_controlador();
		}

		/*--------- Eliminar un evento---------*/
		if(isset($_POST['evento_del'])){
			echo $ins_evento->eliminar_evento_controlador();
		}

		/*--------- actualizar un evento ---------*/
		if(isset($_POST['evento_id_up'])){
			echo $ins_evento->actualizar_evento_controlador();
		}
		

		
	}else{
		
	}