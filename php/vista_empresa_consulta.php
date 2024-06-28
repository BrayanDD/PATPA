<?php 
session_start();
include "conex.php";

// INFORMACION DEL USUARIO
$correo = $_SESSION['usuario'];

// Preparar la consulta
$stmt_usu = $conn->prepare("SELECT * FROM usuario WHERE correo = ?");
$stmt_usu->bind_param("s", $correo);
$stmt_usu->execute();
$datos_usu = $stmt_usu->get_result();
$row = $datos_usu->fetch_assoc();
$rol_id = $row['id_rol'];
$usuario_id_rol = $row['id_rol'];


// Empresa seleccionada
if(isset($_GET['id_empresa'])){
    $empresa_id = $_GET['id_empresa'];
}

// Preparar la consulta
$stmt_consulta = $conn->prepare("SELECT usuario.*, rol.rol AS nombre_rol, categoria.categorias AS nombre_categoria 
                                 FROM usuario 
                                 JOIN rol ON usuario.id_rol = rol.id 
                                 JOIN categoria ON usuario.categorias = categoria.id
                                 WHERE usuario.id = ?");
$stmt_consulta->bind_param("i", $empresa_id); 
$stmt_consulta->execute();
$consulta = $stmt_consulta->get_result();
$empresa_selecionada = $consulta->fetch_assoc();



// Todas las categorias
$categorias = $conn->query("SELECT * FROM categoria");
$filas_informacion_categoria = $categorias->fetch_assoc();

// Preparar la consulta para secciones
$stmt_seccion_empresa = $conn->prepare("SELECT * FROM seccion WHERE empresa_id = ?");
$stmt_seccion_empresa->bind_param("i", $empresa_id); 
$stmt_seccion_empresa->execute();
$informacion_seccion_empresa = $stmt_seccion_empresa->get_result();




$filas_informacion_secciones_empresa = $informacion_seccion_empresa->fetch_assoc();
 

// Consultar Artículos de Empresa
$articulos_empresa_stmt = $conn->prepare("SELECT articulo.*, categoria.categorias AS nombre_categoria, seccion.nombre AS nombre_seccion
                                          FROM articulo
                                          INNER JOIN categoria ON articulo.categoria_id = categoria.id
                                          INNER JOIN seccion ON articulo.seccion_id = seccion.id
                                          WHERE articulo.usuario_id = ?");
$articulos_empresa_stmt->bind_param("i", $empresa_id);
$articulos_empresa_stmt->execute();
$articulos_empresa_result = $articulos_empresa_stmt->get_result();
$filas_articulos_empresa = $articulos_empresa_result->fetch_assoc();


// Consultar Coordenadas de Usuario
$coordenadas_stmt = $conn->prepare("SELECT * FROM usuario WHERE id = ?");
$coordenadas_stmt->bind_param("i", $empresa_id);
$coordenadas_stmt->execute();
$coordenadas_result = $coordenadas_stmt->get_result();
$fila_coordenadas = $coordenadas_result->fetch_assoc();



// MOSTRAR COMENTARIO

// Consultar Comentarios de Empresa
$comentarios_empresa_stmt = $conn->prepare("SELECT comentario.*,
                                            usuario.usuario as nombre_usuario,
                                            usuario.foto as imagen_usuario
                                            FROM comentario
                                            INNER JOIN usuario ON comentario.id_usuario = usuario.id
                                            WHERE id_empresa = ?");
$comentarios_empresa_stmt->bind_param("i", $empresa_id);
$comentarios_empresa_stmt->execute();
$comentarios_empresa_result = $comentarios_empresa_stmt->get_result();

if($comentarios_empresa_result){
    while($filas_comentarios_empresa = $comentarios_empresa_result->fetch_assoc()){
        $id_comentario_usuario = $filas_comentarios_empresa['id_usuario'];

        // Consultar Calificación de Usuario
        $calificacion_usuario_stmt = $conn->prepare("SELECT calificacion FROM calificacion_empresa 
                                                     WHERE id_usuario = ? AND id_empresa = ?");
        $calificacion_usuario_stmt->bind_param("ii", $id_comentario_usuario, $empresa_id);
        $calificacion_usuario_stmt->execute();
        $calificacion_usuario_result = $calificacion_usuario_stmt->get_result();

   
    }
}


mysqli_close($conn);

?>