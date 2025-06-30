@extends('adminlte::page')

@section('title', 'Consultorios')

@section('content_header')
<h1>Consultorios</h1>
@stop

@section('content')
<div class="mb-3 d-flex justify-content-between">
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#nuevoConsultorioModal">
        Nuevo Consultorio
    </button>
    <a href="{{ route('tipos-consultorio.index') }}" class="btn btn-success">
        Tipos de consultorios
    </a>
</div>

<div class="modal fade" id="nuevoTipoModal" tabindex="-1" role="dialog" aria-labelledby="nuevoTipoModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form action="{{ route('tipos-consultorio.store') }}" method="POST">
        @csrf
        <div class="modal-header">
          <h5 class="modal-title" id="nuevoTipoModalLabel">Nuevo tipo de consultorio</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <div class="form-group">
                <label>Nombre del consultorio</label>
                <input type="text" class="form-control" name="nombre_consultorio" required>
            </div>
            <div class="form-group">
                <label>Descripción</label>
                <textarea class="form-control" name="descripcion"></textarea>
            </div>
            <div class="form-group">
                <label>Equipamiento</label>
                <input type="text" class="form-control" name="equipamiento">
            </div>
            <div class="form-group">
                <label>Estado</label>
                <select class="form-control" name="activo_inactivo" required>
                    <option value="1">Activo</option>
                    <option value="0">Inactivo</option>
                </select>
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

<!-- Modal nuevo consultorio -->
<div class="modal fade" id="nuevoConsultorioModal" tabindex="-1" role="dialog" aria-labelledby="nuevoConsultorioModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form action="{{ route('consultorios.store') }}" method="POST">
        @csrf
        <div class="modal-header">
          <h5 class="modal-title" id="nuevoConsultorioModalLabel">Nuevo Consultorio</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <div class="form-group">
                <label>Nombre del Consultorio</label>
                <input type="text" class="form-control" name="nombre_consultorio" required>
            </div>
            <div class="form-group">
                <label>Tipo de Consultorio</label>
                <select class="form-control" name="tipo_id" id="tipo_id" required>
                    <option value="">Seleccione un tipo</option>
                    @foreach($tiposConsultorio as $tipo)
                        <option 
                            value="{{ $tipo->tipo_consultorio_id }}"
                            data-descripcion="{{ $tipo->descripcion }}"
                            data-equipamiento="{{ $tipo->equipamiento }}"
                        >
                            {{ $tipo->tipo_consultorio_id }} - {{ $tipo->descripcion }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label>Descripción</label>
                <textarea class="form-control" id="descripcion_tipo" readonly></textarea>
            </div>
            <div class="form-group">
                <label>Equipamiento</label>
                <input type="text" class="form-control" id="equipamiento_tipo" readonly>
            </div>
            <div class="form-group">
                <label>Ubicación</label>
                <input type="text" class="form-control" name="ubicacion" required>
            </div>
            <div class="form-group">
                <label>Estado del Consultorio</label>
                <select class="form-control" name="estado_consultorio" required>
                    <option value="disponible">Disponible</option>
                    <option value="en_mantenimiento">En Mantenimiento</option>
                    <option value="no_disponible">No Disponible</option>
                </select>
            </div>
            <div class="form-group">
                <label>Estado</label>
                <select class="form-control" name="activo_inactivo" required>
                    <option value="1">Activo</option>
                    <option value="0">Inactivo</option>
                </select>
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
                    <th>Nombre del Consultorio</th>
                    <th>Tipo de Consultorio</th>
                    <th>Ubicación</th>
                    <th>Estado del Consultorio</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($consultorios as $consultorio)
                    <tr>
                        <td>{{ $consultorio->consultorio_id }}</td>
                        <td>{{ $consultorio->nombre_consultorio }}</td>
                        <td>{{ $consultorio->tipoConsultorio->tipo_consultorio_id ?? '' }} - {{ $consultorio->tipoConsultorio->descripcion ?? '' }}</td>
                        <td>{{ $consultorio->ubicacion }}</td>
                        <td>{{ ucfirst(str_replace('_', ' ', $consultorio->estado_consultorio)) }}</td>
                        <td>
                            @if($consultorio->activo_inactivo)
                                <span class="badge badge-success">Activo</span>
                            @else
                                <span class="badge badge-danger">Inactivo</span>
                            @endif
                        </td>
                        <td>
                            <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#editarConsultorioModal{{ $consultorio->consultorio_id }}">
                                Editar
                            </button>
                            <!-- Modal Editar -->
                            <div class="modal fade" id="editarConsultorioModal{{ $consultorio->consultorio_id }}" tabindex="-1" role="dialog" aria-labelledby="editarConsultorioModalLabel{{ $consultorio->consultorio_id }}" aria-hidden="true">
                              <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                  <form action="{{ route('consultorios.update', $consultorio->consultorio_id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="modal-header">
                                      <h5 class="modal-title" id="editarConsultorioModalLabel{{ $consultorio->consultorio_id }}">Editar Consultorio</h5>
                                      <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                                        <span aria-hidden="true">&times;</span>
                                      </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label>Nombre del Consultorio</label>
                                            <input type="text" class="form-control" name="nombre_consultorio" value="{{ $consultorio->nombre_consultorio }}" required>
                                        </div>
                                        <div class="form-group">
                                            <label>Tipo de Consultorio</label>
                                            <select class="form-control" name="tipo_id" required>
                                                @foreach($tiposConsultorio as $tipo)
                                                    <option value="{{ $tipo->tipo_consultorio_id }}" {{ $consultorio->tipo_id == $tipo->tipo_consultorio_id ? 'selected' : '' }}>
                                                        {{ $tipo->tipo_consultorio_id }} - {{ $tipo->descripcion }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>Ubicación</label>
                                            <input type="text" class="form-control" name="ubicacion" value="{{ $consultorio->ubicacion }}" required>
                                        </div>
                                        <div class="form-group">
                                            <label>Estado del Consultorio</label>
                                            <select class="form-control" name="estado_consultorio" required>
                                                <option value="disponible" {{ $consultorio->estado_consultorio == 'disponible' ? 'selected' : '' }}>Disponible</option>
                                                <option value="en_mantenimiento" {{ $consultorio->estado_consultorio == 'en_mantenimiento' ? 'selected' : '' }}>En Mantenimiento</option>
                                                <option value="no_disponible" {{ $consultorio->estado_consultorio == 'no_disponible' ? 'selected' : '' }}>No Disponible</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>Estado</label>
                                            <select class="form-control" name="activo_inactivo" required>
                                                <option value="1" {{ $consultorio->activo_inactivo ? 'selected' : '' }}>Activo</option>
                                                <option value="0" {{ !$consultorio->activo_inactivo ? 'selected' : '' }}>Inactivo</option>
                                            </select>
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
                            <form action="{{ route('consultorios.destroy', $consultorio->consultorio_id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Seguro que deseas eliminar este consultorio?')">Eliminar</button>
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
{{-- Add here extra stylesheets --}}
{{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@stop

@section('js')
<script>
    // Cuando se cambia el tipo de consultorio, actualiza descripción y equipamiento
    document.addEventListener('DOMContentLoaded', function () {
        const tipoSelect = document.getElementById('tipo_id');
        const descripcion = document.getElementById('descripcion_tipo');
        const equipamiento = document.getElementById('equipamiento_tipo');

        tipoSelect.addEventListener('change', function () {
            const selected = tipoSelect.options[tipoSelect.selectedIndex];
            descripcion.value = selected.getAttribute('data-descripcion') || '';
            equipamiento.value = selected.getAttribute('data-equipamiento') || '';
        });
    });
</script>
@stop