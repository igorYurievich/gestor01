<?php
$servername = "eu-cluster-west-01.k8s.cleardb.net";
$username = "bf7be11ee1ae8b";
$password = "9a3790ed6eb9dd0";
$database = "heroku_40fe3ccaf131604";
$port = 3306;

// Установка соединения с базой данных
$conn = new mysqli($servername, $username, $password, $database, $port);

// Проверка соединения
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Успешное подключение
echo "Connected successfully";

// Закрытие соединения (если оно больше не нужно)
$conn->close();
?>
