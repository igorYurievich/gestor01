<?php
include 'conexion.php';

$page = isset($_GET['page']) ? $_GET['page'] : 1;

session_start();
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}

$username = $_SESSION['username'];

if ($username === 'admin') {
    $editar_url = 'edicion.php';
} else {
    $editar_url = 'edicion_user.php';
}

if (isset($_GET['id']) && !empty($_GET['id'])) {
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
                    <table class="table table-bordered">
                        <tbody>
                            <?php
                            while($row = $result->fetch_assoc()) {
                                foreach ($row as $campo => $valor) {
                                    if ($campo !== "ID_Empleado") {
                                        $campo = str_replace('_', ' ', $campo);
                                        $campo = ucwords($campo);
                                        $campo = implode(' ', preg_split('/(?=[A-Z])/', $campo));
                                        echo "<tr>";
                                        echo "<td><strong>$campo:</strong></td>";
                                        echo "<td>$valor</td>";
                                        echo "</tr>";
                                    }
                                }
                            }
                            ?>
                        </tbody>
                    </table>
                    <div class="my-2">
                        <a href="index.php?page=<?php echo $page; ?>" class="btn btn-primary">Volver</a>
                        <a href="<?php echo $editar_url.'?id='.$id_empleado; ?>" class="btn btn-danger">Editar</a>
                    </div>
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
