<?php 
session_start();
include "conex.php";


//INFORMACION DEL USUARIO
$correo = $_SESSION['usuario'];


$datos_usu = $conn->query("SELECT * FROM usuario where correo = '$correo'");
$usuario = $datos_usu->fetch_assoc();

//empresa sele


if($_GET['id_empresa']){
    $empresa_id = $_GET['id_empresa'];
}



$consulta = $conn->query("SELECT usuario.*, rol.rol AS nombre_rol, categoria.categorias as nombre_categoria FROM usuario 
                         JOIN rol ON usuario.id_rol = rol.id JOIN categoria ON usuario.categorias = categoria.id
                         WHERE usuario.id = '$empresa_id'");
$row = $consulta->fetch_assoc();
$usuario_id = $row['id'];
    
    /// todas las categorias
    $categorias = $conn->query("SELECT * From categoria");
    $filas_informacion_categoria = $categorias->fetch_assoc();

    ///mirar cateforias con where
$informacion_seccion_empresa = $conn->query("SELECT * FROM seccion 
where  empresa_id = $empresa_id");


$filas_informacion_secciones_empresa = $informacion_seccion_empresa->fetch_assoc();
 

$articulos_empresa = $conn->query("SELECT articulo.*, categoria.categorias AS nombre_categoria, seccion.nombre AS nombre_seccion
FROM articulo
INNER JOIN categoria ON articulo.categoria_id = categoria.id
INNER JOIN seccion ON articulo.seccion_id = seccion.id
WHERE articulo.usuario_id = '$empresa_id' ");
$filas_articulos_empresa = $articulos_empresa->fetch_assoc();

$coordenadas = $conn->query("SELECT * FROM usuario where id = '$empresa_id'");
$fila_coordenadas = $coordenadas->fetch_assoc();

// MOSTRAR COMENTARIO

$comentarios_empresa = $conn->query("SELECT comentario.*,
                                            usuario.usuario as nombre_usuario,
                                            usuario.foto as imagen_usuario
                                            FROM comentario
                                            INNER JOIN usuario ON comentario.id_usuario = usuario.id
                                            WHERE id_empresa = '$empresa_id'");

if($comentarios_empresa){
    while($filas_comentarios_empresa = $comentarios_empresa->fetch_assoc()){
    //MOSTRAR CALIFICACION DE USUARIO
    $id_comentario_usuario = $filas_comentarios_empresa['id_usuario'];
    $calificacion_usuario = $conn->query("SELECT calificacion From calificacion_empresa Where id_usuario = '$id_comentario_usuario' and id_empresa = '$empresa_id'");
    }
}
mysqli_close($conn);

?>