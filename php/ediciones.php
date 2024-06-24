<?php 
include "conex.php";

// EDICION Y ELIMINACION DE SECCION

if(isset($_GET['codigo_seccion_editar'])) {
        
        $codigo_seccion = $_GET['codigo_seccion_editar'];
        $stmt = $conn->prepare("SELECT * FROM seccion WHERE id = ?");
        $stmt->bind_param("i", $codigo_seccion);
        $stmt->execute();
        $resultado = $stmt->get_result();

        $filas_informacion_secciones_empresa = $resultado->fetch_assoc();
        $stmt->close();
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
    <body >
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Nueva sección</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form  method="post">
                        <label for="nombre_nueva_seccion">Seccion: </label>
                        <textarea name="edicion_seccion_nombre" id="nombre_nueva_seccion" cols="50" rows="2" required><?php echo $filas_informacion_secciones_empresa['nombre'];?></textarea>
                        <a href="../content/usuarios/usuario_empresa.php"><button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button></a>
                        <button type="submit" name="edicion_seccion" class="btn btn-primary">Guardar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>



    <script>

        document.addEventListener('DOMContentLoaded', function () {
    
            
            var myModal = new bootstrap.Modal(document.getElementById('exampleModal'));
            myModal.show();
        });
    </script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>

    </body>

    </html>
    <?php
        
        if (isset($_POST['edicion_seccion'])) {
                  
            $nueva_nombre_seccion = $_POST['edicion_seccion_nombre'];
        
        
            $codigo_seccion = $_GET['codigo_seccion_editar'];
            $sql_update =  $conn->prepare("UPDATE seccion SET nombre = ? WHERE id = ?");
            $sql_update->bind_param("si", $nueva_nombre_seccion, $codigo_seccion);
            $sql_update->execute();
            
            
            if ($sql_update) {
                
                echo '<script>alert("Sección actualizada correctamente"); window.location = "../content/usuarios/usuario_empresa.php";</script>';
            } else {
            
                echo "Error al actualizar la sección: " . $conn->error;
            }
        }

}
if(isset($_GET['codigo_seccion_eliminar'])){
    $seccion_id=$_GET['codigo_seccion_eliminar'];
    $sql_delete = $conn->prepare("DELETE FROM seccion WHERE id = ?");
    $sql_delete->bind_param("i", $seccion_id);
    $sql_delete->execute();

    if($eliminar){
        echo '<script>alert("Sección Eliminada correctamente"); window.location = "../content/usuarios/usuario_empresa.php";</script>';
    } else {
            
     echo "Error al Eliminar la sección: " . $conn->error;
    }
}

//EDICION INFORMACION ARTICULO Y USUARIO

if(isset($_POST['editar_articulo'])){
    $id_articulo =$_POST['id_articulo']; 
    $nombre = $_POST['nombre_editar'];
    $categoria = $_POST['categoria_editar'];
    $seccion = $_POST['seccion_editar'];
    $descripcion = $_POST['descripcion_editar'];

    $imagen = $_FILES["imagen_editar"]["tmp_name"];
    $nombre_imagen= $_FILES["imagen_editar"]["name"];
    $tipo_imagen=strtolower(pathinfo($nombre_imagen,PATHINFO_EXTENSION));
    $sizeimagen = $_FILES["imagen_editar"]["size"];

    $precio = $_POST['precio_editar'];

    if (empty($_FILES['imagen_editar']['tmp_name'])){

        $sql_update = $conn->prepare("UPDATE articulo 
                              SET nombre = ?, 
                                  categoria_id = ?, 
                                  seccion_id = ?, 
                                  descripcion = ?, 
                                  precio = ? 
                              WHERE id = ?");
        $sql_update = $conn->prepare("UPDATE articulo 
        SET nombre = ?, 
            categoria_id = ?, 
            seccion_id = ?, 
            descripcion = ?, 
            precio = ? 
        WHERE id = ?");
        $sql_update->bind_param("siisdi", $nombre, $categoria, $seccion, $descripcion, $precio, $id_articulo);
        $sql_update->execute();
        if($actualizar){echo '
            <script>alert("Articulo editado con exito");
            window.location = "../content/usuarios/usuario_empresa.php";
            </script>
        ';}
        
    }else
    //INSERTAR TODOS LOS DATOS SOLO SI IMG ES VALIDA

    if ($tipo_imagen=="jpg" OR $tipo_imagen=="jpeg" OR $tipo_imagen=="png"  ) {
        $ruta = "images/".$id_articulo.".".$tipo_imagen;
        $directorio = "../images/". $id_articulo. "." . $tipo_imagen;
        

        $actualizar=$conn->query("UPDATE articulo 
        SET nombre='$nombre', 
            categoria_id='$categoria', 
            seccion_id='$seccion', 
            descripcion='$descripcion', 
            imagen='$ruta', 
            precio='$precio' 
        WHERE id='$id_articulo'");
        if($actualizar){echo "<div class='alert alert-info'>Articulo editado</div>";}
        //almacenenar en nuestro visual ERROR EN ESTE
        if(move_uploaded_file($imagen,$directorio)){
        }else{
            echo error_get_last()['message'];
            exit;
        }
        echo '
        <script>alert("Articulo editado con exito");
        window.location = "../content/usuarios/usuario_empresa.php";
        </script>
    ';
    } else {
       echo '
        <script>alert("Tipo de archivo no permitido");
        window.location = "../content/usuarios/usuario_empresa.php";
        </script>
    ';
    }
}

if(isset($_POST['editar_informacion_usuario'])){
    // Obtener el ID del usuario
    $id_usuario = $_POST['id_usuario'];

    $sql_verificar_redireccion = $conn->prepare("SELECT * FROM usuario WHERE id = ?");
    $sql_verificar_redireccion->bind_param("i", $id_usuario);
    $sql_verificar_redireccion->execute();
        $fila_verificar = $verificar_redireccion->fetch_assoc();
    // Obtener la información del fondo
    $fondo_nuevo = $_FILES['fondo_nuevo'];
    $fondo_nombre = $fondo_nuevo['name'];
    $fondo_temporal = $fondo_nuevo['tmp_name'];
    $tipo_imagen_fondo = strtolower(pathinfo($fondo_nombre, PATHINFO_EXTENSION));

    // Obtener la información de la foto
    $foto_nuevo = $_FILES['foto_nuevo'];
    $foto_nombre = $foto_nuevo['name'];
    $foto_temporal = $foto_nuevo['tmp_name'];
    $tipo_imagen_foto = strtolower(pathinfo($foto_nombre, PATHINFO_EXTENSION));

    // Obtener el nombre de usuario y dirección
    $usuario_nuevo = $_POST['usuario_nuevo'];
    $direccion_nueva = $_POST['direccion_nueva'];

    // Validar si no se ha subido un nuevo fondo ni una nueva foto
    if (empty($fondo_nombre) && empty($foto_nombre)) {
        $sql_actualizar = $conn->prepare("UPDATE usuario 
        SET usuario = ?, 
            direccion = ?
        WHERE id = ?");
        $sql_actualizar->bind_param("ssi", $usuario_nuevo, $direccion_nueva, $id_usuario); // "ssi" indica los tipos de datos: string, string, integer
        $sql_actualizar->execute();
        if ($sql_actualizar) {
           if($fila_verificar['id_rol'] == 1){
            echo '
                <script>alert("Usuario editado con éxito");
                window.location = "../content/usuarios/usuario_usuario.php";
                </script>';
           }else{
            echo '
                <script>alert("Usuario editado con éxito");
                window.location = "../content/usuarios/usuario_empresa.php";
                </script>';
           }
        } else {
            echo '
                <script>alert("Error al editar el usuario");
                window.location = "../content/usuarios/usuario_empresa.php";
                </script>';
        }
    } elseif (!empty($foto_nombre)) {
        // Validar si se ha subido una nueva foto y el tipo de archivo es permitido
        if ($tipo_imagen_foto == "jpg" || $tipo_imagen_foto == "jpeg" || $tipo_imagen_foto == "png") {
            $directorio = "../images/foto" . $id_usuario . "." . $tipo_imagen_foto;
            $ruta = "images/foto" . $id_usuario . "." . $tipo_imagen_foto;


            $actualizar = $conn->query("UPDATE usuario 
                SET usuario='$usuario_nuevo',
                    foto='$ruta', 
                    direccion='$direccion_nueva' 
                WHERE id='$id_usuario'");
            // Almacenar en el servidor y verificar si se movió correctamente
            if (move_uploaded_file($foto_temporal, $directorio)) {
                echo '
                    <script>alert("Usuario editado con éxito");
                    window.location = "../content/usuarios/usuario_empresa.php";
                    </script>';
            } else {
                echo '
                    <script>alert("Error al mover el archivo");
                    window.location = "../content/usuarios/usuario_empresa.php";
                    </script>';
            }
        } else {
            echo '
                <script>alert("Tipo de archivo de la foto no permitido");
                window.location = "../content/usuarios/usuario_empresa.php";
                </script>';
        }
    } else {
        if ($tipo_imagen_fondo == "jpg" || $tipo_imagen_fondo == "jpeg" || $tipo_imagen_fondo == "png") {
            $directorio_fondo = "../images/fondo" . $id_usuario . "." . $tipo_imagen_fondo;
            $ruta_fondo = "images/fondo" . $id_usuario . "." . $tipo_imagen_fondo;
        
            $sql_actualizar = $conn->prepare("UPDATE usuario 
            SET usuario = ?, 
                foto = ?, 
                direccion = ?
            WHERE id = ?");
            $sql_actualizar->bind_param("sssi", $usuario_nuevo, $ruta, $direccion_nueva, $id_usuario); 
            $sql_actualizar->execute();
        
            // Almacenar en el servidor y verificar si se movió correctamente
            if (move_uploaded_file($fondo_temporal, $directorio_fondo)) {
                echo '
                    <script>alert("Usuario editado con éxito");
                    window.location = "../content/usuarios/usuario_empresa.php";
                    </script>';
            } else {
                echo '
                    <script>alert("Error al mover el archivo del fondo");
                    window.location = "../content/usuarios/usuario_empresa.php";
                    </script>';
            }
        } else {
            echo '
                <script>alert("Tipo de archivo del fondo no permitido");
                window.location = "../content/usuarios/usuario_empresa.php";
                </script>';
        }
        
    }
    exit();
}

if(isset($_POST['coordenadas'])){
    $id_usuario = $_POST['id_usuario'];
    $latitud = $_POST['latitud'];
    $longitud = $_POST['longitud'];

    $sql_actualizar_coordenadas = $conn->prepare("UPDATE usuario SET latitud = ?, longitud = ? WHERE id = ?");
    $sql_actualizar_coordenadas->bind_param("ddi", $latitud, $longitud, $id_usuario); 
    $sql_actualizar_coordenadas->execute();
    if($coordenadas){
        echo '
                    <script>alert("Coordenadas editadas con éxito");
                    window.location = "../content/usuarios/usuario_empresa.php";
                    </script>';
            } else {
                echo '
                    <script>alert("Error al editar coodenadas");
                    window.location = "../content/usuarios/usuario_empresa.php";
                    </script>';
            }
    
}

mysqli_close($conn);
?>


