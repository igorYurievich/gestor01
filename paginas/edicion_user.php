<?php
include 'conexion.php';

session_start();

if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}

$username = $_SESSION['username'];

if(isset($_GET['id']) && !empty($_GET['id'])){
    $id_empleado = $_GET['id'];
    
    $sql = "SELECT * FROM empleado WHERE ID_Empleado = $id_empleado";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        ?>
        <!DOCTYPE html>
        <html lang="es">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Datos del Empleado</title>
            <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        </head>
        <body>
            <div class="container">
                <h1>Datos del Empleado</h1>
                <div class="row">
                    <div class="col-md-6">
                        <form action="actualizar.php" method="POST">
                            <table class="table">
                                <tbody>
                                    <tr>
                                        <td><strong>Nombre:</strong></td>
                                        <td><?php echo $row['nombre']; ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Apellido1:</strong></td>
                                        <td><?php echo $row['apellido1']; ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Apellido2:</strong></td>
                                        <td><?php echo $row['apellido2']; ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Correo:</strong></td>
                                        <td><input type="text" name="correo" value="<?php echo $row['correo']; ?>" class="form-control"></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Teléfono:</strong></td>
                                        <td><input type="text" name="telefono" value="<?php echo $row['telefono']; ?>" class="form-control"></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Dirección:</strong></td>
                                        <td><?php echo $row['direccion']; ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Localidad:</strong></td>
                                        <td><?php echo $row['localidad']; ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Código Postal:</strong></td>
                                        <td><?php echo $row['cp']; ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Provincia:</strong></td>
                                        <td><?php echo $row['provincia']; ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Título:</strong></td>
                                        <td><?php echo $row['titulo']; ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Teletrabajo:</strong></td>
                                        <td><?php echo $row['teletrabajo']; ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Turno:</strong></td>
                                        <td><?php echo $row['turno']; ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Vacaciones:</strong></td>
                                        <td><?php echo $row['vacaciones']; ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Requerimientos Especiales:</strong></td>
                                        <td><?php echo $row['requerimientos_especiales']; ?></td>
                                    </tr>
                                </tbody>
                            </table>
                            <input type="hidden" name="id_empleado" value="<?php echo $id_empleado; ?>">
                            <button type="submit" class="btn btn-primary">Confirmar Cambios</button>
                            <a href="stat.php" class="btn btn-secondary">Volver</a>
                        </form>
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
