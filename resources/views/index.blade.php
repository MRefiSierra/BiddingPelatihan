@extends('main-layout.main-layout')

@section('title', 'Dashboard')

@section('content')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth'
            });
            calendar.render();
        });
    </script>
    <div class="page">
        <!-- Sidebar -->
        <div class="page-wrapper">
            <div class="page-header d-print-none">
                <div class="container-xl">
                    <div class="row g-2 align-items-center">
                        <div class="col">
                            <h2 class="page-title">
                                Dashboard
                            </h2>
                        </div>
                    </div>
                </div>
            </div>
            <div class="page-body">
                <div class="container-xl">
                    <div class="row row-cards">
                        @if (Auth::user()->role == 'instruktur')
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
                                                <div class="text-secondary">
                                                    {{ $sisaKuotaBid }} tersisa
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
                        @endif
                        <div id='calendar'></div>
                        <!-- Modal -->
                        <div class="modal fade" id="pelatihanModal" tabindex="-1" aria-labelledby="pelatihanModalLabel"
                            aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="pelatihanModalLabel">Detail Pelatihan</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <p><strong>Nama Pelatihan:</strong> <span id="modalPelatihanNama"></span></p>
                                        <p><strong>Tanggal Mulai:</strong> <span id="modalPelatihanTanggalMulai"></span></p>
                                        <p><strong>Tanggal Selesai:</strong> <span id="modalPelatihanTanggalSelesai"></span>
                                        </p>
                                        <p><strong>Kuota Instruktur:</strong> <span
                                                id="modalPelatihanKuotaInstruktur"></span></p>
                                        <p><strong>Instruktur:</strong></p>
                                        <ul id="modalPelatihanInstrukturs"></ul>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
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
                    plugins: ['dayGrid', 'interaction'],
                    events: '/api/pelatihan-events',
                    eventClick: function(info) {
                        var event = info.event;

                        // Mengisi data ke dalam modal
                        document.getElementById('modalPelatihanNama').innerText = event.title;
                        document.getElementById('modalPelatihanTanggalMulai').innerText = event.startStr;
                        document.getElementById('modalPelatihanTanggalSelesai').innerText = event.endStr;
                        document.getElementById('modalPelatihanKuotaInstruktur').innerText = event
                            .extendedProps.quota_instruktur;

                        var instruktursList = document.getElementById('modalPelatihanInstrukturs');
                        instruktursList.innerHTML = '';
                        event.extendedProps.instrukturs.forEach(function(instruktur) {
                            var li = document.createElement('li');
                            li.innerText = instruktur;
                            instruktursList.appendChild(li);
                        });

                        // Menampilkan modal
                        $('#pelatihanModal').modal('show');
                    }
                });

                calendar.render();
            });
        </script> --}}
    @endsection
