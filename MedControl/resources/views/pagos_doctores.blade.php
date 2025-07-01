@extends('adminlte::page')

@section('title', 'Pagos a Doctores')

@section('content_header')
    <h1>Pagos a Doctores</h1>
@stop

@section('content')
    <div class="mb-3 d-flex justify-content-between align-items-center">
        <a href="{{ route('pagos_doctores.create') }}" class="btn btn-success">Registrar Pago a Doctor</a>
    </div>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <div class="card">
        <div class="card-header">Historial de Pagos</div>
        <div class="card-body p-0">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Doctor</th>
                        <th>Monto</th>
                        <th>Fecha de Pago</th>
                        <th>Método de Pago</th>
                        <th>Observaciones</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pagos as $pago)
                        <tr>
                            <td>{{ $pago->id }}</td>
                            <td>{{ $pago->doctor->nombre ?? '-' }}</td>
                            <td>${{ number_format($pago->monto, 2) }}</td>
                            <td>{{ $pago->fecha_pago }}</td>
                            <td>{{ $pago->metodo_pago }}</td>
                            <td>{{ $pago->observaciones }}</td>
                            <td>
                                <a href="{{ route('pagos_doctores.show', $pago->id) }}" class="btn btn-info btn-sm" title="Ver"><i class="fas fa-eye"></i></a>
                                <a href="{{ route('pagos_doctores.edit', $pago->id) }}" class="btn btn-warning btn-sm" title="Editar"><i class="fas fa-edit"></i></a>
                                <form action="{{ route('pagos_doctores.destroy', $pago->id) }}" method="POST" style="display:inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" title="Eliminar" onclick="return confirm('¿Está seguro de eliminar este pago?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center">No hay pagos registrados.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@stop
