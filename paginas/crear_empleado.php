<?php
include './conexion.php';

session_start();

if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $_POST['nombre'];
    $apellido1 = $_POST['apellido1'];
    $apellido2 = !empty($_POST['apellido2']) ? $_POST['apellido2'] : null;
    $correo = $_POST['correo'];
    $telefono = $_POST['telefono'];
    $direccion = $_POST['direccion'];
    $localidad = $_POST['localidad'];
    $cp = $_POST['cp'];
    $provincia = $_POST['provincia'];
    $titulo = $_POST['titulo'];
    $teletrabajo = isset($_POST['teletrabajo']) ? 1 : 0;
    $turno = $_POST['turno'];
    $requerimientos_especiales = $_POST['requerimientos_especiales'];
    $fecha_nacimiento = $_POST['fecha_nacimiento'];
    $id_nacionalidad = $_POST['id_nacionalidad'];
    $idiomas = $_POST['idiomas'];
    $niveles = $_POST['niveles'];

    $sql = "INSERT INTO empleado (nombre, apellido1, apellido2, correo, telefono, direccion, localidad, cp, provincia, titulo, teletrabajo, turno, requerimientos_especiales, fecha_nacimiento)
            VALUES ('$nombre', '$apellido1', '$apellido2', '$correo', '$telefono', '$direccion', '$localidad', '$cp', '$provincia', '$titulo', '$teletrabajo', '$turno', '$requerimientos_especiales', '$fecha_nacimiento')";

    if ($conn->query($sql) === TRUE) {
        $id_empleado = $conn->insert_id;
        $mensaje = "Empleado creado exitosamente.";

        // Insertar nacionalidad del empleado
        $sql_nacionalidad = "INSERT INTO nacionalidad_empleado (id_nacionalidad, id_empleado) VALUES ('$id_nacionalidad', '$id_empleado')";
        $conn->query($sql_nacionalidad);

        // Insertar idiomas del empleado
        foreach ($idiomas as $index => $id_idioma) {
            $id_nivel = $niveles[$index];
            $sql_idioma = "INSERT INTO idioma_empleado (id_idioma, id_nivel, id_empleado) VALUES ('$id_idioma', '$id_nivel', '$id_empleado')";
            $conn->query($sql_idioma);
        }
    } else {
        $mensaje = "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Obtener las nacionalidades
$sql_nacionalidades = "SELECT id_nacionalidad, nombre FROM nacionalidad";
$result_nacionalidades = $conn->query($sql_nacionalidades)->fetch_all(MYSQLI_ASSOC);

// Obtener los idiomas
$sql_idiomas = "SELECT id_idioma, nombre FROM idioma";
$result_idiomas = $conn->query($sql_idiomas)->fetch_all(MYSQLI_ASSOC);

// Obtener los niveles de idioma
$sql_niveles = "SELECT id_nivel, nivel FROM nivel_idioma";
$result_niveles = $conn->query($sql_niveles)->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Empleado</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h1 class="mt-5">Crear Empleado</h1>
        <?php if (isset($mensaje)): ?>
            <div class="alert alert-info"><?php echo $mensaje; ?></div>
        <?php endif; ?>
        <form action="crear_empleado.php" method="POST" onsubmit="return validateForm()">
            <div class="form-group row">
                <div class="col-md-6">
                    <label for="nombre">Nombre:</label>
                    <input type="text" name="nombre" class="form-control" id="nombre" required>
                </div>
                <div class="col-md-6">
                    <label for="apellido1">Apellido 1:</label>
                    <input type="text" name="apellido1" class="form-control" id="apellido1" required>
                </div>
            </div>
            <div class="form-group">
                <label for="apellido2">Apellido 2:</label>
                <input type="text" name="apellido2" class="form-control" id="apellido2">
            </div>
            <div class="form-group">
                <label for="correo">Correo:</label>
                <input type="email" name="correo" class="form-control" id="correo" required>
            </div>
            <div class="form-group">
                <label for="telefono">Teléfono:</label>
                <input type="text" name="telefono" class="form-control" id="telefono" required>
            </div>
            <div class="form-group">
                <label for="direccion">Dirección:</label>
                <input type="text" name="direccion" class="form-control" id="direccion" required>
            </div>
            <div class="form-group row">
                <div class="col-md-4">
                    <label for="localidad">Localidad:</label>
                    <input type="text" name="localidad" class="form-control" id="localidad" required>
                </div>
                <div class="col-md-4">
                    <label for="cp">Código Postal:</label>
                    <input type="text" name="cp" class="form-control" id="cp" required>
                </div>
                <div class="col-md-4">
                    <label for="provincia">Provincia:</label>
                    <input type="text" name="provincia" class="form-control" id="provincia" required>
                </div>
            </div>
            <div class="form-group">
                <label for="titulo">Título:</label>
                <input type="text" name="titulo" class="form-control" id="titulo" required>
            </div>
          
            <div class="form-group">
            <label for="teletrabajo">Teletrabajo:</label>
                <select name="teletrabajo" class="form-control" id="teletrabajo" required>
                    <option value="Si">Si</option>
                    <option value="No">No</option>
                </select>
            </div>
            <div class="form-group">
                <label for="turno">Turno:</label>
                <select name="turno" class="form-control" id="turno" required>
                    <option value="Mañana">Mañana</option>
                    <option value="Tarde">Tarde</option>
                </select>
            </div>
            <div class="form-group">
                <label for="requerimientos_especiales">Requerimientos Especiales:</label>
                <input type="text" name="requerimientos_especiales" class="form-control" id="requerimientos_especiales" required>
            </div>
            <div class="form-group">
                <label for="fecha_nacimiento">Fecha de Nacimiento:</label>
                <input type="date" name="fecha_nacimiento" class="form-control" id="fecha_nacimiento" required>
            </div>
            <div class="form-group">
                <label for="id_nacionalidad">Nacionalidad:</label>
                <select name="id_nacionalidad" class="form-control" id="id_nacionalidad" required>
                    <?php foreach($result_nacionalidades as $nacionalidad): ?>
                        <option value="<?php echo $nacionalidad['id_nacionalidad']; ?>"><?php echo $nacionalidad['nombre']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="idiomas">Idiomas:</label>
                <div id="idiomas-container">
                    <div class="idioma-group">
                        <select name="idiomas[]" class="form-control mb-2">
                            <option value="">Seleccione un idioma</option>
                            <?php foreach($result_idiomas as $idioma): ?>
                                <option value="<?php echo $idioma['id_idioma']; ?>"><?php echo $idioma['nombre']; ?></option>
                            <?php endforeach; ?>
                        </select>
                        <select name="niveles[]" class="form-control mb-2">
                            <option value="">Seleccione un nivel</option>
                            <?php foreach($result_niveles as $nivel): ?>
                                <option value="<?php echo $nivel['id_nivel']; ?>"><?php echo $nivel['nivel']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <button type="button" class="btn btn-secondary" id="add-idioma">Agregar Idioma</button>
            </div>
            <div class="my-2">
            <button type="submit" class="btn btn-primary" id="crear-empleado" disabled>Crear Empleado</button>
            <a href="./stat.php" class="btn btn-secondary">Volver</a>
            </div>
        </form>
    </div>
    <script>
        document.getElementById('add-idioma').addEventListener('click', function() {
            var container = document.getElementById('idiomas-container');
            var idiomaGroup = document.querySelector('.idioma-group').cloneNode(true);
            var selects = idiomaGroup.getElementsByTagName('select');
            for (var i = 0; i < selects.length; i++) {
                selects[i].selectedIndex = 0;
            }
            container.appendChild(idiomaGroup);
            validateIdiomas();
        });

        document.getElementById('idiomas-container').addEventListener('change', validateIdiomas);

        function validateIdiomas() {
            var idiomaSelects = document.querySelectorAll('select[name="idiomas[]"]');
            var nivelSelects = document.querySelectorAll('select[name="niveles[]"]');
            var crearEmpleadoButton = document.getElementById('crear-empleado');
            var idiomaValid = false;

            for (var i = 0; i < idiomaSelects.length; i++) {
                if (idiomaSelects[i].value !== "" && nivelSelects[i].value !== "") {
                    idiomaValid = true;
                    break;
                }
            }

            crearEmpleadoButton.disabled = !idiomaValid;
        }

        function validateForm() {
            var idiomaSelects = document.querySelectorAll('select[name="idiomas[]"]');
            var nivelSelects = document.querySelectorAll('select[name="niveles[]"]');
            var idiomaValid = false;

            for (var i = 0; i < idiomaSelects.length; i++) {
                if (idiomaSelects[i].value !== "" && nivelSelects[i].value !== "") {
                    idiomaValid = true;
                    break;
                }
            }

            if (!idiomaValid) {
                alert("Añada al menos un idioma y su nivel.");
                return false;
            }

            return true;
        }

        document.addEventListener('DOMContentLoaded', validateIdiomas);
    </script>
</body>
</html>
