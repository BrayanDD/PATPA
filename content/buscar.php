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
    <div class="container">
        <!-- CABEZA DE MENU -->
        <?php include "../partials/header.php" ?>
        <main>
            <!-- INICIO -->
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
                            <button type="button" class="pedir" name="pedir" value="pedir">Pedir</button>
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
                    <?php $pagina_actual = 0 ?>
                    
                        <div class="productos_populares">
                            <h1>Productos Populares</h1>
                        </div>
                        <br>
                        <?php
                        $conn = mysqli_connect("localhost", "root", "", "patpa");
                        $limit = 12;
                        $termino_busqueda = isset($_GET['q']) ? $_GET['q'] : '';
                        $pagina_actual = isset($_GET['pagina']) ? $_GET['pagina'] : 1;
                        $offset = ($pagina_actual - 1) * $limit;

                        // Consulta para los artículos
                        $busqueda_articulo = $conn->query("SELECT articulo.*, categoria.categorias as nombre_categoria
                            FROM articulo
                            INNER JOIN categoria on articulo.categoria_id = categoria.id
                            WHERE articulo.nombre LIKE '%$termino_busqueda%'
                            LIMIT $limit OFFSET $offset");

                        // Consulta para las empresas
                        $busqueda_empresa = $conn->query("SELECT usuario.* , categoria.categorias as nombre_categoria
                            FROM usuario
                            INNER JOIN categoria ON usuario.categorias = categoria.id
                            WHERE usuario.usuario LIKE '%$termino_busqueda%'
                            LIMIT $limit OFFSET $offset");

                        ?>

                        <div class="producto_popular">
                            <?php
                            while ($filas_articulos_busqueda = $busqueda_articulo->fetch_assoc()) {
                                // Mostrar resultados de artículos
                            ?>
                                <div class="producto articulo-id" data-id="<?php echo $filas_articulos_busqueda['id']; ?>">
                                    <h2><?php echo $filas_articulos_busqueda['nombre']; ?></h2>
                                    <img src="../<?php echo $filas_articulos_busqueda['imagen']; ?>" alt="">
                                    <p><?php echo $filas_articulos_busqueda['nombre_categoria']; ?></p>
                                    <p>$ <?php echo $filas_articulos_busqueda['precio']; ?></p>
                                </div>
                            <?php
                            }
                            ?>
                        </div>

                        <!-- Empresas populares que tiene mas ventas -->
                        <div class="locales_populares">
                            <h1>Locales / Empresas Populares</h1>
                        </div>
                        <div class="local_popular">
                            <?php
                            while ($filas_empresa_busqueda = $busqueda_empresa->fetch_assoc()) {
                                // Mostrar resultados de empresas
                            ?>
                                <div class="local" data-id="<?php echo $filas_empresa_busqueda['id']; ?>">
                                    <img src="../<?php echo $filas_empresa_busqueda['foto']; ?>" alt="">
                                    <h2><?php echo $filas_empresa_busqueda['nombre']; ?></h2>
                                    <p><?php echo $filas_empresa_busqueda['nombre_categoria']; ?></p>
                                </div>
                            <?php
                            }
                            ?>
                        </div>

                        <div class="paginacion">
                            <?php if ($pagina_actual > 1): ?>
                                <a href="?q=<?= $termino_busqueda ?>&pagina=<?= $pagina_actual - 1 ?>" id="anterior">Anterior</a>
                            <?php endif ?>
                            <p id="numero_pagina"><?= $pagina_actual ?></p>
                            <?php if ($busqueda_articulo->num_rows >= $limit): ?>
                                <a href="?q=<?= $termino_busqueda ?>&pagina=<?= $pagina_actual + 1 ?>" id="siguiente">Siguiente</a>
                            <?php endif; ?>

                            <?php if ($busqueda_empresa->num_rows >= $limit): ?>
                                <a href="?q=<?= $termino_busqueda ?>&pagina=<?= $pagina_actual + 1 ?>" id="siguiente">Siguiente</a>
                            <?php endif; ?>

                            <?php mysqli_close($conn); ?>
                        </div>

                    </div>
            </div>
        </main>
        <?php include "../partials/footer.php" ?>

    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script src="../js/menu_hamburguesa.js"></script>
    <script src="../js/carrito.js"></script>
    <script src="../js/inicio_info.js"></script>
   
</body>
</html>