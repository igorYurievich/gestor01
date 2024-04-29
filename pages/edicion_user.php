<?php
include 'conexion.php';

session_start();

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
            <style>
                body {
                    font-family: Arial, sans-serif;
                    background-color: #f4f4f4;
                    margin: 0;
                    padding: 0;
                }
                .container {
                    width: 100%;
                    max-width: 800px;
                    margin: 100px auto;
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
                }
                th, td {
                    padding: 10px;
                    border: 1px solid #dee2e6;
                    text-align: left;
                }
                th {
                    background-color: #f8f9fa;
                }
            </style>
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
                                // Исключаем отображение поля "ID_Empleado"
                                if($campo !== "ID_Empleado") {
                                    echo "<tr>";
                                    // Определяем, является ли текущее поле "InformacionContacto" или "Telefono"
                                    if($campo === "InformacionContacto" || $campo === "Telefono" || $campo === "Correo") {
                                        // Преобразуем название поля для более читаемого отображения
                                        $campo = str_replace('_', ' ', $campo);
                                        // Преобразуем первую букву каждого слова в заголовке в верхний регистр
                                        $campo = ucwords($campo);
                                        // Добавляем пробелы между словами в заголовке
                                        $campo = implode(' ', preg_split('/(?=[A-Z])/', $campo));
                                        echo "<th>$campo</th>"; // Отображаем название поля как заголовок столбца
                                        echo "<td><input type='text' class='form-control' name='$campo' value='$valor'></td>"; // Отображаем значение поля в виде текстового поля ввода
                                    } else {
                                        // Преобразуем название поля для более читаемого отображения
                                        $campo = str_replace('_', ' ', $campo);
                                        // Преобразуем первую букву каждого слова в заголовке в верхний регистр
                                        $campo = ucwords($campo);
                                        // Добавляем пробелы между словами в заголовке
                                        $campo = implode(' ', preg_split('/(?=[A-Z])/', $campo));
                                        echo "<th>$campo</th>"; // Отображаем название поля как заголовок столбца
                                        echo "<td>$valor</td>"; // Отображаем значение поля в виде обычного текста
                                    }
                                    echo "</tr>";
                                }
                            }
                        }
                        ?>

                            </tbody>

                        </table>
                        <input type="hidden" name="id_empleado" value="<?php echo $id_empleado; ?>">
                        <div class="d-flex justify-content-center">
                            <button type="submit" class="btn btn-success me-2">Confirmar Cambios</button>
                            <a href="index.php" class="btn btn-primary">Volver</a>
                        </div>
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
