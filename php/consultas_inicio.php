<?php 
session_start();
include "conex.php";

$correo = $_SESSION['usuario'];

// Obtener información del usuario
$stmt_usuario = $conn->prepare("SELECT * FROM usuario WHERE correo = ?");
$stmt_usuario->bind_param("s", $correo);
$stmt_usuario->execute();
$result_usuario = $stmt_usuario->get_result();
$row = $result_usuario->fetch_assoc();
$usuario_id = $row['id'];
$usuario_id_rol = $row['id_rol'];


// Consulta de mejores artículos
$articulos_empresa = $conn->query("SELECT articulo.*, categoria.categorias AS nombre_categoria, seccion.nombre AS nombre_seccion
FROM articulo
INNER JOIN categoria ON articulo.categoria_id = categoria.id
INNER JOIN seccion ON articulo.seccion_id = seccion.id
ORDER BY articulo.calificacion DESC
LIMIT 5 ");

// Todas las categorías
$categorias = $conn->query("SELECT * FROM categoria");
$filas_informacion_categoria = $categorias->fetch_assoc();

// Información de secciones de la empresa
$stmt_seccion_empresa = $conn->prepare("SELECT * FROM seccion WHERE empresa_id = ?");
$stmt_seccion_empresa->bind_param("i", $usuario_id);
$stmt_seccion_empresa->execute();
$informacion_seccion_empresa = $stmt_seccion_empresa->get_result();
$filas_informacion_secciones_empresa = $informacion_seccion_empresa->fetch_assoc();


// Empresas mejor calificadas
$consulta_empresas = $conn->query("SELECT usuario.*, categoria.categorias as nombre_categoria FROM usuario 
JOIN categoria ON usuario.categorias = categoria.id
WHERE usuario.id_rol = '3'
ORDER BY usuario.calificacion DESC
LIMIT 3 ");

// Mostrar información de artículo con AJAX
if (isset($_POST['idArticulo'])) {
    $idArticulo = $_POST['idArticulo'];

    $stmt_info_articulo = $conn->prepare("SELECT articulo.*, categoria.categorias as nombre_categoria, usuario.usuario as nombre_empresa, usuario.foto as foto_empresa 
                                          FROM articulo 
                                          INNER JOIN categoria ON articulo.categoria_id = categoria.id 
                                          INNER JOIN usuario ON articulo.usuario_id = usuario.id 
                                          WHERE articulo.id = ?");
    $stmt_info_articulo->bind_param("i", $idArticulo);
    $stmt_info_articulo->execute();
    $info_articulo = $stmt_info_articulo->get_result();

    if ($info_articulo->num_rows > 0) {
        $fila_info_articulo = $info_articulo->fetch_assoc();
        echo json_encode($fila_info_articulo, JSON_UNESCAPED_UNICODE);
        exit;
    } else {
        echo 'error';
        exit;
    }
   
}

// Mostrar información de empresa con AJAX
if (isset($_POST['idEmpresa'])) {
    $idEmpresa = $_POST['idEmpresa'];

    $stmt_info_empresa = $conn->prepare("SELECT usuario.*, categoria.categorias as nombre_categoria 
                                         FROM usuario 
                                         INNER JOIN categoria ON usuario.categorias = categoria.id 
                                         WHERE usuario.id = ?");
    $stmt_info_empresa->bind_param("i", $idEmpresa);
    $stmt_info_empresa->execute();
    $info_empresa = $stmt_info_empresa->get_result();

    if ($info_empresa->num_rows > 0) {
        $fila_info_empresa = $info_empresa->fetch_assoc();
        echo json_encode($fila_info_empresa, JSON_UNESCAPED_UNICODE);
        exit;
    } else {
        echo 'error';
        exit;
    }
   
}

mysqli_close($conn);
?>
