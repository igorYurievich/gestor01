<?php
include 'conexion.php';

session_start();

if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_empleado = $_POST['id_empleado'];

    if (isset($_POST['eliminar_idioma']) && !empty($_POST['eliminar_idioma'])) {
        $id_idioma = $_POST['eliminar_idioma'];
        $sql_delete = "DELETE FROM idioma_empleado WHERE id_empleado = $id_empleado AND id_idioma = $id_idioma";
        $conn->query($sql_delete);
    } else {
        $niveles = $_POST['niveles'];
        $nuevo_idioma = $_POST['nuevo_idioma'];
        $nuevo_nivel = $_POST['nuevo_nivel'];

        foreach ($niveles as $id_idioma => $id_nivel) {
            $sql_update = "UPDATE idioma_empleado SET id_nivel = $id_nivel WHERE id_empleado = $id_empleado AND id_idioma = $id_idioma";
            $conn->query($sql_update);
        }

        if (!empty($nuevo_idioma) && !empty($nuevo_nivel)) {
            $sql_insert = "INSERT INTO idioma_empleado (id_idioma, id_nivel, id_empleado) VALUES ($nuevo_idioma, $nuevo_nivel, $id_empleado)";
            $conn->query($sql_insert);
        }
    }

    header("Location: empleado.php?id=$id_empleado");
    exit();
} else {
    header('Location: index.php');
    exit();
}
?>
