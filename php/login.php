<?php
session_start();
include "conex.php";

$correo = $_POST['correo'];
$contraseña = $_POST['contraseña'];
$contraseña = hash('sha512', $contraseña);


$stmt = $conn->prepare("SELECT * FROM usuario WHERE correo = ? AND contraseña = ?");
$stmt->bind_param("ss", $correo, $contraseña);
$stmt->execute();
$resultado = $stmt->get_result();

if($resultado->num_rows > 0){
    $_SESSION['usuario'] = $correo;
    header("location: ../content/inicio.php");
    exit;
} else {
    echo '
        <script>
            alert("Usuario no existe");
            window.location = "../index.php";
        </script>
    ';
}

$stmt->close();
mysqli_close($conn);
?>
