@extends('adminlte::page')

@section('title', 'Cuentas Bancarias')

@section('content_header')
<h1>Cuentas Bancarias</h1>
@stop

@section('content')
<div class="mb-3">
    <!-- Botón para abrir el modal de nueva cuenta bancaria -->
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#nuevaCuenta_BancariaModal">
        Nueva Cuenta Bancaria
    </button>
</div>

<!-- Modal Nueva Cuenta Bancaria -->
<div class="modal fade" id="nuevaCuenta_BancariaModal" tabindex="-1" role="dialog" aria-labelledby="nuevaCuenta_BancariaModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form action="{{ route('cuentas_bancarias.store') }}" method="POST">
        @csrf
        <div class="modal-header">
          <h5 class="modal-title" id="nuevaCuenta_BancariaLabel">Nueva Cuenta Bancaria</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            {{-- Mostrar errores de validación --}}
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Nombre del titular</label>
                        <input type="text" class="form-control" name="nombre_titular" value="{{ old('nombre_titular') }}" required>
                    </div>
                    <div class="form-group">
                        <label>Cedula del titular</label>
                        <input type="text" class="form-control" name="cedula_titular" value="{{ old('cedula_titular') }}" required>
                    </div>
                    <div class="form-group">
                        <label>Banco</label>
                        <input type="text" class="form-control" name="banco" value="{{ old('banco') }}" required>
                    </div>
                    <div class="form-group">
                        <label>Numero telefonico</label>
                        <input type="text" class="form-control" name="numero_telefonico" value="{{ old('numero_telefonico') }}">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Pago Movil</label>
                         <select class="form-control" name="pago_movil" required>
                            <option value="">Seleccione...</option>
                            <option value="1" {{ old('pago_movil') === '1' ? 'selected' : '' }}>SI</option>
                            <option value="0" {{ old('pago_movil') === '0' ? 'selected' : '' }}>NO</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Estado</label>
                        <select class="form-control" name="activo_inactivo" required>
                            <option value="">Seleccione...</option>
                            <option value="1" {{ old('activo_inactivo') === '1' ? 'selected' : '' }}>Activo</option>
                            <option value="0" {{ old('activo_inactivo') === '0' ? 'selected' : '' }}>Inactivo</option>
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
                    <th>NOMBRE</th>
                    <th>CEDULA</th>
                    <th>BANCO</th>
                    <th>NUMERO TELEFONICO</th>
                    <th>PAGO MOVIL</th>
                    <th>ESTADO</th>
                    <th>ACCIONES</th>
                </tr>
            </thead>
            <tbody>
                @foreach($cuentas_bancarias as $cuenta_bancaria)
                    <tr>
                        <td>{{ $cuenta_bancaria->id_cuenta_bancaria }}</td>
                        <td>{{ $cuenta_bancaria->nombre_titular }}</td>
                        <td>{{ $cuenta_bancaria->cedula_titular }}</td>
                        <td>{{ $cuenta_bancaria->banco }}</td>
                        <td>{{ $cuenta_bancaria->numero_telefonico }}</td>
                        <td>
                            @if($cuenta_bancaria->pago_movil)
                                <span class="">SI</span>
                            @else
                                <span class="">NO</span>
                            @endif
                        </td>
                        <td>
                            @if($cuenta_bancaria->activo_inactivo)
                                <span class="badge badge-success">Activo</span>
                            @else
                                <span class="badge badge-danger">Inactivo</span>
                            @endif
                        </td>
                        <td>
                            <!-- Botón Editar -->
                            <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#editarCuenta_BancariaModal{{ $cuenta_bancaria->id_cuenta_bancaria }}">
                                Editar
                            </button>
                            <!-- Modal Editar -->
                            <div class="modal fade" id="editarCuenta_BancariaModal{{ $cuenta_bancaria->id_cuenta_bancaria  }}" tabindex="-1" role="dialog" aria-labelledby="editarcuenta_bancariaModalLabel{{ $cuenta_bancaria->id_cuenta_bancaria  }}" aria-hidden="true">
                              <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                  <form action="{{ route('cuentas_bancarias.update') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="id_cuenta_bancaria" value="{{ $cuenta_bancaria->id_cuenta_bancaria }}">
                                    <div class="modal-header">
                                      <h5 class="modal-title" id="editarCuenta_BancariaModalLabel{{ $cuenta_bancaria->id_cuenta_bancaria }}">Editar Cuenta Bancaria</h5>
                                      <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                                        <span aria-hidden="true">&times;</span>
                                      </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                        <label>Nombre</label>
                        <input type="text" class="form-control" name="nombre_titular" value="{{ $cuenta_bancaria->nombre_titular }}" required>
                    </div>
                    <div class="form-group">
                        <label>Cedula</label>
                        <input type="text" class="form-control" name="cedula_titular" value="{{ $cuenta_bancaria->cedula_titular }}" required>
                    </div>
                    <div class="form-group">
                        <label>Banco</label>
                        <input type="text" class="form-control" name="banco" value="{{ $cuenta_bancaria->banco }}" required>
                    </div>
                    <div class="form-group">
                        <label>Numero Telefonico</label>
                        <input type="text" class="form-control" name="numero_telefonico" value="{{ $cuenta_bancaria->numero_telefonico }}">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Pago movil</label>
                        <select class="form-control" name="pago_movil" required>
                            <option value="1" {{ $cuenta_bancaria->pago_movil ? 'selected' : '' }}>SI</option>
                            <option value="0" {{ !$cuenta_bancaria->pago_movil ? 'selected' : '' }}>NO</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Estado</label>
                        <select class="form-control" name="activo_inactivo" required>
                            <option value="1" {{ $cuenta_bancaria->activo_inactivo ? 'selected' : '' }}>Activo</option>
                            <option value="0" {{ !$cuenta_bancaria->activo_inactivo ? 'selected' : '' }}>Inactivo</option>
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
                            <form action="{{ route('cuentas_bancarias.destroy') }}" method="POST" style="display:inline;">
                                @csrf
                                <input type="hidden" name="id_cuenta_bancaria" value="{{ $cuenta_bancaria->id_cuenta_bancaria }}">
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Seguro que deseas eliminar esta cuenta bancaria?')">Eliminar</button>
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