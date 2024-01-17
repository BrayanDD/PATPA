<?php 
session_start();
include "conex.php";


//INFORMACION DEL USUARIO
$correo = $_SESSION['usuario'];


$datos_usu = $conn->query("SELECT * FROM usuario where correo = '$correo'");
$usuario = $datos_usu->fetch_assoc();
$usuario_id = $usuario['id'];

//AÑADIR ARTICULOS AL CARRITO
if(isset($_POST['id_producto']) && isset($_POST['cantidad'])){
    $id_articulo = $conn->real_escape_string($_POST['id_producto']);
    $cantidad = $conn->real_escape_string($_POST['cantidad']);

    $agregar_a_carrito = $conn->query("INSERT INTO carrito (articulo_id, cantidad, id_usuario) VALUES ('$id_articulo', '$cantidad','$usuario_id')");
}


//todos los añadidos al carrito
$articulos_carrito = $conn->query("SELECT carrito.* ,
                                    articulo.nombre as nombre_articulo, 
                                    articulo.imagen as imagen_articulo,
                                    articulo.precio as precio_articulo
                                    FROM carrito    
                                    INNER JOIN articulo ON carrito.articulo_id = articulo.id
                                     WHERE id_usuario = '$usuario_id'");


//ACTUALIZAR CANTIDAD ARTICULOS
if(isset($_POST['nueva_cantidad'])){
    $id_articulo = $conn->real_escape_string($_POST['id_articulo']);
    $nueva_cantidad = $conn->real_escape_string($_POST['nueva_cantidad']);

    $actualizar_cantidad=$conn->query("UPDATE carrito SET cantidad = '$nueva_cantidad' WHERE id = '$id_articulo'");
    if ($actualizar_cantidad) {
        echo "bien";
        header("location: ../content/carrito/carrito.php");
    } else {
       echo"error";
    }
}
//eliminar de c<rrito
if(isset($_POST['eliminar_de_carrito'])){
    $id_articulo = $conn->real_escape_string($_POST['id_articulo']);


    $actualizar_cantidad=$conn->query("DELETE FROM carrito WHERE id = '$id_articulo'");
    if ($actualizar_cantidad) {
        echo "bien";
        header("location: ../content/carrito/carrito.php");
    } else {
       echo"error";
    }
}

//subir a pedidos al darle a pagar
if(isset($_POST['final_pagar'])){
    $totalCosto = $_POST['pagar']; // Asegúrate de que coincida con el nombre del campo en el formulario
    if($totalCosto > 0){
        // Insertar información del pedido en la tabla pedido
        $insertar_pedido = $conn->query("INSERT INTO pedido (estado, total, id_usuario) VALUES ('pendiente', '$totalCosto', '$usuario_id')");

        if($insertar_pedido){
            $id_pedido = $conn->insert_id;
            $articulos_carrito = $conn->query("SELECT carrito.* ,
                                        articulo.id as id_articulo,
                                        articulo.nombre as nombre_articulo, 
                                        articulo.imagen as imagen_articulo,
                                        articulo.precio as precio_articulo
                                        FROM carrito    
                                        INNER JOIN articulo ON carrito.articulo_id = articulo.id
                                        WHERE id_usuario = '$usuario_id'");

            while ($fila_articulos_carrito = $articulos_carrito->fetch_assoc()) {
                $articulo = $fila_articulos_carrito['id_articulo'];
                $cantidad  = $fila_articulos_carrito['cantidad'];
                
                // Insertar el artículo en la tabla productos_pedido
                $insertar_producto_pedido = $conn->query("INSERT INTO productos_pedido (id_articulo, id_pedido, cantidad) VALUES ('$articulo', '$id_pedido','$cantidad')");
                
                // Verificar si la inserción fue exitosa
                if (!$insertar_producto_pedido) {
                    // Manejar el error según tus necesidades
                    echo "Error al insertar producto en productos_pedido: " . $conn->error;
                }else{
                    
                }
            
            }
            $limpiar_carrito = $conn->query("DELETE FROM carrito WHERE id_usuario = '$usuario_id'");
            header("location: ../content/inicio.php");
        }
    }else{ header("location: ../content/carrito/carrito.php");}
}


mysqli_close($conn);

?>