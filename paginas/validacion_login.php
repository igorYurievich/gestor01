<?php
session_start();
include 'conexion.php';

function check_login($conn, $username, $password) {
    // Prepara la consulta SQL para seleccionar un usuario basado en el nombre de usuario
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
    
    // Verifica si la preparación de la consulta fue exitosa
    if ($stmt === false) {
        die('Error en la preparación de la consulta: ' . $conn->error);
    }
    
    // Vincula el parámetro de nombre de usuario
    $stmt->bind_param("s", $username);
    
    // Ejecuta la consulta
    $stmt->execute();
    
    // Obtiene el resultado de la consulta
    $result = $stmt->get_result();
    
    // Verifica si se encontró un usuario
    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        // Compara la contraseña ingresada con la almacenada en la base de datos
        if ($password == $row['password']) {
            // Si las contraseñas coinciden, guarda el nombre de usuario y el rol del usuario en la sesión
            $_SESSION['username'] = $username;
            $_SESSION['role'] = $row['role'];
            return true;
        }
    }
    return false;
}

// Verifica si se ha enviado un formulario mediante el método POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Llama a la función check_login() para verificar las credenciales del usuario
    if (check_login($conn, $username, $password)) {
        // Si las credenciales son válidas, redirige al usuario a la página principal
        header('Location: principal.php');
        exit();
    } else {
        // Si las credenciales son inválidas, establece un mensaje de error y redirige al usuario de vuelta a la página de inicio de sesión
        $error = "Nombre de usuario o contraseña incorrectos";
        header('Location: login.php');
        exit();
    }
}
?>
