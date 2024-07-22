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
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                        viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                        class="icon">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                        <path
                                                            d="M16.7 8a3 3 0 0 0 -2.7 -2h-4a3 3 0 0 0 0 6h4a3 3 0 0 1 0 6h-4a3 3 0 0 1 -2.7 -2">
                                                        </path>
                                                        <path d="M12 3v3m0 12v3"></path>
                                                    </svg>
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
                            <div class=" col">
                                <div class="card card-sm">
                                    <div class="card-body">
                                        <div class="row align-items-center">
                                            <div class="col-auto">
                                                <span
                                                    class="bg-green text-white avatar"><!-- Download SVG icon from http://tabler-icons.io/i/shopping-cart -->
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                        viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                        class="icon">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                        <path d="M6 19m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0"></path>
                                                        <path d="M17 19m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0"></path>
                                                        <path d="M17 17h-11v-14h-2"></path>
                                                        <path d="M6 5l14 1l-1 7h-13"></path>
                                                    </svg>
                                                </span>
                                            </div>
                                            <div class="col">
                                                <div class="font-weight-medium">
                                                    Kuota Bid
                                                </div>
                                                @foreach ($sisaKuotaBidPerBulan as $item)
                                                    <div class="text-secondary">
                                                        {{ $item }}
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class=" col">
                                <div class="card card-sm">
                                    <div class="card-body">
                                        <div class="row align-items-center">
                                            <div class="col-auto">
                                                <span
                                                    class="bg-x text-white avatar"><!-- Download SVG icon from http://tabler-icons.io/i/brand-x -->
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                        viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                        class="icon">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                        <path d="M4 4l11.733 16h4.267l-11.733 -16z"></path>
                                                        <path d="M4 20l6.768 -6.768m2.46 -2.46l6.772 -6.772"></path>
                                                    </svg>
                                                </span>
                                            </div>
                                            <div class="col">
                                                <div class="font-weight-medium">
                                                    Jumlah Pelatihan
                                                </div>
                                                <div class="text-secondary">
                                                    {{ $allPelatihan }}
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
                                                    {{ \Carbon\Carbon::parse($pelatihan->relasiDenganRangeTanggal->first()->tanggal_mulai)->format('d') }}
                                                    -
                                                    {{ \Carbon\Carbon::parse($pelatihan->relasiDenganRangeTanggal->first()->tanggal_selesai)->format('d F Y') }}
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
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">Close</button>
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

@endsection
