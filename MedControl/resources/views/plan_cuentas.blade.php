@extends('adminlte::page')

@section('title', 'Plan de Cuentas')

@section('content_header')
    <h1>Registrar Nueva Cuenta</h1>
@stop

@section('content')
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <form action="{{ route('plan-cuentas.store') }}" method="POST" class="mb-4">
        @csrf
        <div class="form-group">
            <label for="codigo">Código:</label>
            <input type="text" class="form-control" name="codigo" required>
        </div>
        <div class="form-group">
            <label for="nombre">Nombre:</label>
            <input type="text" class="form-control" name="nombre" required>
        </div>
        <div class="form-group">
            <label for="tipo">Tipo:</label>
            <select class="form-control" name="tipo" required>
                <option value="activo">Activo</option>
                <option value="pasivo">Pasivo</option>
                <option value="capital">Capital</option>
                <option value="ingreso">Ingreso</option>
                <option value="egreso">Egreso</option>
                <option value="gasto">Gasto</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Registrar Cuenta</button>
    </form>

    <h3>Listado de Cuentas</h3>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Código</th>
                <th>Nombre</th>
                <th>Tipo</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($cuentas as $cuenta)
                <tr>
                    <td>{{ $cuenta->codigo }}</td>
                    <td>{{ $cuenta->nombre }}</td>
                    <td>{{ $cuenta->tipo }}</td>
                    <td>
                        <a href="{{ route('plan-cuentas.edit', $cuenta->cuenta_id) }}" class="btn btn-sm btn-warning">Editar</a>
                        <form action="{{ route('plan-cuentas.destroy', $cuenta->cuenta_id) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('¿Seguro que deseas eliminar esta cuenta?')">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@stop
