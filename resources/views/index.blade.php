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
                                Dashboard
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="page-body">
                <div class="container-xl">
                    @if (Auth::user()->role == 'instruktur')
                        <div class="row row-cards mb-3">
                            <div class="col">
                                <div class="card card-sm">
                                    <div class="card-body">
                                        <div class="row align-items-center">
                                            <div class="col-auto">
                                                <span
                                                    class="bg-primary text-white avatar"><!-- Download SVG icon from http://tabler-icons.io/i/currency-dollar -->
                                                    <i class="ti ti-briefcase fs-1"></i>
                                                </span>
                                            </div>
                                            <div class="col">
                                                <div class="font-weight-medium">
                                                    Jumlah Bid
                                                </div>
                                                <div class="text-secondary">
                                                    Total {{ $allBid }} bid
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col">
                                <div class="card card-sm">
                                    <div class="card-body">
                                        <div class="row align-items-center">
                                            <div class="col-auto">
                                                <span
                                                    class="bg-success text-white avatar"><!-- Download SVG icon from http://tabler-icons.io/i/currency-dollar -->
                                                    <i class="ti ti-refresh fs-1"></i>
                                                </span>
                                            </div>
                                            <div class="col d-flex justify-content-between align-items-center">
                                                <div id="kuotaDisplay" class="">
                                                    <div class="font-weight-medium" id="kuotaBulan">
                                                        Pilih bulan untuk melihat sisa kuota.
                                                    </div>
                                                    <div class="text-secondary" id="kuotaSisa">
                                                        <!-- Sisa kuota akan ditampilkan di sini -->
                                                    </div>
                                                </div>
                                                <div class="dropdown">
                                                    <button class="btn dropdown-toggle p-1" type="button"
                                                        id="dropdownMenuButton" data-bs-toggle="dropdown"
                                                        aria-expanded="false">
                                                    </button>
                                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                        @foreach ($sisaKuotaBidPerBulan as $key => $sisaKuota)
                                                            @php
                                                                [$bulan, $tahun] = explode('-', $key);
                                                                $namaBulan = \Carbon\Carbon::create()
                                                                    ->month($bulan)
                                                                    ->format('F');
                                                            @endphp
                                                            <li>
                                                                <a class="dropdown-item" href="#"
                                                                    data-bulan="{{ $bulan }}"
                                                                    data-tahun="{{ $tahun }}"
                                                                    onclick="updateKuota('{{ $bulan }}', '{{ $tahun }}', '{{ $namaBulan }}', '{{ $sisaKuota }}')">
                                                                    Kuota Bid Bulan {{ $namaBulan }} {{ $tahun }}
                                                                </a>
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @if ($pelatihans->isNotEmpty())
                            <div class="row row-cards mb-3">
                                <div class="page-header d-print-none">
                                    <div class="row justify-content-between align-items-center">
                                        <div class="col-2">
                                            <p class="page-title fs-1">
                                                Pelatihan Aktif
                                            </p>
                                        </div>
                                        <div class="col-2">
                                            <a href="/pelatihan-aktif" class="text-decoration-none text-secondary">
                                                <p class="page-title fs-4">
                                                    Lihat Selengkapnya...
                                                </p>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                @foreach ($pelatihans as $pelatihan)
                                    <div class="col-4">
                                        <div class="card">
                                            <div class="card-status-top bg-info"></div>
                                            <div class="card-body">
                                                <h3 class="card-title">{{ $pelatihan->nama }}</h3>
                                                <p class="text-secondary">
                                                    Tanggal:
                                                    {{ \Carbon\Carbon::parse($pelatihan->relasiDenganRangeTanggal->tanggal_mulai)->format('d') }}
                                                    -
                                                    {{ \Carbon\Carbon::parse($pelatihan->relasiDenganRangeTanggal->tanggal_selesai)->format('d F Y') }}
                                                    <br>
                                                    Lokasi: {{ $pelatihan->lokasi }} <br>
                                                    PRL: {{ $pelatihan->prl }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="row row-cards mb-3">
                                <div class="page-header d-print-none">
                                    <p class="page-title fs-1">
                                        Tidak ada pelatihan aktif
                                    </p>
                                </div>
                            </div>
                        @endif

                    @endif
                    <div id='calendar'></div>
                    <!-- Modal -->

                    <!-- Modal -->
                    <div class="modal fade" id="eventModal" tabindex="-1" aria-labelledby="eventModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="eventModalLabel">Event Details</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <p><strong>Instruktur:</strong> <span id="instrukturList"></span></p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- <script>
            document.addEventListener('DOMContentLoaded', function() {
                var calendarEl = document.getElementById('calendar');

                var calendar = new FullCalendar.Calendar(calendarEl, {
                    initialView: 'dayGridMonth',
                    events: '/admin/calendar',
                    eventContent: function(arg) {
                        let instrukturs = arg.event.extendedProps.instrukturs.join(', ');
                        let content = document.createElement('div');
                        content.innerHTML = `<b>${arg.event.title}</b><br>${instrukturs}`;
                        return {
                            domNodes: [content]
                        }
                    }
                });

                calendar.render();
            });
        </script> --}}
    @if (Auth::user()->role == 'admin')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                var calendarEl = document.getElementById('calendar');

                var calendar = new FullCalendar.Calendar(calendarEl, {
                    initialView: 'dayGridMonth',
                    events: '/admin/calendar',
                    eventClick: function(info) {
                        var instrukturs = info.event.extendedProps.instrukturs.join(', ');
                        document.getElementById('eventModalLabel').textContent = info.event.title;
                        document.getElementById('instrukturList').textContent = instrukturs;
                        var myModal = new bootstrap.Modal(document.getElementById('eventModal'));
                        myModal.show();
                    }
                });

                calendar.render();
            });
        </script>
    @endif
    @if (Auth::user()->role == 'instruktur')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                var calendarEl = document.getElementById('calendar');

                var calendar = new FullCalendar.Calendar(calendarEl, {
                    initialView: 'dayGridMonth',
                    events: '/instruktur/calendar',
                    eventClick: function(info) {
                        var instrukturs = info.event.extendedProps.instrukturs.join(', ');
                        document.getElementById('eventModalLabel').textContent = info.event.title;
                        document.getElementById('instrukturList').textContent = instrukturs;

                        var myModal = new bootstrap.Modal(document.getElementById('eventModal'));
                        myModal.show();
                    }
                });

                calendar.render();
            });
        </script>
    @endif

    <script>
        function updateKuota(bulan, tahun, namaBulan, sisaKuota) {
            document.getElementById('kuotaBulan').textContent = 'Kuota Bid Bulan ' + namaBulan + ' ' + tahun;
            document.getElementById('kuotaSisa').textContent = sisaKuota + ' kuota tersisa';
        }
    </script>

@endsection
