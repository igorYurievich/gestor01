
<?php
$servername = "localhost"; 
$username = "root";
$password = ""; 
$database = "gestor";
$port = 3306;

// Establecer conexión con la base de datos
$conn = new mysqli($servername, $username, $password, $database, $port);

// Verificar la conexión
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


?>
