@extends('adminlte::page')

@section('title', 'Pacientes')

@section('content_header')
<h1>Pacientes</h1>
@stop

@section('content')
<div class="mb-3">
    <!-- Botón para abrir el modal de nuevo paciente -->
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#nuevoPacienteModal">
        Nuevo Paciente
    </button>
</div>

<!-- Modal Nuevo Paciente -->
<div class="modal fade" id="nuevoPacienteModal" tabindex="-1" role="dialog" aria-labelledby="nuevoPacienteModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form action="{{ route('pacientes.store') }}" method="POST">
        @csrf
        <div class="modal-header">
          <h5 class="modal-title" id="nuevoPacienteModalLabel">Nuevo Paciente</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Cédula Identidad</label>
                        <input type="text" class="form-control" name="cedula_identidad" required>
                    </div>
                    <div class="form-group">
                        <label>Nombre Completo</label>
                        <input type="text" class="form-control" name="nombre_completo" required>
                    </div>
                    <div class="form-group">
                        <label>Fecha Nacimiento</label>
                        <input type="date" class="form-control" name="fecha_nacimiento" required>
                    </div>
                    <div class="form-group">
                        <label>Teléfono</label>
                        <input type="text" class="form-control" name="contacto_telefono">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" class="form-control" name="contacto_email">
                    </div>
                    
                    <div class="form-group">
                        <label>Fecha Registro</label>
                        <input type="datetime-local" class="form-control" name="fecha_registro" required>
                    </div>
                    <div class="form-group">
                        <label>Estado</label>
                        <select class="form-control" name="activo_inactivo" required>
                            <option value="1">Activo</option>
                            <option value="0">Inactivo</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Datos Relevantes</label>
                        <textarea class="form-control" name="datos_relevantes"></textarea>
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
                    <th>Cédula Identidad</th>
                    <th>Nombre Completo</th>
                    <th>Fecha Nacimiento</th>
                    <th>Teléfono</th>
                    <th>Email</th>
                    <th>Datos Relevantes</th>
                    <th>Fecha Registro</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($pacientes as $paciente)
                    <tr>
                        <td>{{ $paciente->paciente_id }}</td>
                        <td>{{ $paciente->cedula_identidad }}</td>
                        <td>{{ $paciente->nombre_completo }}</td>
                        <td>{{ $paciente->fecha_nacimiento }}</td>
                        <td>{{ $paciente->contacto_telefono }}</td>
                        <td>{{ $paciente->contacto_email }}</td>
                        <td>{{ $paciente->datos_relevantes }}</td>
                        <td>{{ $paciente->fecha_registro }}</td>
                        <td>
                            @if($paciente->activo_inactivo)
                                <span class="badge badge-success">Activo</span>
                            @else
                                <span class="badge badge-danger">Inactivo</span>
                            @endif
                        </td>
                        <td>
                            <!-- Botón Editar -->
                            <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#editarPacienteModal{{ $paciente->paciente_id }}">
                                Editar
                            </button>
                            <!-- Modal Editar -->
                            <div class="modal fade" id="editarPacienteModal{{ $paciente->paciente_id }}" tabindex="-1" role="dialog" aria-labelledby="editarPacienteModalLabel{{ $paciente->paciente_id }}" aria-hidden="true">
                              <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                  <form action="{{ route('pacientes.update') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="paciente_id" value="{{ $paciente->paciente_id }}">
                                    <div class="modal-header">
                                      <h5 class="modal-title" id="editarPacienteModalLabel{{ $paciente->paciente_id }}">Editar Paciente</h5>
                                      <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                                        <span aria-hidden="true">&times;</span>
                                      </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Cédula Identidad</label>
                                                    <input type="text" class="form-control" name="cedula_identidad" value="{{ $paciente->cedula_identidad }}" required>
                                                </div>
                                                <div class="form-group">
                                                    <label>Nombre Completo</label>
                                                    <input type="text" class="form-control" name="nombre_completo" value="{{ $paciente->nombre_completo }}" required>
                                                </div>
                                                <div class="form-group">
                                                    <label>Fecha Nacimiento</label>
                                                    <input type="date" class="form-control" name="fecha_nacimiento" value="{{ $paciente->fecha_nacimiento }}" required>
                                                </div>
                                                <div class="form-group">
                                                    <label>Teléfono</label>
                                                    <input type="text" class="form-control" name="contacto_telefono" value="{{ $paciente->contacto_telefono }}">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Email</label>
                                                    <input type="email" class="form-control" name="contacto_email" value="{{ $paciente->contacto_email }}">
                                                </div>
                                                
                                                <div class="form-group">
                                                    <label>Fecha Registro</label>
                                                    <input type="datetime-local" class="form-control" name="fecha_registro" value="{{ \Carbon\Carbon::parse($paciente->fecha_registro)->format('Y-m-d\TH:i') }}" required>
                                                </div>
                                                <div class="form-group">
                                                    <label>Estado</label>
                                                    <select class="form-control" name="activo_inactivo" required>
                                                        <option value="1" {{ $paciente->activo_inactivo ? 'selected' : '' }}>Activo</option>
                                                        <option value="0" {{ !$paciente->activo_inactivo ? 'selected' : '' }}>Inactivo</option>
                                                    </select>
                                                </div>

                                                <div class="form-group">
                                                    <label>Datos Relevantes</label>
                                                    <textarea class="form-control" name="datos_relevantes">{{ $paciente->datos_relevantes }}</textarea>
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
                            <!-- Botón Eliminar -->
                            <form action="{{ route('pacientes.destroy') }}" method="POST" style="display:inline;">
                                @csrf
                                <input type="hidden" name="paciente_id" value="{{ $paciente->paciente_id }}">
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Seguro que deseas eliminar este paciente?')">Eliminar</button>
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
    console.log("Hi, I'm using the Laravel-AdminLTE package!");
</script>
@stop