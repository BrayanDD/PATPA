<?php 
session_start();
include "conex.php";

// INFORMACION DEL USUARIO
$correo = $_SESSION['usuario'];

$stmt_datos_usu = $conn->prepare("SELECT * FROM usuario WHERE correo = ?");
$stmt_datos_usu->bind_param("s", $correo);
$stmt_datos_usu->execute();
$result_datos_usu = $stmt_datos_usu->get_result();
$row = $result_datos_usu->fetch_assoc();
$usuario_id = $row['id'];
$usuario_id_rol = $row['id_rol'];

// Todos los añadidos al carrito
$stmt_pedidos = $conn->prepare("SELECT * FROM pedido WHERE id_usuario = ?");
$stmt_pedidos->bind_param("i", $usuario_id);
$stmt_pedidos->execute();
$pedidos = $stmt_pedidos->get_result();


// ACTUALIZAR CANTIDAD ARTICULOS
if (isset($_POST['id_pedido'])) {
    $id_pedido = $_POST['id_pedido'];

    // Verificar si el pedido pertenece al usuario
    $stmt_verificar_pedido = $conn->prepare("SELECT * FROM pedido WHERE id = ? AND id_usuario = ?");
    $stmt_verificar_pedido->bind_param("ii", $id_pedido, $usuario_id);
    $stmt_verificar_pedido->execute();
    $result_verificar_pedido = $stmt_verificar_pedido->get_result();

    if ($result_verificar_pedido->num_rows > 0) {
        $datos_pedido = [];
        $stmt_articulos = $conn->prepare("SELECT productos_pedido.*, 
                                            articulo.nombre as nombre_articulo,
                                            articulo.precio as precio_articulo,
                                            articulo.imagen as imagen_articulo,
                                            (productos_pedido.cantidad * articulo.precio) as total
                                            FROM productos_pedido
                                            INNER JOIN articulo ON productos_pedido.id_articulo = articulo.id
                                            WHERE id_pedido = ?");
        $stmt_articulos->bind_param("i", $id_pedido);
        $stmt_articulos->execute();
        $articulos = $stmt_articulos->get_result();
        $articulos_pedido = [];

        while ($fila_articulos = $articulos->fetch_assoc()) {
            $articulos_pedido[] = $fila_articulos;
        }

        $datos_pedido[$id_pedido] = $articulos_pedido;
        echo json_encode($datos_pedido);
        
    }
   
}

if (isset($_POST['eliminar_pedido'])) {
    $eliminar_pedido = $_POST['id_pedido_eliminar'];

    // Verificar si el pedido pertenece al usuario
    $stmt_verificar_pedido = $conn->prepare("SELECT * FROM pedido WHERE id = ? AND id_usuario = ?");
    $stmt_verificar_pedido->bind_param("ii", $eliminar_pedido, $usuario_id);
    $stmt_verificar_pedido->execute();
    $result_verificar_pedido = $stmt_verificar_pedido->get_result();

    if ($result_verificar_pedido->num_rows > 0) {
        $stmt_producto_pedido = $conn->prepare("DELETE FROM productos_pedido WHERE id_pedido = ?");
        $stmt_producto_pedido->bind_param("i", $eliminar_pedido);
        $stmt_producto_pedido->execute();
       
        
        $stmt_eliminar_pedido = $conn->prepare("DELETE FROM pedido WHERE id = ?");
        $stmt_eliminar_pedido->bind_param("i", $eliminar_pedido);
        $stmt_eliminar_pedido->execute();
        
        if ($stmt_eliminar_pedido->affected_rows > 0) {
            echo '
                <script>
                    alert("Se elimino con exito");
                    window.location= "../content/pedidos/pedidos.php";
                </script>
            ';
        } else {
            echo "error" . $conn->error;
        }
       
    }
  
}

mysqli_close($conn);
?>
