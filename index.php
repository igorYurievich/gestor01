<?php
// Database connection details
$servername = "eu-cluster-west-01.k8s.cleardb.net";
$username = "bf7be11ee1ae8b";
$password = "9a3790ed6eb9dd0";
$database = "heroku_40fe3ccaf131604";
$port = 3306;

// Create connection
$conn = new mysqli($servername, $username, $password, $database, $port);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// SQL query to select all employees
$sql = "SELECT * FROM empleado";
$result = $conn->query($sql);

// Check if there are results and output them
if ($result->num_rows > 0) {
    echo "<table border='1'>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Apellido 1</th>
                <th>Apellido 2</th>
                <th>Correo</th>
                <th>Teléfono</th>
                <th>Dirección</th>
                <th>Localidad</th>
                <th>CP</th>
                <th>Provincia</th>
                <th>Título</th>
                <th>Teletrabajo</th>
                <th>Turno</th>
                <th>Vacaciones</th>
                <th>Requerimientos Especiales</th>
                <th>Fecha de Nacimiento</th>
            </tr>";

    // Output data of each row
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>{$row['id_empleado']}</td>
                <td>{$row['nombre']}</td>
                <td>{$row['apellido1']}</td>
                <td>{$row['apellido2']}</td>
                <td>{$row['correo']}</td>
                <td>{$row['telefono']}</td>
                <td>{$row['direccion']}</td>
                <td>{$row['localidad']}</td>
                <td>{$row['cp']}</td>
                <td>{$row['provincia']}</td>
                <td>{$row['titulo']}</td>
                <td>{$row['teletrabajo']}</td>
                <td>{$row['turno']}</td>
                <td>{$row['vacaciones']}</td>
                <td>{$row['requerimientos_especiales']}</td>
                <td>{$row['fecha_nacimiento']}</td>
              </tr>";
    }
    echo "</table>";
} else {
    echo "0 results";
}

// Close connection
$conn->close();
?>
