<?php
	$servername="localhost";
	$username="root";
	$password="";
	$dbname="programaciondeinstructores";

	$conexion = mysqli_connect($servername, $username, $password, $dbname);

	if(!$conexion){
		echo"Error en la conexion con el servidor";
	}

	$sql = "SELECT * FROM tblcompetencias";
	$ejecutarSql = mysqli_query($conexion, $sql);
	
	echo '<datalist id="evento_competencia"   required>';
	echo '<option value="" selected="">-Seleccione-</option>';
	while($fila = mysqli_fetch_array($ejecutarSql)){
		if($fila['FkRelCompetencia_Programa']==$_GET['c']){
			
			echo"<option value='".$fila['ComCodigoCompetencia']."'>".$fila['ComNombre']."</option>";
		}
		
	}
	echo'</datalist>';
?>