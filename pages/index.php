<?php
session_start();

include 'conexion.php';

if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}

// Определение текущего диапазона отображаемых работников
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$limit = 10;
$offset = ($page - 1) * $limit;

// Запрос на получение работников в текущем диапазоне
$sql = "SELECT * FROM Empleados LIMIT $limit OFFSET $offset";
$result = $conn->query($sql);

$empleados = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $empleados[] = $row;
    }
} else {
    $mensaje = "No se encontraron resultados.";
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel principal</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        .container-fluid {
            height: 100px;
        }

        .sidebar {
            left: 0;
            top: 0;
            height: 110%; 
            width: 15%;
            background-color: #f8f9fa;
            padding-top: 20px;
            z-index: 1; 
        }

        .sidebar a {
            padding: 10px;
            display: block;
            color: #000;
            text-decoration: none;
        }

        .sidebar a:hover {
            background-color: #dee2e6;
        }

    </style>
</head>
<body>
    <div class="container-fluid" style="height: 100vh;">
        <div class="row" style="height: 100%;">
            <!-- Sidebar -->
            <div class="col-md-2 sidebar">
                <a href="index.php">Inicio</a>
                <a href="index.php">Crear empleado</a>
                <a href="statistics.php">Estadísticas</a>
                <a href="logout.php">Cerrar sesión</a>
                <form action="export_pdf.php" method="post">
                    <div class="text-center my-2">
                        <button name="export_pdf_all">Exportar todos los empleados a PDF</button>
                    </div>
                </form>
            </div>

            <!-- Main Content -->
            <div class="col-md-10">
                <h1 class="text-center my-3">Bienvenido, <?php echo $_SESSION['username']; ?>!</h1>
                <?php include 'filter.php'; ?>

                <!-- Добавляем кнопку для экспорта всех работников в PDF -->
                <form action="export_pdf.php" method="post">
                    <div class="my-2">
                        <button name="export_pdf" class="btn btn-primary">Exportar a PDF</button>
                    </div>

                    <?php if(isset($mensaje)): ?>
                        <div><?php echo $mensaje; ?></div>
                    <?php endif; ?>

                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th></th>
                                <th>Nombre</th>
                                <th>Fecha nacimiento</th>
                                <th>Nacionalidad</th>
                                <th>Educación</th>
                                <th>Telefono</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($empleados as $empleado): ?>
                                <tr>
                                    <td style="text-align: center;">
                                        <input type="checkbox" name="selected_empleados[]" value="<?php echo $empleado['ID_Empleado']; ?>">
                                    </td>
                                    <td><?php echo $empleado['NombreCompleto']; ?></td>
                                    <td><?php echo $empleado['FechaNacimiento']; ?></td>
                                    <td><?php echo $empleado['Nacionalidad']; ?></td>
                                    <td><?php echo $empleado['Educacion']; ?></td>
                                    <td><?php echo $empleado['Telefono']; ?></td>
                                    <td class="text-center">
                                        <a href="empleado.php?id=<?php echo $empleado['ID_Empleado']; ?>&page=<?php echo $page; ?>&limit=<?php echo $limit; ?>" class="btn btn-success">Ver</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>

                    <!-- Добавляем скрытое поле для отправки данных о выбранных работниках -->
                    <input type="hidden" name="empleados" id="empleados" value="">
                </form>

                <!-- Добавляем кнопки для перелистывания страниц -->
                <div class="text-center mt-3">
                    <?php if ($page > 1): ?>
                        <a href="?page=<?php echo ($page - 1); ?>" class="btn btn-primary">Anterior</a>
                    <?php endif; ?>
                    
                    <?php if (count($empleados) == $limit): ?>
                        <a href="?page=<?php echo ($page + 1); ?>" class="btn btn-primary">Siguiente</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript для обновления значения скрытого поля перед отправкой формы -->
    <script>
        // Получаем все выбранные чекбоксы
        var checkboxes = document.querySelectorAll('input[name="selected_empleados[]"]');
        
        // Функция для обновления значения скрытого поля перед отправкой формы
        function updateSelectedEmployees() {
            var selectedEmployees = [];
            checkboxes.forEach(function(checkbox) {
                if (checkbox.checked) {
                    selectedEmployees.push(checkbox.value);
                }
            });
            document.getElementById('empleados').value = JSON.stringify(selectedEmployees);
        }
        
        // Добавляем обработчик события для каждого чекбокса
        checkboxes.forEach(function(checkbox) {
            checkbox.addEventListener('change', updateSelectedEmployees);
        });
    </script>
</body>
</html>
