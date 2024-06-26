<?php 
include "../../php/vista_empresa_consulta.php";
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
    <link rel="stylesheet" href="vista_empresa.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"  >
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,800;1,100;1,200;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
  
</head>
  <body>
    <!-- CABEZA DE MENU -->
    <?php include "../../partials/header.php" ?>

    
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
                    <form action="" method="" class="formulario_acciones">
                        <input type="hidden" name="id_producto" class="articulo" value="">
                        <input type="number" name="cantidad" value="1" step="1" id="cantidad" min="1" max="100">
                        <button type="button" class="pedir" name="pedir" value="">Pedir</button>
                        <button type="button"  class="carrito" name="añadir_al_carrito" value="">Carrito</button>
                    </form>
            </div>
        </div>
    
    <main>
        
        </div>
        <!-- fin cuando se le da a la empresa para ver detalles -->
        <div class="portada_empresa">   
            <img src="../../<?php echo $empresa_selecionada ['fondo']?>" class="fondo" alt="">
            <img src="../../<?php echo $empresa_selecionada ['foto']?>" class="portada_logo" alt="">
            <h2><?php echo $empresa_selecionada ['usuario']?></h2>
            <h3><?php echo $empresa_selecionada ['nombre_categoria']?></h3>
            <p style="margin-top: 7px;font-size: 16px;"><?php echo $empresa_selecionada ['direccion']?></p>
            <p style="margin-top: 12px;">Calificacion: </p>
            <br>
            <hr>
            
            <div class="portada_menu">
                <?php 
                $informacion_seccion_empresa->data_seek(0);
                $articulos_empresa_result->data_seek(0);
                while($filas_informacion_secciones_empresa = $informacion_seccion_empresa->fetch_assoc()){ 
                    $seccion = $filas_informacion_secciones_empresa['id']; ?>
                    <a href="#<?php echo $seccion; ?>" class="seccion-enlace">
                        <div>
                            <p><?php echo $filas_informacion_secciones_empresa['nombre']; ?></p>
                        </div>
                    </a>
                <?php } 
                $informacion_seccion_empresa->data_seek(0);
                ?>
            </div>
            
        </div>
        
        <div class="menu_empresa">
            <?php while($filas_informacion_secciones_empresa = $informacion_seccion_empresa->fetch_assoc()){
                $seccion_menu=$filas_informacion_secciones_empresa['id']?> 
                <div id="<?= $seccion_menu ?>" class="contenido_menu">
                    <h2  ><?php echo $filas_informacion_secciones_empresa['nombre'];?></h2>

                <?php 
                $articulos_empresa_result->data_seek(0);
                while($filas_articulos_empresa = $articulos_empresa_result->fetch_assoc()){
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
                <div><h4>Direccion</h4><p><?= $row["direccion"]?></p></div>
                <div><h4>Calificacion</h4><p><?= $row["calificacion"]?></p></div>
                <div><h4>Producto Estrella</h4><p>cra 17</p></div>
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
                    
                    <h3>Direccion</h3>
                    <p>calle</p>
                    <div id="map">

                    </div>
                </div>
            </div>
            <div class="comentarios"> 
                <div class="formulario_comentar">
                    <form action="" id="formularioComentarios">
                        <div class="calificacion" data-calificacion="0" required>
                            <h3>Calificacion: </h3>
                            <span class="estrella" data-valor="1">&#9733;</span>
                            <span class="estrella" data-valor="2">&#9733;</span>
                            <span class="estrella" data-valor="3">&#9733;</span>
                            <span class="estrella" data-valor="4">&#9733;</span>
                            <span class="estrella" data-valor="5">&#9733;</span>
                        </div>  
                        <div class="comentar">
                            <textarea name="comentario" id="comentario" class="comentario" minlength="10" required></textarea>
                        </div>
                        <input type="hidden" id="calificacionSeleccionada" name="calificacion" value="0">
                        <input type="hidden" id="empresa_id" name="empresa_id" value="<?= $empresa_id ?>">
                        <button type="button" id="enviarComentario">Comentar</button>
                    </form>
                </div>
                <div class="comentario_usuario">
                    <?php 
                        $comentarios_empresa_result->data_seek(0);
                        while($filas_comentarios_empresa = $comentarios_empresa_result->fetch_assoc()){ ?>
                        <div class="usuario_comentado">
                            <img src="../../<?= $filas_comentarios_empresa['imagen_usuario']; ?>" alt="">
                    
                            <div class="info_usuario">
                                <h3><?= $filas_comentarios_empresa['nombre_usuario']; ?></h3>
                                <?php while($fila_calificacion_usuario = $calificacion_usuario_result->fetch_assoc()) { ?>
                                    <p class="calificacion_estrella">&#9733; <?= $fila_calificacion_usuario['calificacion'] ?></p>
                                <?php } ?>
                            </div>
                        </div>
                        <div class="contenido_comentario">
                          <?= $filas_comentarios_empresa['comentario']; ?>
                        </div>
                    <?php } ?>
                </div>
            </div>

        </div>
       
    </main>
    <?php include "../../partials/footer.php" ?>

   
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script src="../../js/vista_empresa.js"></script>
    <script src="../../js/menu_hamburguesa.js"></script>
    <script src="../../js/mapa.js"></script>
    <script src="../../js/carrito.js"></script>
    <script src="../../js/añadir_a_pedido.js"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBDaeWicvigtP9xPv919E-RNoxfvC-Hqik&callback=iniciarMap"></script>
    <!-- <script src="../../js/editar_usuario.js"></script> -->
</body>
</html>