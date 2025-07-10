@extends('adminlte::page')

@section('title', 'Registrar Movimiento Contable')

@section('content_header')
    <h1>Registrar Movimiento Contable</h1>
@stop

@section('content')
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('movimientos.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="fecha">Fecha:</label>
            <input type="date" class="form-control" name="fecha" required value="{{ date('Y-m-d') }}">
        </div>
        <div class="form-group">
            <label for="cuenta">Cuenta:</label>
            <select class="form-control" name="cuenta" required>
                <option value="">Seleccione una cuenta</option>
                @foreach($cuentas as $cuenta)
                    <option value="{{ $cuenta->cuenta_id }}">{{ $cuenta->nombre }} ({{ $cuenta->codigo }})</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="descripcion">Descripción:</label>
            <input type="text" class="form-control" name="descripcion" required>
        </div>
        <div class="form-group">
            <label for="debe">Debe:</label>
            <input type="number" step="0.01" class="form-control" name="debe" min="0">
        </div>
        <div class="form-group">
            <label for="haber">Haber:</label>
            <input type="number" step="0.01" class="form-control" name="haber" min="0">
        </div>
        <div class="form-group">
            <label for="referencia">Referencia (opcional):</label>
            <input type="text" class="form-control" name="referencia">
        </div>
        <a href="{{ url('plan-cuentas') }}" class="btn btn-secondary" target="_blank">Agregar nueva cuenta</a>
        <button type="submit" class="btn btn-primary">Registrar Movimiento</button>
    </form>
@stop
