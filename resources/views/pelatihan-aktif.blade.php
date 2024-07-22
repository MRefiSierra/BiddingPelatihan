@extends('main-layout.main-layout')

@section('title', 'Dashboard')

@section('content')
    {{-- <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth'
            });
            calendar.render();
        });
    </script> --}}
    <div class="page">
        <!-- Sidebar -->
        <div class="page-wrapper">
            <div class="page-header d-print-none">
                <div class="container-xl">
                    <div class="row g-2 align-items-center">
                        <div class="col">
                            <p class="page-title fs-1">
                                Pelatihan Aktif
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="page-body">
                <div class="container-xl">
                    <div class="row mb-3">
                        @foreach ($pelatihans as $pelatihan)
                            <div class="col-3 mb-3">
                                <div class="card">
                                    <div class="card-status-top bg-info"></div>
                                    <div class="card-body">
                                        <h3 class="card-title">{{ $pelatihan->nama }}</h3>
                                        <p class="text-secondary">Tanggal :
                                            {{ \Carbon\Carbon::parse($pelatihan->relasiDenganRangeTanggal->tanggal_mulai)->format('d') }}
                                            -
                                            {{ \Carbon\Carbon::parse($pelatihan->relasiDenganRangeTanggal->tanggal_selesai)->format('d F Y') }}
                                            <br>
                                            Lokasi : {{ $pelatihan->lokasi }} <br>
                                            PRL : {{ $pelatihan->prl }}
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endsection
