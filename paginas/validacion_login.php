<?php
session_start();

include 'conexion.php';

function check_login($conn, $username, $password) {
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ? AND password = ?");
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $_SESSION['username'] = $username;
        return true;
    }
    return false;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if (check_login($conn, $username, $password)) {
        $_SESSION['username'] = $username;
        header('Location: principal.php');
        exit(); 
    } else {
        $error = "Nombre de usuario o contraseña incorrectos";
        header('Location: login.php');
    }
}
?>