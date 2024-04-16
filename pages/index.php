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
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel principal</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            text-align: center;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #007bff;
            color: #fff;
        }
        .center {
            text-align: center;
        }
        .button {
            background-color: #007bff;
            color: #fff;
            border: none;
            padding: 8px 16px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            border-radius: 4px;
            cursor: pointer;
        }
        .button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Добро пожаловать, <?php echo $_SESSION['username']; ?>!</h1>
       
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Fecha nacimiento</th>
                    <th>Nacionalidad</th>
                    <th>Educación</th>
                    <!-- Добавьте другие необходимые заголовки столбцов -->
                </tr>
            </thead>
            <tbody>
                <?php foreach ($empleados as $empleado): ?>
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
    </div>
</body>
</html>
