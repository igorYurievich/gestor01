<?php
include 'conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener el ID del empleado y los datos actualizados del formulario
    $id_empleado = $_POST['id_empleado'];
    unset($_POST['id_empleado']); // Eliminar el campo del ID del arreglo POST
    $campos_actualizados = $_POST;

    // Construir la consulta SQL para actualizar los datos del empleado
    $set_clause = "";
    foreach ($campos_actualizados as $campo => $valor) {
        $set_clause .= "$campo = '$valor', ";
    }
    $set_clause = rtrim($set_clause, ", "); // Eliminar la coma y el espacio al final
    $sql = "UPDATE empleados SET $set_clause WHERE ID_Empleado = $id_empleado";

    // Ejecutar la consulta SQL
    if ($conn->query($sql) === TRUE) {
        echo "Los datos del empleado han sido actualizados correctamente.";
    } else {
        echo "Error al actualizar los datos del empleado: " . $conn->error;
    }
}

// Redireccionar de vuelta a la página de detalles del empleado después de la actualización
header("Location: edicion.php?id=$id_empleado");
exit();
?>
