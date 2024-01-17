<?php 
include "../../php/consultas_usuarios.php";
include "../../php/conex.php";

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
        <!DOCTYPE html>
        <html lang="es">
        <head>
            <meta charset="UTF-8">
            <link rel="stylesheet" href="../empresas/vista_empresa.css">
        
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
            <link rel="preconnect" href="https://fonts.googleapis.com">
            <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
            <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,800;1,100;1,200;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet">
        
            <title>PATPA</title>
        </head>
            <body class="body_agregar">
            <div class="agregar_articulo">   
<?php
//EDITAR ARTTICULO
if(isset($_POST['editar_id_articulo'])){
        
 
    $articulos_empresa ->data_seek(0);
    $id_articulo=$_POST['editar_id_articulo'];

    
    if($filas_articulos_empresa['id'] =$id_articulo){
            $articulos_empresa_editar = $conn->query("SELECT articulo.*, categoria.categorias AS nombre_categoria, seccion.nombre AS nombre_seccion
            FROM articulo
            INNER JOIN categoria ON articulo.categoria_id = categoria.id
            INNER JOIN seccion ON articulo.seccion_id = seccion.id
            WHERE articulo.id = '$id_articulo' ");
            $filas_articulos_empresa_editar = $articulos_empresa_editar->fetch_assoc();

                ?>   
                <form action="../../php/ediciones.php"  method="post" enctype="multipart/form-data">
                    <input type="hidden" name="id_articulo" value="<?php echo $id_articulo ;?>">
                    <input type="hidden" name="img_vacia" value="<?= $filas_articulos_empresa['imagen']?>">
                    <h1>Editar articulo </h1>
                    <br>
                    <br>
                    <label for="nombre_producto">Nombre del producto: </label>
                    
                    <input type="text" id="nombre_producto" name="nombre_editar" value="<?= $filas_articulos_empresa_editar['nombre']?>">
                    <br>
                    <br>
                    <label for="imagen">Selecionar imagen: </label>
                    <input type="file" id="imagen" name="imagen_editar" >
                    <br>
                    <br>
        
                    <h4>¿En que categoria pertenece el producto?</h4> 
                    <select  name="categoria_editar" >
                        <option selected value="<?= $filas_articulos_empresa_editar['categoria_id']?>" >Selecionar</option>
                        <?php 
                        $categorias->data_seek(0);
                        while($filas_informacion_categoria = $categorias->fetch_assoc()){?>
                        <option value="<?php echo $filas_informacion_categoria['id'];?>"><?php echo $filas_informacion_categoria['categorias'];?></option>
                        <?php 
                            }
                        ?> 
                    </select>  
                    
                    <br>
                    <br>
                    <h4>¿En que sección pertenece el producto?</h4>
                    <select  name="seccion_editar" >
                        <option selected value="<?php echo $filas_articulos_empresa_editar['seccion_id'];?>" >Selecionar</option>
                        <?php 
                        $informacion_seccion_empresa->data_seek(0);
                        while($filas_informacion_secciones_empresa = $informacion_seccion_empresa->fetch_assoc()){?>
                        <option value="<?php echo $filas_informacion_secciones_empresa['id'];?>"><?php echo $filas_informacion_secciones_empresa['nombre'];?></option>
                        <?php 
                            }
                        ?> 
                    </select>  
                
                    <br>
                    <br>
                    <?php 
                        $articulos_empresa_editar ->data_seek(0);
                        $filas_articulos_empresa_editar = $articulos_empresa_editar->fetch_assoc();
                        ?>
                    <label for="descripcion">Descripcion: </label>
                    <br>
                    <textarea name="descripcion_editar" id="descripcion" class="agregar_articulo_descripcion" style="width:80%;" rows="5" ><?php echo $filas_articulos_empresa_editar['descripcion'];?></textarea>
                        
        
                    <br>
                    <br>
                    <label for="agregar_articulo_precio" >
                        Precio:
                    </label>
                    <input type="number" id="agregar_articulo_precio" name="precio_editar" value="<?php echo $filas_articulos_empresa_editar['precio'];?>">
                    <br>
                    <br>
                    <a href="../usuarios/usuario_empresa.php"><button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button></a>
                    <button type="submit" class="btn btn-primary" name="editar_articulo">Guardar</button> 
        
                </form>
        <?php
        }
    }

/// EDITAR MAPA
if(isset($_POST['editar_mapa'])){
    $id_usuario=$_POST['editar_mapa'];
?>
    <form action="../../php/ediciones.php" method="POST">
        <input type="hidden" value="<?php echo $id_usuario?>" name="id_usuario">

        <h1>Corrdenadas Mapa</h1>
        <p>Ten encuenta que para un correcto funcionamiento debes proporcionar la Latitud y Longitud de tu direccion</p>
        <label for="latitud">Latitud: </label>
        <input type="text" id="latitud" name="latitud">
        <label for="longitud">Latitud: </label>
        <input type="text" id="longitud" name="longitud">
        <a href="usuario_empresa.php"><button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button></a>
        <button type="submit" class="btn btn-primary" name="coordenadas">Guardar</button> 
   
    </form>
    <?php
}   
    
//EDITAR INFORMACION BASICA USUARIO
if(isset($_POST['editar_informacion_usuario'])){
    $id_usuario=$_POST['editar_informacion_usuario'];
?>      
        <form action="../../php/ediciones.php"  method="post" enctype="multipart/form-data">
            <?php $usuario_editar = $row['id']?> 
            <input type="hidden" value="<?php echo $usuario_editar?>" name="id_usuario">
            <h1>Editar informacion</h1>
            <br>
            <br>
            <label for="fondo">Imagen de fondo: </label>
            
            <input type="file" id="fondo" name="fondo_nuevo" >
            <br>
            <br>
            <label for="foto" >Imagen de perfil: </label>
            
            <input type="file" id="foto" name="foto_nuevo" >
            
            <br>
            <br>

            <label for="usuario" >Nombre de Usuario: </label>
            
            <input type="text" id="usuario" name="usuario_nuevo"  value="<?php echo $row['usuario']?>">
            <br>
            <br>
            <label for="direccion" >
                Direccion:
            </label>
            <input type="text" id="direccion" name="direccion_nueva" value="<?php echo $row['direccion']?>">
            <br>
            <br>
            <?php if($usuario_editar == 3){
                ?>
            
                <h4>Secciones que tienes: </h4>  
                        
                <table class="table">
                
                    <thead>
                        <tr>
                        <th scope="col">Id</th>
                        <th scope="col">Nombre</th>
                        <th scope="col">Editar</th>
                        <th scope="col">Eliminar</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php 
                    $informacion_seccion_empresa->data_seek(0);
                    while($filas_informacion_secciones_empresa = $informacion_seccion_empresa->fetch_assoc()){
                        
                        ?>  
                        <tr>
                        <th scope="row"><?php echo $filas_informacion_secciones_empresa['id']?></th>
                        <td><?php echo $filas_informacion_secciones_empresa['nombre']?></td>
                        <td><a href="../../php/ediciones.php?codigo_seccion_editar=<?= $filas_informacion_secciones_empresa['id'];?>"><button name="editar_seccion" type="button">Editar</button></a></td>
                        <td><a href="../../php/ediciones.php?codigo_seccion_eliminar=<?= $filas_informacion_secciones_empresa['id'];?>"><button name="elimiar_seccion" type="button">Eliminar</button></a></td>
                        </tr>
                    <?php }?>
                    </tbody>
                </table>
            
                <br>
                <br>
            <?php } ?>
            <a href="usuario_empresa.php"><button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button></a>
             <button type="submit" class="btn btn-primary" name="editar_informacion_usuario">Guardar</button> 

        </form>
    </div>
   
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/boox|tstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>

</body>

</html>


<?php


}
mysqli_close($conn);

?>