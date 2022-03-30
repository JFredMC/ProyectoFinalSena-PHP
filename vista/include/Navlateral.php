
<?php if($_SESSION['privilegio_spm']==1){ ?>

<body class="body-navlateral">
    

<div class="wrapper">
<div class="section">
    <div class="top_navbar navbar-collapse collapse">
        <div class="hamburger">
            <a href="#">
                <i class="fas fa-bars"></i>
            </a>
        </div>
        
            <ul class="nav navbar-menu navbar-right">
                <li class="dropdown">
                <a href="#" class="dropdown-toggle fa-1x" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false" color="white"><span class="icon"><i class="fas fa-user fa-2x" "></span></i><span class="caret"></span></a>
                <ul class="dropdown-menu">
                    <li class="text-center"><a href="<?php echo SERVERURL ?>perfil/<?php echo mainModel::encryption($_SESSION['id_spm']) ?>">Mi perfil</a></li>
                    
                    <li class="text-center"><a href="<?php echo SERVERURL ?>usuario-lista/">Lista usuarios</a></li>
                    
                    <li class="text-center"><a href="" class="btn-exit-system">Cerrar Sesion</a></li>
                </ul>
                </li>
            </ul>
        </div>
    <div class="sidebar">
        <div class="profile custom-file">
            
            <img src="<?php echo SERVERURL ?>vista/assets/avatar/avatar.png" alt="imagen de perfil">
            <br>
            <figcaption class="text"><a class="text-decoration:none" style="text-decoration:none; color:#1098A0" href="<?php echo SERVERURL ?>perfil/<?php echo mainModel::encryption($_SESSION['id_spm']) ?>"><?php echo $_SESSION['nombre_spm']; echo " "; echo $_SESSION['apellido_spm']; ?> <br> </a><small><?php echo $_SESSION['cargo_spm']; ?></small></figcaption>  
            
        </div>
         
        <ul>
                <li>
                    <a href="<?php echo SERVERURL ?>home/" class="">
                        <span class="icon"><i class="fas fa-home fa-1x"></i></span>
                        <span class="item">Inicio</span>
                    </a>
                </li>
                
                <li>
                    <a href="<?php echo SERVERURL ?>instructor/">
                        <span class="icon"><i class="fas fa-chalkboard-teacher fa-1x"></i></span>
                        <span class="item">Instructor</span>
                    </a>
                </li>
                <li>
                    <a href="<?php echo SERVERURL ?>calendario/">
                        <span class="icon"><i class="fas fa-calendar-alt fa-1x"></i></span>
                        <span class="item">Calendario</span>
                    </a>
                </li>

                <li>
                    <a href="<?php echo SERVERURL ?>evento-asignacion/">
                        <span class="icon"><i class="fas fa-plus fa-1x"></i></span>
                        <span class="item">Asignacion de horarios</span>
                    </a>
                </li>
                <li>
                    <a href="<?php echo SERVERURL ?>programa-formacion-lista/">
                        <span class="icon"><i class="fas fa-book fa-1x"></i></span>
                        <span class="item">Programas de formacion</span>
                    </a>
                </li>
                <li>
                    <a href="<?php echo SERVERURL ?>ficha/">
                        <span class="icon"><i class="fas fa-clipboard fa-1x"></i></span>
                        <span class="item">Fichas</span>
                    </a>
                </li>
                <li>
                    <a href="<?php echo SERVERURL ?>competencia-lista/">
                        <span class="icon"><i class="fas fa-book-open fa-1x"></i></span>
                        <span class="item">Competencias</span>
                    </a>
                </li>
                <li>
                    <a href="<?php echo SERVERURL ?>resultados-de-aprendizaje/">
                        <span class="icon"><i class="fas fa-list fa-1x"></i></span>
                        <span class="item">Resultados de aprendizaje</span>
                    </a>
                </li>
                
            </ul>
        </div>
    </div>
    
</div>

<?php }else{ ?>
    <body class="body-navlateral">
    

<div class="wrapper">
<div class="section">
            <div class="top_navbar navbar-collapse collapse">
                <div class="hamburger">
                    <a href="#">
                        <i class="fas fa-bars"></i>
                    </a>
                </div>
                
                    <ul class="nav navbar-menu navbar-right">
                        <li class="dropdown">
                        <a href="#" class="dropdown-toggle fa-1x" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false" color="white"><span class="icon"><i class="fas fa-user fa-2x" "></span></i><span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li class="text-center"><a href="<?php echo SERVERURL ?>perfil/<?php echo mainModel::encryption($_SESSION['id_spm']) ?>">Mi perfil</a></li>

                            <li class="text-center"><a href="" class="btn-exit-system">Cerrar Sesion</a></li>
                        </ul>
                        </li>
                    </ul>
        </div>
    <div class="sidebar">
    <div class="profile">
        <img src="<?php echo SERVERURL ?>vista/assets/avatar/avatar.png" alt="imagen de perfil">
        <br>
        <figcaption class="text"><a class="text-decoration:none" style="text-decoration:none; color:#1098A0" href="<?php echo SERVERURL ?>perfil/<?php echo mainModel::encryption($_SESSION['id_spm']) ?>"><?php echo $_SESSION['nombre_spm']; echo " "; echo $_SESSION['apellido_spm']; ?> <br> </a><small><?php echo $_SESSION['cargo_spm']; ?></small></figcaption>

        
    </div>
            
        <ul>
                <li>
                    <a href="<?php echo SERVERURL ?>home/" class="">
                        <span class="icon"><i class="fas fa-home fa-1x"></i></span>
                        <span class="item">Inicio</span>
                    </a>
                </li>
                <li>
                    <a href="<?php echo SERVERURL ?>calendario/">
                        <span class="icon"><i class="fas fa-calendar-alt fa-1x"></i></span>
                        <span class="item">Calendario</span>
                    </a>
                </li>

                <li>
                    <a href="<?php echo SERVERURL ?>evento-lista/">
                        <span class="icon"><i class="fas fa-list fa-1x"></i></span>
                        <span class="item">Lista horarios</span>
                    </a>
                </li>
                
                
            </ul>
        </div>
    </div>
    
</div>
<?php } ?>




<script>
    var hamburger = document.querySelector(".hamburger");
    hamburger.addEventListener("click", function(){
        document.querySelector("body").classList.toggle("active");
    })
</script>
</body>