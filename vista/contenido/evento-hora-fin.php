<?php
	$servername="localhost";
	$username="root";
	$password="";
	$dbname="programaciondeinstructores";

	$conexion = mysqli_connect($servername, $username, $password, $dbname);

	if(!$conexion){
		echo"Error en la conexion con el servidor";
	}

	$sql = "SELECT * FROM tblficha";
	$ejecutarSql = mysqli_query($conexion, $sql);

	while($fila = mysqli_fetch_array($ejecutarSql)){
		echo"<option value='".$fila['FiHoraFin']."'>".$fila['FiHoraFin']."</option>";
	}

	mysqli_close($conexion);
?>
