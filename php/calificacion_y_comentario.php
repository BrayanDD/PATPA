<?php 
session_start();
include "conex.php";

$correo = $_SESSION['usuario'];

$consulta = $conn->query("SELECT * FROM usuario WHERE correo = '$correo'");
$row = $consulta->fetch_assoc();

$usuario_id = $row['id'];
$usuario_id_rol = $row['id_rol'];

if (isset($_POST['calificacion'])) {
    $empresa_id = $conn->real_escape_string($_POST['empresa_id']);
    $calificacion = $conn->real_escape_string($_POST['calificacion']);
    $comentario = $conn->real_escape_string($_POST['comentario']);

    // Verificar si el usuario tiene al menos un pedido
    $verificarPedido = $conn->query("SELECT productos_pedido.*, articulo.usuario_id as empresa_producto, pedido.id_usuario as usuario_pedido
                                     FROM productos_pedido 
                                     INNER JOIN articulo ON productos_pedido.id_articulo = articulo.id 
                                     INNER JOIN pedido ON productos_pedido.id_pedido = pedido.id  
                                     WHERE pedido.id_usuario = '$usuario_id' LIMIT 1");

    if ($verificarPedido->num_rows > 0) {
        // El usuario tiene al menos un pedido, procede a aceptar el comentario

        // Verificar si ya tiene calificación
        $calificacion_existente = $conn->query("SELECT * FROM calificacion_empresa WHERE id_usuario = '$usuario_id' AND id_empresa = '$empresa_id' LIMIT 1");

        if ($calificacion_existente) {
            if ($calificacion_existente->num_rows > 0) {
                $actualizar = $conn->query("UPDATE calificacion_empresa SET calificacion = '$calificacion' WHERE id_usuario = '$usuario_id' AND id_empresa = '$empresa_id'");
            } else {
                $calificar = $conn->query("INSERT INTO calificacion_empresa (id_usuario, calificacion, id_empresa) VALUES ('$usuario_id', '$calificacion', '$empresa_id')");
            }

            // Verificar si el usuario ya tiene comentario
            $verificarComentario = $conn->query("SELECT * FROM comentario WHERE id_usuario = '$usuario_id' AND id_empresa = '$empresa_id' LIMIT 1");

            if ($verificarComentario->num_rows > 0) {
                $publicar_comentario = $conn->query("UPDATE comentario SET comentario = '$comentario' WHERE id_usuario = '$usuario_id' AND id_empresa = '$empresa_id'");
            } else {
                $publicar_comentario = $conn->query("INSERT INTO comentario (id_usuario, comentario, id_empresa) VALUES ('$usuario_id', '$comentario', '$empresa_id')");
            }
        } else {
            echo "Error en la consulta de calificación existente: " . $conn->error;
        }

        // Procesar calificaciones y calcular promedio
        $calificacion_existente = $conn->query("SELECT calificacion FROM calificacion_empresa WHERE id_empresa = '$empresa_id'");

        if ($calificacion_existente->num_rows > 0) {
            $total_calificaciones = 0;
            $numero_calificaciones = 0;

            // Iterar a través de las calificaciones
            while ($row = $calificacion_existente->fetch_assoc()) {
                $total_calificaciones += $row['calificacion'];
                $numero_calificaciones++;
            }

            // Calcular el promedio
            $promedio = $total_calificaciones / $numero_calificaciones;

            // Actualizar el promedio en la tabla de usuarios (empresa)
            $actualizar_promedio = $conn->query("UPDATE usuario SET calificacion = '$promedio' WHERE id = '$empresa_id'");
            if (!$actualizar_promedio) {
                echo "Error al actualizar el promedio de calificación: " . $conn->error;
            }
        }
    } else {
        // El usuario no tiene pedidos, no se acepta el comentario
        echo 'denegado';
    }
}

mysqli_close($conn);
?>
