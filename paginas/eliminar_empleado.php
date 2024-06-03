<?php
include 'conexion.php';

session_start();

if (!isset($_SESSION['username']) || $_SESSION['username'] !== 'admin') {
    header('Location: login.php');
    exit();
}

if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id_empleado = $_GET['id'];

    // Consulta para eliminar los idiomas del empleado
    $sql_delete_idiomas = "DELETE FROM idioma_empleado WHERE id_empleado = $id_empleado";
    $conn->query($sql_delete_idiomas);

    // Consulta para eliminar la nacionalidad del empleado
    $sql_delete_nacionalidad = "DELETE FROM nacionalidad_empleado WHERE id_empleado = $id_empleado";
    $conn->query($sql_delete_nacionalidad);

    // Consulta para eliminar el empleado
    $sql_delete_empleado = "DELETE FROM empleado WHERE ID_Empleado = $id_empleado";
    if ($conn->query($sql_delete_empleado) === TRUE) {
        $mensaje = "Empleado eliminado exitosamente.";
    } else {
        $mensaje = "Error al eliminar el empleado: " . $conn->error;
    }

    header('Location: index.php?mensaje=' . urlencode($mensaje));
} else {
    header('Location: index.php?mensaje=' . urlencode("No se ha proporcionado un ID de empleado."));
}
?>
