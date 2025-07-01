<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function citasPorMes()
    {
        // Rango: últimos 6 meses incluyendo el actual
        $start = Carbon::now()->subMonths(5)->startOfMonth();
        $end = Carbon::now()->endOfMonth();

        // Estados a mostrar: programada, completada, cancelada
        $estados = ['programada', 'completada', 'cancelada'];

        // Generar los meses del rango (en español)
        \App::setLocale('es'); // Forzar español para los nombres de meses
        $meses = collect();
        $period = \Carbon\CarbonPeriod::create($start, '1 month', $end);
        foreach ($period as $date) {
            $meses->push([
                'mes' => $date->format('Y-m'),
                'nombre' => ucfirst($date->isoFormat('MMMM YYYY')) // Nombre de mes en español
            ]);
        }

        // Consulta agrupada
        $citas = DB::table('citas')
            ->selectRaw('DATE_FORMAT(fecha_hora_inicio, "%Y-%m") as mes, estado_cita, COUNT(*) as cantidad')
            ->whereBetween('fecha_hora_inicio', [$start, $end])
            ->where('activo_inactivo', 1)
            ->whereIn('estado_cita', $estados)
            ->groupBy('mes', 'estado_cita')
            ->get();

        // Preparar datos para el gráfico
        $result = [
            'labels' => $meses->pluck('nombre'),
            'programadas' => [],
            'realizadas' => [],
            'canceladas' => []
        ];
        foreach ($meses as $i => $mes) {
            $realizadas = 0;
            $canceladas = 0;
            foreach ($estados as $estado) {
                $count = $citas->first(fn($c) => $c->mes === $mes['mes'] && $c->estado_cita === $estado)?->cantidad ?? 0;
                if ($estado === 'completada') $realizadas = $count;
                if ($estado === 'cancelada') $canceladas = $count;
                if ($estado === 'completada') $result['realizadas'][] = $count;
                if ($estado === 'cancelada') $result['canceladas'][] = $count;
            }
            $result['programadas'][] = $realizadas + $canceladas;
        }
        return response()->json($result);
    }

    public function especialidadesMasDemandadas()
    {
        // Rango: mes calendario actual
        $start = Carbon::now()->startOfMonth();
        $end = Carbon::now()->endOfMonth();
        \App::setLocale('es'); // Forzar español para los nombres de meses
        $nombreMes = ucfirst(Carbon::now()->isoFormat('MMMM YYYY'));

        // Consulta: cantidad de citas por especialidad (todas las citas del mes actual)
        $data = DB::table('citas')
            ->join('doctor_por_especialidad', 'citas.doctor_especialista_id', '=', 'doctor_por_especialidad.relacion_id')
            ->join('especialidades', 'doctor_por_especialidad.especialidad_id', '=', 'especialidades.especialidad_id')
            ->join('doctores', 'doctor_por_especialidad.doctor_id', '=', 'doctores.doctor_id')
            ->select('especialidades.nombre as especialidad', DB::raw('COUNT(*) as cantidad'))
            ->whereBetween('citas.fecha_hora_inicio', [$start, $end])
            ->where('citas.activo_inactivo', 1)
            ->groupBy('especialidades.nombre')
            ->orderByDesc('cantidad')
            ->limit(10)
            ->get();

        return response()->json([
            'labels' => $data->pluck('especialidad'),
            'data' => $data->pluck('cantidad'),
            'mes' => $nombreMes
        ]);
    }
}
