<?php
include 'conexion.php';

$sql = "SELECT nacionalidad.nombre, COUNT(nacionalidad_empleado.id_empleado) AS cantidad
        FROM nacionalidad
        LEFT JOIN nacionalidad_empleado ON nacionalidad.id_nacionalidad = nacionalidad_empleado.id_nacionalidad
        GROUP BY nacionalidad.nombre";
$result = $conn->query($sql);

$data = [];
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
}

echo json_encode($data);

$conn->close();
?>
