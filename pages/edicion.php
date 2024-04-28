<?php
include 'conexion.php';

if(isset($_GET['id']) && !empty($_GET['id'])){
    $id_empleado = $_GET['id'];
    
    $sql = "SELECT * FROM empleados WHERE ID_Empleado = $id_empleado";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        ?>
        <!DOCTYPE html>
        <html lang="es">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Datos del Empleado</title>
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        </head>
        <body>
            <div class="container mt-5">
                <h1>Datos del Empleado</h1>
                <div class="table-responsive">
                    <form action="actualizar.php" method="POST">
                        <table class="table table-bordered">
                            <tbody>
                                <?php
                                    while($row = $result->fetch_assoc()) {
                                        foreach ($row as $campo => $valor) {
                                            if($campo !== "ID_Empleado") { // Omitir el campo ID_Empleado
                                                echo "<tr>";
                                                echo "<td><strong>$campo:</strong></td>"; // Mostrar el nombre del campo como etiqueta de columna
                                                echo "<td><input type='text' class='form-control' name='$campo' value='$valor'></td>"; // Mostrar el valor del campo en la segunda columna
                                                echo "</tr>";
                                            }
                                        }
                                    }
                                ?>
                            </tbody>
                        </table>
                        <input type="hidden" name="id_empleado" value="<?php echo $id_empleado; ?>">
                        <button type="submit" class="btn btn-success">Confirmar Cambios</button>
                        <a href="index.php" class="btn btn-primary">Volver</a>
                    </form>
                </div>
            </div>
        </body>
        </html>
        <?php
    } else {
        echo "No se encontraron resultados para el ID de empleado proporcionado.";
    }
} else {
    echo "No se ha proporcionado un ID de empleado.";
}
?>
