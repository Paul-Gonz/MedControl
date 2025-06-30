@extends('adminlte::page')

@section('title', 'Doctores')

@section('content_header')
<h1>Doctores</h1>
@stop

@section('content')
<div class="mb-3">
    <!-- Botón para abrir el modal de nuevo doctor -->
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#nuevoDoctorModal">
        Nuevo Doctor
    </button>
</div>

<!-- Modal Nuevo Doctor -->
<div class="modal fade" id="nuevoDoctorModal" tabindex="-1" role="dialog" aria-labelledby="nuevoDoctorModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form action="{{ route('doctores.store') }}" method="POST">
        @csrf
        <div class="modal-header">
          <h5 class="modal-title" id="nuevoDoctorModalLabel">Nuevo Doctor</h5>
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
                        <label>Cédula Profesional</label>
                        <input type="text" class="form-control" name="cedula_profesional">
                    </div>
                    <div class="form-group">
                        <label>Nombre Completo</label>
                        <input type="text" class="form-control" name="nombre_completo" required>
                    </div>
                    <div class="form-group">
                        <label>Honorarios</label>
                        <input type="number" step="0.01" class="form-control" name="honorarios">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Teléfono</label>
                        <input type="text" class="form-control" name="contacto_telefono">
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" class="form-control" name="contacto_email">
                    </div>
                    <div class="form-group">
                        <label>Estado</label>
                        <select class="form-control" name="activo_inactivo" required>
                            <option value="1">Activo</option>
                            <option value="0">Inactivo</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>ID de Cuenta Bancaria</label>
                        <select class="form-control select2" name="cuenta_id" required>
                            <option value="">Seleccione una cuenta</option>
                            @foreach($cuentas_bancarias as $cuenta)
                                <option value="{{ $cuenta->id_cuenta_bancaria }}">{{ $cuenta->id_cuenta_bancaria }} - {{ $cuenta->nombre_titular }} - {{ $cuenta->banco }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Especialidad</label>
                        <select class="form-control select2" name="especialidad_id" required>
                            <option value="">Seleccione una especialidad</option>
                            @foreach($especialidades as $especialidad)
                                <option value="{{ $especialidad->especialidad_id }}">{{ $especialidad->nombre }}</option>
                            @endforeach
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
                    <th>Cédula Identidad</th>
                    <th>Cédula Profesional</th>
                    <th>Nombre Completo</th>
                    <th>Honorarios</th>
                    <th>Teléfono</th>
                    <th>Email</th>
                    <th>Estado</th>
                    <th>Especialidad</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($doctores as $doctor)
                    <tr>
                        <td>{{ $doctor->doctor_id }}</td>
                        <td>{{ $doctor->cedula_identidad }}</td>
                        <td>{{ $doctor->cedula_profesional }}</td>
                        <td>{{ $doctor->nombre_completo }}</td>
                        <td>{{ $doctor->honorarios }}</td>
                        <td>{{ $doctor->contacto_telefono }}</td>
                        <td>{{ $doctor->contacto_email }}</td>
                        <td>
                            @if($doctor->activo_inactivo)
                                <span class="badge badge-success">Activo</span>
                            @else
                                <span class="badge badge-danger">Inactivo</span>
                            @endif
                        </td>
                        <td>{{ $doctor->especialidad_nombre ?? 'Sin asignar' }}</td>
                        <td>
                            <!-- Botón Editar -->
                            <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#editarDoctorModal{{ $doctor->doctor_id }}">
                                Editar
                            </button>
                            <!-- Modal Editar -->
                            <div class="modal fade" id="editarDoctorModal{{ $doctor->doctor_id }}" tabindex="-1" role="dialog" aria-labelledby="editarDoctorModalLabel{{ $doctor->doctor_id }}" aria-hidden="true">
                              <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                  <form action="{{ route('doctores.update', $doctor->doctor_id) }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="doctor_id" value="{{ $doctor->doctor_id }}">
                                    <div class="modal-header">
                                      <h5 class="modal-title" id="editarDoctorModalLabel{{ $doctor->doctor_id }}">Editar Doctor</h5>
                                      <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                                        <span aria-hidden="true">&times;</span>
                                      </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>ID de Cuenta Bancaria</label>
                                                    <select class="form-control select2" name="cuenta_id" required>
                                                        <option value="">Seleccione una cuenta</option>
                                                        @foreach($cuentas_bancarias as $cuenta)
                                                            <option value="{{ $cuenta->id_cuenta_bancaria }}" {{ $doctor->cuenta_id == $cuenta->id_cuenta_bancaria ? 'selected' : '' }}>
                                                                {{ $cuenta->id_cuenta_bancaria }} - {{ $cuenta->nombre_titular }} - {{ $cuenta->banco }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label>Cédula Identidad</label>
                                                    <input type="text" class="form-control" name="cedula_identidad" value="{{ $doctor->cedula_identidad }}" required>
                                                </div>
                                                <div class="form-group">
                                                    <label>Cédula Profesional</label>
                                                    <input type="text" class="form-control" name="cedula_profesional" value="{{ $doctor->cedula_profesional }}" required>
                                                </div>
                                                <div class="form-group">
                                                    <label>Nombre Completo</label>
                                                    <input type="text" class="form-control" name="nombre_completo" value="{{ $doctor->nombre_completo }}" required>
                                                </div>
                                                <div class="form-group">
                                                    <label>Honorarios</label>
                                                    <input type="number" step="0.01" class="form-control" name="honorarios" value="{{ $doctor->honorarios }}">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Teléfono</label>
                                                    <input type="text" class="form-control" name="contacto_telefono" value="{{ $doctor->contacto_telefono }}">
                                                </div>
                                                <div class="form-group">
                                                    <label>Email</label>
                                                    <input type="email" class="form-control" name="contacto_email" value="{{ $doctor->contacto_email }}">
                                                </div>
                                                <div class="form-group">
                                                    <label>Estado</label>
                                                    <select class="form-control" name="activo_inactivo" required>
                                                        <option value="1" {{ $doctor->activo_inactivo ? 'selected' : '' }}>Activo</option>
                                                        <option value="0" {{ !$doctor->activo_inactivo ? 'selected' : '' }}>Inactivo</option>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label>Especialidad</label>
                                                    <select class="form-control select2" name="especialidad_id" required>
                                                        <option value="">Seleccione una especialidad</option>
                                                        @foreach($especialidades as $especialidad)
                                                            <option value="{{ $especialidad->especialidad_id }}" {{ $doctor->especialidad_id == $especialidad->especialidad_id ? 'selected' : '' }}>{{ $especialidad->nombre }}</option>
                                                        @endforeach
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
                            <!-- Botón Eliminar -->
                            <form action="{{ route('doctores.destroy', $doctor->doctor_id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Seguro que deseas eliminar este doctor?')">Eliminar</button>
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
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
{{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@stop

@section('js')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        $('.select2').select2({
            width: '100%',
            placeholder: 'Seleccione una cuenta',
            allowClear: true,
            dropdownParent: $('#nuevoDoctorModal')
        });
        // Para cada modal de editar doctor
        @foreach($doctores as $doctor)
            $('#editarDoctorModal{{ $doctor->doctor_id }} .select2').select2({
                width: '100%',
                placeholder: 'Seleccione una cuenta',
                allowClear: true,
                dropdownParent: $('#editarDoctorModal{{ $doctor->doctor_id }}')
            });
        @endforeach
    });
    console.log("Hi, I'm using the Laravel-AdminLTE package!");
</script>
@stop