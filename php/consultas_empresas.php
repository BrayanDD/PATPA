<?php 
session_start();
include "conex.php";
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


//MOSTRAR INFORMACION DE LA EMPRESA LOGO NOMBRE
$correo = $_SESSION['usuario'];

$consulta = $conn->query("SELECT * FROM usuario WHERE correo = '$correo'");
$row = $consulta->fetch_assoc();

// MOSTRAR Y REGISTRAR NUEVO ARTICULO Y SECCION
$empresa_id = $row['id'];

//MOSTRAR secciones
$mostrar_categoria = $conn->query("SELECT * FROM categoria");
$mostrar_seccion = $conn->query("SELECT * FROM seccion");



//agregar nueva seccion

if (isset($_POST['nueva_seccion'])) {
    $nombre = $_POST['nueva_seccion_nombre'];
    $nueva_seccion = $conn->query("INSERT INTO seccion (nombre, empresa_id) VALUES ('$nombre', '$empresa_id')");
    echo '
        <script>alert("Agregado exitosamente");
        window.location = "../content/usuarios/usuario_empresa.php";
        </script>
    ';
}

//agregar producto
if(isset($_POST['agregar_articulo'])){
    $nombre = $_POST['nombre_producto'];
    $categoria = $_POST['categoria'];
    $seccion = $_POST['seccion'];
    $descripcion = $_POST['descripcion'];

    $imagen = $_FILES["imagen"]["tmp_name"];
    $nombre_imagen= $_FILES["imagen"]["name"];
    $tipo_imagen=strtolower(pathinfo($nombre_imagen,PATHINFO_EXTENSION));
    $sizeimagen = $_FILES["imagen"]["size"];

    $precio = $_POST['precio'];





    //INSERTAR TODOS LOS DATOS SOLO SI IMG ES VALIDA

    if ($tipo_imagen == "jpg" OR $tipo_imagen == "jpeg" OR $tipo_imagen == "png") {
        $registro = $conn->query("INSERT INTO articulo (nombre, categoria_id, seccion_id, descripcion, imagen, precio, usuario_id) VALUES ('$nombre', '$categoria', '$seccion', '$descripcion', '', '$precio', '$empresa_id')");
        $id_registro = $conn->insert_id;
        $ruta = "images/" . $id_registro . "." . $tipo_imagen;
        $actualizar_imagen = $conn->query("UPDATE articulo SET imagen='$ruta' WHERE id = '$id_registro'");
        $directorio = "../images/" . $id_registro . "." . $tipo_imagen;
    
        // Almacenar en nuestro visual 
        if (move_uploaded_file($imagen, $directorio)) {
        } else {
            echo error_get_last()['message'];
            exit;
        }
    
        echo '
        <script>alert("Articulo guardado con exito");
        window.location = "../content/usuarios/usuario_empresa.php";
        </script>';
    } else {
        echo '
        <script>alert("Tipo de archivo no permitido");
        window.location = "../content/empresas/agregar_articulo.html";
        </script>';
    }
    
        
}

//para mostrar info de articulo con ajax
if(isset($_POST['idArticulo'])){
    $idArticulo =  $_POST['idArticulo'];
    

    $info_articulo=$conn->query("SELECT * FROM articulo Where id = '$idArticulo'");

    $result = mysqli_num_rows($info_articulo);
    if($result > 0){
        $fila_info_articulo=$info_articulo->fetch_assoc();
        echo json_encode($fila_info_articulo,JSON_UNESCAPED_UNICODE);
        exit;
    }else{
        echo 'error';
        exit;
    }
}
// todas las categorias
if (isset($_GET['id_categoria'])) {
    $categoria_id = mysqli_real_escape_string($conn, $_GET['id_categoria']);
    $limit = 12;
   
    // todas las categorias
    $categorias = $conn->query("SELECT * From categoria");

    

    //categoria por la que se busca
    $categoria_selecionada = $conn->query("SELECT * FROM categoria WHERE id = '$categoria_id'");

   

    $empresa_categoria = $conn->query("SELECT usuario.*, 
    categoria.categorias as nombre_categoria 
    FROM usuario
    INNER JOIN categoria ON usuario.categorias = categoria.id 
    WHERE usuario.categorias = '$categoria_id' 
    LIMIT $limit");

    
    
    
    


}else{
    $categorias = $conn->query("SELECT * From categoria");

// MOSTRAR LAS CATEGORIAS Y ARTICULOS DE ESTAS CON LIMITE
 $datosConsulta = [];
 $categorias->data_seek(0);

 while($fila_categoria = $categorias->fetch_assoc()){
    $categoria_id = $fila_categoria['id'];
    
    $empresa = $conn->query("SELECT * FROM usuario where id_rol = 3 and categorias = '$categoria_id'   Limit 12");

     

     $Empresas_categoria = [];
     while($fila_empresa = $empresa->fetch_assoc()){
         $Empresas_categoria[] = $fila_empresa;
        
    }
    $datosConsulta[$categoria_id] = $Empresas_categoria;

    
 }
}

//PAGINACION
if (isset($_POST['pagina']) && isset($_POST['categoriaId'])) {
    $limit = 1;
    $pagina = $_POST['pagina'];
    $categoria_id = $_POST['categoriaId'];
    $offset = ($pagina -1) * $limit; // Calcular el offset para la paginación

    $usuario_categoria = $conn->query("SELECT usuario.*, 
                                        categoria.categorias as nombre_categoria 
                                         
                                    FROM usuario
                                    INNER JOIN categoria ON usuario.categorias = categoria.id 
                                    WHERE usuario.categoria_id = '$categoria_id' 
                                    LIMIT $limit OFFSET $offset");

    $result = mysqli_num_rows($articulo_categoria);

    if ($result > 0) {
        $usuario = [];
        while ($fila_info_usuario = $usuario_categoria->fetch_assoc()) {
            $usuario[] = $fila_info_usuario;
        }
        echo json_encode($usuario, JSON_UNESCAPED_UNICODE);
        exit;
    } else {
        echo 'error';
        exit;
    }
}
mysqli_close($conn);


?>