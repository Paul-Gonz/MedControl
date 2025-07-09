@extends('adminlte::page')

@section('title', 'Registrar Gasto')

@section('content_header')
    <h1>Registrar Gasto</h1>
@stop

@section('content')
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('gastos.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="fecha">Fecha:</label>
            <input type="date" class="form-control" name="fecha" required value="{{ date('Y-m-d') }}">
        </div>
        <div class="form-group">
            <label for="cuenta">Cuenta:</label>
            <select class="form-control" name="cuenta" required>
                @foreach($cuentas as $cuenta)
                    <option value="{{ $cuenta }}">{{ $cuenta }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="descripcion">Descripción:</label>
            <input type="text" class="form-control" name="descripcion" required>
        </div>
        <div class="form-group">
            <label for="monto">Monto:</label>
            <input type="number" step="0.01" class="form-control" name="monto" required>
        </div>
        <div class="form-group">
            <label for="referencia">Referencia (opcional):</label>
            <input type="text" class="form-control" name="referencia">
        </div>
        <button type="submit" class="btn btn-primary">Registrar Gasto</button>
    </form>
@stop