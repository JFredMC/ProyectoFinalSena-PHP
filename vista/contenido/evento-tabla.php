
<?php
	$servername="localhost";
	$username="root";
	$password="";
	$dbname="programaciondeinstructores";

	$conexion = mysqli_connect($servername, $username, $password, $dbname);

	if(!$conexion){
		echo"Error en la conexion con el servidor";
	}

	$sql = "SELECT * FROM tblevento";
	$ejecutarSql = mysqli_query($conexion, $sql);
	echo '<table class="table table-hover table-condensed " id="evento_tabla">
    <thead class="">';
	echo '<tr class="">';
	
	echo '<td class="align-middle">Dia</td>';
	echo '<td class="align-middle">Instructor</td>';
	echo '<td class="align-middle">Ficha</td>';
	echo '<td class="align-middle text-nowrap">Resultado de aprendizaje</td>';
	echo '<td class="align-middle text-nowrap">Fecha Inicio</td>';
	echo '<td class="align-middle">Fecha Fin</td>';
	echo '<td class="align-middle">Acciones</td>';
    echo '</tr>';
	

	echo		'</thead>';
	while($fila = mysqli_fetch_array($ejecutarSql)){
		if($fila['EveInstructor']==$_GET['c']){
			echo '<tr class="text-center" id="evento_tabla">';
            echo '<tr>';
			echo"<td class='align_middle'>".$fila['EveDia']."</td>";
			echo"<td class='align_middle'>".$fila['EveInstructor']."</td>";
			echo"<td class='align_middle'>".$fila['EveFicha']."</td>";
			echo"<td class='align_middle'>".$fila['EveResultado']."</td>";
			echo"<td class='align_middle text-nowrap'>".$fila['EveFechaInicio']."</td>";
			echo"<td class='align_middle text-nowrap'>".$fila['EveFechaFin']."</td>";
			
			echo"<td class='row align-items-start'>
				<a href='' class='btn btn-primary ml-1'>
					<i class='fas fa-sync-alt'></i>	
				</a>";
			echo	"<form class='FormularioAjax ml-1' action='".SERVERURL." '"ajax/usuarioAjax.php"' method='POST' data-form='delete' autocomplete='off'>";
			echo						"<input type='hidden' name='usuario_id_del' value=''>
										<button type='submit' class='btn btn-danger'>
												<i class='far fa-trash-alt'></i>
										</button>
									</form>";
				
				
				"</td>";
		}
		
	}
	echo'</tr></tr></table>';
?>