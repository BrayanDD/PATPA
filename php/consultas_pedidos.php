<?php 
session_start();
include "conex.php";


//INFORMACION DEL USUARIO
$correo = $_SESSION['usuario'];


$datos_usu = $conn->query("SELECT * FROM usuario where correo = '$correo'");
$usuario = $datos_usu->fetch_assoc();
$usuario_id = $usuario['id'];



//todos los añadidos al carrito
$pedidos = $conn->query("SELECT *
                                    FROM pedido   
                                     WHERE id_usuario = '$usuario_id'");


//ACTUALIZAR CANTIDAD ARTICULOS
if(isset($_POST['id_pedido'])){
    $id_pedido = $_POST['id_pedido'];
    
    $datos_pedido = [];
    $articulos = $conn->query("SELECT productos_pedido.*, 
                                    articulo.nombre as nombre_articulo,
                                    articulo.precio as precio_articulo,
                                    articulo.imagen as imagen_articulo,
                                    (productos_pedido.cantidad * articulo.precio) as total
                                    FROM productos_pedido
                                    INNER JOIN articulo on productos_pedido.id_articulo = articulo.id
                                    WHERE id_pedido = '$id_pedido'");
    $articulos_pedido = [];

    while($fila_articulos = $articulos->fetch_assoc()){
        $articulos_pedido[]= $fila_articulos;
    }

    $datos_pedido[$id_pedido]= $articulos_pedido;
    echo json_encode($datos_pedido);
}

if(isset($_POST['eliminar_pedido'])){
    $eliminar_pedido = $_POST['id_pedido_eliminar'];
    $producto_pedido = $conn->query("DELETE FROM productos_pedido where id_pedido = '$eliminar_pedido'");
    $eliminar_pedido = $conn->query("DELETE FROM pedido where id = '$eliminar_pedido'");
    if($eliminar_pedido){
        echo '
            <script>
                alert("Se elimino con exito");
                window.location= "../content/pedidos/pedidos.php";
            </script>
        ';
    }else{echo "error". $conn->error; }
}




mysqli_close($conn);

?>