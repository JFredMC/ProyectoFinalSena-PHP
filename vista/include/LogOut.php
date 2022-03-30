<script>
    let btn_salir=document.querySelector(".btn-exit-system");
    btn_salir.addEventListener('click', function(e){
        e.preventDefault();
        Swal.fire({
			title: 'Estas seguro de cerrar sesion?',
			text: "La sesion se cerrara",
			type: 'question',
            width: '',
            background: '#fff',
            position:'',
            backdrop: false,
            toast: true,
			showCancelButton: true,
			confirmButtonColor: '#1098A0',
			cancelButtonColor: '#F86018',
			confirmButtonText: 'Si, salir!',
			cancelButtonText: 'No, cancelar'
		}).then((result) => {
			if (result.value) {
				
                let url='<?php echo SERVERURL; ?>ajax/loginAjax.php';
                let token='<?php echo $lc->encryption($_SESSION['token_spm']); ?>';
                let usuario='<?php echo $lc->encryption($_SESSION['usuario_spm']); ?>';

                let datos = new FormData();
                datos.append("token",token);
                datos.append("usuario",usuario);

                fetch(url,{
                    method:'POST',
                    body: datos
                })
			    .then(respuesta => respuesta.json())
			    .then(respuesta => {
				return alertas_ajax(respuesta);
			});
			
        }

	});
});

</script>