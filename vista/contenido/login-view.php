<?php
 require_once  "./controlador/loginControlador.php";
?>

<div class="circle-1">
</div>
<div class="circle-2">
</div>
<div class="circle-3">
</div>
<div class="circle-4">
</div>
<div class="text">
	<h1 class="login-text">SISTEMA DE GESTION DE HORARIOS</h1>
</div>

<div class="login-container" id="container">
	<div class="form-container sign-in-container">
		<form action="" method="POST">
			<h1>Inicia Sesion</h1>
			<span>Usa tu cuenta</span>
			<label for="UserName"></label>
			<input type="text" id="UserName" name="usuario_log" pattern="[a-zA-Z0-9]{1,35}" maxlength="35" placeholder="Usuario" required="">
			<label for="UserPassword"></label>
			<input type="password" id="UserPassword" name="clave_log" pattern="[a-zA-Z0-9$@.-]{7,100}" maxlength="100" placeholder="Contraseña" required="">
			<a href="#" class="reset">Olvidaste tu contraseña?</a>
			<button type="submit">INICIAR SESION</button>
		</form>
	</div>
	<div class="overlay-container">
		<div class="overlay">
			<div class="overlay-panel overlay-left">
			</div>
			<div class="overlay-panel overlay-right">
				<img src="<?php echo SERVERURL; ?>vista/assets/img/llustration.svg" alt="" >
				<h1>BIENVENIDO!</h1>
				<p></p>
			</div>
		</div>
	</div>
</div>

<?php
	if(isset($_POST['usuario_log']) && isset($_POST['clave_log'])){
		require_once "./controlador/loginControlador.php";

		$ins_login= new loginControlador();

		echo $ins_login->iniciar_sesion_controlador();
	}
?>
<script>

	let btn_olvido=document.querySelector(".reset");
    btn_olvido.addEventListener('click', function(e){
        e.preventDefault();
        Swal.fire({
			title: 'Recupera tu cuenta',
            width: '20vw',
            background: '#fff',
            position:'',
            backdrop: false,
			input:'email',
			inputPlaceholder: 'Ingresa tu email',
			validationMessage:'No existe ningún usuario con ese correo electrónico',
			inputAutoTrim: false,
			showCancelButton: true,
			confirmButtonColor: '#F86018',
			cancelButtonColor: '#1098A0',
			confirmButtonText: 'Enviar',
			cancelButtonText: 'Atras'
		
		});
	});

	
	



</script>


	

