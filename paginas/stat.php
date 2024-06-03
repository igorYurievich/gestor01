<?php
session_start();

include 'conexion.php';

if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}

$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$limit = 8;
$offset = ($page - 1) * $limit;

$sql = "SELECT * FROM empleado LIMIT $limit OFFSET $offset";
$result = $conn->query($sql);

$empleados = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $empleados[] = $row;
    }
} else {
    $mensaje = "No se encontraron resultados.";
}

$total_rows_sql = "SELECT COUNT(*) AS total FROM empleado";
$total_rows_result = $conn->query($total_rows_sql);
$total_rows_data = $total_rows_result->fetch_assoc();
$total_rows = $total_rows_data['total'];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Navegación</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="estilo_stat.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        @media (max-width: 767px) {
            .sidebar-top {
                position: relative;
                width: 100%;
                z-index: 1;
            }
        }
        .navbar-dark {
            background-color: #343a40 !important;
        }
        .navbar-dark .navbar-nav .nav-link {
            color: #fff !important;
        }
        .navbar-dark .navbar-nav .nav-link:hover {
            color: #ccc !important;
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <nav class="col-12 d-md-none navbar navbar-expand-lg navbar-dark bg-dark sidebar-top">
                <div class="sidebar-sticky">
                    <ul class="nav flex-column">
                        <li class="nav-item py-2">
                            <a class="nav-link active" href="principal.php">
                                <i class="fas fa-home"></i> Inicio
                            </a>
                        </li>
                        <li class="nav-item py-2">
                            <a class="nav-link" href="crear_empleado.php">
                                <i class="fas fa-user-plus"></i> Crear empleado
                            </a>
                        </li>
                        <li class="nav-item py-2">
                            <a class="nav-link" href="stat.php">
                                <i class="fas fa-users"></i> Empleados
                            </a>
                        </li>
                        <li class="nav-item py-2">
                            <a class="nav-link text-danger" href="logout.php">
                                <i class="fas fa-sign-out-alt"></i> Cerrar sesión
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>
            <nav class="col-md-2 d-none d-md-block bg-light sidebar">
                <div class="sidebar-sticky">
                    <ul class="nav flex-column">
                        <li class="nav-item py-2">
                            <a class="nav-link active" href="principal.php">
                                <i class="fas fa-home"></i> Inicio
                            </a>
                        </li>
                        <li class="nav-item py-2">
                            <a class="nav-link" href="crear_empleado.php">
                                <i class="fas fa-user-plus"></i> Crear empleado
                            </a>
                        </li>
                        <li class="nav-item py-2">
                            <a class="nav-link" href="stat.php">
                                <i class="fas fa-users"></i> Empleados
                            </a>
                        </li>
                        <li class="nav-item py-2">
                            <a class="nav-link text-danger" href="logout.php">
                                <i class="fas fa-sign-out-alt"></i> Cerrar sesión
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>



            <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4 py-4">

            <div class="d-flex justify-content-left">
              
            <?php 
            
            

            include 'filter.php'; ?>
              

                    <form action="export_pdf.php" method="post">
                    
                    <div class="mx-2">
                            <button name="export_pdf_all" class="btn btn-success">Exportar todos los empleados a PDF</button>
                    </div>  
                    </form>

                    <form action="pdf_seleccionados.php" method="post">
                  
                        <button id="export_pdf_button" name="export_pdf" class="btn btn-primary mr-2" disabled>Exportar a PDF los empleados seleccionados</button>
                    </div>
                
                    <br>

                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th></th>
                                <th>Nombre</th>
                                <th style="width: 150px;">Apellido 1</th>
                                <th style="width: 150px;">Apellido 2</th>
                                <th>Dirección</th>
                                <th>Localidad</th>
                                <th>Teléfono</th>
                                <th>Título</th>
                                <th>Teletrabajo</th>
                                <th style="width: 150px;">Opciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php include './tabla_empleados.php'; ?>
                        </tbody>
                    </table>

                    <?php if (isset($mensaje)): ?>
                        <div class="alert alert-warning"><?php echo $mensaje; ?></div>
                    <?php endif; ?>

                    <div>
                        <?php
                        $total_pages = ceil($total_rows / $limit);
                        for ($i = 1; $i <= $total_pages; $i++) {
                            echo "<a href=\"?page=$i\" class=\"btn btn-primary\">$i</a> ";
                        }
                        ?>
                    </div>
                </form>

                <script src="./boton_pdf.js"></script>
            </main>
        </div>
    </div>
</body>
</html>


