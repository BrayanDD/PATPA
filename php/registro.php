<?php
include "conex.php";
$nombre = $_POST['nombre'];
$correo = $_POST['correo'];
$usuario = $_POST['usuario'];

$contraseña = $_POST['contraseña'];

$contraseña = hash('sha512', $contraseña);

// SI SE REPITE CORREO Y USUARIO
$verificacion_correo = $conn->query("SELECT * FROM usuario WHERE correo = '$correo' ");

if(mysqli_num_rows($verificacion_correo) > 0){
    echo '
        <script>
            alert("El correo ya esta registrado, intenta con otro");
            window.location = "../index.php";
        </script>
    ';
    exit;
}



$verificacion_usuario = $conn->query("SELECT * FROM usuario WHERE usuario = '$usuario' ");

if(mysqli_num_rows($verificacion_usuario) > 0){
    echo ' 
        <script>
            alert("El Usuario ya esta registrado, intenta con otro");
            window.location = "../index.php";
        </script>
    ';
    exit;
}



if(isset($_POST['formulario1'])){
   
    $rol = 1;
    $direccion  = $_POST['direccion'];
    
    $insertar =$conn->query("INSERT INTO usuario (nombre,correo,usuario,contraseña,id_rol,foto,fondo,direccion) VALUES ('$nombre','$correo','$usuario','$contraseña','$rol','images/foto_pre.png','images/fondo_pre.png','$direccion')");

    
}else if(isset($_POST['formulario2'])){
    $rol= 2;
    $edad= $_POST['edad'];
    $direccion  = $_POST['direccion'];

    $insertar =$conn->query ("INSERT INTO usuario (nombre,correo,usuario,edad,contraseña,id_rol,foto,fondo,direccion) VALUES ('$nombre','$correo','$usuario','$edad','$contraseña','$rol','images/foto_pre.png','images/fondo_pre.png','$direccion')");

   
}else{
    $rol= 3;
    $categoria = $_POST['categoria'];
    $direccion  = $_POST['direccion'];
    
    $insertar =$conn->query("INSERT INTO usuario (nombre,correo,usuario,categorias,contraseña,id_rol,foto,fondo,direccion) VALUES ('$nombre','$correo','$usuario','$categoria','$contraseña','$rol','images/foto_pre.png','images/fondo_pre.png','$direccion'
    )");
    
}
echo ' 
        <script>
            alert("Se registro con exito");
            window.location = "../index.php";
        </script>
    ';

mysqli_close($conn);


?>