<?php 
include "../../php/consultas_usuarios.php";
if(!isset($_SESSION['usuario'])){
    echo'
        <script>
            alert("Por favor inicie sesion");
            window.location = "../../index.php";
        </script>
    ';
    session_destroy();
    die();
 }
 if($row['id_rol'] != 3){
    echo'
        <script>
            alert("Usuario no permitido");
            window.location = "../../index.php";
        </script>
    ';

}
?> 
<!doctype html>
<html lang="es">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>PATPA</title>
    <link rel="stylesheet" href="styles_empresa.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"  >
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
                    <img src="../../images/img_usuario_usuario.png" alt="">
                    <p>Usuario</p>
                <?php 
                    }elseif($row['id_rol'] == 2){
                ?>
                <img src="../../images/img_usuario_repartidor.png" alt="">
                <p>Repartidor</p>
                <?php 
                }else{
                    ?>
                    <img src="../../images/img_usuario_empresa.jpg" alt="">
                    <p>Empresa</p>
                    <?php 
                    }
                    ?>
        </div>
     <div class="usuario">
            <img src="../../<?php echo $row['foto']?>" alt="">
            <a href=""><?php echo $row['nombre'] ?></a>
     </div>
        <div class="container_header">
            <button class="cerrar_informacion">X</button>

         <div class="menu">
            <nav>
                <ul>
                    <li><a href="../inicio.php">Inicio</a></li>
                    <li><a href="../categorias/categorias.php">Productos</a></li>
                    <li><a href="../empresas/empresa.php">Empresas</a></li>
                    <li><a href="../pedidos/pedidos.php">Pedidos</a></li>
                    <li><a href="../carrito/carrito.php">Carrito</a></li>
                        
                </ul>
            </nav>
         </div>
         <form class="formulario_buscar" action="../buscar.php" method="get" role="search">
                <input  type="search" placeholder="Buscar" name="q" aria-label="Search">
                <button class="buscar " type="submit"> Buscar</button>
        </form>
        </div>
        <div class="eslogan">
            <h1>PATPA</h1>
            <p>Para ti de Puerto Asís</p>
        </div>
    </header>
    
    <!--  cuando se le da a la empresa para ver detalles -->
    <div class="informacion_articulo">
            <div class="cabeza">
                <h2></h2>
                <button class="cerrar_informacion_articulo">X</button>
            </div>
            <div class="contenido">
                <img src="">
                <div class="descripcion_pedido">
                    <h3></h3>
                    <p></p>
                    <div class="contenedor_colapsar">
                        <div class="colapsar">  
                            <h3>POLLO</h3>
                        </div>
                    </div>
                </div>
            </div>
            <div class="final">
                <form action="editar.php" method="post">
                    <input type="hidden" name="editar_id_articulo" id="articulo_id_consulta" value="">
                    <button class="final_añadir" type="submit">Editar</button>

                </form>
            </div>
        </div>
    
    <main>
        
        </div>
        <!-- fin cuando se le da a la empresa para ver detalles -->
        <div class="portada_empresa">   
            <img src="../../<?php echo $row['fondo']?>" class="fondo" alt="">
            <img src="../../<?php echo $row['foto']?>" class="portada_logo" alt="">
            <h2><?php echo $row['usuario']?></h2>
            <form action="editar.php" method="post">
                <button class="boton_editar" name="editar_informacion_usuario" value="<?=  $usuario_id; ?>">Editar</button>
            </form>
            <h3><?php echo $row['nombre_categoria']?></h3>
            <p style="margin-top: 7px;font-size: 16px;"><?php echo $row['direccion']?></p>
            <p style="margin-top: 12px;">Calificacion: </p>
            <br>
            <hr>
            
            <div class="portada_menu">
            <?php 
            $informacion_seccion_empresa->data_seek(0);
            $articulos_empresa->data_seek(0);
            while($filas_informacion_secciones_empresa = $informacion_seccion_empresa->fetch_assoc()){?>
                <div>
                    <p><?php echo $filas_informacion_secciones_empresa['nombre']?></p>
                </div>
                <?php 
            }
            $informacion_seccion_empresa->data_seek(0);

            ?>
            </div>
            
        </div>
        
        <div class="menu_empresa">
            <a href="../empresas/agregar_articulo.php"><button class="añadir">+ Añadir</button></a>
            <?php while($filas_informacion_secciones_empresa = $informacion_seccion_empresa->fetch_assoc()){
                $seccion=$filas_informacion_secciones_empresa['id']?> 
                <div class="contenido_menu">
                    <h2><?php echo $filas_informacion_secciones_empresa['nombre'];?></h2>

                <?php 
                $articulos_empresa->data_seek(0);
                while($filas_articulos_empresa = $articulos_empresa->fetch_assoc()){
                    if($filas_articulos_empresa['seccion_id'] == $seccion) {
                        ?> 
                <div class="menu_inventario" id="articulo-id" data-id="<?php echo $filas_articulos_empresa['id']; ?>">
                    <div class="menu_inventario_imagen">
                        <img src="../../<?php echo $filas_articulos_empresa['imagen']?>" alt="">
                    </div>
                    <div class="menu_inventario_informacion">
                        <h4><?php echo $filas_articulos_empresa['nombre']?></h4>
                        <div class="menu_inventario_descripcion">
                            <p><?php echo $filas_articulos_empresa['descripcion']?></p>
                        </div>
                        <h4 style="margin-top: 10px;">$<?php echo $filas_articulos_empresa['precio']?></h4>
                    </div>
                </div>
                <?php 
                    } 
                }?>
                
            </div>
            <?php
             }
              ?>
            
           
        </div>
        <div class="informacion_empresa">
            <div class="informacion_basica">
                <h2 >Sobre Empresa</h2>
                <div><h4>Direccion</h4><p>cra 17</p></div>
                <div><h4>Calificacion</h4><p>cra 17</p></div>
                <div><h4>Producto Popular</h4><p>cra 17</p></div>
                <div><h4>Horario apertura</h4><p>cra 17</p></div>
                <div><h4>Horario de cierre</h4><p>cra 17</p></div>
                
            </div>
            <div class="horario_mapa">
                <div class="horario">
                    <h2>Horarios de Apertura y Cierre</h2>
                    <div><h4>Lunes</h4><p>cra 17</p></div>
                    <div><h4>Martes</h4><p>cra 17</p></div>
                    <div><h4>Miercoles</h4><p>cra 17</p></div>
                    <div><h4>Jueves</h4><p>cra 17</p></div>
                    <div><h4>Viernes</h4><p>cra 17</p></div>
                    <div><h4>Sabado</h4><p>cra 17</p></div>
                    <div><h4>Domingo</h4><p>cra 17</p></div>
                </div>
                <div class="mapa" >
                     <input type="hidden" value="<?php echo $fila_coordenadas['longitud'] ?>" id="longitud">

                    <input type="hidden" value="<?php echo $fila_coordenadas['latitud'] ?>"
                    id="latitud">
                    <form action="editar.php" method="POST">
                     <button class="boton_editar" name="editar_mapa" value="<?=  $usuario_id; ?>">Editar</button>
                    </form>
                    <h3>Direccion</h3>
                    <p>calle</p>
                    <div id="map">

                    </div>
                </div>
            </div>
            <div class="comentarios">
                  
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
                <a href="#"><img src="../../images/facebook_logo.png" alt=""></a>
                <a href="#"><img src="../../images/instagram_logo.png" alt=""></a>
                <a href="#"><img src="../../images/twitter_logo.png" alt=""></a>

            </div>
        </div>
    </footer>
   
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script src="../../js/vista_empresa.js"></script>
    <script src="../../js/menu_hamburguesa.js"></script>
    <script src="../../js/mapa.js"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBDaeWicvigtP9xPv919E-RNoxfvC-Hqik&callback=iniciarMap"></script>
    <!-- <script src="../../js/editar_usuario.js"></script> -->
</body>
</html>