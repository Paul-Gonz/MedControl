@extends('adminlte::page')

@section('content')
<div class="container">
    <h1 class="mb-4">Agenda / Calendario de Citas</h1>
    <div class="google-calendar">
        <div class="calendar-header">
            <button class="calendar-nav" id="prevMonth">&#8592;</button>
            <span class="calendar-month" id="calendarMonth">Julio 2025</span>
            <button class="calendar-nav" id="nextMonth">&#8594;</button>
        </div>
        <div class="calendar-grid" id="calendarGrid">
            <div class="calendar-day calendar-day-name">Domingo</div>
            <div class="calendar-day calendar-day-name">Lunes</div>
            <div class="calendar-day calendar-day-name">Martes</div>
            <div class="calendar-day calendar-day-name">Miércoles</div>
            <div class="calendar-day calendar-day-name">Jueves</div>
            <div class="calendar-day calendar-day-name">Viernes</div>
            <div class="calendar-day calendar-day-name">Sábado</div>
            <!-- Los días se llenan con JS -->
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .google-calendar {
        max-width: 700px;
        margin: 40px auto;
        background: #fff;
        border-radius: 16px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        padding: 16px;
        font-family: 'Segoe UI', 'Arial', sans-serif;
    }
    .calendar-header {
        display: flex;
        justify-content: center;
        align-items: center;
        font-size: 1.5rem;
        font-weight: bold;
        margin-bottom: 16px;
        gap: 16px;
    }
    .calendar-nav {
        background: #f1f3f4;
        border: none;
        border-radius: 50%;
        width: 36px;
        height: 36px;
        font-size: 1.2rem;
        cursor: pointer;
        transition: background 0.2s;
    }
    .calendar-nav:hover {
        background: #e0e0e0;
    }
    .calendar-grid {
        display: grid;
        grid-template-columns: repeat(7, 1fr);
        grid-auto-rows: 80px;
        gap: 2px;
        background: #fff;
        border-radius: 8px;
        padding: 4px;
    }
    .calendar-day {
        background: #e6e6fa;
        border-radius: 8px;
        text-align: center;
        padding: 8px 10px;
        font-size: 1.1rem;
        min-height: 40px;
        box-sizing: border-box;
        position: relative;
        border: 1px solid #fff;
        color: #222;
        font-weight: 400;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: flex-start;
    }
    .calendar-day-name {
        background: #fff;
        color: #222;
        font-weight: bold;
        text-align: center;
        border: none;
        font-size: 1.1rem;
        border-bottom: 2px solid #e6e6fa;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .calendar-day.today {
        border: 2px solid #4285f4;
        background: #e3f0fd;
    }
    .calendar-day .event {
        background: #34a853;
        color: #fff;
        border-radius: 4px;
        padding: 2px 6px;
        font-size: 0.85rem;
        margin-top: 6px;
        display: inline-block;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        max-width: 90%;
    }
    .calendar-day.inactive {
        color: #b0b0b0;
        background: #ffe4ec;
    }
</style>
@endpush

@push('scripts')
<script>
// Datos estáticos de ejemplo para eventos
const events = {
    '2025-07-10': [{ title: 'Cita médica 10:00' }],
    '2025-07-15': [{ title: 'Reunión equipo' }],
    '2025-07-22': [{ title: 'Vacuna' }],
};

const monthNames = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];
let currentMonth = 6; // Julio (0-indexed)
let currentYear = 2025;

function renderCalendar(month, year) {
    const grid = document.getElementById('calendarGrid');
    // Elimina los días anteriores
    while (grid.children.length > 7) grid.removeChild(grid.lastChild);
    // Primer día del mes
    const firstDay = new Date(year, month, 1);
    const startDay = firstDay.getDay(); // Domingo=0
    const daysInMonth = new Date(year, month + 1, 0).getDate();
    // Días del mes anterior para completar la semana
    const prevMonthDays = new Date(year, month, 0).getDate();
    for (let i = 0; i < startDay; i++) {
        const day = document.createElement('div');
        day.className = 'calendar-day inactive';
        day.textContent = prevMonthDays - startDay + i + 1;
        grid.appendChild(day);
    }
    // Días del mes actual
    for (let d = 1; d <= daysInMonth; d++) {
        const dateStr = `${year}-${String(month+1).padStart(2,'0')}-${String(d).padStart(2,'0')}`;
        const day = document.createElement('div');
        day.className = 'calendar-day';
        // Hoy
        const today = new Date();
        if (d === today.getDate() && month === today.getMonth() && year === today.getFullYear()) {
            day.classList.add('today');
        }
        day.innerHTML = `<div style='font-weight:bold;'>${d}</div>`;
        if (events[dateStr]) {
            events[dateStr].forEach(ev => {
                const evDiv = document.createElement('div');
                evDiv.className = 'event';
                evDiv.textContent = ev.title;
                day.appendChild(evDiv);
            });
        }
        grid.appendChild(day);
    }
    // Días del siguiente mes para completar la cuadrícula
    const totalCells = startDay + daysInMonth;
    for (let i = 0; i < (totalCells % 7 === 0 ? 0 : 7 - (totalCells % 7)); i++) {
        const day = document.createElement('div');
        day.className = 'calendar-day inactive';
        day.textContent = i + 1;
        grid.appendChild(day);
    }
    document.getElementById('calendarMonth').textContent = `${monthNames[month]} ${year}`;
}

document.addEventListener('DOMContentLoaded', function() {
    renderCalendar(currentMonth, currentYear);
    document.getElementById('prevMonth').onclick = function() {
        currentMonth--;
        if (currentMonth < 0) {
            currentMonth = 11;
            currentYear--;
        }
        renderCalendar(currentMonth, currentYear);
    };
    document.getElementById('nextMonth').onclick = function() {
        currentMonth++;
        if (currentMonth > 11) {
            currentMonth = 0;
            currentYear++;
        }
        renderCalendar(currentMonth, currentYear);
    };
});
</script>
@endpush