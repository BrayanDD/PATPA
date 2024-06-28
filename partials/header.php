<link rel="stylesheet" href="/patpa/static/css/header.css">

  <body>
    <!-- CABEZA DE MENU -->
    <header>
        <div class="bar_menu">
            <span class="linea1_bar_menu"></span>
            <span class="linea2_bar_menu"></span>
            <span class="linea3_bar_menu"></span>
        </div>
        <div class="usuario">
        <?php
                if($usuario_id_rol == 1){
                ?>
                    <a href="/patpa/content/usuarios/usuario_usuario.php"><img src="/patpa/<?php echo $row['foto']?>" alt=""></a>
                    <a href="/patpa/content/usuarios/usuario_usuario.php"><?php echo $row['usuario']?></a>
                <?php
                    }elseif($usuario_id_rol == 2){
                ?>
                     <img src="../<?php echo $row['foto']?>" alt="">
                     <a href=""><?php echo $row['usuario']?></a>
                <?php 
                }else{
                    ?>
                    <a href="usuarios/usuario_empresa.php"><img src="../<?php echo $row['foto']?>" alt=""></a>
                    <a href="usuarios/usuario_empresa.php"><?php echo $row['usuario']?></a>
                    <?php 
                    }
                    ?>
            
        </div>
        <div class="container_header">
            <button class="cerrar_informacion">Cerrar</button>
            <div class="menu">
                 <nav class="nav-list">
                     <ul>
                        <li><a href="/patpa/content/inicio.php">Inicio</a></li>

                        <li><a href="/patpa/content/categorias/categorias.php">Categorias</a></li>
                        <li><a href="/patpa/content/empresas/empresa.php">Empresas</a></li>
                        <li><a href="/patpa/content/pedidos/pedidos.php">Pedidos</a></li>
                        <li><a href="/patpa/content/carrito/carrito.php">Carrito</a></li>
                                
                    </ul>
                 </nav>
             </div>
            <form class="formulario_buscar" action="/patpa/content/buscar.php" method="get" role="search">
              <input  type="search" placeholder="Buscar" name="q" aria-label="Search">
              <button class="buscar " type="submit"> Buscar</button>
            </form>
        </div>
        <div class="eslogan">
            <h1>PATPA</h1>
            <p>Para ti de Puerto Asís</p>
        </div>
    </header>
    