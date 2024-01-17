<?php
 include "../php/consultas_inicio.php";
 
 if(!isset($_SESSION['usuario'])){
    echo'
        <script>
            alert("Por favor inicie sesion");
            window.location = "../index.php";
        </script>
    ';
    session_destroy();
    die();
 }

?>

<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>PATPA</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,800;1,100;1,200;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
</head>

  <body>
    <!-- CABEZA DE MENU -->
    <header>
        <div class="bar_menu">
            <span class="linea1_bar_menu"></span>
            <span class="linea2_bar_menu"></span>
            <span class="linea3_bar_menu"></span>
        </div>
        <div class="logo">
        
            <?php
                if($row['id_rol'] == 1){
                ?>
                    <a href="usuarios/usuario_usuario.php"><img src="../images/img_usuario_usuario.png" alt=""></a>
                    <a href="usuarios/usuario_usuario.php"><p>Usuario</p></a>
                <?php 
                    }elseif($row['id_rol'] == 2){
                ?>
                <img src="../images/img_usuario_repartidor.png" alt="">
                <p>Repartidor</p>
                <?php 
                }else{
                    ?>
                    <a href="usuarios/usuario_empresa.php"><img src="../images/img_usuario_empresa.jpg" alt=""></a>
                    <a href="usuarios/usuario_empresa.php"><p>Empresa</p></a>
                    <?php 
                    }
                    ?>
        </div>
        <div class="usuario">
        <?php
                if($usuario_id_rol == 1){
                ?>
                    <a href="usuarios/usuario_usuario.php"><img src="../<?php echo $row['foto']?>" alt=""></a>
                    <a href="usuarios/usuario_usuario.php"><?php echo $row['usuario']?></a>
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
                        <li><a href="categorias/categorias.php">Categorias</a></li>
                        <li><a href="empresas/empresa.php">Empresas</a></li>
                        <li><a href="pedidos/pedidos.php">Pedidos</a></li>
                        <li><a href="carrito/carrito.php">Carrito</a></li>
                                
                    </ul>
                 </nav>
             </div>
            <form class="formulario_buscar" action="buscar.php" method="get" role="search">
              <input  type="search" placeholder="Buscar" name="q" aria-label="Search">
              <button class="buscar " type="submit"> Buscar</button>
            </form>
        </div>
        <div class="eslogan">
            <h1>PATPA</h1>
            <p>Para ti de Puerto Asís</p>
        </div>
    </header>
    <main>
         <!-- INICIO -->
        <div class="que_es">
            <section>
                <h1>¿Que es PATPA?</h1>
                <p>PATPA es una plataforma donde las empresas y emprendimientos puden dar a conocer sus productos y servicios ofrecidos , donde las personas puden trabajar como repartidores y donde los usuarios puden conocer los productos que hay en Puerto Asís, conocer sus precios con mayor facilidad para poder elegir y tambien ordenar una entrega a domicilio
                </p>
            </section>
        </div>
         <!-- productos popualres-->
        <div class="principal">
            <!-- cuando se le da al articulo para ver detalles -->
           
                <div class="mostrar_informacion" >
                    <button class="cerrar-articulo">Cerrar</button>
                    <h1></h1>
                    
                    <br>
                    <h5></h5>
                    <br>
                    <h3 class="precio"></h3>
                    <br>
                    <div class="imagen_articulo_informacion">
                        <img src="" alt="" >
                        <div class="calificacion">
                            calificacion
                        </div>
                    </div>
                    <h3 id="empresa"></h3>
                    <div class="informacion_empresa">
                        <img src="" alt="" class="imagen_empresa">
                        
                    </div>
                    <h3>Descripcion</h3>
                    <div class="descripcion">
                        <p></p>
                    </div>
        
                    <form action="" method="" class="formulario_acciones">
                        <input type="hidden" name="id_producto" class="articulo" value="">
                        <input type="number" name="cantidad" value="1" step="1" id="cantidad" min="1" max="100">
                        <button type="button" class="pedir" name="pedir" value="">Pedir</button>
                        <button type="button"  class="carrito" name="añadir_al_carrito" value="">Carrito</button>
                    </form>
                  
                </div>
                <div class="mostrar_informacion_empresa" >
                    <button class="cerrar-empresa">Cerrar</button>
                    <h1></h1>   
                    <br>
                    <h5>Categoria</h5>
                    <br>
                    <h3 class="direccion"></h3>
                    <br>
                    <div class="imagen_articulo_informacion">
                        <img src="" alt="" >
                        <div class="calificacion">
                            calificacion
                        </div>
                    </div>
                    <h3>Descripcion</h3>
                    <div class="descripcion">
                        <p></p>
                    </div>
        
                    <form action="" class="formulario_acciones">
                        <button type="submit" name="accion" value="pedir">Ver detalles</button>
                       
                    </form>
                  
                </div>
                
                    <div class="productos_populares">
                        <h1>Productos Populares</h1>
                    </div>
                    <br>
                    <div class="producto_popular">
                        <?php 
                        while($filas_articulos_empresa = $articulos_empresa->fetch_assoc()
                        ){
                        ?>
                           
                                <div  class="producto articulo-id"  data-id="<?php echo    $filas_articulos_empresa['id']; ?>">
                                    <h2><?php echo $filas_articulos_empresa['nombre']; ?></h2>
                                    <img src="../<?php echo $filas_articulos_empresa['imagen']; ?>" alt="">
                                    <p><?php echo $filas_articulos_empresa['nombre_categoria']; ?></p>
                                    <p>$ <?php echo $filas_articulos_empresa['precio']; ?></p>
                                </div>
                            
                            
                        <?php 
                        }
                        ?>
                    </div>
                <!-- Empresas populares que tiene mas ventas
                -->
                
                    <div class="locales_populares">
                        <h1>Locales / Empresas Populares</h1>
                    </div>
                    <div class="local_popular">
                        <?php 
                        
                        while($filas_empresa = $consulta_empresas->fetch_assoc()
                        ){?>
                        
                            <div class="local" class="producto articulo-id"  data-id="<?php echo    $filas_empresa['id']; ?>">
                                <img src="../<?php echo $filas_empresa['foto']; ?>"  alt="">
                                <h2><?php echo $filas_empresa['nombre']; ?></h2>
                                <p><?php echo $filas_empresa['nombre_categoria']; ?></p>
                            </div>
                            
                        
                        <?php 
                        }
                        ?>
                    </div>
        </div>
    </main>
    <footer>
        <div class="contenido_footer">
            <div class="cookies">
                <a href="#">Cookies</a>
                <a href="#">Normas</a>
            </div>
            <div class="informacion">
                <p>Telefono: 1111111</p>
                <p>Correo: patpaoficiak@gmail.com</p>
            </div>
            <div class="redes_sociales">
                <a href="#"><img src="../images/facebook_logo.png" alt=""></a>
                <a href="#"><img src="../images/instagram_logo.png" alt=""></a>
                <a href="#"><img src="../images/twitter_logo.png" alt=""></a>

            </div>
        </div>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script src="../js/menu_hamburguesa.js"></script>
    <script src="../js/carrito.js"></script>
    <script src="../js/añadir_a_pedido.js"></script>
    <script src="../js/inicio_info.js"></script>
   
</body>
</html>