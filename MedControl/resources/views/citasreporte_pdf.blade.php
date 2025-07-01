<!DOCTYPE html>
<html>
<head>
    <title>{{ $titulo }}</title>
    <style>
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #ccc; padding: 4px; font-size: 12px; }
        th { background: #f5f5f5; }
    </style>
</head>
<body>
    <h2>{{ $titulo }}</h2>
    <table>
        <thead>
            <tr>
                <th>{{ $columna }}</th>
                <th>Total de Citas</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($reporte as $row)
                <tr>
                    <td>{{ $row->nombre }}</td>
                    <td>{{ $row->total_citas }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="2">No hay datos para mostrar.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>