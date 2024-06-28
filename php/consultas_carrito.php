<?php
session_start();
include "conex.php";

// Obtener información del usuario
$correo = $_SESSION['usuario'];
$datos_usu = $conn->query("SELECT * FROM usuario WHERE correo = '$correo'");
$row = $datos_usu->fetch_assoc();
$usuario_id = $row['id'];
$usuario_id_rol = $row['id_rol'];
// Añadir artículos al carrito
if (isset($_POST['id_producto']) && isset($_POST['cantidad'])) {
    $id_articulo = $conn->real_escape_string($_POST['id_producto']);
    $cantidad = $conn->real_escape_string($_POST['cantidad']);

    $agregar_a_carrito = $conn->prepare("INSERT INTO carrito (articulo_id, cantidad, id_usuario) VALUES (?, ?, ?)");
    $agregar_a_carrito->bind_param("iii", $id_articulo, $cantidad, $usuario_id);
    $agregar_a_carrito->execute();
    
}

// Consultar artículos en el carrito
$articulos_carrito = $conn->query("SELECT carrito.*, 
                                   articulo.nombre as nombre_articulo, 
                                   articulo.imagen as imagen_articulo,
                                   articulo.precio as precio_articulo
                                   FROM carrito    
                                   INNER JOIN articulo ON carrito.articulo_id = articulo.id
                                   WHERE id_usuario = '$usuario_id'");

// Actualizar cantidad de artículos en el carrito
if (isset($_POST['nueva_cantidad'])) {
    $id_articulo = $conn->real_escape_string($_POST['id_articulo']);
    $nueva_cantidad = $conn->real_escape_string($_POST['nueva_cantidad']);

    $actualizar_cantidad = $conn->prepare("UPDATE carrito SET cantidad = ? WHERE id = ?");
    $actualizar_cantidad->bind_param("ii", $nueva_cantidad, $id_articulo);
    if ($actualizar_cantidad->execute()) {
        header("location: ../content/carrito/carrito.php");
        exit;
    } else {
        echo "Error al actualizar cantidad: " . $conn->error;
    }
  
}

// Eliminar artículo del carrito
if (isset($_POST['eliminar_de_carrito'])) {
    $id_articulo = $conn->real_escape_string($_POST['id_articulo']);

    $eliminar_de_carrito = $conn->prepare("DELETE FROM carrito WHERE id = ?");
    $eliminar_de_carrito->bind_param("i", $id_articulo);
    if ($eliminar_de_carrito->execute()) {
        header("location: ../content/carrito/carrito.php");
        exit;
    } else {
        echo "Error al eliminar artículo del carrito: " . $conn->error;
    }
   
}

// Procesar pedido al pagar
if (isset($_POST['final_pagar'])) {
    $totalCosto = $_POST['pagar'];
    if ($totalCosto > 0) {
        // Insertar información del pedido en la tabla pedido
        $insertar_pedido = $conn->prepare("INSERT INTO pedido (estado, total, id_usuario) VALUES ('pendiente', ?, ?)");
        $insertar_pedido->bind_param("di", $totalCosto, $usuario_id);
        if ($insertar_pedido->execute()) {
            $id_pedido = $conn->insert_id;

            // Obtener artículos del carrito para insertar en productos_pedido
            $articulos_carrito = $conn->query("SELECT carrito.*, 
                                               articulo.id as id_articulo,
                                               articulo.nombre as nombre_articulo, 
                                               articulo.imagen as imagen_articulo,
                                               articulo.precio as precio_articulo
                                               FROM carrito    
                                               INNER JOIN articulo ON carrito.articulo_id = articulo.id
                                               WHERE id_usuario = '$usuario_id'");

            while ($fila_articulos_carrito = $articulos_carrito->fetch_assoc()) {
                $articulo = $fila_articulos_carrito['id_articulo'];
                $cantidad = $fila_articulos_carrito['cantidad'];

                // Insertar el artículo en la tabla productos_pedido
                $insertar_producto_pedido = $conn->prepare("INSERT INTO productos_pedido (id_articulo, id_pedido, cantidad) VALUES (?, ?, ?)");
                $insertar_producto_pedido->bind_param("iii", $articulo, $id_pedido, $cantidad);
                if (!$insertar_producto_pedido->execute()) {
                    echo "Error al insertar producto en productos_pedido: " . $conn->error;
                }
             
            }

            // Limpiar carrito después de procesar el pedido
            $limpiar_carrito = $conn->query("DELETE FROM carrito WHERE id_usuario = '$usuario_id'");
            header("location: ../content/inicio.php");
            exit;
        } else {
            echo "Error al insertar pedido: " . $conn->error;
        }
       
    } else {
        header("location: ../content/carrito/carrito.php");
        exit;
    }
}

mysqli_close($conn);
?>
