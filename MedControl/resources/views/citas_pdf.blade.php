<!DOCTYPE html>
<html>
<head>
    <title>Reporte de Citas</title>
    <style>
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #ccc; padding: 4px; font-size: 12px; }
        th { background: #f5f5f5; }
    </style>
</head>
<body>
    <h2>Reporte de Citas</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Paciente</th>
                <th>Motivo</th>
                <th>Inicio</th>
                <th>Fin</th>
                <th>Estado</th>
                <th>Activo</th>
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
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>