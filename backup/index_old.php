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

// Проверяем, была ли нажата кнопка "Экспорт в PDF"
if (isset($_POST['export_pdf'])) {
    // Массив для хранения выбранных работников
    $selected_empleados = [];
    // Проверяем, были ли выбраны какие-либо работники
    if (!empty($_POST['selected_empleados'])) {
        // Получаем ID выбранных работников
        $selected_ids = $_POST['selected_empleados'];
        // Фильтруем массив всех работников по выбранным ID
        foreach ($empleados as $empleado) {
            if (in_array($empleado['ID_Empleado'], $selected_ids)) {
                $selected_empleados[] = $empleado;
            }
        }
        
        // Создаем PDF файл только с выбранными работниками
        if (!empty($selected_empleados)) {
            require_once('../fpdf186/fpdf.php');
            
            // Создаем PDF с горизонтальной ориентацией страницы
            $pdf = new FPDF('L'); // 'L' - означает горизонтальную ориентацию
            $pdf->AddPage();
            $pdf->SetFont('Arial', '', 12); // Убираем жирный стиль для текста

           // Заголовки столбцов
                $pdf->SetFont('Arial', 'B', 12); // Устанавливаем жирный стиль для текста заголовков
                $pdf->Cell(60, 10, utf8_decode('Nombre'), 1);
                $pdf->Cell(35, 10, utf8_decode('Fecha nac'), 1);
                $pdf->Cell(50, 10, utf8_decode('Nacionalidad'), 1);
                $pdf->Cell(30, 10, utf8_decode('Telefono'), 1); 
                $pdf->Cell(90, 10, utf8_decode('Educación'), 1); // Увеличиваем ширину ячейки для "Educacion"
                
                $pdf->SetFont('Arial', '', 12); // Возвращаем обычный стиль текста
                $pdf->Ln(); // Переходим на новую строку после заголовков

            // Добавляем данные каждого выбранного работника в таблицу
            foreach ($selected_empleados as $empleado) {
                $pdf->Cell(60, 10, utf8_decode($empleado['NombreCompleto']), 1);
                $pdf->Cell(35, 10, utf8_decode($empleado['FechaNacimiento']), 1);
                $pdf->Cell(50, 10, utf8_decode($empleado['Nacionalidad']), 1);
                $pdf->Cell(30, 10, utf8_decode($empleado['Telefono']), 1);
                $pdf->MultiCell(90, 10, utf8_decode($empleado['Educacion']), 1); // Используем MultiCell для многострочного текста
                
            }
            
            $pdf->Output('selected_employees.pdf', 'D');
            exit();
        }
    }

    
    
}

if (isset($_POST['export_pdf_all'])) {
    // Запрос всех работников
    $todos_sql = "SELECT * FROM Empleados";
    $result = $conn->query($todos_sql);

    // Проверка наличия результатов запроса
    if ($result->num_rows > 0) {
        require_once('../fpdf186/fpdf.php');
        
        // Создание PDF с горизонтальной ориентацией страницы
        $pdf = new FPDF('L'); // 'L' - означает горизонтальную ориентацию
        $pdf->AddPage();
        $pdf->SetFont('Arial', '', 12);
        
        $pdf->SetFont('Arial', 'B', 12); // Устанавливаем жирный стиль для текста заголовков
                $pdf->Cell(60, 10, utf8_decode('Nombre'), 1);
                $pdf->Cell(35, 10, utf8_decode('Fecha nac'), 1);
                $pdf->Cell(50, 10, utf8_decode('Nacionalidad'), 1);
                $pdf->Cell(30, 10, utf8_decode('Telefono'), 1); 
                $pdf->Cell(90, 10, utf8_decode('Educación'), 1); // Увеличиваем ширину ячейки для "Educacion"
                
                $pdf->SetFont('Arial', '', 12); // Возвращаем обычный стиль текста
                $pdf->Ln(); // Переходим на новую строку после заголовков
        
        // Добавление данных каждого работника в таблицу
        while ($row = $result->fetch_assoc()) {
            $pdf->Cell(60, 10, utf8_decode($row['NombreCompleto']), 1);
            $pdf->Cell(35, 10, utf8_decode($row['FechaNacimiento']), 1);
            $pdf->Cell(50, 10, utf8_decode($row['Nacionalidad']), 1);
            $pdf->Cell(30, 10, utf8_decode($row['Telefono']), 1);
            $pdf->MultiCell(90, 10, utf8_decode($row['Educacion']), 1); // Используем MultiCell для многострочного текста
            
        }
        
        // Вывод PDF в новой вкладке
        $pdf->Output('all_employees.pdf', 'D');
        exit();
    }
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
                <a href="statistics.php">Estadísticas</a>
                <a href="logout.php">Cerrar sesión</a>
                <form action="" method="post">
                    <div class="text-center my-2">
                        <button name="export_pdf_all" >Exportar todos los empleados a PDF</button>
                    </div>
                </form>
            </div>

           <!-- Main Content -->
            <div class="col-md-10">
                <h1 class="text-center my-3">Bienvenido, <?php echo $_SESSION['username']; ?>!</h1>
                <?php include 'filter.php'; ?>

                <!-- Добавляем кнопку для экспорта всех работников в PDF -->
                <form action="" method="post">
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
                </form>

               <!-- Добавляем кнопки для перелистывания страниц -->
               <div class="text-center mt-3">
                    <?php if ($page > 1): ?>
                        <a href="?page=<?php echo ($page - 1); ?>" class="btn btn-primary">Предыдущие 10 работников</a>
                    <?php endif; ?>
                    
                    <?php if (count($empleados) == $limit): ?>
                        <a href="?page=<?php echo ($page + 1); ?>" class="btn btn-primary">Следующие 10 работников</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
