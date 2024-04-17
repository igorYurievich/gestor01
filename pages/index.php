<?php
session_start();

include 'conexion.php'; // Подключаемся к базе данных

// Проверяем, вошел ли пользователь в систему, если нет - перенаправляем на страницу входа
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}

// Запрос к базе данных для получения информации о работниках
$sql = "SELECT * FROM Empleados";
$result = $conn->query($sql);

// Массив для хранения данных о работниках
$empleados = [];

if ($result->num_rows > 0) {
    // Заполняем массив данными о работниках
    while ($row = $result->fetch_assoc()) {
        $empleados[] = $row;
    }
}

// Поиск по имени
if (isset($_POST['buscar'])) {
    $search = $_POST['buscar'];
    $filteredEmpleados = array_filter($empleados, function ($empleado) use ($search) {
        return stripos($empleado['NombreCompleto'], $search) !== false;
    });
} else {
    $filteredEmpleados = $empleados;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel principal</title>
    <link rel="stylesheet" href="../assets/css/style.css">

</head>
<body>
    <div class="container">
        <h1>Добро пожаловать, <?php echo $_SESSION['username']; ?>!</h1>
        

        <form method="post" action="">
            <input type="text" name="buscar" placeholder="Buscar por nombre">
            <button type="submit">Buscar</button>
        </form>
        
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Fecha nacimiento</th>
                    <th>Nacionalidad</th>
                    <th>Educación</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($filteredEmpleados as $empleado): ?>
                    <tr>
                        <td><?php echo $empleado['ID_Empleado']; ?></td>
                        <td><?php echo $empleado['NombreCompleto']; ?></td>
                        <td><?php echo $empleado['FechaNacimiento']; ?></td>
                        <td><?php echo $empleado['Nacionalidad']; ?></td>
                        <td><?php echo $empleado['Educacion']; ?></td>
                        <!-- Добавьте другие необходимые столбцы с данными -->
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <br>
        <a href="logout.php" class="button">Salir</a>
    </div>
</body>
</html>
