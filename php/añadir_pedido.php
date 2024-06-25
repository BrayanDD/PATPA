<?php 
session_start();
include "conex.php";

// INFORMACION DEL USUARIO
$correo = $_SESSION['usuario'];
$datos_usu = $conn->query("SELECT * FROM usuario WHERE correo = '$correo'");
$usuario = $datos_usu->fetch_assoc();
$usuario_id = $usuario['id'];

// AÑADIR ARTICULOS a pedidos
if(isset($_POST['id_producto']) && isset($_POST['cantidad'])){
    $id_articulo = $conn->real_escape_string($_POST['id_producto']);
    $cantidad = $conn->real_escape_string($_POST['cantidad']);

    // Verificar si el artículo existe y obtener su precio
    $result = $conn->query("SELECT precio FROM articulo WHERE id = '$id_articulo'");
  
    if ($result) {
        // Verifica si se devolvieron filas
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $precio_unitario = $row['precio'];
    
            // Calcula el totalCosto basado en precio_unitario y cantidad
            $totalCosto = $precio_unitario * $cantidad;

            // Insertar el pedido
            $insertar_pedido = $conn->query("INSERT INTO pedido (estado, total, id_usuario) VALUES ('pendiente', '$totalCosto', '$usuario_id')");

            if ($insertar_pedido) {
                $id_pedido = $conn->insert_id;

                // Insertar el artículo en la tabla productos_pedido con el mismo id_pedido
                $insertar_producto_pedido = $conn->query("INSERT INTO productos_pedido (id_articulo, id_pedido, cantidad) VALUES ('$id_articulo', '$id_pedido', '$cantidad')");

                // Verificar si la inserción fue exitosa
                if (!$insertar_producto_pedido) {
                    // Manejar el error según tus necesidades
                    echo "Error al insertar producto en productos_pedido: " . $conn->error;
                }

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
        echo "Error en la consulta SQL: " . $conn->error;
    }
} else {
    // Redirigir si los datos no están presentes en $_POST
    header("location: /patpa/content/inicio.php");
    exit;
}

mysqli_close($conn);
?>
