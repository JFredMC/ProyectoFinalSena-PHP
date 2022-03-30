<?php
	$servername="localhost";
	$username="root";
	$password="";
	$dbname="programaciondeinstructores";

	$conexion = mysqli_connect($servername, $username, $password, $dbname);

	if(!$conexion){
		echo"Error en la conexion con el servidor";
	}

	$sql = "SELECT * FROM tblinstructor";
	$ejecutarSql = mysqli_query($conexion, $sql);

	while($fila = mysqli_fetch_array($ejecutarSql)){
		echo"<option value='".$fila['InsIdentificacion']."'>".$fila['InsIdentificacion']."-".$fila['InsNombres']." ".$fila['InsApellidos']."</option>";
	}

	mysqli_close($conexion);
?>



