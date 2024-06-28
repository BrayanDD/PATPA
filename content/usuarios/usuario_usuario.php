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
if($row['id_rol'] != 1){
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
    <link rel="stylesheet" href="styles_usuario.css">
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
                <button class="final_añadir"> + Carrito</button>
                <button class="final_pagar">Pagar: <p>$100.000</p></button>
            </div>
        </div>
    <main>
    
        </div>
        <!-- cuando se le da a la empresa para ver detalles -->
        <div class="portada_empresa">   
           <img src="../../<?php echo $row['fondo']?>" class="fondo" alt="">
            <img src="../../<?php echo $row['foto']?>" class="portada_logo" alt="">
            <h2><?php echo $row['usuario']?></h2>
            <form action="editar.php" method="post">
                <button class="boton_editar" name="editar_informacion_usuario" value="<?=  $usuario_id; ?>">Editar</button>
            </form>
            
            <p style="margin-top: 7px;font-size: 16px;"><?php echo $row['direccion']?></p>
            <p style="margin-top: 12px;">Calificacion: </p>
            <br>
            <hr>
        </div>
        <div class="mas_usado">
            
            <div class="contenido_menu">
                <h2>Productos mas consumidos</h2>
                <div class="menu_inventario">
                    <div class="menu_inventario_imagen">
                        <img src="../../images/menu_inventario_imagen.png" alt="">
                    </div>
                    <div class="menu_inventario_informacion">
                        <h4>Pollo Nocturno para 2</h4>
                        <div class="menu_inventario_descripcion">
                            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Reprehenderit quisquam quae, unde veritatis est, voluptates officiis atque, distinctio ullam illum accusantium quibusdam minima. Quae assumenda nihil non, porro iusto in!</p>
                        </div>
                        <h4 style="margin-top: 10px;">$10.000</h4>
                    </div>
                </div>
                <div class="menu_inventario">
                    <div class="menu_inventario_imagen">
                        <img src="../../images/menu_inventario_imagen.png" alt="">
                    </div>
                    <div class="menu_inventario_informacion">
                        <h4>Pollo Nocturno para 2</h4>
                        <div class="menu_inventario_descripcion">
                            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Reprehenderit quisquam quae, unde veritatis est, voluptates officiis atque, distinctio ullam illum accusantium quibusdam minima. Quae assumenda nihil non, porro iusto in!</p>
                        </div>
                        <h4 style="margin-top: 10px;">$10.000</h4>
                    </div>
                </div>
                <div class="menu_inventario">
                    <div class="menu_inventario_imagen">
                        <img src="../../images/menu_inventario_imagen.png" alt="">
                    </div>
                    <div class="menu_inventario_informacion">
                        <h4>Pollo Nocturno para 2</h4>
                        <div class="menu_inventario_descripcion">
                            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Reprehenderit quisquam quae, unde veritatis est, voluptates officiis atque, distinctio ullam illum accusantium quibusdam minima. Quae assumenda nihil non, porro iusto in!</p>
                        </div>
                        <h4 style="margin-top: 10px;">$10.000</h4>
                    </div>
                </div>
                
            </div>
            <div class="contenido_menu">
                <h2>Empresas mas visitadas</h2>
                <div class="menu_inventario">
                    <div class="menu_inventario_imagen">
                        <img src="../../images/menu_inventario_imagen.png" alt="">
                    </div>
                    <div class="menu_inventario_informacion">
                        <h4>Pollo Nocturno para 2</h4>
                        <div class="menu_inventario_descripcion">
                            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Reprehenderit quisquam quae, unde veritatis est, voluptates officiis atque, distinctio ullam illum accusantium quibusdam minima. Quae assumenda nihil non, porro iusto in!</p>
                        </div>
                        <h4 style="margin-top: 10px;">$10.000</h4>
                    </div>
                </div>
                <div class="menu_inventario">
                    <div class="menu_inventario_imagen">
                        <img src="../../images/menu_inventario_imagen.png" alt="">
                    </div>
                    <div class="menu_inventario_informacion">
                        <h4>Pollo Nocturno para 2</h4>
                        <div class="menu_inventario_descripcion">
                            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Reprehenderit quisquam quae, unde veritatis est, voluptates officiis atque, distinctio ullam illum accusantium quibusdam minima. Quae assumenda nihil non, porro iusto in!</p>
                        </div>
                        <h4 style="margin-top: 10px;">$10.000</h4>
                    </div>
                </div>
                <div class="menu_inventario">
                    <div class="menu_inventario_imagen">
                        <img src="../../images/menu_inventario_imagen.png" alt="">
                    </div>
                    <div class="menu_inventario_informacion">
                        <h4>Pollo Nocturno para 2</h4>
                        <div class="menu_inventario_descripcion">
                            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Reprehenderit quisquam quae, unde veritatis est, voluptates officiis atque, distinctio ullam illum accusantium quibusdam minima. Quae assumenda nihil non, porro iusto in!</p>
                        </div>
                        <h4 style="margin-top: 10px;">$10.000</h4>
                    </div>
                </div>
                
            </div>
        </div>
        
    </main>
    <?php include "../../partials/footer.php" ?>

   
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script src="../../js/vista_empresa.js"></script>
    <script src="../../js/menu_hamburguesa.js"></script>
    

</body>
</html>