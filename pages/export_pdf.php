<?php
session_start();

include 'conexion.php';

if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}

$empleados = []; // Определяем переменную $empleados


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
        
        // Заголовки столбцов
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


if (isset($_POST['empleados'])) {
    // Получаем данные о выбранных работниках
    $selected_empleados = json_decode($_POST['empleados'], true);
    
    if (!empty($selected_empleados)) {
        // Формируем запрос для выборки данных выбранных работников
        $selected_sql = "SELECT * FROM Empleados WHERE ID_Empleado IN (" . implode(",", $selected_empleados) . ")";
        $result = $conn->query($selected_sql);
        
        // Проверяем наличие результатов запроса
        if ($result->num_rows > 0) {
            require_once('../fpdf186/fpdf.php');
            
            // Создание PDF с горизонтальной ориентацией страницы
            $pdf = new FPDF('L');
            $pdf->AddPage();
            $pdf->SetFont('Arial', '', 12);
            
            // Заголовки столбцов
            $pdf->SetFont('Arial', 'B', 12);
            $pdf->Cell(60, 10, utf8_decode('Nombre'), 1);
            $pdf->Cell(35, 10, utf8_decode('Fecha nac'), 1);
            $pdf->Cell(50, 10, utf8_decode('Nacionalidad'), 1);
            $pdf->Cell(30, 10, utf8_decode('Telefono'), 1);
            $pdf->Cell(90, 10, utf8_decode('Educación'), 1);
            $pdf->SetFont('Arial', '', 12);
            $pdf->Ln();
            
            // Добавление данных каждого выбранного работника в таблицу
            while ($row = $result->fetch_assoc()) {
                $pdf->Cell(60, 10, utf8_decode($row['NombreCompleto']), 1);
                $pdf->Cell(35, 10, utf8_decode($row['FechaNacimiento']), 1);
                $pdf->Cell(50, 10, utf8_decode($row['Nacionalidad']), 1);
                $pdf->Cell(30, 10, utf8_decode($row['Telefono']), 1);
                $pdf->MultiCell(90, 10, utf8_decode($row['Educacion']), 1);
            }
            
            // Вывод PDF в новой вкладке
            $pdf->Output('selected_employees.pdf', 'D');
            exit();
        }
    }
}



?>
