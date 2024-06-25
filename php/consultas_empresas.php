<?php 
session_start();
include "conex.php";

if(!isset($_SESSION['usuario'])){
    echo '
        <script>
            alert("Por favor inicie sesión");
            window.location = "../../index.php";
        </script>
    ';
    session_destroy();
    die();
}

$correo = $_SESSION['usuario'];

// Obtener información del usuario
$stmt_usuario = $conn->prepare("SELECT * FROM usuario WHERE correo = ?");
$stmt_usuario->bind_param("s", $correo);
$stmt_usuario->execute();
$result_usuario = $stmt_usuario->get_result();
$row = $result_usuario->fetch_assoc();
$empresa_id = $row['id'];
$stmt_usuario->close();

// Mostrar todas las categorías
$mostrar_categoria = $conn->query("SELECT * FROM categoria");

// Mostrar todas las secciones
$mostrar_seccion = $conn->query("SELECT * FROM seccion");

// Agregar nueva sección
if (isset($_POST['nueva_seccion'])) {
    $nombre = $_POST['nueva_seccion_nombre'];
    $stmt_nueva_seccion = $conn->prepare("INSERT INTO seccion (nombre, empresa_id) VALUES (?, ?)");
    $stmt_nueva_seccion->bind_param("si", $nombre, $empresa_id);
    $stmt_nueva_seccion->execute();
    echo '
        <script>
            alert("Agregado exitosamente");
            window.location = "../content/usuarios/usuario_empresa.php";
        </script>
    ';
    $stmt_nueva_seccion->close();
}

// Agregar producto
if(isset($_POST['agregar_articulo'])){
    $nombre = $_POST['nombre_producto'];
    $categoria = $_POST['categoria'];
    $seccion = $_POST['seccion'];
    $descripcion = $_POST['descripcion'];
    $imagen = $_FILES["imagen"]["tmp_name"];
    $nombre_imagen = $_FILES["imagen"]["name"];
    $tipo_imagen = strtolower(pathinfo($nombre_imagen, PATHINFO_EXTENSION));
    $precio = $_POST['precio'];

    // Insertar datos solo si la imagen es válida
    if (in_array($tipo_imagen, array('jpg', 'jpeg', 'png'))) {
        $stmt_insertar_articulo = $conn->prepare("INSERT INTO articulo (nombre, categoria_id, seccion_id, descripcion, imagen, precio, usuario_id) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt_insertar_articulo->bind_param("siisssi", $nombre, $categoria, $seccion, $descripcion, $ruta, $precio, $empresa_id);
        $stmt_insertar_articulo->execute();
        $id_registro = $stmt_insertar_articulo->insert_id;
        $ruta = "images/" . $id_registro . "." . $tipo_imagen;
        $stmt_actualizar_imagen = $conn->prepare("UPDATE articulo SET imagen = ? WHERE id = ?");
        $stmt_actualizar_imagen->bind_param("si", $ruta, $id_registro);
        $stmt_actualizar_imagen->execute();
        
        $directorio = "../images/" . $id_registro . "." . $tipo_imagen;
        if (move_uploaded_file($imagen, $directorio)) {
            echo '
                <script>
                    alert("Artículo guardado con éxito");
                    window.location = "../content/usuarios/usuario_empresa.php";
                </script>
            ';
        } else {
            echo '
                <script>
                    alert("Error al mover el archivo");
                    window.location = "../content/empresas/agregar_articulo.html";
                </script>
            ';
        }
        $stmt_insertar_articulo->close();
        $stmt_actualizar_imagen->close();
    } else {
        echo '
            <script>
                alert("Tipo de archivo no permitido");
                window.location = "../content/empresas/agregar_articulo.html";
            </script>
        ';
    }
}

// Mostrar información de artículo con AJAX
if(isset($_POST['idArticulo'])){
    $idArticulo =  $_POST['idArticulo'];
    $stmt_info_articulo = $conn->prepare("SELECT * FROM articulo WHERE id = ?");
    $stmt_info_articulo->bind_param("i", $idArticulo);
    $stmt_info_articulo->execute();
    $info_articulo = $stmt_info_articulo->get_result();

    if($info_articulo->num_rows > 0){
        $fila_info_articulo = $info_articulo->fetch_assoc();
        echo json_encode($fila_info_articulo, JSON_UNESCAPED_UNICODE);
        exit;
    } else {
        echo 'error';
        exit;
    }
    $stmt_info_articulo->close();
}

// Filtrar empresas por categoría
if (isset($_GET['id_categoria'])) {
    $categoria_id = mysqli_real_escape_string($conn, $_GET['id_categoria']);
    $limit = 12;
    
    $empresa_categoria = $conn->query("SELECT usuario.*, 
                                       categoria.categorias as nombre_categoria 
                                       FROM usuario
                                       INNER JOIN categoria ON usuario.categorias = categoria.id 
                                       WHERE usuario.categorias = '$categoria_id' 
                                       LIMIT $limit");
} else {
    // Mostrar todas las categorías y limitar los resultados
    $datosConsulta = [];
    $categorias->data_seek(0);
    
    while ($fila_categoria = $categorias->fetch_assoc()) {
        $categoria_id = $fila_categoria['id'];
        $empresa = $conn->query("SELECT * FROM usuario WHERE id_rol = 3 AND categorias = '$categoria_id' LIMIT 12");
        $Empresas_categoria = [];
        
        while ($fila_empresa = $empresa->fetch_assoc()) {
            $Empresas_categoria[] = $fila_empresa;
        }
        
        $datosConsulta[$categoria_id] = $Empresas_categoria;
    }
}

// Paginación
if (isset($_POST['pagina']) && isset($_POST['categoriaId'])) {
    $limit = 1;
    $pagina = $_POST['pagina'];
    $categoria_id = $_POST['categoriaId'];
    $offset = ($pagina - 1) * $limit;

    $stmt_usuario_categoria = $conn->prepare("SELECT usuario.*, 
                                              categoria.categorias as nombre_categoria 
                                              FROM usuario
                                              INNER JOIN categoria ON usuario.categorias = categoria.id 
                                              WHERE usuario.categoria_id = ? 
                                              LIMIT ? OFFSET ?");
    $stmt_usuario_categoria->bind_param("iii", $categoria_id, $limit, $offset);
    $stmt_usuario_categoria->execute();
    $result = $stmt_usuario_categoria->get_result();

    if ($result->num_rows > 0) {
        $usuarios = [];
        while ($fila_info_usuario = $result->fetch_assoc()) {
            $usuarios[] = $fila_info_usuario;
        }
        echo json_encode($usuarios, JSON_UNESCAPED_UNICODE);
        exit;
    } else {
        echo 'error';
        exit;
    }
    $stmt_usuario_categoria->close();
}

mysqli_close($conn);
?>
