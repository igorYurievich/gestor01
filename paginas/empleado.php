<?php
include 'conexion.php';

session_start();

if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}

$username = $_SESSION['username'];
$page = isset($_GET['page']) ? $_GET['page'] : 1;

$editar_idiomas_url = 'editar_idiomas.php';
$editar_url = ($username === 'admin') ? 'edicion.php' : 'edicion_user.php';

if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id_empleado = $_GET['id'];

    // Consulta para obtener los datos principales del empleado
    $sql_empleado = "SELECT empleado.*, nacionalidad.nombre AS nacionalidad FROM empleado JOIN nacionalidad_empleado ON empleado.ID_Empleado = nacionalidad_empleado.id_empleado JOIN nacionalidad ON nacionalidad_empleado.id_nacionalidad = nacionalidad.id_nacionalidad WHERE empleado.ID_Empleado = $id_empleado";
    $result_empleado = $conn->query($sql_empleado);

    // Consulta para obtener los idiomas del empleado y sus niveles
    $sql_idiomas = "SELECT idioma.nombre AS idioma, nivel_idioma.nivel AS nivel FROM idioma_empleado JOIN idioma ON idioma_empleado.id_idioma = idioma.id_idioma JOIN nivel_idioma ON idioma_empleado.id_nivel = nivel_idioma.id_nivel WHERE idioma_empleado.id_empleado = $id_empleado";
    $result_idiomas = $conn->query($sql_idiomas);

    if ($result_empleado->num_rows > 0) {
        ?>
        <!DOCTYPE html>
        <html lang="es">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Datos del Empleado</title>
            <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
        </head>
        <body>
            <div class="container">
                <h1 class="mt-5">Datos del Empleado</h1>
                <div class="mt-3">
                    <table class="table table-bordered">
                        <tbody>
                        <?php
$row_empleado = $result_empleado->fetch_assoc();
?>
<tr>
    <td><strong>Nombre:</strong></td>
    <td><?php echo $row_empleado['nombre']; ?></td>
</tr>
<tr>
    <td><strong>Apellido 1:</strong></td>
    <td><?php echo $row_empleado['apellido1']; ?></td>
</tr>
<tr>
    <td><strong>Apellido 2:</strong></td>
    <td><?php echo $row_empleado['apellido2']; ?></td>
</tr>
<tr>
    <td><strong>Correo:</strong></td>
    <td><?php echo $row_empleado['correo']; ?></td>
</tr>
<tr>
    <td><strong>Teléfono:</strong></td>
    <td><?php echo $row_empleado['telefono']; ?></td>
</tr>
<tr>
    <td><strong>Dirección:</strong></td>
    <td><?php echo $row_empleado['direccion']; ?></td>
</tr>
<tr>
    <td><strong>Localidad:</strong></td>
    <td><?php echo $row_empleado['localidad']; ?></td>
</tr>
<tr>
    <td><strong>Código Postal:</strong></td>
    <td><?php echo $row_empleado['cp']; ?></td>
</tr>
<tr>
    <td><strong>Provincia:</strong></td>
    <td><?php echo $row_empleado['provincia']; ?></td>
</tr>
<tr>
    <td><strong>Título:</strong></td>
    <td><?php echo $row_empleado['titulo']; ?></td>
</tr>
<tr>
    <td><strong>Teletrabajo:</strong></td>
    <td><?php echo $row_empleado['teletrabajo'] == 1 ? 'Sí' : 'No'; ?></td>
</tr>
<tr>
    <td><strong>Turno:</strong></td>
    <td><?php echo $row_empleado['turno']; ?></td>
</tr>
<tr>
    <td><strong>Requerimientos Especiales:</strong></td>
    <td><?php echo $row_empleado['requerimientos_especiales']; ?></td>
</tr>
<tr>
    <td><strong>Fecha de Nacimiento:</strong></td>
    <td><?php echo $row_empleado['fecha_nacimiento']; ?></td>
</tr>
<tr>
    <td><strong>Nacionalidad:</strong></td>
    <td><?php echo $row_empleado['nacionalidad']; ?></td>
</tr>

                            <tr>
                                <td><strong>Idiomas:</strong></td>
                                <td>
                                    <ul>
                                        <?php
                                        while ($row_idiomas = $result_idiomas->fetch_assoc()) {
                                            echo "<li>" . $row_idiomas['idioma'] . " (Nivel: " . $row_idiomas['nivel'] . ")</li>";
                                        }
                                        ?>
                                    </ul>
                                </td>
                            </tr>
                        </tbody>
                    </table>

                    <div class="mt-3">
                        <a href="stat.php?page=<?php echo $page; ?>" class="btn btn-primary">Volver</a>
                        <a href="exportar_empleado.php?id=<?php echo $id_empleado; ?>" class="btn btn-danger"><i class="fas fa-file-pdf"></i></a>                        
                        <a href="<?php echo $editar_url . '?id=' . $id_empleado; ?>" class="btn btn-secondary">Editar</a>
                        <a href="<?php echo $editar_idiomas_url . '?id=' . $id_empleado; ?>" class="btn btn-secondary">Editar idiomas</a>
                        <?php if ($username === 'admin'): ?>
                            <a href="eliminar_empleado.php?id=<?php echo $id_empleado; ?>" class="btn btn-danger" onclick="return confirm('¿Está seguro de que desea eliminar este empleado?');">Eliminar</a>
                        <?php endif; ?>
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
