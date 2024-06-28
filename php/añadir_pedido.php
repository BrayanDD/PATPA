<?php 
session_start();
include "conex.php";

// INFORMACION DEL USUARIO
$correo = $_SESSION['usuario'];
$datos_usu = $conn->prepare("SELECT * FROM usuario WHERE correo = ?");
$datos_usu->bind_param("s", $correo);
$datos_usu->execute();
$resultado_usu = $datos_usu->get_result();
$usuario = $resultado_usu->fetch_assoc();
$usuario_id = $usuario['id'];

// AÑADIR ARTICULOS a pedidos
if(isset($_POST['id_producto']) && isset($_POST['cantidad'])){
    $id_articulo = $_POST['id_producto'];
    $cantidad = $_POST['cantidad'];

    // Verificar si el artículo existe y obtener su precio
    $result = $conn->prepare("SELECT precio FROM articulo WHERE id = ?");
    $result->bind_param("i", $id_articulo);
    $result->execute();
    $resultado_art = $result->get_result();
  
    if ($resultado_art->num_rows > 0) {
        $row = $resultado_art->fetch_assoc();
        $precio_unitario = $row['precio'];
    
        // Calcula el totalCosto basado en precio_unitario y cantidad
        $totalCosto = $precio_unitario * $cantidad;

        // Insertar el pedido
        $insertar_pedido = $conn->prepare("INSERT INTO pedido (estado, total, id_usuario) VALUES ('pendiente', ?, ?)");
        $insertar_pedido->bind_param("ii", $totalCosto, $usuario_id);
        $insertar_pedido->execute();

        if ($insertar_pedido) {
            $id_pedido = $conn->insert_id;

            // Insertar el artículo en la tabla productos_pedido con el mismo id_pedido
            $insertar_producto_pedido = $conn->prepare("INSERT INTO productos_pedido (id_articulo, id_pedido, cantidad) VALUES (?, ?, ?)");
            $insertar_producto_pedido->bind_param("iii", $id_articulo, $id_pedido, $cantidad);
            $insertar_producto_pedido->execute();

            // Redirigir después de realizar las operaciones
            header("location: /patpa/content/pedidos/pedidos.php");
            exit;
        } else {
            echo "Error al insertar pedido: " . $conn->error;
        }
    } else {
        echo "Error: No se encontró ningún registro con id_producto = $id_articulo";
    }
} else {
    // Redirigir si los datos no están presentes en $_POST
    header("location: /patpa/content/inicio.php");
    exit;
}

$conn->close();
?>
