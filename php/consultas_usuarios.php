<?php 
session_start();
include "conex.php";


//INFORMACION DEL USUARIO
$correo = $_SESSION['usuario'];

$tipo_usuario = $conn->query("SELECT * from usuario where correo = '$correo'");

$fila_tipo = $tipo_usuario->fetch_assoc();
$rol_id = $fila_tipo['id_rol'];
$direccion = $fila_tipo['direccion'];

if($rol_id == 1){
    $consulta = $conn->query("SELECT usuario.*, rol.rol AS nombre_rol
                          FROM usuario 
                         INNER JOIN rol ON usuario.id_rol = rol.id 
                         WHERE usuario.correo = '$correo'");
                         

}else{
$consulta = $conn->query("SELECT usuario.*, rol.rol AS nombre_rol, categoria.categorias as nombre_categoria FROM usuario 
                         INNER JOIN rol ON usuario.id_rol = rol.id 
                         INNER JOIN categoria ON usuario.categorias = categoria.id
                         WHERE usuario.correo = '$correo'");
                         
}

$row = $consulta->fetch_assoc();
$usuario_id = $row['id'];
    
    /// todas las categorias
    $categorias = $conn->query("SELECT * From categoria");
    $filas_informacion_categoria = $categorias->fetch_assoc();

    ///mirar cateforias con where
$informacion_seccion_empresa = $conn->query("SELECT * FROM seccion 
where  empresa_id = '$usuario_id'");

$filas_informacion_secciones_empresa = $informacion_seccion_empresa->fetch_assoc();
 

$articulos_empresa = $conn->query("SELECT articulo.*, categoria.categorias AS nombre_categoria, seccion.nombre AS nombre_seccion
FROM articulo
INNER JOIN categoria ON articulo.categoria_id = categoria.id
INNER JOIN seccion ON articulo.seccion_id = seccion.id
WHERE articulo.usuario_id = '$usuario_id' ");
$filas_articulos_empresa = $articulos_empresa->fetch_assoc();



$coordenadas = $conn->query("SELECT * FROM usuario where id = '$usuario_id'");
$fila_coordenadas = $coordenadas->fetch_assoc();

mysqli_close($conn);

?>