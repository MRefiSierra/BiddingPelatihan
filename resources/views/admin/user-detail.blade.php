@extends('main-layout.main-layout')

@section('title', 'Management User')

@section('content')
    <script>
            document.addEventListener('DOMContentLoaded', function() {
                var calendarEl = document.getElementById('calendar');
                var userId = '{{ $user->id }}'; // Ambil user ID dari blade

                var calendar = new FullCalendar.Calendar(calendarEl, {
                    timeZone: 'UTC',
                    initialView: 'multiMonthYear',
                    multiMonthMaxColumns: 4,
                    multiMonthMinWidth: 550,
                    editable: true,
                    events: `/user-detail/${userId}/calendar` // Panggil endpoint berdasarkan user ID
                });

                calendar.render();
            });
    </script>
    <div class="page-wrapper">
        <div class="page-header d-print-none">
            <div class="container-xl">
                <div class="row g-2 align-items-center">
                    <div class="col">
                        <p class="page-title fs-1">
                            {{ $user->name }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <div class="page-body">
            <div class="container-xl">
                <div class="calendar border-0" id="calendar"></div>

            </div>
        </div>
    </div>
@endsection
