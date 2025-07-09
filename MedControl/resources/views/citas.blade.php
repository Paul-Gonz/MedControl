@extends('adminlte::page')

@section('content')
<div class="container">
    <h1 class="mb-4">Gestión de Citas</h1>

    {{-- Mensajes de éxito y error --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if($errors->any())
        <div class="alert alert-danger">
            <b>¡Corrige los siguientes errores!</b>
            <ul>
                @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if($mode == 'index')
        <!-- Botón para generar reporte -->
        <button class="btn btn-info mb-3" data-bs-toggle="modal" data-bs-target="#modalReporteCitas">
            Generar Reporte
        </button>

        <!-- Modal para seleccionar el tipo de reporte -->
        <div class="modal fade" id="modalReporteCitas" tabindex="-1" aria-labelledby="modalReporteCitasLabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <form action="{{ route('citas.reporte.pdf') }}" method="GET" target="_blank">
                <div class="modal-header">
                  <h5 class="modal-title" id="modalReporteCitasLabel">Generar Reporte de Citas</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                  <div class="form-check">
                    <input class="form-check-input" type="radio" name="tipo" id="especialidad" value="especialidad" checked>
                    <label class="form-check-label" for="especialidad">Por Especialidad</label>
                  </div>
                  <div class="form-check">
                    <input class="form-check-input" type="radio" name="tipo" id="doctor" value="doctor">
                    <label class="form-check-label" for="doctor">Por Doctor</label>
                  </div>
                </div>
                <div class="modal-footer">
                  <button type="submit" class="btn btn-primary">Generar PDF</button>
                </div>
              </form>
            </div>
          </div>
        </div>
        <a href="{{ route('citas.create') }}" class="btn btn-success mb-3">Nueva Cita</a>
        <!-- Barra de búsqueda -->
        <div class="mb-3">
            <input type="text" id="busquedaCita" class="form-control" placeholder="Buscar por paciente, motivo, estado o ID...">
        </div>
        <table class="table table-bordered table-striped" id="tablaCitas">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Paciente</th>
                    <th>Motivo</th>
                    <th>Inicio</th>
                    <th>Fin</th>
                    <th>Estado</th>
                    <th>Activo</th>
                    <th>Costo</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
            @foreach($citas as $cita)
                <tr>
                    <td>{{ $cita->cita_id }}</td>
                    <td>{{ $cita->paciente->nombre_completo ?? $cita->paciente_id }}</td>
                    <td>{{ $cita->motivo }}</td>
                    <td>{{ $cita->fecha_hora_inicio }}</td>
                    <td>{{ $cita->fecha_hora_fin }}</td>
                    <td>{{ ucfirst($cita->estado_cita) }}</td>
                    <td>{{ $cita->activo_inactivo ? 'Sí' : 'No' }}</td>
                    <td>{{ optional($cita->facturas->first())->subtotal !== null ? '$' . number_format($cita->facturas->first()->subtotal, 2) : '-' }}</td>
                    <td>
                        <a href="{{ route('citas.edit', $cita->cita_id) }}" class="btn btn-primary btn-sm">Editar</a>
                        <form action="{{ route('citas.destroy', $cita->cita_id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            
                        </form>
                        @if($cita->estado_cita !== 'completada')
                            <button type="button" class="btn btn-success btn-sm btn-completar-cita" data-id="{{ $cita->cita_id }}">Completar</button>
                        @endif
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @elseif($mode == 'create' || $mode == 'edit')
        @php
            $isEdit = $mode == 'edit';
        @endphp
        <h2 class="mb-4">{{ $isEdit ? 'Editar Cita' : 'Registrar Nueva Cita' }}</h2>
        <form action="{{ $isEdit ? route('citas.update', $cita->cita_id) : route('citas.store') }}" method="POST">
            @csrf
            @if($isEdit)
                @method('PUT')
            @endif

            <div class="mb-3">
                <label for="paciente_id" class="form-label">Paciente</label>
                <select name="paciente_id" class="form-control select2-paciente" required>
                    <option value="">Seleccione un paciente</option>
                    @foreach($pacientes as $paciente)
                        <option value="{{ $paciente->paciente_id }}" {{ old('paciente_id', $cita->paciente_id ?? '') == $paciente->paciente_id ? 'selected' : '' }}>
                            {{ $paciente->paciente_id }} - {{ $paciente->nombre_completo }} - {{ $paciente->cedula_identidad }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label for="doctor_especialista_id" class="form-label">Doctor Especialista</label>
                <select name="doctor_especialista_id" class="form-control select2-doctor" required>
                    <option value="">Seleccione un doctor</option>
                    @foreach($doctores as $doctor)
                        <option value="{{ $doctor->relacion_id }}" data-costo="{{ $doctor->costo_especialidad ?? '' }}" {{ old('doctor_especialista_id', $cita->doctor_especialista_id ?? '') == $doctor->relacion_id ? 'selected' : '' }}>
                            {{ $doctor->doctor_id }} - {{ $doctor->nombre_completo }} - {{ $doctor->especialidad_nombre }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label for="consultorio_id" class="form-label">Consultorio</label>
                <select name="consultorio_id" class="form-control" required>
                    <option value="">Seleccione un consultorio</option>
                    @foreach($consultorios as $consultorio)
                        <option value="{{ $consultorio->consultorio_id }}" {{ old('consultorio_id', $cita->consultorio_id ?? '') == $consultorio->consultorio_id ? 'selected' : '' }}>
                            {{ $consultorio->consultorio_id }} - {{ $consultorio->nombre_consultorio ?? 'Consultorio' }} - {{ $consultorio->tipoConsultorio->descripcion ?? 'Tipo Sin Describir' }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label for="expediente_id" class="form-label">Expediente</label>
                <select name="expediente_id" class="form-control" required>
                    <option value="">Seleccione un expediente</option>
                    @foreach($expedientes as $expediente)
                        <option value="{{ $expediente->expediente_id }}" {{ old('expediente_id', $cita->expediente_id ?? '') == $expediente->expediente_id ? 'selected' : '' }}>
                            {{ $expediente->expediente_id }} - {{ $expediente->descripcion ?? 'Expediente' }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label for="motivo" class="form-label">Motivo</label>
                <textarea name="motivo" class="form-control" required>{{ old('motivo', $cita->motivo ?? '') }}</textarea>
            </div>
            <div class="mb-3">
                <label for="fecha_hora_inicio" class="form-label">Fecha y hora de inicio</label>
                <input type="datetime-local" name="fecha_hora_inicio" class="form-control"
                  value="{{ old('fecha_hora_inicio', isset($cita) ? \Carbon\Carbon::parse($cita->fecha_hora_inicio)->format('Y-m-d\TH:i') : '') }}" required>
            </div>
            <div class="mb-3">
                <label for="fecha_hora_fin" class="form-label">Fecha y hora de fin</label>
                <input type="datetime-local" name="fecha_hora_fin" class="form-control"
                  value="{{ old('fecha_hora_fin', isset($cita) ? \Carbon\Carbon::parse($cita->fecha_hora_fin)->format('Y-m-d\TH:i') : '') }}" required>
            </div>
            <div class="mb-3">
                <label for="estado_cita" class="form-label">Estado</label>
                <select name="estado_cita" class="form-control" required>
                    @foreach(['programada','completada','cancelada','aplazada'] as $estado)
                        <option value="{{ $estado }}" {{ old('estado_cita', $cita->estado_cita ?? '') == $estado ? 'selected' : '' }}>
                            {{ ucfirst($estado) }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label for="activo_inactivo" class="form-label">Activo</label>
                <select name="activo_inactivo" class="form-control" required>
                    <option value="1" {{ old('activo_inactivo', $cita->activo_inactivo ?? 1) == 1 ? 'selected' : '' }}>Activo</option>
                    <option value="0" {{ old('activo_inactivo', $cita->activo_inactivo ?? 1) == 0 ? 'selected' : '' }}>Inactivo</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="costo" class="form-label">Costo de la Cita en $</label>
                <input type="number" step="0.01" name="costo" class="form-control"
                     value="{{ \App\Http\Controllers\CitaController::COSTO_CITA_FIJO }}" readonly>
            </div>
            <button type="submit" class="btn btn-{{ $isEdit ? 'primary' : 'success' }}">
                {{ $isEdit ? 'Actualizar' : 'Guardar' }}
            </button>
            <a href="{{ route('citas.index') }}" class="btn btn-secondary">Cancelar</a>
        </form>
        <div>
            <p> </p>
        </div>
    @endif
</div>
@endsection

<!-- Bootstrap 5 JS en tu layout principal, antes del cierre de body -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

@section('css')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endsection

@section('js')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        $('.select2-doctor').select2({
            width: '100%',
            placeholder: 'Seleccione un doctor',
            allowClear: true
        });
        $('.select2-paciente').select2({
            width: '100%',
            placeholder: 'Seleccione un paciente',
            allowClear: true
        });
        // Autollenar costo al seleccionar doctor (costo de especialidad)
        $(document).on('change', 'select.select2-doctor', function() {
            var selected = $(this).find('option:selected');
            var costo = selected.data('costo');
            if (costo !== undefined && costo !== '' && costo !== null) {
                $('#costoCita').val(costo);
            }
        });
        // Acción para completar cita
        $(document).on('click', '.btn-completar-cita', function() {
            var btn = $(this);
            var citaId = btn.data('id');
            if(confirm('¿Marcar esta cita como completada?')) {
                $.ajax({
                    url: '/citas/' + citaId + '/completar',
                    type: 'PATCH',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if(response.success) {
                            // Actualizar la celda de estado y ocultar el botón
                            var row = btn.closest('tr');
                            row.find('td:nth-child(6)').text('Completada');
                            btn.remove();
                        } else {
                            alert(response.message || 'No se pudo completar la cita.');
                        }
                    },
                    error: function() {
                        alert('Error al completar la cita.');
                    }
                });
            }
        });
    });
</script>
@push('js')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const input = document.getElementById('busquedaCita');
    const table = document.getElementById('tablaCitas');
    input.addEventListener('keyup', function() {
        const filtro = input.value.toLowerCase();
        for (let row of table.tBodies[0].rows) {
            let texto = row.innerText.toLowerCase();
            row.style.display = texto.includes(filtro) ? '' : 'none';
        }
    });
});
</script>
@endpush
@endsection