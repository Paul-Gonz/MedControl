@extends('adminlte::page')

@section('title', 'Editar Cuenta')

@section('content_header')
    <h1>Editar Cuenta</h1>
@stop

@section('content')
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <form action="{{ route('plan-cuentas.update', $cuenta->cuenta_id) }}" method="POST" class="mb-4">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="codigo">Código:</label>
            <input type="text" class="form-control" name="codigo" required value="{{ $cuenta->codigo }}">
        </div>
        <div class="form-group">
            <label for="nombre">Nombre:</label>
            <input type="text" class="form-control" name="nombre" required value="{{ $cuenta->nombre }}">
        </div>
        <div class="form-group">
            <label for="tipo">Tipo:</label>
            <select class="form-control" name="tipo" required>
                <option value="activo" @if($cuenta->tipo=='activo') selected @endif>Activo</option>
                <option value="pasivo" @if($cuenta->tipo=='pasivo') selected @endif>Pasivo</option>
                <option value="capital" @if($cuenta->tipo=='capital') selected @endif>Capital</option>
                <option value="ingreso" @if($cuenta->tipo=='ingreso') selected @endif>Ingreso</option>
                <option value="egreso" @if($cuenta->tipo=='egreso') selected @endif>Egreso</option>
                <option value="gasto" @if($cuenta->tipo=='gasto') selected @endif>Gasto</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Actualizar Cuenta</button>
        <a href="{{ route('plan-cuentas.index') }}" class="btn btn-secondary">Volver</a>
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
            @foreach($cuentas as $c)
                <tr>
                    <td>{{ $c->codigo }}</td>
                    <td>{{ $c->nombre }}</td>
                    <td>{{ $c->tipo }}</td>
                    <td>
                        <a href="{{ route('plan-cuentas.edit', $c->cuenta_id) }}" class="btn btn-sm btn-warning">Editar</a>
                        <form action="{{ route('plan-cuentas.destroy', $c->cuenta_id) }}" method="POST" style="display:inline-block;">
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
