@extends('adminlte::page')

@section('title', 'Contabilidad')

@section('content_header')
    <h1>Pagos y Facturación</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-md-6 d-flex align-items-end">
            <form action="{{ route('contabilidad.libro_diario') }}" method="POST" class="w-100 me-2">
                @csrf
                <div class="form-group">
                    <label>Desde</label>
                    <input type="date" name="desde" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Hasta</label>
                    <input type="date" name="hasta" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary w-100">Generar Libro Diario</button>
            </form>
        </div>
        <div class="col-md-6 d-flex align-items-end">
            <form action="{{ route('contabilidad.libro_mayor') }}" method="POST" class="w-100 ms-2">
                @csrf
                <div class="form-group">
                    <label>Mes</label>
                    <input type="month" name="mes" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-success w-100">Generar Libro Mayor</button>
            </form>
        </div>
    </div>
    <div> 
        <p></p>
    </div>
     <div class="row mb-4">
        <div class="col-md-12">
            <div class="card mb-4">
                <div class="card-header">Ingresos y Egresos Mensuales</div>
                <div class="card-body d-flex justify-content-center align-items-center" style="height:320px;">
                    <canvas id="ingresosChart" style="width:100%;max-width:1000px;max-height:300px;"></canvas>
                </div>
            </div>
        </div>
    </div>
@stop

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
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
    </script>
@stop