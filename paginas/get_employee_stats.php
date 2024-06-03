<?php
include 'conexion.php';

// Consulta para obtener el total de empleados
$sql_total_empleados = "SELECT COUNT(id_empleado) AS total FROM empleado";
$result_total_empleados = $conn->query($sql_total_empleados);
$total_empleados = $result_total_empleados->fetch_assoc()['total'];

// Consulta para obtener la cantidad de empleados que hacen teletrabajo
$sql_teletrabajo = "SELECT COUNT(id_empleado) AS teletrabajo FROM empleado WHERE teletrabajo = 1";
$result_teletrabajo = $conn->query($sql_teletrabajo);
$total_teletrabajo = $result_teletrabajo->fetch_assoc()['teletrabajo'];

echo json_encode([
    'total_empleados' => $total_empleados,
    'total_teletrabajo' => $total_teletrabajo
]);

$conn->close();
?>
