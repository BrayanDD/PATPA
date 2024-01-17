<?php 
    session_start();
    include "conex.php";

    $correo = $_POST['correo'];
    $contraseña = $_POST['contraseña'];
    $contraseña = hash('sha512', $contraseña);
    $validar_login= $conn->query("SELECT * FROM usuario WHERE correo ='$correo' and contraseña = '$contraseña'");


    if(mysqli_num_rows($validar_login) > 0){
        $_SESSION['usuario']= $correo;
        header("location: ../content/inicio.php");
        exit;
    }else{
        
        echo ' 
        <script>alert("Usuario no existe");
        window.location = "../index.php";
        
        </script>
        ';
    }
    mysqli_close($conn);

    
?>