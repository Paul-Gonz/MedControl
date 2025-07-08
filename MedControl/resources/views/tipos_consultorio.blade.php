@extends('adminlte::page')

@section('title', 'Tipos de Consultorios')

@section('content_header')
<h1>Tipos de Consultorios</h1>
@stop

@section('content')
<div class="mb-3 d-flex justify-content-between">
    <a href="{{ route('consultorios.index') }}" class="btn btn-primary">
        Volver a Consultorios
    </a>
    <button type="button" class="btn btn-success" data-toggle="modal" data-target="#nuevoTipoModal">
        Nuevo Tipo de Consultorio
    </button>
</div>

<!-- Modal para un nuevo tipo de consultorio -->
<div class="modal fade" id="nuevoTipoModal" tabindex="-1" role="dialog" aria-labelledby="nuevoTipoModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form action="{{ route('tipos-consultorio.store') }}" method="POST">
        @csrf
        <div class="modal-header">
          <h5 class="modal-title" id="nuevoTipoModalLabel">Nuevo Tipo de Consultorio</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
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

<div class="card">
    <div class="card-body">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Descripción</th>
                    <th>Equipamiento</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($tipos as $tipo)
                    <tr>
                        <td>{{ $tipo->tipo_consultorio_id }}</td>
                        <td>{{ $tipo->descripcion }}</td>
                        <td>{{ $tipo->equipamiento }}</td>
                        <td>
                            @if($tipo->activo_inactivo)
                                <span class="badge badge-success">Activo</span>
                            @else
                                <span class="badge badge-danger">Inactivo</span>
                            @endif
                        </td>
                        <td>
                            @if($tipo->activo_inactivo)
                                <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#editarTipoModal{{ $tipo->tipo_consultorio_id }}">
                                    Editar
                                </button>
                                <!-- Modal para editar -->
                                <div class="modal fade" id="editarTipoModal{{ $tipo->tipo_consultorio_id }}" tabindex="-1" role="dialog" aria-labelledby="editarTipoModalLabel{{ $tipo->tipo_consultorio_id }}" aria-hidden="true">
                                  <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <!-- Usar POST porque así lo definí en la ruta -->
                                      <form action="{{ route('tipos-consultorio.update', $tipo->tipo_consultorio_id) }}" method="POST">
                                        @csrf
                                        <div class="modal-header">
                                          <h5 class="modal-title" id="editarTipoModalLabel{{ $tipo->tipo_consultorio_id }}">Editar Tipo de Consultorio</h5>
                                          <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                                            <span aria-hidden="true">&times;</span>
                                          </button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="form-group">
                                                <label>Descripción</label>
                                                <textarea class="form-control" name="descripcion">{{ $tipo->descripcion }}</textarea>
                                            </div>
                                            <div class="form-group">
                                                <label>Equipamiento</label>
                                                <input type="text" class="form-control" name="equipamiento" value="{{ $tipo->equipamiento }}">
                                            </div>
                                            <div class="form-group">
                                                <label>Estado</label>
                                                <select class="form-control" name="activo_inactivo" required>
                                                    <option value="1" {{ $tipo->activo_inactivo ? 'selected' : '' }}>Activo</option>
                                                    <option value="0" {{ !$tipo->activo_inactivo ? 'selected' : '' }}>Inactivo</option>
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
                                <!-- Botón para eliminar -->
                                <form action="{{ route('tipos-consultorio.destroy', $tipo->tipo_consultorio_id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Seguro que deseas eliminar este tipo de consultorio?')">Eliminar</button>
                                </form>
                            @else
                                <!-- Botón para reingresar -->
                                <form action="{{ route('tipos-consultorio.reingresar', $tipo->tipo_consultorio_id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    <button type="submit" class="btn btn-success btn-sm" onclick="return confirm('¿Seguro que deseas reingresar este tipo de consultorio?')">Reingresar</button>
                                </form>
                            @endif
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
    console.log("Tipos de consultorios");

    // Limpiamos el formulario de "Nuevo tipo de consultoriu"
    $('#nuevoTipoModal').on('hidden.bs.modal', function () {
        $(this).find('form')[0].reset();
    });

    // Limpiar al editar
    $('[id^=editarTipoModal]').on('hidden.bs.modal', function () {
        $(this).find('form')[0].reset();
    });

    // Limpiar al hacer click en "Cancelar"
    $('.modal .btn-secondary').on('click', function () {
        $(this).closest('.modal').find('form')[0].reset();
    });
</script>
@stop