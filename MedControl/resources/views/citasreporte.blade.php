@extends('layouts.app')

@section('content')
<div class="container">
    <h2>{{ $titulo }}</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>{{ $columna }}</th>
                <th>Total de Citas</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($reporte as $row)
                <tr>
                    <td>{{ $row->nombre }}</td>
                    <td>{{ $row->total_citas }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="2">No hay datos para mostrar.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
    <a href="{{ route('citas.index') }}" class="btn btn-secondary">Volver a Citas</a>
</div>
@endsection