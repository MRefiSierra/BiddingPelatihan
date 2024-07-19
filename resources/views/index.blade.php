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
                                            {{-- <div class="text-secondary">
                                                3 Bid di bulan ini
                                            </div> --}}
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
                                            {{-- <div class="text-secondary">
                                                32 shipped
                                            </div> --}}
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
                                            {{-- <div class="text-secondary">
                                                16 today
                                            </div> --}}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id='calendar'></div>
                        {{-- <div class="table-responsive">
                            <table class="table table-vcenter">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Title</th>
                                        <th>Email</th>
                                        <th>Role</th>
                                        <th class="w-1"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Paweł Kuna</td>
                                        <td class="text-secondary">
                                            UI Designer, Training
                                        </td>
                                        <td class="text-secondary"><a href="#"
                                                class="text-reset">paweluna@howstuffworks.com</a></td>
                                        <td class="text-secondary">
                                            User
                                        </td>
                                        <td>
                                            <a href="#">Edit</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Jeffie Lewzey</td>
                                        <td class="text-secondary">
                                            Chemical Engineer, Support
                                        </td>
                                        <td class="text-secondary"><a href="#"
                                                class="text-reset">jlewzey1@seesaa.net</a></td>
                                        <td class="text-secondary">
                                            Admin
                                        </td>
                                        <td>
                                            <a href="#">Edit</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Mallory Hulme</td>
                                        <td class="text-secondary">
                                            Geologist IV, Support
                                        </td>
                                        <td class="text-secondary"><a href="#"
                                                class="text-reset">mhulme2@domainmarket.com</a></td>
                                        <td class="text-secondary">
                                            User
                                        </td>
                                        <td>
                                            <a href="#">Edit</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Dunn Slane</td>
                                        <td class="text-secondary">
                                            Research Nurse, Sales
                                        </td>
                                        <td class="text-secondary"><a href="#"
                                                class="text-reset">dslane3@epa.gov</a></td>
                                        <td class="text-secondary">
                                            Owner
                                        </td>
                                        <td>
                                            <a href="#">Edit</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Emmy Levet</td>
                                        <td class="text-secondary">
                                            VP Product Management, Accounting
                                        </td>
                                        <td class="text-secondary"><a href="#"
                                                class="text-reset">elevet4@senate.gov</a></td>
                                        <td class="text-secondary">
                                            Admin
                                        </td>
                                        <td>
                                            <a href="#">Edit</a>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div> --}}
                    </div>
                </div>
            </div>
        </div>
    @endsection
