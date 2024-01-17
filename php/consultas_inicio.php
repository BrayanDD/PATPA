<?php 
session_start();
include "conex.php";


//
$correo = $_SESSION['usuario'];

$consulta = $conn->query("SELECT * FROM usuario WHERE correo = '$correo'");
$row = $consulta->fetch_assoc();


$usuario_id = $row['id'];
$usuario_id_rol = $row['id_rol'];

//consulta mejores articulos
$articulos_empresa = $conn->query("SELECT articulo.*, categoria.categorias AS nombre_categoria, seccion.nombre AS nombre_seccion
FROM articulo
INNER JOIN categoria ON articulo.categoria_id = categoria.id
INNER JOIN seccion ON articulo.seccion_id = seccion.id
ORDER BY articulo.calificacion DESC
LIMIT 5 ");


/// todas las categorias
$categorias = $conn->query("SELECT * From categoria");
$filas_informacion_categoria = $categorias->fetch_assoc();

///mirar cateforias con where
$informacion_seccion_empresa = $conn->query("SELECT * FROM seccion where  empresa_id = '$usuario_id'");

$filas_informacion_secciones_empresa = $informacion_seccion_empresa->fetch_assoc();

//BUSCAR EMPRESAS MEJOR CALIFICADAS
$consulta_empresas = $conn->query("SELECT usuario.*, categoria.categorias as nombre_categoria FROM usuario 
                          JOIN categoria ON usuario.categorias = categoria.id
                         WHERE usuario.id_rol = '3'
                         ORDER BY usuario.calificacion DESC
                         LIMIT 3 ");
                


//para mostrar info de articulo con ajax
if(isset($_POST['idArticulo'])){
    $idArticulo =  $_POST['idArticulo'];
    

    $info_articulo=$conn->query("SELECT articulo.* , categoria.categorias as nombre_categoria, usuario.usuario as nombre_empresa, usuario.foto as foto_empresa FROM articulo INNER JOIN categoria ON articulo.categoria_id = categoria.id INNER JOIN usuario ON articulo.usuario_id = usuario.id Where articulo.id = '$idArticulo'");

    $result = mysqli_num_rows($info_articulo);
    if($result > 0){
        $fila_info_articulo=$info_articulo->fetch_assoc();
        echo json_encode($fila_info_articulo,JSON_UNESCAPED_UNICODE);
        exit;
    }else{
        echo 'error';
        exit;
    }
}

//para mostrar info de empresa con ajax
if(isset($_POST['idEmpresa'])){
    $idEmpresa =  $_POST['idEmpresa'];
    

    $info_empresa=$conn->query("SELECT usuario.* , categoria.categorias as nombre_categoria  FROM usuario INNER JOIN categoria ON usuario.categorias = categoria.id  Where usuario.id = '$idEmpresa'");

    $result = mysqli_num_rows($info_empresa);
    if($result > 0){
        $fila_info_empresa=$info_empresa->fetch_assoc();
        echo json_encode($fila_info_empresa,JSON_UNESCAPED_UNICODE);
        exit;
    }else{
        echo 'error';
        exit;
    }
}
mysqli_close($conn);


?>