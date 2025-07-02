@extends('adminlte::page')

@section('title', 'Usuarios')

@section('content_header')
<h1>Usuarios</h1>
@stop

@section('content')
<div class="mb-3">
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#nuevoUsuarioModal">
        Nuevo Usuario
    </button>
</div>

<!-- Modal Nuevo Usuario -->
<div class="modal fade" id="nuevoUsuarioModal" tabindex="-1" role="dialog" aria-labelledby="nuevoUsuarioModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form action="{{ route('usuarios.store') }}" method="POST">
        @csrf
        <div class="modal-header">
          <h5 class="modal-title" id="nuevoUsuarioModalLabel">Nuevo Usuario</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Usuario</label>
                        <input type="text" class="form-control" name="usuario" required>
                    </div>
                    <div class="form-group">
                        <label>Clave</label>
                        <input type="password" class="form-control" name="clave" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Nombre Asignado</label>
                        <input type="text" class="form-control" name="nombre_asignado" required>
                    </div>
                    <div class="form-group">
                        <label>Cédula Asignado</label>
                        <input type="text" class="form-control" name="cedula_asignado" required>
                    </div>
                    <div class="form-group">
                        <label>¿Es administrador?</label><br>
                        <input type="checkbox" name="admin" value="1">
                        <span>Administrador</span>
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
                    <th>Usuario ID</th>
                    <th>Usuario</th>
                    <th>Nombre Asignado</th>
                    <th>Cédula Asignado</th>
                    <th>Rol</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($usuarios as $usuario)
                    <tr>
                        <td>{{ $usuario->usuario_id }}</td>
                        <td>{{ $usuario->usuario }}</td>
                        <td>{{ $usuario->nombre_asignado }}</td>
                        <td>{{ $usuario->cedula_asignado }}</td>
                        <td>
                            @if($usuario->admin)
                                <span class="badge badge-danger">Administrador</span>
                            @else
                                <span class="badge badge-primary">Usuario Normal</span>
                            @endif
                        </td>
                        <td>
                            <!-- Botón Editar -->
                            <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#editarUsuarioModal{{ $usuario->usuario_id }}">
                                Editar
                            </button>
                            <!-- Modal Editar -->
                            <div class="modal fade" id="editarUsuarioModal{{ $usuario->usuario_id }}" tabindex="-1" role="dialog" aria-labelledby="editarUsuarioModalLabel{{ $usuario->usuario_id }}" aria-hidden="true">
                              <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                  <form action="{{ route('usuarios.update', $usuario->usuario_id) }}" method="POST">
                                    @csrf
                                    @method('POST')
                                    <div class="modal-header">
                                      <h5 class="modal-title" id="editarUsuarioModalLabel{{ $usuario->usuario_id }}">Editar Usuario</h5>
                                      <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                                        <span aria-hidden="true">&times;</span>
                                      </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Usuario</label>
                                                    <input type="text" class="form-control" name="usuario" value="{{ $usuario->usuario }}" required>
                                                </div>
                                                <div class="form-group">
                                                    <label>Clave</label>
                                                    <input type="password" class="form-control" name="clave" placeholder="Dejar en blanco para no cambiar">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Nombre Asignado</label>
                                                    <input type="text" class="form-control" name="nombre_asignado" value="{{ $usuario->nombre_asignado }}" required>
                                                </div>
                                                <div class="form-group">
                                                    <label>Cédula Asignado</label>
                                                    <input type="text" class="form-control" name="cedula_asignado" value="{{ $usuario->cedula_asignado }}" required>
                                                </div>
                                                <div class="form-group">
                                                    <label>¿Es administrador?</label><br>
                                                    <input type="checkbox" name="admin" value="1" {{ $usuario->admin ? 'checked' : '' }}>
                                                    <span>Administrador</span>
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
@stop

@section('js')
<script>
    console.log("CRUD de usuarios cargado!");
</script>
@stop