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
        
        $pdf = new FPDF('L');
        $pdf->AddPage();
        $pdf->SetFont('Arial', 'B', 12);
        
        
        $pdf->Cell(30, 10, utf8_decode('Nombre'), 1);
        $pdf->Cell(30, 10, utf8_decode('Apellido 1'), 1); // Cambiado
        $pdf->Cell(30, 10, utf8_decode('Apellido 2'), 1); // Cambiado
        $pdf->Cell(70, 10, utf8_decode('Correo'), 1); // Cambiado
        $pdf->Cell(30, 10, utf8_decode('Teléfono'), 1);
        
        $pdf->Cell(80, 10, utf8_decode('Título'), 1); // Cambiado
        $pdf->Ln();
        
        $pdf->SetFont('Arial', '', 12);
    
        while ($row = $result->fetch_assoc()) {
           
            $pdf->Cell(30, 10, utf8_decode($row['nombre']), 1);
            $pdf->Cell(30, 10, utf8_decode($row['apellido1']), 1); // Cambiado
            $pdf->Cell(30, 10, utf8_decode($row['apellido2']), 1); // Cambiado
            $pdf->Cell(70, 10, utf8_decode($row['correo']), 1); // Cambiado
            $pdf->Cell(30, 10, utf8_decode($row['telefono']), 1);
            
            $pdf->MultiCell(80, 10, utf8_decode($row['titulo']), 1); // Cambiado
        }
  
    

        $pdf->Output('selected_employees.pdf', 'D');
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
            
            $pdf = new FPDF('L');
            $pdf->AddPage();
            $pdf->SetFont('Arial', 'B', 12);
            
            
            $pdf->Cell(30, 10, utf8_decode('Nombre'), 1);
            $pdf->Cell(30, 10, utf8_decode('Apellido 1'), 1); // Cambiado
            $pdf->Cell(30, 10, utf8_decode('Apellido 2'), 1); // Cambiado
            $pdf->Cell(70, 10, utf8_decode('Correo'), 1); // Cambiado
            $pdf->Cell(30, 10, utf8_decode('Teléfono'), 1);
            
            $pdf->Cell(80, 10, utf8_decode('Título'), 1); // Cambiado
            $pdf->Ln();
            
            $pdf->SetFont('Arial', '', 12);
        
            while ($row = $result->fetch_assoc()) {
               
                $pdf->Cell(30, 10, utf8_decode($row['nombre']), 1);
                $pdf->Cell(30, 10, utf8_decode($row['apellido1']), 1); // Cambiado
                $pdf->Cell(30, 10, utf8_decode($row['apellido2']), 1); // Cambiado
                $pdf->Cell(70, 10, utf8_decode($row['correo']), 1); // Cambiado
                $pdf->Cell(30, 10, utf8_decode($row['telefono']), 1);
                
                $pdf->MultiCell(80, 10, utf8_decode($row['titulo']), 1); // Cambiado
            }
      
        

            $pdf->Output('selected_employees.pdf', 'D');
            exit();
        }
    } else {
        echo "No se han seleccionado empleados.";
    }
}
?>
