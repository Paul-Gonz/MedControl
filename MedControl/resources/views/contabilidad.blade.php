@extends('adminlte::page')

@section('title', 'Contabilidad')

@section('content_header')
    <h1>Pagos y Facturación</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-md-6">
            <form action="{{ route('contabilidad.libro_diario') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label>Desde</label>
                    <input type="date" name="desde" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Hasta</label>
                    <input type="date" name="hasta" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary">Generar Libro Diario</button>
            </form>
        </div>
        <div class="col-md-6">
            <form action="{{ route('contabilidad.libro_mayor') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label>Mes</label>
                    <input type="month" name="mes" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-success">Generar Libro Mayor</button>
            </form>
        </div>
    </div>
@stop