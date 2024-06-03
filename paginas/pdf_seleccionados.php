<?php
session_start();

include 'conexion.php';

if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}

if (isset($_POST['export_pdf'])) {
    $selected_empleados = isset($_POST['selected_empleados']) ? $_POST['selected_empleados'] : [];

    if (!empty($selected_empleados)) {
        require_once('../fpdf186/fpdf.php');
        
        $pdf = new FPDF('P', 'mm', 'A4');
        
        foreach ($selected_empleados as $empleado_id) {
            $pdf->AddPage();
            $pdf->SetFont('Arial', '', 12);
            $pdf->Cell(0, 10, 'Datos del Empleado', 0, 1, 'C');
            $pdf->Ln(10);

            // Obtener datos del empleado
            $empleado_sql = "SELECT * FROM empleado WHERE id_empleado = ?";
            $stmt = $conn->prepare($empleado_sql);
            $stmt->bind_param('i', $empleado_id);
            $stmt->execute();
            $result_empleado = $stmt->get_result();
            $row_empleado = $result_empleado->fetch_assoc();

            // Mostrar datos del empleado
            foreach ($row_empleado as $field_name => $field_value) {
                $field_name = ucwords(str_replace('_', ' ', $field_name));
                $pdf->SetFillColor(200, 220, 255); // Establecer el color de fondo
                $pdf->SetTextColor(0); // Restaurar el color de texto a negro
                $pdf->Cell(60, 10, utf8_decode($field_name), 1, 0, 'L', true);
                $pdf->Cell(130, 10, utf8_decode($field_value), 1, 0, 'L');
                $pdf->Ln();
            }

            // Agregar sección para los idiomas del empleado
            $idiomas_sql = "SELECT idioma.nombre AS idioma, nivel_idioma.nivel AS nivel 
                            FROM idioma_empleado 
                            INNER JOIN idioma ON idioma_empleado.id_idioma = idioma.id_idioma 
                            INNER JOIN nivel_idioma ON idioma_empleado.id_nivel = nivel_idioma.id_nivel 
                            WHERE id_empleado = ?";
            $stmt = $conn->prepare($idiomas_sql);
            $stmt->bind_param('i', $empleado_id);
            $stmt->execute();
            $result_idiomas = $stmt->get_result();

            if ($result_idiomas->num_rows > 0) {
                $pdf->Ln(10); // Espacio antes de la nueva sección
                $pdf->SetFont('Arial', 'B', 12);
                $pdf->SetFillColor(200, 220, 255); // Establecer el color de fondo
                $pdf->SetTextColor(0); // Restaurar el color de texto a negro
                $pdf->Cell(0, 10, 'Idiomas', 0, 1, 'C', true); // Usar el fondo para toda la celda
                $pdf->Ln(5);
                
                $pdf->Cell(60, 10, 'Idioma', 1, 0, 'C', true);
                $pdf->Cell(130, 10, 'Nivel', 1, 0, 'C', true);
                $pdf->Ln();
                
                while ($row_idiomas = $result_idiomas->fetch_assoc()) {
                    $pdf->Cell(60, 10, utf8_decode($row_idiomas['idioma']), 1);
                    $pdf->Cell(130, 10, utf8_decode($row_idiomas['nivel']), 1);
                    $pdf->Ln();
                }
            }
        }

        $pdf->Output('selected_employees.pdf', 'D');
        exit();
    }
} else {
    header('Location: stat.php');
    exit();
}
?>
