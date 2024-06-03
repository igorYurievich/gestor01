<?php
include 'conexion.php';

$nombre = isset($_POST['nombre']) ? $_POST['nombre'] : '';
$apellido1 = isset($_POST['apellido1']) ? $_POST['apellido1'] : '';
$apellido2 = isset($_POST['apellido2']) ? $_POST['apellido2'] : '';
$localidad = isset($_POST['localidad']) ? $_POST['localidad'] : '';
$titulo = isset($_POST['titulo']) ? $_POST['titulo'] : '';

$where_clauses = [];
if (!empty($nombre)) {
    $where_clauses[] = "nombre LIKE '%$nombre%'";
}
if (!empty($apellido1)) {
    $where_clauses[] = "apellido1 LIKE '%$apellido1%'";
}
if (!empty($apellido2)) {
    $where_clauses[] = "apellido2 LIKE '%$apellido2%'";
}
if (!empty($localidad)) {
    $where_clauses[] = "localidad LIKE '%$localidad%'";
}
if (!empty($titulo)) {
    $where_clauses[] = "titulo LIKE '%$titulo%'";
}

$where_sql = '';
if (count($where_clauses) > 0) {
    $where_sql = 'WHERE ' . implode(' AND ', $where_clauses);
}

$sql = "SELECT * FROM empleado $where_sql LIMIT $limit OFFSET $offset";
$result = $conn->query($sql);

$empleados = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $empleados[] = $row;
    }
} else {
    $mensaje = "No se encontraron resultados.";
}
?>

<form method="POST" action="">
    <div class="form-row">
        <div class="form-group col-md-2">
            <label for="nombre">Nombre</label>
            <input type="text" class="form-control" id="nombre" name="nombre" value="<?php echo $nombre; ?>">
        </div>
        <div class="form-group col-md-2">
            <label for="apellido1">Apellido 1</label>
            <input type="text" class="form-control" id="apellido1" name="apellido1" value="<?php echo $apellido1; ?>">
        </div>
        <div class="form-group col-md-2">
            <label for="apellido2">Apellido 2</label>
            <input type="text" class="form-control" id="apellido2" name="apellido2" value="<?php echo $apellido2; ?>">
        </div>
        <div class="form-group col-md-2">
            <label for="localidad">Localidad</label>
            <input type="text" class="form-control" id="localidad" name="localidad" value="<?php echo $localidad; ?>">
        </div>
        <div class="form-group col-md-2">
            <label for="titulo">Título</label>
            <input type="text" class="form-control" id="titulo" name="titulo" value="<?php echo $titulo; ?>">
        </div>
        <div class="form-group col-md-2 align-self-end">
            <button type="submit" class="btn btn-primary">Buscar</button>
        </div>
    </div>
</form>
