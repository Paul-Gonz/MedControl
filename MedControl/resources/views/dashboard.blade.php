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
                    <div class="card-header d-flex justify-content-between align-items-center">
                        Ingresos y Egresos Mensuales
                        <button class="btn btn-primary btn-sm" onclick="mostrarReporte('ingresosChart')">Mostrar reporte</button>
                    </div>
                    <div class="card-body d-flex justify-content-center align-items-center" style="height:320px;">
                        <canvas id="ingresosChart" style="width:100%;max-width:1000px;max-height:300px;"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        Citas de los Ultimos 6 Meses
                        <button class="btn btn-primary btn-sm" onclick="mostrarReporte('barChart')">Mostrar reporte</button>
                    </div>
                    <div class="card-body d-flex justify-content-center align-items-center" style="height:320px;">
                        <canvas id="barChart" width="300" height="300" style="max-width:300px;max-height:300px;"></canvas>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        Especialidades más Demandadas de este Mes
                        <button class="btn btn-primary btn-sm" onclick="mostrarReporte('pieChart')">Mostrar reporte</button>
                    </div>
                    <div class="card-body d-flex justify-content-center align-items-center" style="height:320px;">
                        <canvas id="pieChart" width="300" height="300" style="max-width:300px;max-height:300px;"></canvas>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="row mt-4">
            <div class="col-md-12">
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        Top 10 Doctores con Más Consultas Completadas Este Mes
                        <button class="btn btn-primary btn-sm" onclick="mostrarReporte('topDoctoresPagadasChart')">Mostrar reporte</button>
                    </div>
                    <div class="card-body d-flex justify-content-center align-items-center" style="height:320px;">
                        <canvas id="topDoctoresPagadasChart" style="width:100%;max-width:1000px;max-height:300px;"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-4">
            <div class="col-md-8">
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        Horas de Uso de Consultorios
                        <button class="btn btn-primary btn-sm" onclick="mostrarReporte('ocupacionChart')">Mostrar reporte</button>
                    </div>
                    <div class="card-body d-flex justify-content-center align-items-center" style="height:320px;">
                        <canvas id="ocupacionChart" style="width:100%;max-width:1000px;max-height:300px;"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-4">
            <div class="col-md-12">
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        Cantidad de Citas por Día de Esta Semana
                        <button class="btn btn-primary btn-sm" onclick="mostrarReporte('citasSemanaChart')">Mostrar reporte</button>
                    </div>
                    <div class="card-body d-flex justify-content-center align-items-center" style="height:320px;">
                        <canvas id="citasSemanaChart" style="width:100%;max-width:1000px;max-height:300px;"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Parte de Reportes Gerenciales -->
        <div class="row mt-5">
            <div class="col-12">
                <h3 class="mb-4 text-primary">Reportes Gerenciales</h3>
            </div>
        </div>
        <div class="row">
            <!-- Gráfica de ingresos por especialidad -->
            <div class="col-md-12">
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        Reporte de Ingresos por Especialidad
                        <button class="btn btn-primary btn-sm" onclick="mostrarReporte('ingresosEspecialidadChart')">Mostrar reporte</button>
                    </div>
                    <div class="card-body d-flex justify-content-center align-items-center" style="height:320px;">
                        <canvas id="ingresosEspecialidadChart" style="width:100%;max-width:1000px;max-height:300px;"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <!-- Gráfica de torta de distribución del presupuesto por área -->
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        Distribución del Presupuesto por Área - Total $100,000
                        <button class="btn btn-primary btn-sm" onclick="mostrarReporte('presupuestoAreasChart')">Mostrar reporte</button>
                    </div>
                    <div class="card-body d-flex justify-content-center align-items-center" style="height:320px;">
                        <canvas id="presupuestoAreasChart" style="width:100%;max-width:600px;max-height:300px;"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <!-- Gráfica de barras de cantidad de pacientes atendidos por especialidad -->
        <div class="row">
            <div class="col-md-12">
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        Cantidad de pacientes atendidos por especialidad
                        <button class="btn btn-primary btn-sm" onclick="mostrarReporte('pacientesEspecialidadChart')">Mostrar reporte</button>
                    </div>
                    <div class="card-body d-flex justify-content-center align-items-center" style="height:320px;">
                        <canvas id="pacientesEspecialidadChart" style="width:100%;max-width:1000px;max-height:300px;"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <!-- Gráfica de barras de ingresos por servicio -->
        <div class="row">
            <div class="col-md-12">
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        Reporte de Ingresos por Servicio
                        <button class="btn btn-primary btn-sm" onclick="mostrarReporte('ingresosServicioChart')">Mostrar reporte</button>
                    </div>
                    <div class="card-body d-flex justify-content-center align-items-center" style="height:320px;">
                        <canvas id="ingresosServicioChart" style="width:100%;max-width:1000px;max-height:300px;"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para mostrar reporte de gráfica -->
    <div class="modal fade" id="modalReporteGrafica" tabindex="-1" aria-labelledby="modalReporteGraficaLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="modalReporteGraficaLabel">Reporte de Gráfica</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
          </div>
          <div class="modal-body">
            <div class="d-flex justify-content-center mb-3">
              <canvas id="modalChart" style="max-width:700px;max-height:350px;"></canvas>
            </div>
            <div id="modalTableContainer"></div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-success" id="btnDescargarPDF">
              Descargar PDF
            </button>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
          </div>
        </div>
      </div>
    </div>
@stop

@section('css')
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/main.min.css" rel="stylesheet">
@stop

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Gráfico de Barras de citas médicas por mes
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

        // Gráfico de Torta: Distribución de citas por especialidad
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
            .then (data => {
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

        // Gráfico de Barras: Cantidad de citas por día de esta semana (funcional)
        fetch("{{ route('dashboard.citasPorDiaSemana') }}")
            .then(response => response.json())
            .then(data => {
                const canvas = document.getElementById('citasSemanaChart');
                if (!canvas) return;
                const ctx = canvas.getContext('2d');
                new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: data.labels,
                        datasets: [
                            {
                                label: 'Citas agendadas',
                                data: data.data,
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
            });

        // Gráfico de Barras: Top 10 doctores con más consultas pagadas este mes (funcional)
        fetch("{{ route('dashboard.topDoctoresPagadasMes') }}")
            .then(response => response.json())
            .then(data => {
                const ctxTopDoctores = document.getElementById('topDoctoresPagadasChart').getContext('2d');
                new Chart(ctxTopDoctores, {
                    type: 'bar',
                    data: {
                        labels: data.labels,
                        datasets: [{
                            label: 'Consultas pagadas',
                            data: data.data,
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
                                },
                                ticks: {
                                    precision: 0,
                                    callback: function(value) {
                                        return Number.isInteger(value) ? value : '';
                                    }
                                },
                                    stepSize: 1
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

        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('ingresosEspecialidadChart');
            if (!ctx) return;
            new Chart(ctx.getContext('2d'), {
                type: 'bar',
                data: {
                    labels: ['Cardiología', 'Pediatría', 'Dermatología', 'Ginecología', 'Traumatología'],
                    datasets: [
                        {
                            label: 'Ingresos (USD)',
                            data: [12000, 9600, 7800, 5400, 6300],
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
                    plugins: {
                        title: {
                            display: true,
                            text: 'Reporte de Ingresos por Especialidad - Enero-Febrero-Marzo-2025'
                        },
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: 'Ingresos (USD)'
                            }
                        },
                        x: {
                            title: {
                                display: true,
                                text: 'Especialidad'
                            }
                        }
                    }
                }
            });
        });

        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('presupuestoAreasChart');
            if (!ctx) return;
            new Chart(ctx.getContext('2d'), {
                type: 'pie',
                data: {
                    labels: ['Quirófano', 'Urgencias', 'Hospitalización', 'Laboratorio', 'Administración'],
                    datasets: [{
                        data: [55, 20, 15, 7, 3],
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.7)',
                            'rgba(54, 162, 235, 0.7)',
                            'rgba(255, 206, 86, 0.7)',
                            'rgba(75, 192, 192, 0.7)',
                            'rgba(153, 102, 255, 0.7)'
                        ],
                        borderColor: [
                            'rgba(255, 99, 132, 1)',
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 206, 86, 1)',
                            'rgba(75, 192, 192, 1)',
                            'rgba(153, 102, 255, 1)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        title: {
                            display: true,
                            text: 'Distribución del Presupuesto por Área - Total $100,000 - Enero-Febrero-Marzo-2025'
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    const label = context.label || '';
                                    const value = context.parsed;
                                    const monto = Math.round((value / 100) * 100000);
                                    return `${label}: ${value}% ($${monto.toLocaleString()})`;
                                }
                            }
                        },
                        legend: {
                            display: true
                        }
                    }
                }
            });
        });

        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('pacientesEspecialidadChart');
            if (!ctx) return;
            new Chart(ctx.getContext('2d'), {
                type: 'bar',
                data: {
                    labels: ['Cardiología', 'Pediatría', 'Dermatología', 'Ginecología', 'Traumatología'],
                    datasets: [
                        {
                            label: 'Pacientes atendidos',
                            data: [320, 410, 290, 180, 230],
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
                    plugins: {
                        title: {
                            display: true,
                            text: 'Cantidad de pacientes atendidos por especialidad - Enero-Febreo-Marzo-2025'
                        },
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: 'Cantidad de pacientes'
                            }
                        },
                        x: {
                            title: {
                                display: true,
                                text: 'Especialidad'
                            }
                        }
                    }
                }
            });
        });


        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('ingresosServicioChart');
            if (!ctx) return;
            new Chart(ctx.getContext('2d'), {
                type: 'bar',
                data: {
                    labels: ['Ecografías', 'Cirugías', 'Exámenes de sangre', 'Endoscopías'],
                    datasets: [
                        {
                            label: 'Ingresos (USD)',
                            data: [3500, 12000, 2200, 4800],
                            backgroundColor: [
                                'rgba(54, 162, 235, 0.7)',
                                'rgba(255, 99, 132, 0.7)',
                                'rgba(255, 206, 86, 0.7)',
                                'rgba(75, 192, 192, 0.7)'
                            ],
                            borderColor: [
                                'rgba(54, 162, 235, 1)',
                                'rgba(255, 99, 132, 1)',
                                'rgba(255, 206, 86, 1)',
                                'rgba(75, 192, 192, 1)'
                            ],
                            borderWidth: 1
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        title: {
                            display: true,
                            text: 'Reporte de Ingresos por Servicio - Enero-Febrero-Marzo-2025'
                        },
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: 'Ingresos (USD)'
                            }
                        },
                        x: {
                            title: {
                                display: true,
                                text: 'Servicio'
                            }
                        }
                    }
                }
            });
        });

        let modalChartInstance = null;
        function mostrarReporte(canvasId) {
            // Obtener datos del gráfico original
            const originalCanvas = document.getElementById(canvasId);
            if (!originalCanvas) return;
            const chartInstance = Chart.getChart(originalCanvas);
            if (!chartInstance) return;

            // Copiar datos y opciones
            const chartData = JSON.parse(JSON.stringify(chartInstance.data));
            const chartOptions = JSON.parse(JSON.stringify(chartInstance.options));
            const chartType = chartInstance.config.type;

            // Mostrar modal
            const modal = new bootstrap.Modal(document.getElementById('modalReporteGrafica'));
            document.getElementById('modalReporteGraficaLabel').innerText = chartInstance.options.plugins?.title?.text || 'Reporte de Gráfica';

            // Limpiar canvas del modal
            const modalCanvas = document.getElementById('modalChart');
            if (modalChartInstance) {
                modalChartInstance.destroy();
            }
            
            // Crear nueva gráfica en el modal
            modalChartInstance = new Chart(modalCanvas, {
                type: chartType,
                data: chartData,
                options: chartOptions
            });

            // Generar tabla de datos
            let tableHtml = '<div class="table-responsive"><table class="table table-bordered table-sm"><thead><tr>';
            if (chartData.labels && chartData.labels.length > 0) {
                tableHtml += '<th>Etiqueta</th>';
                chartData.datasets.forEach(ds => {

                    if (canvasId !== 'presupuestoAreasChart') {
                        tableHtml += `<th>${ds.label || ''}</th>`;
                    }
                });

                if (canvasId === 'presupuestoAreasChart') {
                    tableHtml += '<th>Porcentaje (%)</th><th>Monto (USD)</th>';
                }
                tableHtml += '</tr></thead><tbody>';
                chartData.labels.forEach((label, i) => {
                    tableHtml += `<tr><td>${label}</td>`;
                    chartData.datasets.forEach(ds => {

                        if (canvasId !== 'presupuestoAreasChart') {
                            tableHtml += `<td>${Array.isArray(ds.data) ? (ds.data[i] ?? '') : ''}</td>`;
                        }
                    });

                    if (canvasId === 'presupuestoAreasChart') {
                        const porcentaje = chartData.datasets[0].data[i];
                        const monto = Math.round((porcentaje / 100) * 100000);
                        tableHtml += `<td>${porcentaje}%</td><td>$${monto.toLocaleString()}</td>`;
                    }
                    tableHtml += '</tr>';
                });
            } else if (chartData.datasets && chartData.datasets.length > 0) {
                // Pie chart u otros sin labels
                tableHtml += '<th>Dato</th></tr></thead><tbody>';
                chartData.datasets.forEach(ds => {
                    (ds.data || []).forEach((d, i) => {
                        tableHtml += `<tr><td>${d}</td></tr>`;
                    });
                });
            }
            tableHtml += '</tbody></table></div>';
            document.getElementById('modalTableContainer').innerHTML = tableHtml;

            modal.show();
        }

        // Descargar PDF del reporte del modal
        document.getElementById('btnDescargarPDF').addEventListener('click', async function() {
            const { jsPDF } = window.jspdf;
            const doc = new jsPDF({ orientation: 'landscape', unit: 'pt', format: 'a4' });
            // Capturar la gráfica
            const chartCanvas = document.getElementById('modalChart');
            const chartImg = chartCanvas.toDataURL('image/png', 1.0);
            const titulo = document.getElementById('modalReporteGraficaLabel').innerText;
            doc.text(titulo, 40, 40);
            doc.addImage(chartImg, 'PNG', 40, 60, 500, 250);
            // Capturar la tabla
            const table = document.getElementById('modalTableContainer');
            await html2canvas(table).then(canvas => {
                const tableImg = canvas.toDataURL('image/png', 1.0);
                doc.addImage(tableImg, 'PNG', 40, 330, 700, 0);
            });
            // Generar nombre de archivo personalizado
            let nombre = titulo.replace(/^reporte de gráfica\s*/i, '').trim();
            nombre = nombre ? `Reporte de grafica ${nombre}.pdf` : 'Reporte de grafica.pdf';
            doc.save(nombre);
        });
    </script>
    <script> console.log("Hi, I'm using the Laravel-AdminLTE package!"); </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
@stop