@extends('adminlte::page')

@section('title', 'Libro Diario')

@section('content_header')
    <h1>Libro Diario ({{ $desde }} a {{ $hasta }})</h1>
@stop

@section('content')
    <h3>Pagos de Pacientes</h3>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Fecha</th>
                <th>Monto</th>
                <th>Método</th>
                <th>Referencia</th>
            </tr>
        </thead>
        <tbody>
            @forelse($pagos as $pago)
                <tr>
                    <td>{{ $pago->fecha_pago }}</td>
                    <td>{{ $pago->monto }}</td>
                    <td>{{ $pago->metodo_pago }}</td>
                    <td>{{ $pago->numero_referencia }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center">No hay pagos registrados.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <h3>Pagos a Doctores</h3>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Fecha</th>
                <th>Doctor</th>
                <th>Monto</th>
                <th>Método</th>
            </tr>
        </thead>
        <tbody>
            @forelse($pagos_doctores as $pago)
                <tr>
                    <td>{{ $pago->fecha_pago }}</td>
                    <td>{{ $pago->doctor->nombre ?? '-' }}</td>
                    <td>{{ $pago->monto }}</td>
                    <td>{{ $pago->metodo_pago }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center">No hay pagos a doctores registrados.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
@stop