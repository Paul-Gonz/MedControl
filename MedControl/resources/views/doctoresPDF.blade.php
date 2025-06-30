<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte de Doctor x Especialidad</title>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 11px;
            margin: 1px;
        }
        .card {
            border: 1px solid #aaa;
            border-radius: 6px;
            padding: 10px;
            margin-bottom: 20px;
        }
        .card-body {
            padding: 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
        }
        th, td {
            padding: 5px 3px;
            text-align: left;
            font-size: 10px;
            word-break: break-word;
        }
        th {
            background: #f2f2f2;
            font-weight: bold;
        }
        .badge {
            display: inline-block;
            padding: 2px 6px;
            border-radius: 4px;
            color: #fff;
            font-size: 9px;
        }
        .badge-success {
            background: #28a745;
        }
        .badge-danger {
            background: #dc3545;
        }
        .col-id {
            width: 35px;
            min-width: 25px;
            max-width: 40px;
            text-align: center;
        }
        h1 {
            text-align: center;
        }
        .especialidad-titulo {
            text-align: center;
            font-size: 14px;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <h1>Listado de Doctores por Especialidad</h1>
    @isset($especialidad)
        <div class="especialidad-titulo">
            <strong>Especialidad:</strong> {{ $especialidad->nombre }}
        </div>
    @endisset
    <div class="card">
        <div class="card-body">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th class="col-id">ID</th>
                        <th>Nombre Completo</th>
                        <th>Cédula Identidad</th>
                        <th>Cédula Profesional</th>
                        <th>Honorarios</th>
                        <th>Teléfono</th>
                        <th>Email</th>
                        <th>Especialidad</th>
                        <th>Estado</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($doctores as $doctor)
                        <tr>
                            <td class="col-id">{{ $doctor->doctor_id }}</td>
                            <td>{{ $doctor->nombre_completo }}</td>
                            <td>{{ $doctor->cedula_identidad }}</td>
                            <td>{{ $doctor->cedula_profesional }}</td>
                            <td>{{ $doctor->honorarios }}</td>
                            <td>{{ $doctor->contacto_telefono }}</td>
                            <td>{{ $doctor->contacto_email }}</td>
                            <td>{{ $doctor->especialidad_nombre ?? '' }}</td>
                            <td>
                                @if($doctor->activo_inactivo)
                                    <span class="badge badge-success">Activo</span>
                                @else
                                    <span class="badge badge-danger">Inactivo</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
