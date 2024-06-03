<?php
session_start(); // Asegúrate de iniciar la sesión

include 'conexion.php';
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
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <nav class="col-md-2 d-none d-md-block bg-light sidebar">
                <div class="sidebar-sticky">
                    <ul class="nav flex-column">
                        <li class="nav-item py-2">
                            <a class="nav-link active" href="principal.php">
                                Inicio
                            </a>
                        </li>
                        <li class="nav-item py-2">
                            <a class="nav-link" href="crear_empleado.php">
                                Crear empleado
                            </a>
                        </li>
                        <li class="nav-item py-2">
                            <a class="nav-link" href="stat.php">
                                Empleados
                            </a>
                        </li>
                        <li class="nav-item py-2">
                            <a class="nav-link text-danger" href="logout.php">
                                Cerrar sesión
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>
            <main class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
                <h2>Inicio</h2>
                <div class="row">
                    <div class="col-lg-3 col-6">
                        <!-- Contenedor Vacío -->
                    </div>
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-info">
                            <div class="inner">
                                <h3 id="total-empleados">0</h3>
                                <p>Total de Empleados</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-users"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-success">
                            <div class="inner">
                                <h3 id="total-teletrabajo">0</h3>
                                <p>Teletrabajo</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-laptop"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6">
                        <div id="myChartContainer">
                            <canvas id="myChart" width="320" height="320"></canvas>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div id="myBarChartContainer">
                            <canvas id="myBarChart" width="320" height="320"></canvas>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
    
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="graficos.js"></script>
</body>
</html>
