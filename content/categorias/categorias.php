<?php
 include "../../php/consultas_categorias.php";
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
    <?php include "../../partials/header.php" ?>

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
        </div>
        <!-- Filtros para categorias -->
        <div class="contenedor_buscar_categorias">
            <form  action="">
            <select class="buscar_categorias" name="categorias" id="selectCategorias">
                <option selected value="" disabled>Categorias: </option>
                <?php 
                $categorias->data_seek(0);
                while($filas_informacion_categoria = $categorias->fetch_assoc()){?>
                    <option value="<?= $filas_informacion_categoria['id']?>"><?= $filas_informacion_categoria['categorias']?></option>
                <?php } ?>
            </select>
            </form>
        </div>
        
        <!-- mostrar articulos -->
        <div class="contenedor_categoria">
                <?php
                    $categorias->data_seek(0);
                    
                while ($filas_informacion_categoria = $categorias->fetch_assoc()) {
                    $categoria_id = $filas_informacion_categoria['id']; 
                    $articulosDeCategoria = $datosConsulta[$categoria_id];
                ?>

                    <h1 id="categoria"><?= $filas_informacion_categoria['categorias'] ?></h1>

                    <div class="categoria">
                        <?php
                        $articulos_empresa->data_seek(0);
                        foreach ($articulosDeCategoria as $articulo) {
                            
                                ?>
                                <div class="articulos" data-id="<?= $articulo['id'] ?>">
                                    <div class="imagen_articulo">
                                        <img src="../../<?= $articulo['imagen'] ?>" alt="">
                                    </div>
                                    <div class="informacion_articulo">
                                        <h2><?= $articulo['nombre'] ?></h2>
                                        <h4><?= $articulo['nombre_empresa'] ?></h4>
                                        <p><?= $articulo['nombre_categoria'] ?></p>
                                        <button>Detalles</button>
                                    </div>
                                </div>
                                <?php
                            
                        }
                        ?>
                    </div>

                <?php
                }
                ?>

    </main>
    <?php include "../../partials/footer.php" ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script src="../../js/menu_hamburguesa.js"></script>
    <script src="../../js/carrito.js"></script>
    <script src="../../js/añadir_a_pedido.js"></script>
    <script src="../../js/categorias.js"></script>

</body>
</html>