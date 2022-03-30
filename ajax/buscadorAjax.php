<?php
    session_start(['name'=>'SPM']);
    require_once "../config/APP.php";

    if(isset($_POST['busqueda_inicial']) || isset($_POST['eliminar_busqueda']) || isset($_POST['fecha_inicio']) || isset($_POST['fecha_fin'])){

        $data_url=[
            "usuario"=>"usuario-buscar",
            "instructor"=>"instructor-buscar",
            "ficha"=>"ficha-buscar",
            "resultado"=>"resultado-buscar",
            "evento"=>"evento-buscar",
            "programa"=>"programa-formacion-buscar",
            "competencia"=>"competencia-buscar"
        ];

        if(isset($_POST['modulo'])){
            $modulo=$_POST['modulo'];
            if(!isset($data_url[$modulo])){
                $alerta=[
                    "Alerta"=>"simple",
                    "Titulo"=>"Ocurrio un error inesperado",
                    "Texto"=>"No es posible realizar la busqueda",
                    "Tipo"=>"error"
                ];
                echo json_encode($alerta);
                exit();
            }
        }else{
            $alerta=[
                "Alerta"=>"simple",
                "Titulo"=>"Ocurrio un error inesperado",
                "Texto"=>"No es posible realizar la busqueda por un problema de configuracion",
                "Tipo"=>"error"
            ];
            echo json_encode($alerta);
            exit();
        }
        
        if($modulo=="prestamo"){

        }else{
            $name_var="busqueda_".$modulo;

            // INICIAR BUSQUEDA
            if(isset($_POST['busqueda_inicial'])){
                if($_POST['busqueda_inicial']==""){
                    $alerta=[
                        "Alerta"=>"simple",
                        "Titulo"=>"Ocurrio un error inesperado",
                        "Texto"=>"Introduzca un valor para iniciar la busqueda",
                        "Tipo"=>"error"
                    ];
                    echo json_encode($alerta);
                    exit();
                }
                $_SESSION[$name_var]=$_POST['busqueda_inicial'];
            }
            
            //ELIMINAR BUSQUEDA
            if(isset($_POST['eliminar_busqueda'])){
                unset($_SESSION[$name_var]);
            }
        }

        //redireccionar
        $url=$data_url[$modulo];
        $alerta=[
            "Alerta"=>"redireccionar",
            "URL"=>SERVERURL.$url."/"
        ];

        echo json_encode($alerta);
        
    }else{
        session_unset();
		session_destroy();
		header("Location: ".SERVERURL."login/");
		exit();
    }
?>