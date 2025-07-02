@extends('adminlte::page')

@section('title', 'Expedientes')

@section('content_header')
<h1>Expedientes</h1>
@stop

@section('content')
<div class="mb-3">
    <!-- Botón para abrir el modal de nuevo expediente -->
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#nuevoExpedienteModal">
        Nuevo Expediente
    </button>
</div>

<!-- Modal Nuevo expedient -->
<div class="modal fade" id="nuevoExpedienteModal" tabindex="-1" role="dialog" aria-labelledby="nuevoExpedienteModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form action="{{ route('expedientes.store') }}" method="POST">
        @csrf
        <div class="modal-header">
          <h5 class="modal-title" id="nuevoExpedienteLabel">Nuevo Expediente</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            {{-- Mostrar errores de validación --}}
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Diagnóstico</label>
                        <input type="text" class="form-control" name="diagnostico" value="{{ old('diagnostico') }}" required>
                    </div>
                    <div class="form-group">
                        <label>Tratamiento</label>
                        <input type="text" class="form-control" name="tratamiento" value="{{ old('tratamiento') }}" required>
                    </div>
                    <div class="form-group">
                        <label>Receta</label>
                        <input type="text" class="form-control" name="receta" value="{{ old('receta') }}" required>
                    </div>
                    <div class="form-group">
                        <label>Observaciones</label>
                        <input type="text" class="form-control" name="observaciones" value="{{ old('observaciones') }}">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Fecha Registro</label>
                        <input type="datetime-local" class="form-control" name="fecha_creacion" value="{{ old('fecha_registro') }}" required>
                    </div>
                    <div class="form-group">
                        <label>Fecha Actualización</label>
                        <input type="datetime-local" class="form-control" name="fecha_actualizacion" value="{{ old('fecha_actualizacion') }}">
                    </div>
                    <div class="form-group">
                        <label>Estado</label>
                        <select class="form-control" name="activo_inactivo" required>
                            <option value="">Seleccione...</option>
                            <option value="1" {{ old('activo_inactivo') === '1' ? 'selected' : '' }}>Activo</option>
                            <option value="0" {{ old('activo_inactivo') === '0' ? 'selected' : '' }}>Inactivo</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-success">Guardar</button>
        </div>
      </form>
    </div>
  </div>
</div>

<div class="card">
    <div class="card-body">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>DIAGNOSTICO</th>
                    <th>TRATAMIENTO</th>
                    <th>RECETA</th>
                    <th>OBSERVACIONES</th>
                    <th>FECHA REGISTRO</th>
                    <th>ESTADO</th>
                    <th>ACCIONES</th>
                </tr>
            </thead>
            <tbody>
                @foreach($expedientes as $expediente)
                    <tr>
                        <td>{{ $expediente->expediente_id }}</td>
                        <td>{{ $expediente->diagnostico }}</td>
                        <td>{{ $expediente->tratamiento }}</td>
                        <td>{{ $expediente->receta }}</td>
                        <td>{{ $expediente->observaciones }}</td>
                        <td>{{ $expediente->fecha_registro }}</td>
                        <td>
                            @if($expediente->activo_inactivo)
                                <span class="badge badge-success">Activo</span>
                            @else
                                <span class="badge badge-danger">Inactivo</span>
                            @endif
                        </td>
                        <td>
                            <!-- Botón Editar -->
                            <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#editarExpedienteModal{{ $expediente->expediente_id }}">
                                Editar
                            </button>
                            <!-- Modal Editar -->
                            <div class="modal fade" id="editarExpedienteModal{{ $expediente->expediente_id }}" tabindex="-1" role="dialog" aria-labelledby="editarExpedienteModalLabel{{ $expediente->expediente_id }}" aria-hidden="true">
                              <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                  <form action="{{ route('expedientes.update') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="expediente_id" value="{{ $expediente->expediente_id }}">
                                    <div class="modal-header">
                                      <h5 class="modal-title" id="editarExpedienteModalLabel{{ $expediente->expediente_id }}">Editar Expediente</h5>
                                      <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                                        <span aria-hidden="true">&times;</span>
                                      </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                        <label>Diagnóstico</label>
                        <input type="text" class="form-control" name="diagnostico" value="{{ $expediente->diagnostico }}" required>
                    </div>
                    <div class="form-group">
                        <label>Tratamiento</label>
                        <input type="text" class="form-control" name="tratamiento" value="{{ $expediente->tratamiento }}" required>
                    </div>
                    <div class="form-group">
                        <label>Receta</label>
                        <input type="text" class="form-control" name="receta" value="{{ $expediente->receta }}" required>
                    </div>
                    <div class="form-group">
                        <label>Observaciones</label>
                        <input type="text" class="form-control" name="observaciones" value="{{ $expediente->observaciones }}">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Fecha Registro</label>
                        <input type="datetime-local" class="form-control" name="fecha_creacion" value="{{ $expediente->fecha_creacion }}" required>
                    </div>
                    <div class="form-group">
                        <label>Fecha Actualización</label>
                        <input type="datetime-local" class="form-control" name="fecha_actualizacion" value="{{ $expediente->fecha_actualizacion }}">
                    </div>
                    <div class="form-group">
                        <label>Estado</label>
                        <select class="form-control" name="activo_inactivo" required>
                            <option value="1" {{ $expediente->activo_inactivo ? 'selected' : '' }}>Activo</option>
                            <option value="0" {{ !$expediente->activo_inactivo ? 'selected' : '' }}>Inactivo</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-success">Actualizar</button>
        </div>
      </form>
    </div>
  </div>
</div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@stop

@section('css')
{{-- Add here extra stylesheets --}}
{{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@stop

@section('js')
<script>
    console.log("Hi, I'm using the Laravel-AdminLTE package!");
</script>
@stop