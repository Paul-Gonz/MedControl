@extends('adminlte::page')

@section('title', 'Pagos a Doctores')

@section('content_header')
    <h1>Pagos a Doctores</h1>
@stop

@section('content')
    <!-- Botón para abrir el modal de registro -->
    <button type="button" class="btn btn-success mb-3" data-toggle="modal" data-target="#modalPagoDoctor" onclick="resetForm()">
        Registrar Pago
    </button>

    <!-- Modal de registro/edición de pago (Bootstrap 4 compatible) -->
    <div class="modal fade" id="modalPagoDoctor" tabindex="-1" role="dialog" aria-labelledby="modalPagoDoctorLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="modalPagoDoctorLabel">Registrar/Editar Pago a Doctor</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form id="formPagoDoctor" method="POST" action="{{ route('pagos_doctores.store') }}">
                @csrf
                <input type="hidden" name="id" id="pago_id">
                <div class="row">
                    <div class="col-md-3">
                        <label for="doctor_id">Doctor</label>
                        <select name="doctor_id" id="doctor_id" class="form-control" required onchange="setHonorario()">
                            <option value="">Seleccione un doctor</option>
                            @foreach($doctores as $doctor)
                                <option value="{{ $doctor->doctor_id }}" data-honorario="{{ $doctor->honorarios }}">{{ $doctor->nombre_completo }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label for="monto">Monto</label>
                        <input type="number" name="monto" id="monto" class="form-control" step="0.01" required>
                    </div>
                    <div class="col-md-2">
                        <label for="fecha_pago">Fecha de Pago</label>
                        <input type="date" name="fecha_pago" id="fecha_pago" class="form-control" required>
                    </div>
                    <div class="col-md-2">
                        <label for="metodo_pago">Método de Pago</label>
                        <input type="text" name="metodo_pago" id="metodo_pago" class="form-control">
                    </div>
                    <div class="col-md-3">
                        <label for="observaciones">Observaciones</label>
                        <input type="text" name="observaciones" id="observaciones" class="form-control">
                    </div>
                </div>
                <div class="mt-2">
                    <button type="submit" class="btn btn-success" id="btnGuardar">Registrar</button>
                    <button type="button" class="btn btn-secondary" id="btnCancelar" data-dismiss="modal" onclick="resetForm()">Cancelar</button>
                </div>
            </form>
          </div>
        </div>
      </div>
    </div>
    <hr>
    <!-- Tabla de pagos -->
    <table class="table table-bordered mt-3">
        <thead>
            <tr>
                <th>ID</th>
                <th>Doctor</th>
                <th>Monto</th>
                <th>Fecha de Pago</th>
                <th>Método de Pago</th>
                <th>Observaciones</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($pagos as $pago)
                <tr>
                    <td>{{ $pago->id ?? $pago->pago_doctor_id ?? $pago->pago_id }}</td>
                    <td>{{ $pago->doctor->nombre_completo ?? '' }}</td>
                    <td>{{ $pago->monto }}</td>
                    <td>{{ $pago->fecha_pago }}</td>
                    <td>{{ $pago->metodo_pago }}</td>
                    <td>{{ $pago->observaciones }}</td>
                    <td>
                        <button class="btn btn-sm btn-warning" onclick='editarPago(@json($pago)); $("#modalPagoDoctor").modal("show");'>Editar</button>
                        <form action="{{ route('pagos_doctores.destroy', $pago->id ?? $pago->pago_doctor_id ?? $pago->pago_id) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('¿Seguro de eliminar?')">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@stop

@section('js')
<script>
function setHonorario() {
    var select = document.getElementById('doctor_id');
    var monto = document.getElementById('monto');
    var selected = select.options[select.selectedIndex];
    var honorario = selected.getAttribute('data-honorario');
    if(honorario) {
        monto.value = honorario;
    }
}
function editarPago(pago) {
    document.getElementById('formPagoDoctor').action = '/pagos-doctores/update/' + (pago.id || pago.pago_doctor_id || pago.pago_id);
    let methodInput = document.querySelector('input[name="_method"]');
    if(!methodInput) {
        document.getElementById('formPagoDoctor').insertAdjacentHTML('beforeend', '<input type="hidden" name="_method" value="PUT">');
    }
    document.getElementById('pago_id').value = pago.id || pago.pago_doctor_id || pago.pago_id;
    document.getElementById('doctor_id').value = pago.doctor_id;
    setHonorario();
    document.getElementById('monto').value = pago.monto;
    document.getElementById('fecha_pago').value = pago.fecha_pago ? pago.fecha_pago.substring(0,10) : '';
    document.getElementById('metodo_pago').value = pago.metodo_pago;
    document.getElementById('observaciones').value = pago.observaciones;
    document.getElementById('btnGuardar').textContent = 'Actualizar';
}
function resetForm() {
    document.getElementById('formPagoDoctor').action = '{{ route('pagos_doctores.store') }}';
    let methodInput = document.querySelector('input[name="_method"]');
    if(methodInput) methodInput.remove();
    document.getElementById('formPagoDoctor').reset();
    document.getElementById('btnGuardar').textContent = 'Registrar';
}
</script>
@stop
