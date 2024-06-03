
<?php
$servername = "eu-cluster-west-01.k8s.cleardb.net";
$username = "bf7be11ee1ae8b";
$password = "9a3790ed6eb9dd0";
$database = "heroku_40fe3ccaf131604";
$port = 3306;

// Establecer conexión con la base de datos
$conn = new mysqli($servername, $username, $password, $database, $port);

// Verificar la conexión
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


?>
