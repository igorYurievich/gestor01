<?php
include './conexion.php';

session_start();

if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}

$username = $_SESSION['username'];

if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id_empleado = $_GET['id'];
    
    $sql = "SELECT ie.id_idioma, i.nombre AS idioma, ie.id_nivel
            FROM idioma_empleado ie
            INNER JOIN idioma i ON ie.id_idioma = i.id_idioma
            WHERE ie.id_empleado = $id_empleado";
    $result = $conn->query($sql);

    ?>
    <!DOCTYPE html>
    <html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Editar Idiomas</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    </head>
    <body>
        <div class="container">
            <h1 class="mt-5">Editar Idiomas</h1>
            <div class="mt-3">
                <form action="actualizar_idioma.php" method="POST">
                    <input type="hidden" name="id_empleado" value="<?php echo $id_empleado; ?>">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Idioma</th>
                                <th>Nivel</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    echo "<tr>";
                                    echo "<td>{$row['idioma']}</td>";
                                    echo "<td><select name='niveles[{$row['id_idioma']}]' class='form-control'>";
                                    $sql_niveles = "SELECT * FROM nivel_idioma";
                                    $result_niveles = $conn->query($sql_niveles);
                                    if ($result_niveles->num_rows > 0) {
                                        while ($row_nivel = $result_niveles->fetch_assoc()) {
                                            $selected = ($row_nivel['id_nivel'] == $row['id_nivel']) ? 'selected' : '';
                                            echo "<option value='{$row_nivel['id_nivel']}' $selected>{$row_nivel['nivel']}</option>";
                                        }
                                    }
                                    echo "</select></td>";
                                    echo "<td><button type='submit' name='eliminar_idioma' value='{$row['id_idioma']}' class='btn btn-danger'>Eliminar</button></td>";
                                    echo "</tr>";
                                }
                            }
                            ?>
                        </tbody>
                    </table>
                    <div class="form-group">
                        <h3>Añadir nuevo idioma</h3>
                        <label for="nuevo_idioma">Idioma:</label>
                        <select name="nuevo_idioma" class="form-control" id="nuevo_idioma">
                            <option value="">Seleccionar Idioma</option>
                            <?php
                            $sql_idiomas = "SELECT * FROM idioma";
                            $result_idiomas = $conn->query($sql_idiomas);
                            if ($result_idiomas->num_rows > 0) {
                                while ($row_idioma = $result_idiomas->fetch_assoc()) {
                                    echo "<option value='{$row_idioma['id_idioma']}'>{$row_idioma['nombre']}</option>";
                                }
                            }
                            ?>
                        </select>
                        <label for="nuevo_nivel">Nivel:</label>
                        <select name="nuevo_nivel" class="form-control" id="nuevo_nivel">
                            <option value="">Seleccionar Nivel</option>
                            <?php
                            $sql_niveles = "SELECT * FROM nivel_idioma";
                            $result_niveles = $conn->query($sql_niveles);
                            if ($result_niveles->num_rows > 0) {
                                while ($row_nivel = $result_niveles->fetch_assoc()) {
                                    echo "<option value='{$row_nivel['id_nivel']}'>{$row_nivel['nivel']}</option>";
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                    <a href="./empleado.php?id=<?php echo $id_empleado; ?>" class="btn btn-secondary">Volver</a>
                </form>
            </div>
        </div>
    </body>
    </html>
    <?php
} else {
    echo "No se ha proporcionado un ID de empleado.";
}
?>
