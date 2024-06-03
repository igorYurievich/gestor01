<?php
include 'conexion.php';

$sql = "SELECT idioma.nombre, COUNT(idioma_empleado.id_empleado) AS cantidad
        FROM idioma
        LEFT JOIN idioma_empleado ON idioma.id_idioma = idioma_empleado.id_idioma
        GROUP BY idioma.nombre";
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
