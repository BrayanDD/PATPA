<?php
 include "../../php/consultas_pedidos.php";
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
    <link rel="stylesheet" href="pedidos.css">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,800;1,100;1,200;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet">
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
                if($usuario['id_rol'] == 1){
                ?>
                    <img src="../../images/img_usuario_usuario.png" alt="">
                    <p>Usuario</p>
                <?php 
                    }elseif($usuario['id_rol'] == 2){
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
        <?php
                if($usuario['id_rol'] == 1){
                ?>
                    <a href="../usuarios/usuario_usuario.php"><img src="../../<?php  echo $usuario['foto']?>" alt=""></a>
                    <a href="../usuarios/usuario_usuario.php"><?php echo $usuario['usuario']?></a>
                <?php
                     }elseif($usuario['id_rol'] == 2){
                 ?>
                       <img src="../<?php echo $usuario['foto']?>" alt="">
                      <a href=""><?php echo $usuario['usuario']?></a>
                 <?php  
                 }else{
                    ?>
                      <a href="../usuarios/usuario_empresa.kphp"><img src="../../<?php echo $usuario['foto']?>" alt=""></a>
                     <a href="../usuarios/usuario_empresa.php"><?php  echo $usuario['usuario']?></a>
                       <?php 
                     }
                     ?>
     </div>
        <div class="container_header">
            <button class="cerrar_informacion">X</button>

         <div class="menu">
            <nav>
                <ul>
                    <li><a href="../inicio.php">Inicio</a></li>
                    <li><a href="../categorias/categorias.php">Productos</a></li>
                    <li><a href="../empresas/empresa.php">Empresas</a></li>
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
    <div class="informacion_articulo">
            <div class="cabeza">
                <h2>Detalle Pedido</h2>
                <button class="cerrar_informacion_articulo">X</button>
            </div>
            <div class="contenido">
                <table>
                    <tr>
                        <th class="nombre_art">Articulo</th>
                        <th>Imagen</th>
                        <th>Precio Unitario</th>
                        <th>Cantitad</th>
                        <th>Total</th>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>

                </table>
                
            </div>
            <div class="final">
                <h4>Precio Final</h4>
                
            </div>
        </div>
    <main>
        <div class="contenido_menu">
            <table>
                <tr>
                    <th><h2>ID</h2></th>
                    <th><h4>Articulos</h4></th>
                    <th><h4>Valor a pagar</h4></th>
                    <th style="margin-right: 30px;"><h5>Estado</h5></th>
                    <th style="margin-right: 30px;"><h5>Cancelar</h5></th>
                    
                </tr>

                <?php
                    
                while ($fila_pedidos = $pedidos->fetch_assoc()) {
                    $id_pedido_tiene = $fila_pedidos['id']
                  ?>
                    <tr>
                        <td>
                            <div class="menu_inventario">
                               
                                    <h4 class="id_pedido"><?=$id_pedido_tiene ?></h4>
                            </div>
                        </td>
                        <td>
                            <h4 style="margin-top: 10px;" class="detalles">Ver detalles</h4>
                        </td>
                        <td>
                           
                            <p>$ <?= $fila_pedidos['total'] ?></p>
                            
                        </td>
                        <td style="margin-right: 30px;">
                            <p><?= $fila_pedidos['estado'] ?></p>
                                
                        </td>
                        <td style="margin-left: 10px;">
                            <form action="../../php/consultas_pedidos.php" method="POST">
                                <input type="hidden" value="<?= $id_pedido_tiene ?>" name="id_pedido_eliminar">   
                                <button type="submit" name="eliminar_pedido">cancelar</button>
                            </form>
                        </td>
                    </tr>
                <?php } ?>
            </table>

        </div>
        


       
    </main>
    <br>
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
    <script src="../../js/pedidos.js"></script>
    <script src="../../js/menu_hamburguesa.js"></script>
</body>
</html>