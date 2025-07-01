@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Dashboard</h1>
@stop

@section('content')
    <div class="container">
        <!-- Gráfico de Línea: Ingresos y Egresos mensuales (funcional) -->
        <div class="row mt-4">
            <div class="col-md-12">
                <div class="card mb-4">
                    <div class="card-header">Ingresos y Egresos Mensuales</div>
                    <div class="card-body d-flex justify-content-center align-items-center" style="height:320px;">
                        <canvas id="ingresosChart" style="width:100%;max-width:1000px;max-height:300px;"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card mb-4">
                    <div class="card-header">Citas de los Ultimos 6 Meses</div>
                    <div class="card-body d-flex justify-content-center align-items-center" style="height:320px;">
                        <canvas id="barChart" width="300" height="300" style="max-width:300px;max-height:300px;"></canvas>
                    </div>
                </div>
            </div>
            
            <div class="col-md-6">
                <div class="card mb-4">
                    <div class="card-header">Especialidades más Demandadas de este Mes</div>
                    <div class="card-body d-flex justify-content-center align-items-center" style="height:320px;">
                        <canvas id="pieChart" width="300" height="300" style="max-width:300px;max-height:300px;"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <!-- Tabla: Top 10 doctores con más consultas (Ejemplo) -->
        <div class="row mt-4">
            <div class="col-md-12">
                <div class="card mb-4">
                    <div class="card-header">Top 10 Doctores con Más Consultas Pagadas Este Mes</div>
                    <div class="card-body d-flex justify-content-center align-items-center" style="height:320px;">
                        <canvas id="topDoctoresPagadasChart" style="width:100%;max-width:1000px;max-height:300px;"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <!-- Gráfico de Barras: Horas de uso de consultorios -->
        <div class="row mt-4">
            <div class="col-md-8">
                <div class="card mb-4">
                    <div class="card-header">Horas de Uso de Consultorios </div>
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
        // Gráfico de Barras: Citas médicas por mes (dinámico)
        fetch("{{ route('dashboard.citasPorMes') }}")
            .then(response => response.json())
            .then(data => {
                const ctxBar = document.getElementById('barChart').getContext('2d');
                new Chart(ctxBar, {
                    type: 'bar',
                    data: {
                        labels: data.labels,
                        datasets: [
                            {
                                label: 'Totales',
                                data: data.programadas,
                                backgroundColor: 'rgba(54, 162, 235, 0.7)'
                            },
                            {
                                label: 'Realizadas',
                                data: data.realizadas,
                                backgroundColor: 'rgba(40, 167, 69, 0.7)'
                            },
                            {
                                label: 'Canceladas',
                                data: data.canceladas,
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
            });

        // Gráfico de Torta: Distribución de citas por especialidad (dinámico)
        fetch("{{ route('dashboard.especialidadesMasDemandadas') }}")
            .then(response => response.json())
            .then(data => {
                const ctxPie = document.getElementById('pieChart').getContext('2d');
                let labels = data.labels;
                let chartData = data.data;
                let backgroundColor = [
                    'rgba(54, 162, 235, 0.7)',
                    'rgba(255, 99, 132, 0.7)',
                    'rgba(255, 206, 86, 0.7)',
                    'rgba(75, 192, 192, 0.7)',
                    'rgba(153, 102, 255, 0.7)',
                    'rgba(255, 159, 64, 0.7)',
                    'rgba(40, 167, 69, 0.7)',
                    'rgba(220, 53, 69, 0.7)',
                    'rgba(0, 123, 255, 0.7)',
                    'rgba(255, 193, 7, 0.7)'
                ];
                let borderColor = [
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 99, 132, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 159, 64, 1)',
                    'rgba(40, 167, 69, 1)',
                    'rgba(220, 53, 69, 1)',
                    'rgba(0, 123, 255, 1)',
                    'rgba(255, 193, 7, 1)'
                ];
                if (!labels || !Array.isArray(labels) || labels.length === 0 || !chartData || !Array.isArray(chartData) || chartData.length === 0) {
                    labels = ['Sin datos'];
                    chartData = [1];
                    backgroundColor = ['#e0e0e0'];
                    borderColor = ['#bdbdbd'];
                }
                new Chart(ctxPie, {
                    type: 'pie',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Citas por especialidad',
                            data: chartData,
                            backgroundColor: backgroundColor,
                            borderColor: borderColor,
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: false,
                        maintainAspectRatio: false,
                        plugins: {
                            title: {
                                display: true,
                                text: 'Especialidades más demandadas - ' + (data.mes || '')
                            }
                        }
                    }
                });
            });

        // Gráfico de Línea: Ingresos y Egresos mensuales (funcional)
        fetch("{{ route('dashboard.ingresosEgresos') }}")
            .then(response => response.json())
            .then(data => {
                const ctxIngresos = document.getElementById('ingresosChart').getContext('2d');
                new Chart(ctxIngresos, {
                    type: 'line',
                    data: {
                        labels: data.labels,
                        datasets: [
                            {
                                label: 'Ingresos ($)',
                                data: data.ingresos,
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
                                data: data.egresos,
                                fill: false,
                                borderColor: 'rgba(54, 162, 235, 1)',
                                backgroundColor: 'rgba(54, 162, 235, 0.7)',
                                tension: 0.3,
                                pointBackgroundColor: 'rgba(54, 162, 235, 1)',
                                pointBorderColor: '#fff',
                                pointRadius: 6,
                                pointHoverRadius: 8
                            },
                            {
                                label: 'Total (Ingresos - Egresos)',
                                data: data.total,
                                fill: false,
                                borderColor: 'rgba(40, 167, 69, 1)',
                                backgroundColor: 'rgba(40, 167, 69, 0.7)',
                                borderDash: [5, 5],
                                tension: 0.3,
                                pointBackgroundColor: 'rgba(40, 167, 69, 1)',
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
            });

        // Gráfico de Barras: Horas de uso de consultorios (funcional)
        fetch("{{ route('dashboard.horasUsoConsultorios') }}")
            .then(response => response.json())
            .then(data => {
                const canvas = document.getElementById('ocupacionChart');
                if (!canvas) return;
                const ctxOcupacion = canvas.getContext('2d');
                new Chart(ctxOcupacion, {
                    type: 'bar',
                    data: {
                        labels: data.labels,
                        datasets: [
                            {
                                label: 'Horas de uso',
                                data: data.data,
                                backgroundColor: [
                                    'rgba(54, 162, 235, 0.7)',
                                    'rgba(255, 99, 132, 0.7)',
                                    'rgba(255, 206, 86, 0.7)',
                                    'rgba(75, 192, 192, 0.7)',
                                    'rgba(153, 102, 255, 0.7)',
                                    'rgba(255, 159, 64, 0.7)'
                                ],
                                borderColor: [
                                    'rgba(54, 162, 235, 1)',
                                    'rgba(255, 99, 132, 1)',
                                    'rgba(255, 206, 86, 1)',
                                    'rgba(75, 192, 192, 1)',
                                    'rgba(153, 102, 255, 1)',
                                    'rgba(255, 159, 64, 1)'
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
            }});

        // Gráfico de Barras: Top 10 doctores con más consultas pagadas este mes
        document.addEventListener('DOMContentLoaded', function() {
            const topDoctoresLabels = [
                'Dr. Juan Pérez', 'Dra. María López', 'Dr. Carlos Ruiz', 'Dra. Ana Torres', 'Dr. Luis Gómez',
                'Dra. Sofía Martínez', 'Dr. Pablo Sánchez', 'Dra. Laura Díaz', 'Dr. Andrés Castro', 'Dra. Paula Romero'
            ];
            const topDoctoresData = [25, 22, 20, 18, 17, 15, 14, 13, 12, 11]; // Ejemplo de datos
            const ctxTopDoctores = document.getElementById('topDoctoresPagadasChart').getContext('2d');
            new Chart(ctxTopDoctores, {
                type: 'bar',
                data: {
                    labels: topDoctoresLabels,
                    datasets: [{
                        label: 'Consultas pagadas',
                        data: topDoctoresData,
                        backgroundColor: 'rgba(255, 99, 132, 0.7)',
                        borderColor: 'rgba(255, 99, 132, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    indexAxis: 'y', // Barra horizontal
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        x: {
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: 'Cantidad de consultas pagadas'
                            }
                        },
                        y: {
                            title: {
                                display: true,
                                text: 'Doctor'
                            }
                        }
                    }
                }
            });
        });
    </script>
    <script> console.log("Hi, I'm using the Laravel-AdminLTE package!"); </script>
@stop