<?php 
session_start();
include "conex.php";


//INFORMACION DEL USUARIO
$correo = $_SESSION['usuario'];

$stmt_tipo_usuario = $conn->prepare("SELECT * FROM usuario WHERE correo = ?");
$stmt_tipo_usuario->bind_param("s", $correo);
$stmt_tipo_usuario->execute();
$result_tipo_usuario = $stmt_tipo_usuario->get_result();
$fila_tipo = $result_tipo_usuario->fetch_assoc();

$stmt_tipo_usuario->close();

$fila_tipo = $tipo_usuario->fetch_assoc();
$rol_id = $fila_tipo['id_rol'];
$direccion = $fila_tipo['direccion'];

if($rol_id == 1){
    $stmt_consulta = $conn->prepare("SELECT usuario.*, rol.rol AS nombre_rol 
    FROM usuario 
    INNER JOIN rol ON usuario.id_rol = rol.id 
    WHERE usuario.correo = ?");
    $stmt_consulta->bind_param("s", $correo);
    $stmt_consulta->execute();
                            

}else{
    $stmt_consulta = $conn->prepare("SELECT usuario.*, rol.rol AS nombre_rol, categoria.categorias as nombre_categoria 
    FROM usuario 
    INNER JOIN rol ON usuario.id_rol = rol.id 
    INNER JOIN categoria ON usuario.categorias = categoria.id 
    WHERE usuario.correo = ?");
    $stmt_consulta->bind_param("s", $correo);
    $stmt_consulta->execute();
                         
}

$result_consulta = $stmt_consulta->get_result();
$row = $result_consulta->fetch_assoc();
$usuario_id = $row['id'];
    
    /// todas las categorias
    $stmt_categorias = $conn->prepare("SELECT * FROM categoria");
    $stmt_categorias->execute();
    $result_categorias = $stmt_categorias->get_result();
    $filas_informacion_categoria = $result_categorias->fetch_assoc();
    
    $stmt_categorias->close();
    

    ///mirar cateforias con where
    $stmt_seccion = $conn->prepare("SELECT * FROM seccion WHERE empresa_id = ?");
    $stmt_seccion->bind_param("i", $usuario_id);
    $stmt_seccion->execute();
    $result_seccion = $stmt_seccion->get_result();
    $filas_informacion_secciones_empresa = $result_seccion->fetch_assoc();
    
    $stmt_seccion->close();
    
 

    $stmt_articulos = $conn->prepare("SELECT articulo.*, categoria.categorias AS nombre_categoria, seccion.nombre AS nombre_seccion
    FROM articulo
    INNER JOIN categoria ON articulo.categoria_id = categoria.id
    INNER JOIN seccion ON articulo.seccion_id = seccion.id
    WHERE articulo.usuario_id = ?");
    $stmt_articulos->bind_param("i", $usuario_id);
    $stmt_articulos->execute();
    $result_articulos = $stmt_articulos->get_result();
    $filas_articulos_empresa = $result_articulos->fetch_assoc();
    
    $stmt_articulos->close();
    



    $stmt_coordenadas = $conn->prepare("SELECT * FROM usuario WHERE id = ?");
    $stmt_coordenadas->bind_param("i", $usuario_id);
    $stmt_coordenadas->execute();
    $result_coordenadas = $stmt_coordenadas->get_result();
    $fila_coordenadas = $result_coordenadas->fetch_assoc();
    
    $stmt_coordenadas->close();
    

mysqli_close($conn);

?>