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
        <a href="{{ route('citas.create') }}" class="btn btn-success mb-3">Nueva Cita</a>
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Paciente</th>
                    <th>Motivo</th>
                    <th>Inicio</th>
                    <th>Fin</th>
                    <th>Estado</th>
                    <th>Activo</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
            @foreach($citas as $cita)
                <tr>
                    <td>{{ $cita->cita_id }}</td>
                    <td>{{ $cita->paciente->nombre ?? $cita->paciente_id }}</td>
                    <td>{{ $cita->motivo }}</td>
                    <td>{{ $cita->fecha_hora_inicio }}</td>
                    <td>{{ $cita->fecha_hora_fin }}</td>
                    <td>{{ ucfirst($cita->estado_cita) }}</td>
                    <td>{{ $cita->activo_inactivo ? 'Sí' : 'No' }}</td>
                    <td>
                        <a href="{{ route('citas.edit', $cita->cita_id) }}" class="btn btn-primary btn-sm">Editar</a>
                        <form action="{{ route('citas.destroy', $cita->cita_id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Eliminar esta cita?')">Eliminar</button>
                        </form>
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
                <label for="paciente_id" class="form-label">Paciente (ID)</label>
                <input type="number" name="paciente_id" class="form-control" 
                  value="{{ old('paciente_id', $cita->paciente_id ?? '') }}" required>
            </div>
            <div class="mb-3">
                <label for="doctor_especialista_id" class="form-label">Doctor Especialista (ID)</label>
                <input type="number" name="doctor_especialista_id" class="form-control" 
                  value="{{ old('doctor_especialista_id', $cita->doctor_especialista_id ?? '') }}" required>
            </div>
            <div class="mb-3">
                <label for="consultorio_id" class="form-label">Consultorio (ID)</label>
                <input type="number" name="consultorio_id" class="form-control" 
                  value="{{ old('consultorio_id', $cita->consultorio_id ?? '') }}" required>
            </div>
            <div class="mb-3">
                <label for="expediente_id" class="form-label">Expediente (ID)</label>
                <input type="number" name="expediente_id" class="form-control" 
                  value="{{ old('expediente_id', $cita->expediente_id ?? '') }}" required>
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
            <button type="submit" class="btn btn-{{ $isEdit ? 'primary' : 'success' }}">
                {{ $isEdit ? 'Actualizar' : 'Guardar' }}
            </button>
            <a href="{{ route('citas.index') }}" class="btn btn-secondary">Cancelar</a>
        </form>
    @endif
</div>
@endsection