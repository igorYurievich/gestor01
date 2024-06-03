<?php
session_start();
include 'conexion.php';

function check_login($conn, $username, $password) {
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        // Compara la contraseña ingresada con la almacenada en la base de datos
        if ($password == $row['password']) {
            $_SESSION['username'] = $username;
            $_SESSION['role'] = $row['role']; // Guarda el rol del usuario en la sesión
            return true;
        }
    }
    return false;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if (check_login($conn, $username, $password)) {
        header('Location: principal.php');
        exit();
    } else {
        $error = "Nombre de usuario o contraseña incorrectos";
        header('Location: login.php');
        exit();
    }
}
?>
