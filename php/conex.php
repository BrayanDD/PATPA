<?php
$servername = "sql212.infinityfree.com";
$username = "epiz_34328927";
$password = "p67bcpLswq";
$database = "epiz_34328927_XXX"; 
// Crear conexión
$conn = new mysqli($servername, $username, $password, $database);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

echo "Conexión exitosa";
?>
