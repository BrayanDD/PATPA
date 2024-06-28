<?php 
session_start();
include "conex.php";

$correo = $_SESSION['usuario'];

$consulta = $conn->prepare("SELECT * FROM usuario WHERE correo = ?");
$consulta->bind_param("s", $correo);
$consulta->execute();
$resultado = $consulta->get_result();
$row = $resultado->fetch_assoc();

$usuario_id = $row['id'];
$usuario_id_rol = $row['id_rol'];

if (isset($_POST['calificacion'])) {
    $empresa_id = $_POST['empresa_id'];
    $calificacion = $_POST['calificacion'];
    $comentario = $_POST['comentario'];

    // Verificar si el usuario tiene al menos un pedido
    $verificarPedido = $conn->prepare("SELECT productos_pedido.*, articulo.usuario_id as empresa_producto, pedido.id_usuario as usuario_pedido
                                       FROM productos_pedido 
                                       INNER JOIN articulo ON productos_pedido.id_articulo = articulo.id 
                                       INNER JOIN pedido ON productos_pedido.id_pedido = pedido.id  
                                       WHERE pedido.id_usuario = ? LIMIT 1");
    $verificarPedido->bind_param("i", $usuario_id);
    $verificarPedido->execute();
    $resultadoPedido = $verificarPedido->get_result();

    if ($resultadoPedido->num_rows > 0) {
        // El usuario tiene al menos un pedido, procede a aceptar el comentario

        // Verificar si ya tiene calificación
        $calificacion_existente = $conn->prepare("SELECT * FROM calificacion_empresa WHERE id_usuario = ? AND id_empresa = ? LIMIT 1");
        $calificacion_existente->bind_param("ii", $usuario_id, $empresa_id);
        $calificacion_existente->execute();
        $resultadoCalificacion = $calificacion_existente->get_result();

        if ($resultadoCalificacion->num_rows > 0) {
            $actualizar = $conn->prepare("UPDATE calificacion_empresa SET calificacion = ? WHERE id_usuario = ? AND id_empresa = ?");
            $actualizar->bind_param("iii", $calificacion, $usuario_id, $empresa_id);
            $actualizar->execute();
        } else {
            $calificar = $conn->prepare("INSERT INTO calificacion_empresa (id_usuario, calificacion, id_empresa) VALUES (?, ?, ?)");
            $calificar->bind_param("iii", $usuario_id, $calificacion, $empresa_id);
            $calificar->execute();
        }

        // Verificar si el usuario ya tiene comentario
        $verificarComentario = $conn->prepare("SELECT * FROM comentario WHERE id_usuario = ? AND id_empresa = ? LIMIT 1");
        $verificarComentario->bind_param("ii", $usuario_id, $empresa_id);
        $verificarComentario->execute();
        $resultadoComentario = $verificarComentario->get_result();

        if ($resultadoComentario->num_rows > 0) {
            $publicar_comentario = $conn->prepare("UPDATE comentario SET comentario = ? WHERE id_usuario = ? AND id_empresa = ?");
            $publicar_comentario->bind_param("sii", $comentario, $usuario_id, $empresa_id);
            $publicar_comentario->execute();
        } else {
            $publicar_comentario = $conn->prepare("INSERT INTO comentario (id_usuario, comentario, id_empresa) VALUES (?, ?, ?)");
            $publicar_comentario->bind_param("ssi", $usuario_id, $comentario, $empresa_id);
            $publicar_comentario->execute();
        }

        // Procesar calificaciones y calcular promedio
        $calificacion_existente = $conn->prepare("SELECT calificacion FROM calificacion_empresa WHERE id_empresa = ?");
        $calificacion_existente->bind_param("i", $empresa_id);
        $calificacion_existente->execute();
        $resultadoCalificaciones = $calificacion_existente->get_result();

        if ($resultadoCalificaciones->num_rows > 0) {
            $total_calificaciones = 0;
            $numero_calificaciones = 0;

            // Iterar a través de las calificaciones
            while ($row = $resultadoCalificaciones->fetch_assoc()) {
                $total_calificaciones += $row['calificacion'];
                $numero_calificaciones++;
            }

            // Calcular el promedio
            $promedio = $total_calificaciones / $numero_calificaciones;

            // Actualizar el promedio en la tabla de usuarios (empresa)
            $actualizar_promedio = $conn->prepare("UPDATE usuario SET calificacion = ? WHERE id = ?");
            $actualizar_promedio->bind_param("di", $promedio, $empresa_id);
            $actualizar_promedio->execute();
            if (!$actualizar_promedio) {
                echo "Error al actualizar el promedio de calificación: " . $conn->error;
            }
        }
    } else {
        // El usuario no tiene pedidos, no se acepta el comentario
        echo 'denegado';
    }
}

$conn->close();
?>
