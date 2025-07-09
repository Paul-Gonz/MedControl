@extends('adminlte::page')

@section('title', 'Libro Diario')

@section('content_header')
    <h1>Libro Diario ({{ $desde }} a {{ $hasta }})</h1>
@stop

@section('content')
<table class="table table-bordered">
    <thead>
        <tr>
            <th>Fecha</th>
            <th>Cuenta</th>
            <th>Descripción</th>
            <th>Debe</th>
            <th>Haber</th>
            <th>Referencia</th>
        </tr>
    </thead>
    <tbody>
        @foreach($movimientos as $mov)
        <tr>
            <td>{{ $mov->fecha }}</td>
            <td>{{ $mov->cuenta }}</td>
            <td>{{ $mov->descripcion }}</td>
            <td>{{ number_format($mov->debe,2) }}</td>
            <td>{{ number_format($mov->haber,2) }}</td>
            <td>{{ $mov->referencia }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
@stop