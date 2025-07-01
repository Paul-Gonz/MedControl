@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Dashboard</h1>
@stop

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card mb-4">
                    <div class="card-header">Gráfico de Barras (Ejemplo)</div>
                    <div class="card-body d-flex justify-content-center align-items-center" style="height:320px;">
                        <canvas id="barChart" width="300" height="300" style="max-width:300px;max-height:300px;"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card mb-4">
                    <div class="card-header">Gráfico de Torta (Ejemplo)</div>
                    <div class="card-body d-flex justify-content-center align-items-center" style="height:320px;">
                        <canvas id="pieChart" width="300" height="300" style="max-width:300px;max-height:300px;"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <!-- Tabla: Top 10 doctores con más consultas (Ejemplo) -->
        <div class="row mt-4">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Top 10 Doctores con Más Consultas</div>
                    <div class="card-body">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nombre</th>
                                    <th>Especialidad</th>
                                    <th>Consultas Realizadas</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr><td>1</td><td>Dr. Juan Pérez</td><td>Pediatría</td><td>120</td></tr>
                                <tr><td>2</td><td>Dra. María López</td><td>Cardiología</td><td>110</td></tr>
                                <tr><td>3</td><td>Dr. Carlos Ruiz</td><td>Dermatología</td><td>105</td></tr>
                                <tr><td>4</td><td>Dra. Ana Torres</td><td>Ginecología</td><td>98</td></tr>
                                <tr><td>5</td><td>Dr. Luis Gómez</td><td>Traumatología</td><td>95</td></tr>
                                <tr><td>6</td><td>Dra. Sofía Martínez</td><td>Pediatría</td><td>90</td></tr>
                                <tr><td>7</td><td>Dr. Pablo Sánchez</td><td>Cardiología</td><td>88</td></tr>
                                <tr><td>8</td><td>Dra. Laura Díaz</td><td>Dermatología</td><td>85</td></tr>
                                <tr><td>9</td><td>Dr. Andrés Castro</td><td>Ginecología</td><td>80</td></tr>
                                <tr><td>10</td><td>Dra. Paula Romero</td><td>Traumatología</td><td>78</td></tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- Tabla: Citas de Hoy (Ejemplo) -->
        <div class="row mt-4">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Citas de Hoy</div>
                    <div class="card-body">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Fecha</th>
                                    <th>Hora</th>
                                    <th>Doctor</th>
                                    <th>Especialidad</th>
                                    <th>Consultorio</th>
                                    <th>Paciente</th>
                                    <th>Estado</th>
                                    <th>Motivo</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr><td>1</td><td>2025-06-30</td><td>09:00</td><td>Dr. Juan Pérez</td><td>Pediatría</td><td>Consultorio 1</td><td>Pedro Gómez</td><td><span class="badge badge-success">Realizada</span></td><td>Control mensual</td></tr>
                                <tr><td>2</td><td>2025-06-30</td><td>10:00</td><td>Dra. María López</td><td>Cardiología</td><td>Consultorio 2</td><td>Lucía Torres</td><td><span class="badge badge-warning">Agendada</span></td><td>Chequeo anual</td></tr>
                                <tr><td>3</td><td>2025-06-30</td><td>11:00</td><td>Dr. Carlos Ruiz</td><td>Dermatología</td><td>Consultorio 3</td><td>Andrés Díaz</td><td><span class="badge badge-danger">Cancelada</span></td><td>Consulta de alergia</td></tr>
                                <tr><td>4</td><td>2025-06-30</td><td>12:00</td><td>Dra. Ana Torres</td><td>Ginecología</td><td>Consultorio 4</td><td>María Ruiz</td><td><span class="badge badge-success">Realizada</span></td><td>Revisión anual</td></tr>
                                <tr><td>5</td><td>2025-06-30</td><td>13:00</td><td>Dr. Luis Gómez</td><td>Traumatología</td><td>Consultorio 5</td><td>José Castro</td><td><span class="badge badge-warning">Agendada</span></td><td>Dolor de rodilla</td></tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- Gráfico de Barras: Horas de uso de consultorios (ejemplo) y minicalendario -->
        <div class="row mt-4">
            <div class="col-md-8">
                <div class="card mb-4">
                    <div class="card-header">Horas de Uso de Consultorios (Ejemplo)</div>
                    <div class="card-body d-flex justify-content-center align-items-center" style="height:320px;">
                        <canvas id="ocupacionChart" style="width:100%;max-width:1000px;max-height:300px;"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('css')
    {{-- Add here extra stylesheets --}}
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/main.min.css" rel="stylesheet">
@stop

@section('js')
    <!-- Chart.js CDN (puedes cambiarlo por asset si lo tienes local) -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- FullCalendar CDN -->
    <script>
        // Gráfico de Barras: Citas médicas por mes
        const ctxBar = document.getElementById('barChart').getContext('2d');
        new Chart(ctxBar, {
            type: 'bar',
            data: {
                labels: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo'],
                datasets: [
                    {
                        label: 'Agendadas',
                        data: [30, 45, 40, 50, 60],
                        backgroundColor: 'rgba(54, 162, 235, 0.7)'
                    },
                    {
                        label: 'Realizadas',
                        data: [25, 40, 35, 45, 55],
                        backgroundColor: 'rgba(40, 167, 69, 0.7)'
                    },
                    {
                        label: 'Canceladas',
                        data: [5, 5, 5, 5, 5],
                        backgroundColor: 'rgba(220, 53, 69, 0.7)'
                    }
                ]
            },
            options: {
                responsive: false,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // Gráfico de Torta: Distribución de citas por especialidad
        const ctxPie = document.getElementById('pieChart').getContext('2d');
        new Chart(ctxPie, {
            type: 'pie',
            data: {
                labels: ['Pediatría', 'Cardiología', 'Dermatología', 'Ginecología', 'Traumatología'],
                datasets: [{
                    label: 'Citas por especialidad',
                    data: [40, 25, 15, 10, 10],
                    backgroundColor: [
                        'rgba(54, 162, 235, 0.7)',
                        'rgba(255, 99, 132, 0.7)',
                        'rgba(255, 206, 86, 0.7)',
                        'rgba(75, 192, 192, 0.7)',
                        'rgba(153, 102, 255, 0.7)'
                    ],
                    borderColor: [
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 99, 132, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: false,
                maintainAspectRatio: false
            }
        });

        // Gráfico de Línea: Ingresos y Egresos mensuales (ejemplo)
        const ingresosChartContainer = document.getElementById('ingresosChart')?.parentElement;
        if (ingresosChartContainer) {
            ingresosChartContainer.parentElement.parentElement.remove(); // Elimina el gráfico anterior si existe
        }
        document.querySelector('.row.justify-content-center').insertAdjacentHTML('beforeend', `
            <div class="col-md-12">
                <div class="card mb-4">
                    <div class="card-header">Ingresos y Egresos Mensuales (Ejemplo)</div>
                    <div class="card-body d-flex justify-content-center align-items-center" style="height:320px;">
                        <canvas id="ingresosChart" style="width:100%;max-width:1000px;max-height:300px;"></canvas>
                    </div>
                </div>
            </div>
        `);

        const ctxIngresos = document.getElementById('ingresosChart').getContext('2d');
        new Chart(ctxIngresos, {
            type: 'line',
            data: {
                labels: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo'],
                datasets: [
                    {
                        label: 'Ingresos ($)',
                        data: [1200, 1500, 1100, 1800, 1600],
                        fill: false,
                        borderColor: 'rgba(255, 159, 64, 1)',
                        backgroundColor: 'rgba(255, 159, 64, 0.7)',
                        tension: 0.3,
                        pointBackgroundColor: 'rgba(255, 159, 64, 1)',
                        pointBorderColor: '#fff',
                        pointRadius: 6,
                        pointHoverRadius: 8
                    },
                    {
                        label: 'Egresos ($)',
                        data: [800, 900, 950, 1000, 1100],
                        fill: false,
                        borderColor: 'rgba(54, 162, 235, 1)',
                        backgroundColor: 'rgba(54, 162, 235, 0.7)',
                        tension: 0.3,
                        pointBackgroundColor: 'rgba(54, 162, 235, 1)',
                        pointBorderColor: '#fff',
                        pointRadius: 6,
                        pointHoverRadius: 8
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    x: {
                        display: true,
                        title: {
                            display: true,
                            text: 'Mes'
                        }
                    },
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Monto ($)'
                        }
                    }
                }
            }
        });

        // Gráfico de Barras: Horas de uso de consultorios (ejemplo)
        const ocupacionChartContainer = document.getElementById('ocupacionChart')?.parentElement;
        if (ocupacionChartContainer) {
            ocupacionChartContainer.parentElement.parentElement.remove(); // Elimina el gráfico anterior si existe
        }
        document.querySelector('.row.justify-content-center').insertAdjacentHTML('beforeend', `
            <div class="col-md-12">
                <div class="card mb-4">
                    <div class="card-header">Horas de Uso de Consultorios (Ejemplo)</div>
                    <div class="card-body d-flex justify-content-center align-items-center" style="height:320px;">
                        <canvas id="ocupacionChart" style="width:100%;max-width:1000px;max-height:300px;"></canvas>
                    </div>
                </div>
            </div>
        `);

        const ctxOcupacion = document.getElementById('ocupacionChart').getContext('2d');
        new Chart(ctxOcupacion, {
            type: 'bar',
            data: {
                labels: ['Consultorio 1', 'Consultorio 2', 'Consultorio 3', 'Consultorio 4', 'Consultorio 5'],
                datasets: [
                    {
                        label: 'Horas de uso',
                        data: [120, 95, 80, 140, 110],
                        backgroundColor: [
                            'rgba(54, 162, 235, 0.7)',
                            'rgba(255, 99, 132, 0.7)',
                            'rgba(255, 206, 86, 0.7)',
                            'rgba(75, 192, 192, 0.7)',
                            'rgba(153, 102, 255, 0.7)'
                        ],
                        borderColor: [
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 99, 132, 1)',
                            'rgba(255, 206, 86, 1)',
                            'rgba(75, 192, 192, 1)',
                            'rgba(153, 102, 255, 1)'
                        ],
                        borderWidth: 1
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Horas de uso'
                        }
                    },
                    x: {
                        title: {
                            display: true,
                            text: 'Consultorios'
                        }
                    }
                }
            }
        });

        // Gráfico de Barras: Cantidad de citas por día de esta semana
        document.querySelector('.row.justify-content-center').insertAdjacentHTML('beforeend', `
            <div class="col-md-12">
                <div class="card mb-4">
                    <div class="card-header">Cantidad de Citas por Día (Esta Semana)</div>
                    <div class="card-body d-flex justify-content-center align-items-center" style="height:320px;">
                        <canvas id="citasSemanaChart" style="width:100%;max-width:1000px;max-height:300px;"></canvas>
                    </div>
                </div>
            </div>
        `);

        const ctxCitasSemana = document.getElementById('citasSemanaChart').getContext('2d');
        new Chart(ctxCitasSemana, {
            type: 'bar',
            data: {
                labels: ['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo'],
                datasets: [
                    {
                        label: 'Citas agendadas',
                        data: [3, 2, 4, 1, 2, 0, 0], // Ejemplo de datos
                        backgroundColor: 'rgba(0, 123, 255, 0.7)'
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Cantidad de citas'
                        }
                    },
                    x: {
                        title: {
                            display: true,
                            text: 'Día de la semana'
                        }
                    }
                }
            }
        });

        // });
    </script>
    <script> console.log("Hi, I'm using the Laravel-AdminLTE package!"); </script>
@stop