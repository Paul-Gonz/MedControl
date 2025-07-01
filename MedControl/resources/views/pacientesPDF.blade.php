<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Reporte de Pacientes</title>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 11px;
            margin: 1px;
        }

        .header-reporte {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 10px;
        }

        .logo {
            height: 130px;
        }

        .fecha-reporte {
            font-size: 12px;
            color: #555;
            text-align: right;
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

        th,
        td {
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
    </style>
</head>
<body> 
   <div class="header-principal" style="display: flex; align-items: center; justify-content: center; margin-bottom: 15px;">
        <div style="text-align: center;">
            <div style="font-size: 28px; font-weight: bold; margin-bottom: 4px;">MedControl</div>
            <div style="font-size: 14px;">
                Av. Principal 1234, Edificio Salud, Piso 2<br>
                Ciudad, País<br>
                Tel: (123) 456-7890 &nbsp; | &nbsp; Email: info@medcontrol.com
            </div>
        </div>
    </div>
    <div class="header-reporte">
        <div class="fecha-reporte">
            Fecha de generación: {{ \Carbon\Carbon::now()->format('d/m/Y H:i') }}
        </div>
    </div>
    <h1>Listado de pacientes</h1>
    <div class="card">
        <div class="card-body">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th class="col-id">ID</th>
                        <th>Cédula Identidad</th>
                        <th>Nombre Completo</th>
                        <th>Fecha Nacimiento</th>
                        <th>Teléfono</th>
                        <th>Email</th>
                        <th>Datos Relevantes</th>
                        <th>Fecha Registro</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pacientes as $paciente)
                    <tr>
                        <td class="col-id">{{ $paciente->paciente_id }}</td>
                        <td>{{ $paciente->cedula_identidad }}</td>
                        <td>{{ $paciente->nombre_completo }}</td>
                        <td>{{ $paciente->fecha_nacimiento }}</td>
                        <td>{{ $paciente->contacto_telefono }}</td>
                        <td>{{ $paciente->contacto_email }}</td>
                        <td>{{ $paciente->datos_relevantes }}</td>
                        <td>{{ $paciente->fecha_registro }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>