<?php
session_start();

include 'conexion.php';

if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}

if (isset($_POST['export_pdf_all'])) {
    $todos_sql = "SELECT * FROM empleado";
    $result = $conn->query($todos_sql);

    if ($result->num_rows > 0) {
        require_once('../fpdf186/fpdf.php');
        
        $pdf = new FPDF('P', 'mm', 'A4');
        
        while ($row_empleado = $result->fetch_assoc()) {
            $pdf->AddPage();
            $pdf->SetFont('Arial', '', 12);
            $pdf->Cell(0, 10, 'Datos del Empleado', 0, 1, 'C');
            $pdf->Ln(10);

            $pdf->SetFont('Arial', '', 12);
            $pdf->SetFillColor(200, 220, 255);
            $pdf->SetTextColor(0);
            foreach ($row_empleado as $field_name => $field_value) {
                if ($field_name !== 'id_empleado') {
                    $field_name = str_replace('_', ' ', $field_name);
                    $pdf->Cell(60, 10, utf8_decode(ucwords($field_name)), 1, 0, 'L', true);
                    $pdf->Cell(130, 10, utf8_decode($field_value), 1, 0, 'L');
                    $pdf->Ln();
                }
            }

            // Agregar sección para los idiomas
            $idiomas_sql = "SELECT idioma.nombre AS idioma, nivel_idioma.nivel AS nivel 
            FROM idioma_empleado 
            INNER JOIN idioma ON idioma_empleado.id_idioma = idioma.id_idioma 
            INNER JOIN nivel_idioma ON idioma_empleado.id_nivel = nivel_idioma.id_nivel 
            WHERE id_empleado = ".$row_empleado['id_empleado'];

            $result_idiomas = $conn->query($idiomas_sql);

            if ($result_idiomas->num_rows > 0) {
                $pdf->Ln(10); // Espacio antes de la nueva sección
                $pdf->SetFont('Arial', 'B', 12);
                $pdf->Cell(0, 10, 'Idiomas', 0, 1, 'C');
                $pdf->Ln(5);
                
                $pdf->Cell(60, 10, 'Idioma', 1, 0, 'C', true);
                $pdf->Cell(130, 10, 'Nivel', 1, 0, 'C', true);
                $pdf->Ln();
                
                $pdf->SetFont('Arial', '', 12);
                while ($row_idiomas = $result_idiomas->fetch_assoc()) {
                    $pdf->Cell(60, 10, utf8_decode($row_idiomas['idioma']), 1);
                    $pdf->Cell(130, 10, utf8_decode($row_idiomas['nivel']), 1);
                    $pdf->Ln();
                }
            }
        }

        $pdf->Output('empleado_all.pdf', 'D');
        exit();
    }
}

if (isset($_POST['selected_empleados'])) {
    $selected_empleados = $_POST['selected_empleados'];

    if (!empty($selected_empleados)) {
        $placeholders = implode(',', array_fill(0, count($selected_empleados), '?'));
        $selected_sql = "SELECT * FROM empleado WHERE ID_Empleado IN ($placeholders)";

        $stmt = $conn->prepare($selected_sql);
        $stmt->bind_param(str_repeat('i', count($selected_empleados)), ...$selected_empleados);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            require_once('../fpdf186/fpdf.php');
            
            $pdf = new FPDF('P', 'mm', 'A4');
            
            while ($row = $result->fetch_assoc()) {
                $pdf->AddPage();
                $pdf->SetFont('Arial', '', 12);
                $pdf->Cell(0, 10, 'Datos del Empleado', 0, 1, 'C');
                $pdf->Ln(10);

                $pdf->SetFont('Arial', '', 12);
                $pdf->SetFillColor(200, 220, 255);
                $pdf->SetTextColor(0);
                foreach ($row as $field_name => $field_value) {
                    if ($field_name !== 'id_empleado') {
                        $field_name = str_replace('_', ' ', $field_name);
                        $pdf->Cell(60, 10, utf8_decode(ucwords($field_name)), 1, 0, 'L', true);
                        $pdf->Cell(130, 10, utf8_decode($field_value), 1, 0, 'L');
                        $pdf->Ln();
                    }
                }

                // Agregar sección para los idiomas
                $idiomas_sql = "SELECT idioma.nombre AS idioma, nivel_idioma.nivel AS nivel 
                                FROM idioma_empleado 
                                INNER JOIN idioma ON idioma_empleado.id_idioma = idioma.id_idioma 
                                INNER JOIN nivel_idioma ON idioma_empleado.id_nivel = nivel_idioma.id_nivel 
                                WHERE id_empleado = ".$row['id'];
                $result_idiomas = $conn->query($idiomas_sql);

                if ($result_idiomas->num_rows > 0) {
                    $pdf->Ln(10); // Espacio antes de la nueva sección
                    $pdf->SetFont('Arial', 'B', 12);
                    $pdf->Cell(0, 10, 'Idiomas', 0, 1, 'C');
                    $pdf->Ln(5);
                    
                    $pdf->Cell(60, 10, 'Idioma', 1, 0, 'C', true);
                    $pdf->Cell(130, 10, 'Nivel', 1, 0, 'C', true);
                    $pdf->Ln();
                    
                    $pdf->SetFont('Arial', '', 12);
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
        echo "No se han seleccionado empleados.";
    }
}
?>
