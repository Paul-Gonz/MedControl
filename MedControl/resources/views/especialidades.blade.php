@extends('adminlte::page')

@section('title', 'Especialidades')

@section('content_header')
<h1>Especialidades</h1>
@stop

@section('content')
<div class="mb-3">
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#nuevaEspecialidadModal">
        Nueva Especialidad
    </button>
</div>

<!-- Modal Nueva Especialidad -->
<div class="modal fade" id="nuevaEspecialidadModal" tabindex="-1" role="dialog" aria-labelledby="nuevaEspecialidadModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form action="{{ route('especialidades.store') }}" method="POST">
        @csrf
        <div class="modal-header">
          <h5 class="modal-title" id="nuevaEspecialidadModalLabel">Nueva Especialidad</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <div class="form-group">
                <label>Nombre</label>
                <input type="text" class="form-control" name="nombre" required>
            </div>
            <div class="form-group">
                <label>Descripción</label>
                <textarea class="form-control" name="descripcion"></textarea>
            </div>
            <div class="form-group">
                <label>Estado</label>
                <select class="form-control" name="activo_inactivo" required>
                    <option value="1">Activo</option>
                    <option value="0">Inactivo</option>
                </select>
            </div>
            <div class="form-group">
                <label>Costo de la Especialidad ($)</label>
                <input type="number" step="0.01" class="form-control" name="costo_especialidad" required>
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
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Estado</th>
                    <th>Costo</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($especialidades as $especialidad)
                    <tr>
                        <td>{{ $especialidad->especialidad_id }}</td>
                        <td>{{ $especialidad->nombre }}</td>
                        <td>{{ $especialidad->descripcion }}</td>
                        <td>
                            @if($especialidad->activo_inactivo)
                                <span class="badge badge-success">Activo</span>
                            @else
                                <span class="badge badge-danger">Inactivo</span>
                            @endif
                        </td>
                        <td>{{ number_format($especialidad->costo_especialidad, 2) }}</td>
                        <td>

                            <!-- Botón Editar -->
                            <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#editarEspecialidadModal{{ $especialidad->especialidad_id }}">
                                Editar
                            </button>
                            <!-- Modal Editar -->
                            <div class="modal fade" id="editarEspecialidadModal{{ $especialidad->especialidad_id }}" tabindex="-1" role="dialog" aria-labelledby="editarEspecialidadModalLabel{{ $especialidad->especialidad_id }}" aria-hidden="true">
                              <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                  <form action="{{ route('especialidades.update') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="especialidad_id" value="{{ $especialidad->especialidad_id }}">
                                    <div class="modal-header">
                                      <h5 class="modal-title" id="editarEspecialidadModalLabel{{ $especialidad->especialidad_id }}">Editar Especialidad</h5>
                                      <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                                        <span aria-hidden="true">&times;</span>
                                      </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label>Nombre</label>
                                            <input type="text" class="form-control" name="nombre" value="{{ $especialidad->nombre }}" required>
                                        </div>
                                        <div class="form-group">
                                            <label>Descripción</label>
                                            <textarea class="form-control" name="descripcion">{{ $especialidad->descripcion }}</textarea>
                                        </div>
                                        <div class="form-group">
                                            <label>Estado</label>
                                            <select class="form-control" name="activo_inactivo" required>
                                                <option value="1" {{ $especialidad->activo_inactivo ? 'selected' : '' }}>Activo</option>
                                                <option value="0" {{ !$especialidad->activo_inactivo ? 'selected' : '' }}>Inactivo</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>Costo de la Especialidad ($)</label>
                                            <input type="number" step="0.01" class="form-control" name="costo_especialidad" value="{{ $especialidad->costo_especialidad }}" required>
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
                            <!-- Botón Eliminar -->
                            <form action="{{ route('especialidades.destroy') }}" method="POST" style="display:inline;">
                                @csrf
                                <input type="hidden" name="especialidad_id" value="{{ $especialidad->especialidad_id }}">
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Seguro que deseas eliminar esta especialidad?')">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@stop

@section('css')
{{-- Aquí puedes agregar hojas de estilo adicionales --}}
@stop

@section('js')
<script>
    console.log("Vista de Especialidades cargada.");
</script>
@stop