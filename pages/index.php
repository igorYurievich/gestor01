<?php
session_start();

include 'conexion.php';

if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}

$sql = "SELECT * FROM Empleados";

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
            
            $pdf = new FPDF();
            $pdf->AddPage();
            $pdf->SetFont('Arial', 'B', 12);
            
            foreach ($selected_empleados as $empleado) {
                $pdf->MultiCell(0, 10, 'Nombre: ' . utf8_decode($empleado['NombreCompleto']), 0, 'L');
                $pdf->MultiCell(0, 10, 'Fecha nacimiento: ' . utf8_decode($empleado['FechaNacimiento']), 0, 'L');
                $pdf->MultiCell(0, 10, 'Nacionalidad: ' . utf8_decode($empleado['Nacionalidad']), 0, 'L');
                $pdf->MultiCell(0, 10, 'Educacion: ' . utf8_decode($empleado['Educacion']), 0, 'L');
                $pdf->Ln(); // переходим на новую строку для следующего работника
            }
            
            $pdf->Output('selected_employees.pdf', 'I');
            exit();
        }
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
</head>
<body>
    <div class="container">
        <h1>Bienvenido, <?php echo $_SESSION['username']; ?>!</h1>

        <form action="" method="post">
            <div class="text-center my-2">
                <button name="export_pdf" class="btn btn-primary">Exportar a PDF</button>
                <a href="logout.php" class="btn btn-danger">Cerrar sesión</a>
            </div>

            <?php if(isset($mensaje)): ?>
                <div><?php echo $mensaje; ?></div>
            <?php endif; ?>

            <table class="table table-striped">
                <thead>
                    <tr>
                        <th></th>
                        <th>Nombre</th>
                        <th>Fecha nacimiento</th>
                        <th>Nacionalidad</th>
                        <th>Educación</th>
                        <th>Seleccionar</th>
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
                            <td>
                                <a href="empleado.php?id=<?php echo $empleado['ID_Empleado']; ?>" class="btn btn-success">Ver</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </form>
    </div>
</body>
</html>
