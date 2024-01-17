<?php
session_start();
include "conex.php";

//INFORMACION DEL USUARIO
$correo = $_SESSION['usuario'];
$tipo_usuario = $conn->query("SELECT * from usuario where correo = '$correo'");

$fila_tipo = $tipo_usuario->fetch_assoc();
$rol_id = $fila_tipo['id_rol'];

if($rol_id == 1){
    $consulta = $conn->query("SELECT usuario.*, rol.rol AS nombre_rol
                          FROM usuario 
                         INNER JOIN rol ON usuario.id_rol = rol.id 
                         WHERE usuario.correo = '$correo'");
                         

}else{
$consulta = $conn->query("SELECT usuario.*, rol.rol AS nombre_rol, categoria.categorias as nombre_categoria FROM usuario 
                         JOIN rol ON usuario.id_rol = rol.id JOIN categoria ON usuario.categorias = categoria.id
                         WHERE usuario.correo = '$correo'");
}
$row = $consulta->fetch_assoc();
$usuario_id = $row['id'];

function construirHTMLArticulos($articulos_empresa)
{
    $html = '';

    while ($fila_articulo = $articulos_empresa->fetch_assoc()) {
        
        $html .= '<div class="articulos" data-id="' . $fila_articulo['id'] . '">';
        $html .= '<div class="imagen_articulo">';
        $html .= '<img src="../../' . $fila_articulo['imagen'] . '" alt="">';
        $html .= '</div>';
        $html .= '<div class="informacion_articulo" >';
        $html .= '<h2>' . $fila_articulo['nombre'] . '</h2>';
        $html .= '<h4>' . $fila_articulo['nombre_empresa'] . '</h4>';
        $html .= '<p>' . $fila_articulo['nombre_categoria'] . '</p>';
        $html .= '<button>Detalles</button>';
        $html .= '</div>';
        $html .= '</div>';
    }

    return $html;
}

// todas las categorias
if (isset($_GET['id_categoria'])) {
    $categoria_id = $_GET['id_categoria'];
    $limit = "12";
   
    // todas las categorias
    $categorias = $conn->query("SELECT * From categoria");

    

    //categoria por la que se busca
    $categoria_selecionada = $conn->query("SELECT * FROM categoria WHERE id = '$categoria_id'");
    $articulo_categoria=$conn->query("SELECT articulo.* , categoria.categorias as nombre_categoria, usuario.usuario as nombre_empresa, usuario.foto as foto_empresa FROM articulo INNER JOIN categoria ON articulo.categoria_id = categoria.id INNER JOIN usuario ON articulo.usuario_id = usuario.id Where articulo.categoria_id = '$categoria_id' LIMIT $limit");

    
    
    
    


}else{
    $categorias = $conn->query("SELECT * From categoria");


// MOSTRAR LAS CATEGORIAS Y ARTICULOS DE ESTAS CON LIMITE
 $datosConsulta = [];
 $categorias->data_seek(0);

 while($fila_categoria = $categorias->fetch_assoc()){
    $categoria_id = $fila_categoria['id'];
    
    $articulos_empresa = $conn->query("SELECT articulo.*, 
    categoria.categorias AS nombre_categoria,
    categoria.id AS id_categoria,
     usuario.usuario as nombre_empresa
     FROM articulo
     INNER JOIN categoria ON articulo.categoria_id = categoria.id
    INNER JOIN usuario ON articulo.usuario_id = usuario.id
     WHERE categoria_id = '$categoria_id' Limit 12");

     $Articulos_categoria = [];
     while($fila_articulo_categoria = $articulos_empresa->fetch_assoc()){
         $Articulos_categoria[] = $fila_articulo_categoria;
        
    }
    $datosConsulta[$categoria_id] = $Articulos_categoria;

    
 }
}

//PAGINACION
if (isset($_POST['pagina']) && isset($_POST['categoriaId'])) {
    $limit = 12;
    $pagina = $_POST['pagina'];
    $categoria_id = $_POST['categoriaId'];
    $offset = ($pagina -1) * $limit; // Calcular el offset para la paginación

    $articulo_categoria = $conn->query("SELECT articulo.*, 
                                        categoria.categorias as nombre_categoria, 
                                        usuario.usuario as nombre_empresa, 
                                        usuario.foto as foto_empresa 
                                    FROM articulo 
                                    INNER JOIN categoria ON articulo.categoria_id = categoria.id 
                                    INNER JOIN usuario ON articulo.usuario_id = usuario.id 
                                    WHERE articulo.categoria_id = '$categoria_id' 
                                    LIMIT $limit OFFSET $offset");

    $result = mysqli_num_rows($articulo_categoria);

    if ($result > 0) {
        $articulos = [];
        while ($fila_info_articulo = $articulo_categoria->fetch_assoc()) {
            $articulos[] = $fila_info_articulo;
        }
        echo json_encode($articulos, JSON_UNESCAPED_UNICODE);
        exit;
    } else {
        echo 'error';
        exit;
    }
}


mysqli_close($conn);
?>
