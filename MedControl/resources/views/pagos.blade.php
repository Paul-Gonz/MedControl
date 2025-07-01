@extends('adminlte::page')

@section('content')
<div class="container">
    <h1 class="mb-4">Gestión de Pagos</h1>

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
        <!-- Botón para abrir el modal de nuevo pago -->
        <button type="button" class="btn btn-success mb-3" data-toggle="modal" data-target="#nuevoPagoModal">
            Nuevo Pago
        </button>
        <!-- Modal de Nuevo Pago -->
        <div class="modal fade" id="nuevoPagoModal" tabindex="-1" aria-labelledby="nuevoPagoModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="nuevoPagoModalLabel">Registrar Nuevo Pago</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="nuevoPagoForm" action="{{ route('pagos.store') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="factura_id" class="form-label">Factura</label>
                                <input type="text" id="busqueda-factura" class="form-control mb-2" placeholder="Buscar por paciente, doctor, especialidad, cédula o fecha...">
                                <!-- Lista estática de facturas -->
                                <div id="factura-lista" style="max-height: 250px; overflow-y: auto; border: 1px solid #ccc; border-radius: 4px;">
                                    @foreach($facturas as $factura)
                                        @php
                                            $cita = $factura->cita;
                                            $paciente = $cita && isset($cita->paciente) ? $cita->paciente : null;
                                            $doctorEsp = $cita && isset($cita->doctorPorEspecialidad) ? $cita->doctorPorEspecialidad : null;
                                            $doctor = $doctorEsp && isset($doctorEsp->doctor) ? $doctorEsp->doctor : null;
                                            $especialidad = $doctorEsp && isset($doctorEsp->especialidad) ? $doctorEsp->especialidad : null;
                                            $nombrePaciente = $paciente ? $paciente->nombre_completo : 'No asignado';
                                            $cedulaPaciente = $paciente && $paciente->cedula_identidad ? $paciente->cedula_identidad : 'No asignado';
                                            $nombreDoctor = $doctor ? $doctor->nombre_completo : 'No asignado';
                                            $nombreEspecialidad = $especialidad ? $especialidad->nombre : 'No asignada';
                                            $fechaCita = $cita ? $cita->fecha_hora_inicio : 'No asignado';
                                            $montoFactura = isset($factura->total) ? number_format((float)$factura->total, 2, '.', '') : '';
                                            $busqueda = "Cita #{$cita->cita_id} {$nombrePaciente} {$cedulaPaciente} {$nombreDoctor} {$nombreEspecialidad} {$fechaCita}";
                                        @endphp
                                        <div class="factura-item p-2 border-bottom" style="cursor:pointer;" data-id="{{ $factura->factura_id }}"
                                            data-monto="{{ $montoFactura }}"
                                            data-cita-id="{{ $cita ? $cita->cita_id : '' }}"
                                            data-doctor="{{ $nombreDoctor }}"
                                            data-especialidad="{{ $nombreEspecialidad }}"
                                            data-paciente="{{ $nombrePaciente }}"
                                            data-cedula="{{ $cedulaPaciente }}"
                                            data-inicio="{{ $cita ? $cita->fecha_hora_inicio : '' }}"
                                            data-fin="{{ $cita ? $cita->fecha_hora_fin : '' }}"
                                            data-fecha="{{ $cita ? $cita->fecha_hora_inicio : '' }}"
                                            data-busqueda="{{ strtolower($busqueda) }}"
                                            onclick="seleccionarFactura('{{ $factura->factura_id }}', this)">
                                            <b>Cita #{{ $cita ? $cita->cita_id : 'N/A' }}</b> - Paciente: {{ $nombrePaciente }} - Cédula: {{ $cedulaPaciente }}<br>
                                            Doctor: {{ $nombreDoctor }} - Especialidad: {{ $nombreEspecialidad }}<br>
                                            Fecha: {{ $fechaCita }}<br>
                                        </div>
                                    @endforeach
                                </div>
                                <input type="hidden" name="factura_id" id="factura_id_hidden" required>
                            </div>
                            <!-- Información de la factura/cita seleccionada -->
                            <div id="info-cita" class="mb-3" style="display:none;">
                                <div><b>ID Cita:</b> <span id="info-cita-id"></span></div>
                                <div><b>Doctor:</b> <span id="info-doctor"></span></div>
                                <div><b>Especialidad:</b> <span id="info-especialidad"></span></div>
                                <div><b>Paciente:</b> <span id="info-paciente"></span></div>
                                <div><b>Cédula:</b> <span id="info-cedula"></span></div>
                                <div><b>Inicio:</b> <span id="info-inicio"></span></div>
                                <div><b>Fin:</b> <span id="info-fin"></span></div>
                            </div>
                            <div class="mb-3">
                                <label for="monto" class="form-label">Monto</label>
                                <div id="monto_pago_texto" class="form-control bg-light" style="height:auto; min-height:38px;">Seleccione una factura</div>
                                <input type="hidden" step="0.01" name="monto" id="monto_pago" required value="">
                            </div>
                            <div class="mb-3">
                                <label for="metodo_pago" class="form-label">Método de Pago</label>
                                <select name="metodo_pago" class="form-control" required>
                                    <option value="efectivo">Efectivo</option>
                                    <option value="tarjeta">Tarjeta</option>
                                    <option value="transferencia">Transferencia</option>
                                    <option value="cheque">Cheque</option>
                                    <option value="otro">Otro</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="fecha_pago" class="form-label">Fecha de Pago</label>
                                <input type="datetime-local" name="fecha_pago" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="numero_referencia" class="form-label">Número de Referencia</label>
                                <input type="text" name="numero_referencia" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="activo_inactivo" class="form-label">Activo</label>
                                <select name="activo_inactivo" class="form-control" required>
                                    <option value="1">Activo</option>
                                    <option value="0">Inactivo</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-success">Guardar</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Factura</th>
                    <th>Método</th>
                    <th>Monto</th>
                    <th>Fecha</th>
                    <th>Referencia</th>
                    <th>Activo</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
            @foreach($pagos as $pago)
                <tr>
                    <td>{{ $pago->pago_id }}</td>
                    <td>{{ $pago->factura_id }}</td>
                    <td>{{ ucfirst($pago->metodo_pago) }}</td>
                    <td>{{ $pago->monto }}</td>
                    <td>{{ $pago->fecha_pago }}</td>
                    <td>{{ $pago->numero_referencia }}</td>
                    <td>{{ $pago->activo_inactivo ? 'Sí' : 'No' }}</td>
                    <td>
                        <a href="{{ route('pagos.edit', $pago->pago_id) }}" class="btn btn-primary btn-sm">Editar</a>
                        <form action="{{ route('pagos.destroy', $pago->pago_id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Eliminar este pago?')">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @elseif($mode == 'create' || $mode == 'edit')
        @php $isEdit = $mode == 'edit'; @endphp
        <h2 class="mb-4">{{ $isEdit ? 'Editar Pago' : 'Registrar Nuevo Pago' }}</h2>
        <form action="{{ $isEdit ? route('pagos.update', $pago->pago_id) : route('pagos.store') }}" method="POST">
            @csrf
            @if($isEdit)
                @method('PUT')
            @endif
            <div class="mb-3">
                <label for="factura_id" class="form-label">Factura</label>
                <select name="factura_id" class="form-control" id="factura_id_select_edit" required>
                    <option value="">Seleccione una factura</option>
                    @foreach($facturas as $factura)
                        @php
                            $cita = $factura->cita;
                            $paciente = $cita && isset($cita->paciente) ? $cita->paciente : null;
                            $doctorEsp = $cita && isset($cita->doctorPorEspecialidad) ? $cita->doctorPorEspecialidad : null;
                            $doctor = $doctorEsp && isset($doctorEsp->doctor) ? $doctorEsp->doctor : null;
                            $especialidad = $doctorEsp && isset($doctorEsp->especialidad) ? $doctorEsp->especialidad : null;
                            $nombrePaciente = $paciente ? $paciente->nombre_completo : 'No asignado';
                            $cedulaPaciente = $paciente && $paciente->cedula_identidad ? $paciente->cedula_identidad : 'No asignado';
                            $nombreDoctor = $doctor ? $doctor->nombre_completo : 'No asignado';
                            $nombreEspecialidad = $especialidad ? $especialidad->nombre : 'No asignada';
                            $fechaCita = $cita ? $cita->fecha_hora_inicio : 'No asignado';
                        @endphp
                        <option value="{{ $factura->factura_id }}" {{ old('factura_id', $pago->factura_id ?? '') == $factura->factura_id ? 'selected' : '' }}
                            data-factura-id="{{ $factura->factura_id }}"
                            data-monto="{{ $factura->monto ?? '' }}"
                            data-cita-id="{{ $cita ? $cita->cita_id : '' }}"
                            data-doctor="{{ $doctor ? $doctor->nombre_completo : '' }}"
                            data-especialidad="{{ $especialidad ? $especialidad->nombre : '' }}"
                            data-paciente="{{ $paciente ? $paciente->nombre_completo : '' }}"
                            data-cedula="{{ $paciente && $paciente->cedula_identidad ? $paciente->cedula_identidad : '' }}"
                            data-inicio="{{ $cita ? $cita->fecha_hora_inicio : '' }}"
                            data-fin="{{ $cita ? $cita->fecha_hora_fin : '' }}"
                        >
                            Cita #{{ $cita ? $cita->cita_id : 'N/A' }} - Paciente: {{ $nombrePaciente }} - Cédula: {{ $cedulaPaciente }} - Doctor: {{ $nombreDoctor }} - Especialidad: {{ $nombreEspecialidad }} - Fecha: {{ $fechaCita }}
                        </option>
                    @endforeach
                </select>
            </div>
            <!-- Información de la factura/cita seleccionada -->
            <div id="info-cita-edit" class="mb-3" style="display:block; min-height: 60px;">
                <label class="form-label"><b>Información de la Factura y Cita</b></label>
                <div class="row">
                    <div class="col-6"><b>ID Factura:</b> <span id="info-factura-id-edit">-</span></div>
                    <div class="col-6"><b>ID Cita:</b> <span id="info-cita-id-edit">-</span></div>
                    <div class="col-6"><b>Paciente:</b> <span id="info-paciente-edit">-</span></div>
                    <div class="col-6"><b>Cédula:</b> <span id="info-cedula-edit">-</span></div>
                    <div class="col-6"><b>Doctor:</b> <span id="info-doctor-edit">-</span></div>
                    <div class="col-6"><b>Especialidad:</b> <span id="info-especialidad-edit">-</span></div>
                    <div class="col-6"><b>Fecha:</b> <span id="info-fecha-edit">-</span></div>
                </div>
            </div>
            <div class="mb-3">
                <label for="metodo_pago" class="form-label">Método de Pago</label>
                <select name="metodo_pago" class="form-control" required>
                    <option value="efectivo" {{ old('metodo_pago', $pago->metodo_pago ?? '') == 'efectivo' ? 'selected' : '' }}>Efectivo</option>
                    <option value="tarjeta" {{ old('metodo_pago', $pago->metodo_pago ?? '') == 'tarjeta' ? 'selected' : '' }}>Tarjeta</option>
                    <option value="transferencia" {{ old('metodo_pago', $pago->metodo_pago ?? '') == 'transferencia' ? 'selected' : '' }}>Transferencia</option>
                    <option value="cheque" {{ old('metodo_pago', $pago->metodo_pago ?? '') == 'cheque' ? 'selected' : '' }}>Cheque</option>
                    <option value="otro" {{ old('metodo_pago', $pago->metodo_pago ?? '') == 'otro' ? 'selected' : '' }}>Otro</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="monto" class="form-label">Monto</label>
                <input type="number" step="0.01" name="monto" class="form-control" id="monto_pago_edit" value="{{ old('monto', $pago->monto ?? '') }}" required readonly>
            </div>
            <div class="mb-3">
                <label for="fecha_pago" class="form-label">Fecha de Pago</label>
                <input type="datetime-local" name="fecha_pago" class="form-control" value="{{ old('fecha_pago', isset($pago) ? \Carbon\Carbon::parse($pago->fecha_pago)->format('Y-m-d\TH:i') : '') }}" required>
            </div>
            <div class="mb-3">
                <label for="numero_referencia" class="form-label">Número de Referencia</label>
                <input type="text" name="numero_referencia" class="form-control" value="{{ old('numero_referencia', $pago->numero_referencia ?? '') }}" required>
            </div>
            <div class="mb-3">
                <label for="activo_inactivo" class="form-label">Activo</label>
                <select name="activo_inactivo" class="form-control" required>
                    <option value="1" {{ old('activo_inactivo', $pago->activo_inactivo ?? 1) == 1 ? 'selected' : '' }}>Activo</option>
                    <option value="0" {{ old('activo_inactivo', $pago->activo_inactivo ?? 1) == 0 ? 'selected' : '' }}>Inactivo</option>
                </select>
            </div>
            <button type="submit" class="btn btn-{{ $isEdit ? 'primary' : 'success' }}">
                {{ $isEdit ? 'Actualizar' : 'Guardar' }}
            </button>
            <a href="{{ route('pagos.index') }}" class="btn btn-secondary">Cancelar</a>
        </form>
    @endif
</div>
@endsection

@section('js')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const facturaSelect = document.getElementById('factura_id_select');
        const infoCitaDiv = document.getElementById('info-cita');
        const citaIdSpan = document.getElementById('info-cita-id');
        const doctorSpan = document.getElementById('info-doctor');
        const especialidadSpan = document.getElementById('info-especialidad');
        const pacienteSpan = document.getElementById('info-paciente');
        const cedulaSpan = document.getElementById('info-cedula');
        const fechaSpan = document.getElementById('info-fecha');
        const facturaIdSpan = document.getElementById('info-factura-id');
        const montoInput = document.getElementById('monto_pago');
        if (facturaSelect) {
            function actualizarMontoYDatos() {
                const selected = facturaSelect.options[facturaSelect.selectedIndex];
                if (selected && selected.value) {
                    facturaIdSpan.textContent = selected.getAttribute('data-factura-id') || '-';
                    citaIdSpan.textContent = selected.getAttribute('data-cita-id') || '-';
                    pacienteSpan.textContent = selected.getAttribute('data-paciente') || '-';
                    cedulaSpan.textContent = selected.getAttribute('data-cedula') || '-';
                    doctorSpan.textContent = selected.getAttribute('data-doctor') || '-';
                    especialidadSpan.textContent = selected.getAttribute('data-especialidad') || '-';
                    fechaSpan.textContent = selected.getAttribute('data-fecha') || '-';
                    // Actualizar monto automáticamente
                    const monto = selected.getAttribute('data-monto');
                    if (montoInput) {
                        montoInput.value = monto || '';
                    }
                } else {
                    facturaIdSpan.textContent = '-';
                    citaIdSpan.textContent = '-';
                    pacienteSpan.textContent = '-';
                    cedulaSpan.textContent = '-';
                    doctorSpan.textContent = '-';
                    especialidadSpan.textContent = '-';
                    fechaSpan.textContent = '-';
                    if (montoInput) {
                        montoInput.value = '';
                    }
                }
                infoCitaDiv.style.display = 'block';
            }
            facturaSelect.addEventListener('change', actualizarMontoYDatos);
            setTimeout(actualizarMontoYDatos, 200);
        }

        // Script para la búsqueda de citas
        const busquedaInput = document.getElementById('busqueda-cita');
        if (busquedaInput && facturaSelect) {
            busquedaInput.addEventListener('input', function() {
                const filtro = busquedaInput.value.toLowerCase();
                let algunaVisible = false;
                for (let i = 0; i < facturaSelect.options.length; i++) {
                    const option = facturaSelect.options[i];
                    if (i === 0) continue; // Saltar la opción por defecto
                    const texto = (option.getAttribute('data-busqueda') || option.textContent).toLowerCase();
                    if (texto.includes(filtro)) {
                        option.style.display = '';
                        algunaVisible = true;
                    } else {
                        option.style.display = 'none';
                    }
                }
                // Si no hay ninguna opción visible, selecciona la opción por defecto
                if (!algunaVisible) {
                    facturaSelect.selectedIndex = 0;
                }
            });
        }
        // Forzar refresco visual en navegadores antiguos
        if (facturaSelect) {
            facturaSelect.addEventListener('mousedown', function() {
                this.size = this.options.length > 10 ? 10 : this.options.length;
            });
            facturaSelect.addEventListener('blur', function() {
                this.size = 0;
            });
        }
    });
    function seleccionarFactura(id, el) {
        const lista = document.getElementById('factura-lista');
        document.getElementById('factura_id_hidden').value = id;
        // Resaltar la seleccionada
        lista.querySelectorAll('.factura-item').forEach(function(item) {
            item.style.background = item.getAttribute('data-id') === id ? '#d1e7dd' : '';
        });
        // Mostrar info
        const selected = el;
        document.getElementById('info-cita').style.display = 'block';
        document.getElementById('info-cita-id').textContent = selected.getAttribute('data-cita-id') || '-';
        document.getElementById('info-doctor').textContent = selected.getAttribute('data-doctor') || '-';
        document.getElementById('info-especialidad').textContent = selected.getAttribute('data-especialidad') || '-';
        document.getElementById('info-paciente').textContent = selected.getAttribute('data-paciente') || '-';
        document.getElementById('info-cedula').textContent = selected.getAttribute('data-cedula') || '-';
        document.getElementById('info-inicio').textContent = selected.getAttribute('data-inicio') || '-';
        document.getElementById('info-fin').textContent = selected.getAttribute('data-fin') || '-';
        // Mostrar y registrar el total de la factura
        const monto = selected.getAttribute('data-monto');
        const montoInput = document.getElementById('monto_pago');
        const montoTexto = document.getElementById('monto_pago_texto');
        if (montoInput) {
            montoInput.value = monto || '';
        }
        if (montoTexto) {
            montoTexto.textContent = monto ? `$${parseFloat(monto).toFixed(2)}` : 'No disponible';
        }
    }

    // Búsqueda en la lista estática de facturas
    document.addEventListener('DOMContentLoaded', function() {
        const busquedaFactura = document.getElementById('busqueda-factura');
        const lista = document.getElementById('factura-lista');
        if (busquedaFactura && lista) {
            busquedaFactura.addEventListener('input', function() {
                const filtro = busquedaFactura.value.toLowerCase();
                let algunaVisible = false;
                lista.querySelectorAll('.factura-item').forEach(function(item) {
                    const texto = item.getAttribute('data-busqueda') || '';
                    if (texto.includes(filtro)) {
                        item.style.display = '';
                        algunaVisible = true;
                    } else {
                        item.style.display = 'none';
                    }
                });
                // Si no hay ninguna visible, deselecciona
                if (!algunaVisible) {
                    document.getElementById('factura_id_hidden').value = '';
                }
            });
        }
    });
</script>
@endsection
