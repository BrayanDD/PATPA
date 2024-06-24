<?php
include "conex.php";
$nombre = $_POST['nombre'];
$correo = $_POST['correo'];
$usuario = $_POST['usuario'];

$contraseña = $_POST['contraseña'];

$contraseña = hash('sha512', $contraseña);

$stmt = $conn->prepare("SELECT * FROM usuario WHERE correo = ?");
$stmt->bind_param("s", $correo); 
$stmt->execute();
$resultado = $stmt->get_result();

if ($resultado->num_rows > 0) {
    echo '
        <script>
            alert("El correo ya está registrado, intenta con otro");
            window.location = "../index.php";
        </script>
    ';
    exit;
}



$stmt->close();



$stmt = $conn->prepare("SELECT * FROM usuario WHERE usuario = ?");
$stmt->bind_param("s", $usuario); 
$stmt->execute();
$resultado = $stmt->get_result();

if ($resultado->num_rows > 0) {

    echo '
        <script>
            alert("El Usuario ya está registrado, intenta con otro");
            window.location = "../index.php";
        </script>
    ';
    exit;
}



$stmt->close();


if(isset($_POST['formulario1'])){
    $nombre = $_POST['nombre'];
    $correo = $_POST['correo'];
    $usuario = $_POST['usuario'];
    $contraseña = hash('sha512', $_POST['contraseña']);
    $rol = 1;
    $direccion = $_POST['direccion'];
    
    $stmt = $conn->prepare("INSERT INTO usuario (nombre, correo, usuario, contraseña, id_rol, foto, fondo, direccion) VALUES (?, ?, ?, ?, ?, 'images/foto_pre.png', 'images/fondo_pre.png', ?)");
    $stmt->bind_param("ssssis", $nombre, $correo, $usuario, $contraseña, $rol, $direccion);
    $stmt->execute();
    $stmt->close();
}
else if(isset($_POST['formulario2'])){
    $nombre = $_POST['nombre'];
    $correo = $_POST['correo'];
    $usuario = $_POST['usuario'];
    $edad = $_POST['edad'];
    $contraseña = hash('sha512', $_POST['contraseña']);
    $rol = 2;
    $direccion = $_POST['direccion'];
    
    $stmt = $conn->prepare("INSERT INTO usuario (nombre, correo, usuario, edad, contraseña, id_rol, foto, fondo, direccion) VALUES (?, ?, ?, ?, ?, ?, 'images/foto_pre.png', 'images/fondo_pre.png', ?)");
    $stmt->bind_param("ssssiss", $nombre, $correo, $usuario, $edad, $contraseña, $rol, $direccion);
    $stmt->execute();
    $stmt->close();
}else {
    $nombre = $_POST['nombre'];
    $correo = $_POST['correo'];
    $usuario = $_POST['usuario'];
    $categoria = $_POST['categoria'];
    $contraseña = hash('sha512', $_POST['contraseña']);
    $rol = 3;
    $direccion = $_POST['direccion'];
    
    $stmt = $conn->prepare("INSERT INTO usuario (nombre, correo, usuario, categorias, contraseña, id_rol, foto, fondo, direccion) VALUES (?, ?, ?, ?, ?, ?, 'images/foto_pre.png', 'images/fondo_pre.png', ?)");
    $stmt->bind_param("ssssiss", $nombre, $correo, $usuario, $categoria, $contraseña, $rol, $direccion);
    $stmt->execute();
    $stmt->close();
}

echo ' 
        <script>
            alert("Se registro con exito");
            window.location = "../index.php";
        </script>
    ';

mysqli_close($conn);


?>