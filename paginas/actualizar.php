<?php
include 'conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['id_empleado'])) {
        $id_empleado = $_POST['id_empleado'];
        $updates = [];

        foreach ($_POST as $key => $value) {
            // Evita actualizar el ID del empleado
            if ($key !== 'id_empleado') {
                // Escapa el valor para prevenir inyección SQL
                $value = $conn->real_escape_string($value);
                // Crea la parte de la consulta SQL para actualizar el campo actual
                $updates[] = "$key = '$value'";
            }
        }

        // Combina los campos a actualizar en una sola cadena
        $updates_str = implode(', ', $updates);

        // Construye la consulta SQL para actualizar los datos del empleado
        $sql_actualizar = "UPDATE empleado SET $updates_str WHERE ID_Empleado = $id_empleado";

        if ($conn->query($sql_actualizar) === TRUE) {
            // Redirecciona de vuelta a la página del empleado
            header("Location: http://localhost/dwes/proyectoFinalCoreccion/paginas/empleado.php?id=$id_empleado");
            exit();
        } else {
            echo "Error al actualizar los datos: " . $conn->error;
        }
    } else {
        echo "No se ha proporcionado el ID del empleado.";
    }
} else {
    echo "Acceso denegado.";
}
?>
