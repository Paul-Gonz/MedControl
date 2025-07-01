@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Agenda / Calendario de Citas</h1>
    <div id="calendar"></div>
</div>
@endsection

@push('styles')
<link href='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/main.min.css' rel='stylesheet' />
<style>
    #calendar {
        max-width: 900px;
        margin: 40px auto;
        background: #fff;
        border-radius: 16px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        padding: 16px;
    }
    .fc-toolbar-title {
        font-size: 2rem;
        color: #007bff;
    }
</style>
@endpush

@push('scripts')
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/main.min.js'></script>
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/locales-all.min.js'></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');
    var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        locale: 'es',
        themeSystem: 'standard',
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,timeGridDay'
        },
        events: '{{ route('agenda.citas') }}',
        eventClick: function(info) {
            alert('Cita: ' + info.event.title);
        }
    });
    calendar.render();
});
</script>
@endpush