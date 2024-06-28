<?php
session_start();
include "conex.php";

// INFORMACION DEL USUARIO
$correo = $_SESSION['usuario'];
$tipo_usuario = $conn->prepare("SELECT * FROM usuario WHERE correo = ?");
$tipo_usuario->bind_param("s", $correo);
$tipo_usuario->execute();
$result_tipo_usuario = $tipo_usuario->get_result();
$fila_tipo = $result_tipo_usuario->fetch_assoc();
$rol_id = $fila_tipo['id_rol'];
$tipo_usuario->close();

if ($rol_id == 1) {
    $consulta = $conn->prepare("SELECT usuario.*, rol.rol AS nombre_rol
                                FROM usuario 
                                INNER JOIN rol ON usuario.id_rol = rol.id 
                                WHERE usuario.correo = ?");
    $consulta->bind_param("s", $correo);
} else {
    $consulta = $conn->prepare("SELECT usuario.*, rol.rol AS nombre_rol, categoria.categorias as nombre_categoria 
                                FROM usuario 
                                JOIN rol ON usuario.id_rol = rol.id 
                                JOIN categoria ON usuario.categorias = categoria.id
                                WHERE usuario.correo = ?");
    $consulta->bind_param("s", $correo);
}

$consulta->execute();
$result_consulta = $consulta->get_result();
$row = $result_consulta->fetch_assoc();
$usuario_id = $row['id'];
$usuario_id_rol = $row['id_rol'];
function construirHTMLArticulos($articulos_empresa)
{
    $html = '';

    while ($fila_articulo = $articulos_empresa->fetch_assoc()) {
        $html .= '<div class="articulos" data-id="' . $fila_articulo['id'] . '">';
        $html .= '<div class="imagen_articulo">';
        $html .= '<img src="../../' . $fila_articulo['imagen'] . '" alt="">';
        $html .= '</div>';
        $html .= '<div class="informacion_articulo">';
        $html .= '<h2>' . $fila_articulo['nombre'] . '</h2>';
        $html .= '<h4>' . $fila_articulo['nombre_empresa'] . '</h4>';
        $html .= '<p>' . $fila_articulo['nombre_categoria'] . '</p>';
        $html .= '<button>Detalles</button>';
        $html .= '</div>';
        $html .= '</div>';
    }

    return $html;
}

// Obtener todas las categorías
$categorias = $conn->query("SELECT * From categoria");

if (isset($_GET['id_categoria'])) {
    $categoria_id = $_GET['id_categoria'];
    $limit = 12;

    // Consultar la categoría seleccionada
    $categoria_seleccionada = $conn->prepare("SELECT * FROM categoria WHERE id = ?");
    $categoria_seleccionada->bind_param("i", $categoria_id);
    $categoria_seleccionada->execute();
    $result_categoria = $categoria_seleccionada->get_result();

    // Consultar los artículos por categoría
    $articulo_categoria = $conn->prepare("SELECT articulo.*, 
                                           categoria.categorias AS nombre_categoria, 
                                           usuario.usuario AS nombre_empresa 
                                           FROM articulo
                                           INNER JOIN categoria ON articulo.categoria_id = categoria.id
                                           INNER JOIN usuario ON articulo.usuario_id = usuario.id
                                           WHERE articulo.categoria_id = ?
                                           LIMIT ?");
    $articulo_categoria->bind_param("ii", $categoria_id, $limit);
    $articulo_categoria->execute();

} else {
    // Mostrar todas las categorías y los artículos limitados
    $datosConsulta = [];
    $categorias->data_seek(0);

    while ($fila_categoria = $categorias->fetch_assoc()) {
        $categoria_id = $fila_categoria['id'];

        $articulos_empresa = $conn->prepare("SELECT articulo.*, 
                                             categoria.categorias AS nombre_categoria,
                                             usuario.usuario AS nombre_empresa
                                             FROM articulo
                                             INNER JOIN categoria ON articulo.categoria_id = categoria.id
                                             INNER JOIN usuario ON articulo.usuario_id = usuario.id
                                             WHERE categoria_id = ?
                                             LIMIT 12");
        $articulos_empresa->bind_param("i", $categoria_id);
        $articulos_empresa->execute();
        $result_articulos = $articulos_empresa->get_result();

        $Articulos_categoria = [];
        while ($fila_articulo_categoria = $result_articulos->fetch_assoc()) {
            $Articulos_categoria[] = $fila_articulo_categoria;
        }
        $datosConsulta[$categoria_id] = $Articulos_categoria;

        
    }
}

// PAGINACION
if (isset($_POST['pagina']) && isset($_POST['categoriaId'])) {
    $limit = 12;
    $pagina = $_POST['pagina'];
    $categoria_id = $_POST['categoriaId'];
    $offset = ($pagina - 1) * $limit;

    $articulo_categoria = $conn->prepare("SELECT articulo.*, 
                                           categoria.categorias AS nombre_categoria, 
                                           usuario.usuario AS nombre_empresa, 
                                           usuario.foto AS foto_empresa 
                                           FROM articulo 
                                           INNER JOIN categoria ON articulo.categoria_id = categoria.id 
                                           INNER JOIN usuario ON articulo.usuario_id = usuario.id 
                                           WHERE articulo.categoria_id = ? 
                                           LIMIT ? OFFSET ?");
    $articulo_categoria->bind_param("iii", $categoria_id, $limit, $offset);
    $articulo_categoria->execute();
    $result = $articulo_categoria->get_result();

    if ($result->num_rows > 0) {
        $articulos = [];
        while ($fila_info_articulo = $result->fetch_assoc()) {
            $articulos[] = $fila_info_articulo;
        }
        echo json_encode($articulos, JSON_UNESCAPED_UNICODE);
        exit;
    } else {
        echo 'error';
        exit;
    }
    
}

mysqli_close($conn);
?>
