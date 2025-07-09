@extends('adminlte::page')

@section('title', 'Libro Mayor')

@section('content_header')
    <h1>Libro Mayor ({{ $cuenta }} - Mes: {{ $mes }})</h1>
@stop

@section('content')
<table class="table table-bordered">
    <thead>
        <tr>
            <th>Fecha</th>
            <th>Descripción</th>
            <th>Debe</th>
            <th>Haber</th>
            <th>Saldo</th>
        </tr>
    </thead>
    <tbody>
        @php $saldo = 0; @endphp
        @foreach($movimientos as $mov)
            @php $saldo += $mov->debe - $mov->haber; @endphp
            <tr>
                <td>{{ $mov->fecha }}</td>
                <td>{{ $mov->descripcion }}</td>
                <td>{{ number_format($mov->debe,2) }}</td>
                <td>{{ number_format($mov->haber,2) }}</td>
                <td>{{ number_format($saldo,2) }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
@stop