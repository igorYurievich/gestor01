
$(document).ready(function() {
    // Obtener estadísticas de empleados
    $.ajax({
        url: 'get_employee_stats.php',
        method: 'GET',
        success: function(data) {
            var parsedData = JSON.parse(data);
            $('#total-empleados').text(parsedData.total_empleados);
            $('#total-teletrabajo').text(parsedData.total_teletrabajo);
        }
    });

    // Obtener datos de idiomas y crear gráfico
    $.ajax({
        url: 'get_idioma_data.php',
        method: 'GET',
        success: function(data) {
            var idiomas = [];
            var cantidades = [];
            var colors = [];
            var borderColor = [];
            var parsedData = JSON.parse(data);
            
            var colorPalette = [
                'rgba(255, 99, 132, 0.8)',
                'rgba(54, 162, 235, 0.8)',
                'rgba(255, 206, 86, 0.8)',
                'rgba(75, 192, 192, 0.8)',
                'rgba(153, 102, 255, 0.8)',
                'rgba(255, 159, 64, 0.8)',
                'rgba(255, 99, 71, 0.8)',
                'rgba(60, 179, 113, 0.8)'
            ];

            var borderColorPalette = [
                'rgba(255, 99, 132, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)',
                'rgba(255, 99, 71, 1)',
                'rgba(60, 179, 113, 1)'
            ];

            for(var i in parsedData) {
                idiomas.push(parsedData[i].nombre);
                cantidades.push(parsedData[i].cantidad);
                colors.push(colorPalette[i % colorPalette.length]);
                borderColor.push(borderColorPalette[i % borderColorPalette.length]);
            }

            var ctx = document.getElementById('myChart').getContext('2d');
            var myChart = new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: idiomas,
                    datasets: [{
                        data: cantidades,
                        backgroundColor: colors,
                        borderColor: borderColor,
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'top',
                        },
                        title: {
                            display: true,
                            text: 'Distribución de Idiomas de Empleados'
                        }
                    }
                }
            });
        }
    });

    // Obtener datos de nacionalidades y crear gráfico
    $.ajax({
        url: 'get_nacionalidad_data.php',
        method: 'GET',
        success: function(data) {
            var nacionalidades = [];
            var cantidades = [];
            var colors = [];
            var borderColor = [];
            var parsedData = JSON.parse(data);

            var colorPalette = [
                'rgba(255, 99, 132, 0.8)',
                'rgba(54, 162, 235, 0.8)',
                'rgba(255, 206, 86, 0.8)',
                'rgba(75, 192, 192, 0.8)',
                'rgba(153, 102, 255, 0.8)',
                'rgba(255, 159, 64, 0.8)',
                'rgba(255, 99, 71, 0.8)',
                'rgba(60, 179, 113, 0.8)'
            ];

            var borderColorPalette = [
                'rgba(255, 99, 132, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)',
                'rgba(255, 99, 71, 1)',
                'rgba(60, 179, 113, 1)'
            ];

            for(var i in parsedData) {
                nacionalidades.push(parsedData[i].nombre);
                cantidades.push(parsedData[i].cantidad);
                colors.push(colorPalette[i % colorPalette.length]);
                borderColor.push(borderColorPalette[i % borderColorPalette.length]);
            }

            var ctx = document.getElementById('myBarChart').getContext('2d');
            var myBarChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: nacionalidades,
                    datasets: [{
                        label: 'Nacionalidades',
                        data: cantidades,
                        backgroundColor: colors,
                        borderColor: borderColor,
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'top',
                        },
                        title: {
                            display: true,
                            text: 'Distribución de Nacionalidades de Empleados'
                        }
                    },
                    scales: {
                        x: {
                            stacked: true
                        },
                        y: {
                            stacked: true
                        }
                    }
                }
            });
        }
    });
});
