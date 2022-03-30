<?php
	$servername="localhost";
	$username="root";
	$password="";
	$dbname="programaciondeinstructores";

	$conexion = mysqli_connect($servername, $username, $password, $dbname);

	if(!$conexion){
		echo"Error en la conexion con el servidor";
	}

	$sql = "SELECT * FROM tblresultadodeaprendizaje";
	$ejecutarSql = mysqli_query($conexion, $sql);
	
	echo '<datalist id="evento_resultado" required>';
	echo '<option value="" selected="">-Seleccione-</option>';
	while($fila = mysqli_fetch_array($ejecutarSql)){
		if($fila['FkRel_Resultado_Competencia']==$_GET['c']){
			
			echo"<option value='".$fila['ResCodigo']."'>".$fila['ResCodigo']."-".$fila['ResNombre']."</option>";
		}
		
	}
	echo'</datalist>';
?>