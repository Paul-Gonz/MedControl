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
        <!-- Tabla y calendario en la misma fila -->
        <div class="row mt-4">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Tabla de Información de Ejemplo</div>
                    <div class="card-body">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nombre</th>
                                    <th>Email</th>
                                    <th>Estado</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>Juan Pérez</td>
                                    <td>juan@example.com</td>
                                    <td><span class="badge badge-success">Activo</span></td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>María López</td>
                                    <td>maria@example.com</td>
                                    <td><span class="badge badge-warning">Pendiente</span></td>
                                </tr>
                                <tr>
                                    <td>3</td>
                                    <td>Carlos Ruiz</td>
                                    <td>carlos@example.com</td>
                                    <td><span class="badge badge-danger">Inactivo</span></td>
                                </tr>
                            </tbody>
                        </table>
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
        // Gráfico de Barras de ejemplo
        const ctxBar = document.getElementById('barChart').getContext('2d');
        new Chart(ctxBar, {
            type: 'bar',
            data: {
                labels: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo'],
                datasets: [{
                    label: 'Usuarios registrados',
                    data: [12, 19, 3, 5, 2],
                    backgroundColor: 'rgba(54, 162, 235, 0.7)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
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

        // Gráfico de Torta de ejemplo
        const ctxPie = document.getElementById('pieChart').getContext('2d');
        new Chart(ctxPie, {
            type: 'pie',
            data: {
                labels: ['Activos', 'Inactivos', 'Pendientes'],
                datasets: [{
                    label: 'Estado de usuarios',
                    data: [10, 5, 3],
                    backgroundColor: [
                        'rgba(40, 167, 69, 0.7)',
                        'rgba(220, 53, 69, 0.7)',
                        'rgba(255, 193, 7, 0.7)'
                    ],
                    borderColor: [
                        'rgba(40, 167, 69, 1)',
                        'rgba(220, 53, 69, 1)',
                        'rgba(255, 193, 7, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: false,
                maintainAspectRatio: false
            }
        });

        // Calendario de ejemplo con FullCalendar
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');
            if (calendarEl) {
                var calendar = new FullCalendar.Calendar(calendarEl, {
                    initialView: 'dayGridMonth',
                    locale: 'es',
                    height: 500,
                    headerToolbar: {
                        left: 'prev,next today',
                        center: 'title',
                        right: 'dayGridMonth,timeGridWeek,timeGridDay'
                    },
                    events: [
                        {
                            title: 'Cita médica',
                            start: new Date().toISOString().slice(0,10),
                            color: '#28a745'
                        },
                        {
                            title: 'Reunión',
                            start: new Date(new Date().setDate(new Date().getDate() + 3)).toISOString().slice(0,10),
                            color: '#007bff'
                        },
                        {
                            title: 'Vacaciones',
                            start: new Date(new Date().setDate(new Date().getDate() + 7)).toISOString().slice(0,10),
                            color: '#ffc107'
                        }
                    ]
                });
                calendar.render();
            }
        });
    </script>
    <script> console.log("Hi, I'm using the Laravel-AdminLTE package!"); </script>
@stop