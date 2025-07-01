@extends('adminlte::page')

@section('title', 'Libro Mayor')

@section('content_header')
    <h1>Libro Mayor (Mes: {{ $mes }})</h1>
@stop

@section('content')
    <h3>Pagos de Pacientes</h3>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Cuenta</th>
                <th>Monto Total</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Pagos Recibidos</td>
                <td>
                    {{ number_format($pagos->sum('monto'), 2) }}
                </td>
            </tr>
        </tbody>
    </table>

    <h3>Pagos a Doctores</h3>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Cuenta</th>
                <th>Monto Total</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Pagos a Doctores</td>
                <td>
                    {{ number_format($pagos_doctores->sum('monto'), 2) }}
                </td>
            </tr>
        </tbody>
    </table>
@stop