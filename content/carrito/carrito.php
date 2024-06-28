<?php
 include "../../php/consultas_carrito.php";
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
    <link rel="stylesheet" href="carrito.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"  >
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,800;1,100;1,200;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet">
  </head>
  <body>
    <!-- CABEZA DE MENU -->
    <?php include "../../partials/header.php" ?>

    <div class="informacion_articulo">
            <div class="cabeza">
                <h2>EMPRESA</h2>
                <button class="cerrar_informacion_articulo">X</button>
            </div>
            <div class="contenido">
                <img src="../../images/kisspng-bandeja-paisa-full-breakfast-colombian-cuisine-pai-carne-asada-5b5579ff8795d8.5620214715323284475554.png" alt="">
                <div class="descripcion_pedido">
                    <h3>Precio</h3>
                    <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Earum repellendus nihil facilis facere? Sit ratione dolorem, quod eos illum et aspernatur explicabo eaque repudiandae cum dolore, ipsam similique quis quae?</p>
                    <div class="contenedor_colapsar">
                        <div class="colapsar">  
                            <h3>POLLO</h3>
                        </div>
                    </div>
                </div>
            </div>
            <div class="final">
                <form action="" >
                    <input type="number" step="1" value="1">
                </form>
                
            </div>
        </div>
    <main>
        <div class="contenido_menu">
            <table>
                <tr>
                    <th><h2>Articulos</h2></th>
                    <th><h4>Precio</h4></th>
                    <th><h4>Cantidad</h4></th>
                    <th style="margin-right: 30px;"><h5>Actualizar</h5></th>
                    <th style="margin-left: 10px;"><h5>Eliminar</h5></th>
                </tr>

                <?php
                    $totalCosto = 0;
                while ($fila_articulos_carrito = $articulos_carrito->fetch_assoc()) {
                    $precio_articulo = $fila_articulos_carrito['precio_articulo'];
                    $cantidad = $fila_articulos_carrito['cantidad']; 
                    // Calcular costo parcial
                    $costoParcial = $precio_articulo * $cantidad;

                    // Sumar al costo total
                     $totalCosto += $costoParcial;?>
                    <tr>
                        <td>
                            <div class="menu_inventario">
                                <div class="menu_inventario_imagen">
                                    <img src="../../<?= $fila_articulos_carrito['imagen_articulo'] ?>" alt="">
                                </div>
                                <div class="menu_inventario_informacion">
                                    <h4><?= $fila_articulos_carrito['nombre_articulo'] ?></h4>
                                </div>
                            </div>
                        </td>
                        <td>
                            <h4 style="margin-top: 10px;"><?= $fila_articulos_carrito['precio_articulo'] ?></h4>
                        </td>
                        <td>
                            <form action="../../php/consultas_carrito.php" method="post">
                                <input type="number" min="1" max="100" value="<?= $fila_articulos_carrito['cantidad'] ?>"               name="nueva_cantidad">
                                <input type="hidden" value="<?= $fila_articulos_carrito['id'] ?>" name="id_articulo">
                            
                        </td>
                        <td style="margin-right: 30px;">
                                <button type="submit" class="btn btn-success actualizar_carrito" name="actualizar_cantidad"> Actualizar
                                </button>
                            </form>
                        </td>
                        <td style="margin-left: 10px;">
                            <form action="../../php/consultas_carrito.php" method="post">
                                <input type="hidden" value="<?= $fila_articulos_carrito['id'] ?>" name="id_articulo">   
                                <button type="submit" name="eliminar_de_carrito">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                <?php } ?>
            </table>

        </div>
        
        <form action="../../php/consultas_carrito.php" method="post">
            <input type="hidden" name="pagar" value="<?= $totalCosto ?>">
            <button  type="submit" name="final_pagar" class="final_pagar">Pagar: <p>$<?= $totalCosto ?></p></button>
        </form>

       
    </main>
    <br>
    <?php include "../../partials/footer.php" ?>

   
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script src="../../js/vista_empresa.js"></script>
    <script src="../../js/carrito.js"></script>
    <script src="../../js/menu_hamburguesa.js"></script>
</body>
</html>