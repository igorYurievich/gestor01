<?php
include 'conexion.php';

session_start();

if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}

$username = $_SESSION['username'];

if ($username !== 'admin') {
    echo "Acceso denegado. No tiene permisos para acceder a esta página.";
    exit();
}

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
                <h1 class="mt-5">Datos del Empleado</h1>
                <div class="mt-3">
                    <form action="actualizar.php" method="POST">
                        <table class="table">
                            <tbody>
                                <tr>
                                    <td><strong>Nombre:</strong></td>
                                    <td><input type='text' name='nombre' value='<?php echo $row['nombre']; ?>' class='form-control'></td>
                                </tr>
                                <tr>
                                    <td><strong>Apellido 1:</strong></td>
                                    <td><input type='text' name='apellido1' value='<?php echo $row['apellido1']; ?>' class='form-control'></td>
                                </tr>
                                <tr>
                                    <td><strong>Apellido 2:</strong></td>
                                    <td><input type='text' name='apellido2' value='<?php echo $row['apellido2']; ?>' class='form-control'></td>
                                </tr>
                                <tr>
                                    <td><strong>Correo:</strong></td>
                                    <td><input type='text' name='correo' value='<?php echo $row['correo']; ?>' class='form-control'></td>
                                </tr>
                                <tr>
                                    <td><strong>Telefono:</strong></td>
                                    <td><input type='text' name='telefono' value='<?php echo $row['telefono']; ?>' class='form-control'></td>
                                </tr>
                                <tr>
                                    <td><strong>Direccion:</strong></td>
                                    <td><input type='text' name='direccion' value='<?php echo $row['direccion']; ?>' class='form-control'></td>
                                </tr>
                                <tr>
                                    <td><strong>Título:</strong></td>
                                    <td><input type='text' name='titulo' value='<?php echo $row['titulo']; ?>' class='form-control'></td>
                                </tr>
                                <tr>
                                    <td><strong>Localidad:</strong></td>
                                    <td><input type='text' name='localidad' value='<?php echo $row['localidad']; ?>' class='form-control'></td>
                                </tr>
                                <tr>
                                    <td><strong>CP:</strong></td>
                                    <td><input type='text' name='cp' value='<?php echo $row['cp']; ?>' class='form-control'></td>
                                </tr>
                                <tr>
                                    <td><strong>Provincia:</strong></td>
                                    <td><input type='text' name='provincia' value='<?php echo $row['provincia']; ?>' class='form-control'></td>
                                </tr>
                                <tr>
    <td><strong>Teletrabajo:</strong></td>
    <td>
        <select name="teletrabajo" class="form-control">
            <option value="1" <?php echo $row['teletrabajo'] == 1 ? 'selected' : ''; ?>>Sí</option>
            <option value="0" <?php echo $row['teletrabajo'] == 0 ? 'selected' : ''; ?>>No</option>
        </select>
    </td>
</tr>

<tr>
                                    <td><strong>Turno:</strong></td>
                                    <td>
                                        <select name="turno" class="form-control">
                                            <option value="Mañana" <?php echo $row['turno'] == 'Mañana' ? 'selected' : ''; ?>>Mañana</option>
                                            <option value="Tarde" <?php echo $row['turno'] == 'Tarde' ? 'selected' : ''; ?>>Tarde</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Vacaciones:</strong></td>
                                    <td><input type='text' name='vacaciones' value='<?php echo $row['vacaciones']; ?>' class='form-control'></td>
                                </tr>
                                <tr>
                                    <td><strong>Requerimientos Especiales:</strong></td>
                                    <td><input type='text' name='requerimientos_especiales' value='<?php echo $row['requerimientos_especiales']; ?>' class='form-control'></td>
                                </tr>
                                <tr>
    <td><strong>Fecha de Nacimiento:</strong></td>
    <td><input type='date' name='fecha_nacimiento' value='<?php echo $row['fecha_nacimiento']; ?>' class='form-control'></td>
</tr>

                            </tbody>
                        </table>
                        <input type="hidden" name="id_empleado" value="<?php echo $id_empleado; ?>">
                        <button type="submit" class="btn btn-primary">Confirmar Cambios</button>
                        <a href="empleado.php?id=<?php echo $id_empleado; ?>" class="btn btn-secondary">Volver</a>
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
