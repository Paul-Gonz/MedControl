<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\App;

class DashboardController extends Controller
{
    public function citasPorMes()
    {
        // Rango: últimos 6 meses incluyendo el actual
        $start = Carbon::now()->subMonths(5)->startOfMonth();
        $end = Carbon::now()->endOfMonth();

        // Estados a mostrar: programada, completada, cancelada
        $estados = ['programada', 'completada', 'cancelada'];

        // Generar los meses del rango
        App::setLocale('es');
        $meses = collect();
        $period = \Carbon\CarbonPeriod::create($start, '1 month', $end);
        foreach ($period as $date) {
            $meses->push([
                'mes' => $date->format('Y-m'),
                'nombre' => ucfirst($date->isoFormat('MMMM YYYY'))
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
        App::setLocale('es'); // Forzar español para los nombres de meses
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

    public function ingresosEgresosPorMes()
    {
        try {
            // Rango: últimos 6 meses incluyendo el actual
            $start = Carbon::now()->subMonths(5)->startOfMonth();
            $end = Carbon::now()->endOfMonth();
            App::setLocale('es');
            $meses = collect();
            $period = \Carbon\CarbonPeriod::create($start, '1 month', $end);
            foreach ($period as $date) {
                $meses->push([
                    'mes' => $date->format('Y-m'),
                    'nombre' => ucfirst($date->isoFormat('MMMM YYYY'))
                ]);
            }

            // Ingresos: pagos de pacientes (tabla pagos)
            $ingresos = DB::table('pagos')
                ->selectRaw('DATE_FORMAT(fecha_pago, "%Y-%m") as mes, SUM(monto) as total')
                ->whereBetween('fecha_pago', [$start, $end])
                ->groupBy('mes')
                ->pluck('total', 'mes');

            // Egresos: pagos a doctores (tabla pago_doctores)
            $egresos = DB::table('pagos_doctores')
                ->selectRaw('DATE_FORMAT(fecha_pago, "%Y-%m") as mes, SUM(monto) as total')
                ->whereBetween('fecha_pago', [$start, $end])
                ->groupBy('mes')
                ->pluck('total', 'mes');

            $result = [
                'labels' => $meses->pluck('nombre'),
                'ingresos' => [],
                'egresos' => [],
                'total' => []
            ];
            $acumulado = 0;
            foreach ($meses as $mes) {
                $ing = (float)($ingresos[$mes['mes']] ?? 0);
                $egr = (float)($egresos[$mes['mes']] ?? 0);
                $result['ingresos'][] = $ing;
                $result['egresos'][] = $egr;
                $acumulado += ($ing - $egr);
                $result['total'][] = $acumulado;
            }
            return response()->json($result);
        } catch (\Throwable $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    // Horas de uso de consultorios (últimos 6 meses, ejemplo funcional)
    public function horasUsoConsultorios()
    {
        // Rango: últimos 6 meses incluyendo el actual
        $start = Carbon::now()->subMonths(5)->startOfMonth();
        $end = Carbon::now()->endOfMonth();
        App::setLocale('es');
        $meses = collect();
        $period = \Carbon\CarbonPeriod::create($start, '1 month', $end);
        foreach ($period as $date) {
            $meses->push([
                'mes' => $date->format('Y-m'),
                'nombre' => ucfirst($date->isoFormat('MMMM YYYY'))
            ]);
        }

        // Consultorios (corregido: nombre_consultorio)
        $consultorios = DB::table('consultorios')->select('consultorio_id', 'nombre_consultorio')->get();

        // Horas de uso por consultorio (suma de duración de citas en horas, siempre positivo)
        $horasPorConsultorio = DB::table('citas')
            ->select('consultorio_id', DB::raw('SUM(ABS(TIMESTAMPDIFF(SECOND, fecha_hora_inicio, fecha_hora_fin)))/3600 as horas'))
            ->whereBetween('fecha_hora_inicio', [$start, $end])
            ->where('activo_inactivo', 1)
            ->groupBy('consultorio_id')
            ->pluck('horas', 'consultorio_id');

        $labels = $consultorios->pluck('nombre_consultorio');
        $data = $consultorios->map(function ($c) use ($horasPorConsultorio) {
            return round($horasPorConsultorio[$c->consultorio_id] ?? 0, 1);
        });

        return response()->json([
            'labels' => $labels,
            'data' => $data
        ]);
    }

    // Cantidad de citas por día de la semana actual
    public function citasPorDiaSemana()
    {
        $start = Carbon::now()->startOfWeek();
        $end = Carbon::now()->endOfWeek();
        App::setLocale('es');
        $dias = ['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo'];
        $fechas = [];
        for ($i = 0; $i < 7; $i++) {
            $fechas[] = $start->copy()->addDays($i)->format('d/m');
        }
        $labels = array_map(function ($dia, $fecha) {
            return $dia . ' (' . $fecha . ')';
        }, $dias, $fechas);
        $citas = DB::table('citas')
            ->select(DB::raw('DAYOFWEEK(fecha_hora_inicio) as dia_semana'), DB::raw('COUNT(*) as cantidad'))
            ->whereBetween('fecha_hora_inicio', [$start, $end])
            ->where('activo_inactivo', 1)
            ->groupBy('dia_semana')
            ->get();
        $data = array_fill(0, 7, 0);
        foreach ($citas as $cita) {
            $index = ($cita->dia_semana + 5) % 7; // DAYOFWEEK: 1=Domingo, 2=Lunes,...7=Sábado
            $data[$index] = $cita->cantidad;
        }
        return response()->json([
            'labels' => $labels,
            'data' => $data
        ]);
    }

    // Top 10 doctores con más consultas pagadas este mes
    public function topDoctoresPagadasMes()
    {
        $start = Carbon::now()->startOfMonth();
        $end = Carbon::now()->endOfMonth();
        // Se asume que una consulta pagada es una cita completada con pago registrado
        $doctores = DB::table('citas')
            ->join('doctor_por_especialidad', 'citas.doctor_especialista_id', '=', 'doctor_por_especialidad.relacion_id')
            ->join('doctores', 'doctor_por_especialidad.doctor_id', '=', 'doctores.doctor_id')
            ->select('doctores.nombre_completo as doctor', DB::raw('COUNT(*) as cantidad'))
            ->whereBetween('citas.fecha_hora_inicio', [$start, $end])
            ->where('citas.estado_cita', 'completada')
            ->where('citas.activo_inactivo', 1)
            ->groupBy('doctores.nombre_completo')
            ->orderByDesc('cantidad')
            ->limit(10)
            ->get();
        return response()->json([
            'labels' => $doctores->pluck('doctor'),
            'data' => $doctores->pluck('cantidad')
        ]);
    }
}
