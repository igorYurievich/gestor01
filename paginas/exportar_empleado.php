<?php
session_start();

include 'conexion.php';

if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}

if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id_empleado = $_GET['id'];

    // Consulta para obtener los datos del empleado
    $sql_empleado = "SELECT empleado.*, nacionalidad.nombre AS nacionalidad FROM empleado JOIN nacionalidad_empleado ON empleado.ID_Empleado = nacionalidad_empleado.id_empleado JOIN nacionalidad ON nacionalidad_empleado.id_nacionalidad = nacionalidad.id_nacionalidad WHERE empleado.ID_Empleado = $id_empleado";
    $result_empleado = $conn->query($sql_empleado);

    // Consulta para obtener los idiomas y niveles del empleado
    $sql_idiomas = "SELECT idioma.nombre AS idioma, nivel_idioma.nivel AS nivel 
                    FROM idioma_empleado 
                    JOIN idioma ON idioma_empleado.id_idioma = idioma.id_idioma 
                    JOIN nivel_idioma ON idioma_empleado.id_nivel = nivel_idioma.id_nivel 
                    WHERE idioma_empleado.id_empleado = $id_empleado";
    $result_idiomas = $conn->query($sql_idiomas);

    if ($result_empleado->num_rows > 0) {
        $row_empleado = $result_empleado->fetch_assoc();

        require_once('../fpdf186/fpdf.php');
        
        $pdf = new FPDF();
        $pdf->AddPage();
        $pdf->SetFont('Arial', 'B', 16);
        $pdf->Cell(0, 10, 'Datos del Empleado', 0, 1, 'C');
        $pdf->Ln(10);

        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(60, 10, 'Campo', 1); // Ajuste de anchura de la columna "Campo"
        $pdf->Cell(130, 10, 'Informacion', 1); // Ajuste de anchura de la columna "Informacion"
        $pdf->Ln();

        $pdf->SetFont('Arial', '', 12);
        $fields = [
            'Nombre' => 'nombre',
            'Apellido 1' => 'apellido1',
            'Apellido 2' => 'apellido2',
            'Correo' => 'correo',
            'Teléfono' => 'telefono',
            'Dirección' => 'direccion',
            'Localidad' => 'localidad',
            'Código Postal' => 'cp',
            'Provincia' => 'provincia',
            'Título' => 'titulo',
            'Teletrabajo' => 'teletrabajo',
            'Turno' => 'turno',
            'Vacaciones' => 'vacaciones',
            'Requerimientos Especiales' => 'requerimientos_especiales',
            'Fecha de Nacimiento' => 'fecha_nacimiento',
            'Nacionalidad' => 'nacionalidad'
        ];

        foreach ($fields as $field_name => $field_db) {
            $pdf->Cell(60, 10, utf8_decode($field_name), 1); // Ajuste de anchura de la columna "Campo"
            $pdf->Cell(130, 10, utf8_decode($row_empleado[$field_db]), 1); // Ajuste de anchura de la columna "Informacion"
            $pdf->Ln();
        }

        // Añadir una sección para los idiomas
        if ($result_idiomas->num_rows > 0) {
            $pdf->Ln(10); // Espacio antes de la nueva sección
            $pdf->SetFont('Arial', 'B', 12);
            $pdf->Cell(0, 10, 'Idiomas', 0, 1, 'C');
            $pdf->Ln(5);
            
            $pdf->Cell(60, 10, 'Idioma', 1);
            $pdf->Cell(130, 10, 'Nivel', 1);
            $pdf->Ln();
            
            $pdf->SetFont('Arial', '', 12);
            while ($row_idiomas = $result_idiomas->fetch_assoc()) {
                $pdf->Cell(60, 10, utf8_decode($row_idiomas['idioma']), 1);
                $pdf->Cell(130, 10, utf8_decode($row_idiomas['nivel']), 1);
                $pdf->Ln();
            }
        }

        $pdf->Output('empleado_' . $id_empleado . '.pdf', 'D');
        exit();
    } else {
        echo "No se encontraron resultados para el ID de empleado proporcionado.";
    }
} else {
    echo "No se ha proporcionado un ID de empleado.";
}
?>
