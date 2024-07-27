@extends('main-layout.main-layout')

@section('title', 'Input Pelatihan')

@section('content')
    <style>
        td {
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .computer {
            @media screen and (min-width: 576px) {
                display: block;
            }

            @media screen and (max-width: 575px) {
                display: none
            }
        }

        .mobile {
            @media screen and (max-width: 576px) {
                display: block;
            }

            @media screen and (min-width: 575px) {
                /* display: none */
            }
        }

        #selectAllMonthsButton,
        #deselectAllMonthsButton,
        #selectAllInstructorsButton,
        #deselectAllInstructorsButton {
            cursor: pointer;
        }
    </style>
    <div class="page-wrapper">
        <div class="page-header d-print-none">
            <div class="container-xl">
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible" role="alert">
                        <h4 class="alert-title fs-2">Congrats, </h4>
                        <div class="text-secondary">{{ session('success') }}</div>
                        <a class="btn-close" data-bs-dismiss="alert" aria-label="close"></a>
                    </div>
                @endif
                @if (session('error'))
                    <div class="alert alert-warning alert-dismissible" role="alert">
                        <h4 class="alert-title fs-2">Oopss, </h4>
                        <div class="text-secondary">{{ session('error') }}</div>
                        <a class="btn-close" data-bs-dismiss="alert" aria-label="close"></a>
                    </div>
                @endif
                <div class="row g-2 align-items-center">
                    <div class="col-12 col-xl-6 col-lg-4 col-md-12 col-sm-12">
                        <h2 class="page-title">
                            Listing Pelatihan
                        </h2>
                    </div>
                    <div class="col d-lg-flex justify-content-end gap-3">
                        <div class="row pt-lg-0 pt-2">
                            <!-- Tombol untuk membuka modal -->
                            <div class="text-center">
                                <button type="button" class="btn btn-large btn-success w-100" data-bs-toggle="modal"
                                    data-bs-target="#exportModal">
                                    <i class="ti ti-file-excel pe-2 fs-2"></i>
                                    Export Excel
                                </button>
                            </div>
                        </div>
                        <div class="row pt-lg-0 pt-2">
                            <div class=" text-center">
                                <a href="/input-pelatihan" class="text-light text-decoration-none">
                                    <button class="btn btn-large btn-info w-100">
                                        <i class="ti ti-plus pe-2 fs-2"></i>
                                        Tambah Pelatihan
                                    </button>
                                </a>
                            </div>
                        </div>
                        {{-- <a href="{{ route('exportExcel.store') }}"class="btn btn-large btn-success">Print dsini</a> --}}
                    </div>
                </div>
            </div>
        </div>

        <div class="text-center">
            <!-- Modal -->
            <!-- Modal Export -->
            <div class="modal fade" id="exportModal" tabindex="-1" aria-labelledby="exportModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exportModalLabel">Export Excel</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form id="exportForm" action="{{ route('exportExcel.store') }}" method="GET">
                                <!-- Tab Navigation -->
                                <ul class="nav nav-tabs" id="exportTabs" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <a class="nav-link active" id="month-tab" data-bs-toggle="tab" href="#month"
                                            role="tab">Bulan dan Tahun</a>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <a class="nav-link" id="instructor-tab" data-bs-toggle="tab" href="#instructor"
                                            role="tab">Instruktur</a>
                                    </li>
                                </ul>

                                <!-- Tab Content -->
                                <div class="tab-content mt-3" id="exportTabsContent">
                                    <!-- Tab Bulan dan Tahun -->
                                    <div class="tab-pane fade show active" id="month" role="tabpanel"
                                        aria-labelledby="month-tab">
                                        <input type="hidden" name="exportType" id="exportTypeMonth" value="month">
                                        <div class="gap-3">
                                            <div class="mb-3 col">
                                                <label for="year" class="form-label">Tahun:</label>
                                                <input class="form-control" type="number" id="year" name="year"
                                                    min="2000" max="3000" step="1"
                                                    value="{{ \Carbon\Carbon::now()->year }}"
                                                    placeholder="Masukkan Tahun" />
                                            </div>
                                            <div class="mb-3 col">
                                                <label for="months" class="form-label">Bulan:</label>
                                                <div id="monthsWrapper" class="form-control text-start"
                                                    style="height: 200px; overflow-y: auto;">
                                                    @for ($i = 1; $i <= 12; $i++)
                                                        <div class="form-check text-start">
                                                            <input type="checkbox" id="month{{ $i }}"
                                                                value="{{ $i }}" class="form-check-input">
                                                            <label class="form-check-label"
                                                                for="month{{ $i }}">{{ \Carbon\Carbon::create()->month($i)->format('F') }}</label>
                                                        </div>
                                                    @endfor
                                                </div>
                                                <div class="d-flex mt-2">
                                                    <p id="selectAllMonthsButton"
                                                        class="text-secondary text-decoration-underline mb-2 m-1">Pilih
                                                        semua</p>
                                                    <p id="deselectAllMonthsButton"
                                                        class="text-secondary text-decoration-underline mb-2 m-1">Jangan
                                                        pilih semua</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Tab Instruktur -->
                                    <div class="tab-pane fade" id="instructor" role="tabpanel"
                                        aria-labelledby="instructor-tab">
                                        <input type="hidden" name="exportType" id="exportTypeInstructor"
                                            value="instructor">
                                        <div class="mb-3 col">
                                            <label for="searchInstructor" class="form-label">Cari Instruktur:</label>
                                            <input type="text" id="searchInstructor" class="form-control"
                                                placeholder="Cari instruktur...">
                                        </div>
                                        <div class="mb-3 col">
                                            <label for="instructors" class="form-label">Instruktur:</label>
                                            <div id="instructorsWrapper" class="form-control text-start"
                                                style="height: 250px; overflow-y: auto;">
                                                @foreach ($instructors as $instructor)
                                                    <div class="form-check text-start">
                                                        <input type="checkbox" id="instructor{{ $instructor->id }}"
                                                            value="{{ $instructor->id }}" class="form-check-input"
                                                            name="instructors[]">
                                                        <label class="form-check-label"
                                                            for="instructor{{ $instructor->id }}">{{ $instructor->name }}</label>
                                                    </div>
                                                @endforeach
                                            </div>
                                            <div class="d-flex mt-2">
                                                <p id="selectAllInstructorsButton"
                                                    class="text-secondary text-decoration-underline mb-2 m-1">Pilih semua
                                                </p>
                                                <p id="deselectAllInstructorsButton"
                                                    class="text-secondary text-decoration-underline mb-2 m-1">Jangan pilih
                                                    semua</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Tombol Submit -->
                                <button type="submit" class="btn btn-success mt-3">Export</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Script untuk menampilkan form berdasarkan jenis ekspor yang dipilih -->
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const form = document.getElementById('exportForm');
                form.addEventListener('submit', function(event) {
                    event.preventDefault();

                    const activeTab = document.querySelector('.nav-link.active').getAttribute('href');
                    let url = form.action + '?';
                    const params = new URLSearchParams();

                    if (activeTab === '#month') {
                        const year = document.getElementById('year').value;
                        const months = Array.from(document.querySelectorAll(
                            '#monthsWrapper .form-check-input:checked')).map(cb => cb.value);

                        if (months.length > 0) {
                            params.append('exportType', 'month');
                            params.append('year', year);
                            months.forEach(month => params.append('months[]', month));

                            url += params.toString();

                            window.location.href = url;
                        }
                    } else if (activeTab === '#instructor') {
                        const instructors = Array.from(document.querySelectorAll(
                            '#instructorsWrapper .form-check-input:checked')).map(cb => cb.value);

                        if (instructors.length > 0) {
                            params.append('exportType', 'instructor');
                            instructors.forEach(instructor => params.append('instructors[]', instructor));

                            url += params.toString();

                            window.location.href = url;
                        }
                    }
                });

                // Implementasi seleksi dan deselect semua checkbox
                const checkboxesMonths = document.querySelectorAll('#monthsWrapper .form-check-input');
                const selectAllMonthsButton = document.getElementById('selectAllMonthsButton');
                const deselectAllMonthsButton = document.getElementById('deselectAllMonthsButton');

                selectAllMonthsButton.addEventListener('click', function() {
                    checkboxesMonths.forEach(function(checkbox) {
                        checkbox.checked = true;
                    });
                });

                deselectAllMonthsButton.addEventListener('click', function() {
                    checkboxesMonths.forEach(function(checkbox) {
                        checkbox.checked = false;
                    });
                });

                const checkboxesInstructors = document.querySelectorAll('#instructorsWrapper .form-check-input');
                const selectAllInstructorsButton = document.getElementById('selectAllInstructorsButton');
                const deselectAllInstructorsButton = document.getElementById('deselectAllInstructorsButton');

                selectAllInstructorsButton.addEventListener('click', function() {
                    checkboxesInstructors.forEach(function(checkbox) {
                        checkbox.checked = true;
                    });
                });

                deselectAllInstructorsButton.addEventListener('click', function() {
                    checkboxesInstructors.forEach(function(checkbox) {
                        checkbox.checked = false;
                    });
                });
            });
        </script>








        <div class="page-body">
            <div class="container-xl">
                {{-- mobile --}}
                <div class="mobile">
                    @foreach ($pelatihans as $pelatihan)
                        <div class="card mb-2" style="height: 320px">
                            <div class="card-body">
                                <p class="card-title fs-2">{{ $pelatihan->nama }}</p>
                                <p class="text-secondary m-0 my-1 fs-3">
                                    @if (is_null($pelatihan->relasiDenganRangeTanggal))
                                        <p>Belum ada</p>
                                    @else
                                        {{ \Carbon\Carbon::parse(optional($pelatihan->relasiDenganRangeTanggal)->tanggal_mulai)->format('d F') }}
                                        -
                                        {{ \Carbon\Carbon::parse(optional($pelatihan->relasiDenganRangeTanggal)->tanggal_selesai)->format('d F Y') }}
                                    @endif
                                </p>
                                <div class="row align-items-center">
                                    <div class="col-6 border border-top-0 border-bottom-0 border-start-0">
                                        <p class="text-secondary m-0 my-1">
                                            <span class="fw-bold"> PRL </span> : {{ $pelatihan->prl }}
                                        </p>
                                    </div>
                                    <div class="col-6">
                                        <p class="text-secondary m-0 my-1">
                                            <span class="fw-bold"> Kuota </span> : {{ $pelatihan->kuota }}
                                        </p>
                                    </div>
                                </div>
                                <p class="text-secondary m-0 my-1">
                                    <span class="fw-bold">Lokasi</span> : {{ $pelatihan->lokasi }}
                                </p>
                                <div class="text-secondary m-0 my-1 d-flex align-items-center">
                                    <span class="fw-bold"> Instruktur 1 </span> :
                                    @if ($pelatihan->relasiDenganInstruktur->isEmpty())
                                        Belum ada yang bid
                                    @else
                                        @foreach ($pelatihan->relasiDenganInstruktur as $index => $instruktur)
                                            @if ($index == 0)
                                                {{ $instruktur->user->name }}
                                                <div class="d-flex gap-1 ps-2">
                                                    <a href="/user-detail/{{ $instruktur->user->id }}"
                                                        class="align-items-center d-flex text-decoration-none">
                                                        <button class="btn btn-sm btn-success py-1">
                                                            <i class="ti ti-eye"></i>
                                                        </button>
                                                    </a>
                                                    <a href="/user-detail/delete/{{ $instruktur->id }}"
                                                        class="align-items-center d-flex text-decoration-none">
                                                        <button class="btn btn-sm btn-danger py-1">
                                                            <i class="ti ti-trash"></i>
                                                        </button>
                                                    </a>
                                                </div>
                                            @endif
                                        @endforeach
                                    @endif
                                </div>
                                <div class="text-secondary m-0 my-1 d-flex align-items-center">
                                    <span class="fw-bold"> Instruktur 2 </span>:
                                    @if ($pelatihan->relasiDenganInstruktur->isEmpty())
                                        Belum ada yang bid
                                    @else
                                        {{-- @foreach ($pelatihan->relasiDenganInstruktur as $index => $instruktur) --}}
                                        @if ($index == 1)
                                            {{ $instruktur->user->name }}
                                            <div class="d-flex gap-1 ps-2">
                                                <a href="/user-detail/{{ $instruktur->user->id }}"
                                                    class="align-items-center d-flex text-decoration-none">
                                                    <button class="btn btn-sm btn-success py-1">
                                                        <i class="ti ti-eye"></i>
                                                    </button>
                                                </a>
                                                <a href="/user-detail/delete/{{ $instruktur->id }}"
                                                    class="align-items-center d-flex text-decoration-none">
                                                    <button class="btn btn-sm btn-danger py-1">
                                                        <i class="ti ti-trash"></i>
                                                    </button>
                                                </a>
                                            </div>
                                        @endif
                                        {{-- @endforeach --}}
                                    @endif
                                    </p>
                                </div>
                                <!-- Card footer -->
                                <div class="card-footer">
                                    <div class="d-flex align-items-center justify-content-center">
                                        <div class="col">
                                            <p class="text-secondary m-0"><span>Sisa Kuota :
                                                    {{ $pelatihan->kuota_instruktur }}</span></p>
                                        </div>
                                        <div class="col align-items-center justify-content-center">
                                            <a href="/edit-pelatihan/{{ $pelatihan->id }}"
                                                class="align-items-center d-flex text-decoration-none py-1">
                                                <button class="btn btn-sm btn-warning py-1 w-100">
                                                    <i class="ti ti-edit"></i>
                                                </button>
                                            </a>
                                            <a href="{{ route('pelatihan.delete.store', ['id' => $pelatihan->id]) }}"
                                                class="align-items-center d-flex text-decoration-none py-1">
                                                <button class="btn btn-sm btn-danger py-1 w-100">
                                                    <i class="ti ti-trash"></i>
                                                </button>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    <div class="my-3">
                        {{ $pelatihans->withQueryString()->links() }}
                    </div>
                </div>

                {{-- computer --}}
                <div class="computer">
                    <div class="table-responsive">
                        <table class="table table-vcenter">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Pelatihan</th>
                                    <th>PRL</th>
                                    <th>Tanggal Pelatihan</th>
                                    <th>Lokasi</th>
                                    <th>Kuota</th>
                                    <th>Kuota Instruktur</th>
                                    <th>Instruktur 1</th>
                                    <th>Instruktur 2</th>
                                    <th>Aksi</th>
                                    <th class="w-1"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($pelatihans as $pelatihan)
                                    <tr>
                                        <td>{{ $loop->iteration + $pelatihans->firstItem() - 1 }}</td>
                                        <td>{{ $pelatihan->nama }}</td>
                                        <td>{{ $pelatihan->prl }}</td>
                                        <td class="text-secondary">
                                            @if ($pelatihan->relasiDenganRangeTanggal)
                                                {{ \Carbon\Carbon::parse($pelatihan->relasiDenganRangeTanggal->tanggal_mulai)->format('d F') }}
                                                -
                                                {{ \Carbon\Carbon::parse($pelatihan->relasiDenganRangeTanggal->tanggal_selesai)->format('d F Y') }}
                                            @else
                                                <p>Belum ada</p>
                                            @endif
                                        </td>
                                        <td>{{ $pelatihan->lokasi }}</td>
                                        <td>{{ $pelatihan->kuota }}</td>
                                        <td>{{ $pelatihan->kuota_instruktur }}</td>
                                        <td>
                                            <div class="d-flex justify-content-between">
                                                @if ($pelatihan->relasiDenganInstruktur->isEmpty())
                                                    <p>Belum ada yang bid</p>
                                                @else
                                                    @foreach ($pelatihan->relasiDenganInstruktur as $index => $instruktur)
                                                        @if ($index == 0)
                                                            {{ $instruktur->user->name }}
                                                            <div class="d-flex gap-1 ps-2">
                                                                <a href="/user-detail/{{ $instruktur->user->id }}"
                                                                    class="align-items-center d-flex text-decoration-none">
                                                                    <button class="btn btn-sm btn-success py-1">
                                                                        <i class="ti ti-eye"></i>
                                                                    </button>
                                                                </a>
                                                                <a href="/user-detail/delete/{{ $instruktur->id }}"
                                                                    class="align-items-center d-flex text-decoration-none">
                                                                    <button class="btn btn-sm btn-danger py-1">
                                                                        <i class="ti ti-trash"></i>
                                                                    </button>
                                                                </a>
                                                            </div>
                                                        @endif
                                                    @endforeach
                                                @endif
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex gap-1">
                                                @if ($pelatihan->relasiDenganInstruktur->isEmpty())
                                                    <p>Belum ada yang bid</p>
                                                @else
                                                    {{-- @foreach ($pelatihan->relasiDenganInstruktur as $index => $instruktur) --}}
                                                    @if ($index == 1)
                                                        {{ $instruktur->user->name }}
                                                        <a href="/user-detail/{{ $instruktur->user->id }}"
                                                            class="align-items-center d-flex text-decoration-none">
                                                            <button class="btn btn-sm btn-success py-1">
                                                                <i class="ti ti-eye"></i>
                                                            </button>
                                                        </a>
                                                        <a href="/user-detail/delete/{{ $instruktur->id }}"
                                                            class="align-items-center d-flex text-decoration-none">
                                                            <button class="btn btn-sm btn-danger py-1">
                                                                <i class="ti ti-trash"></i>
                                                            </button>
                                                        </a>
                                                    @endif
                                                    {{-- @endforeach --}}
                                                @endif
                                            </div>
                                        </td>

                                        <td>
                                            <div class="d-flex gap-1">
                                                <a href="/edit-pelatihan/{{ $pelatihan->id }}"
                                                    class="align-items-center d-flex text-decoration-none">
                                                    <button class="btn btn-sm btn-warning py-1">
                                                        <i class="ti ti-edit"></i>
                                                    </button>
                                                </a>
                                                <a href="{{ route('pelatihan.delete.store', ['id' => $pelatihan->id]) }}"
                                                    class="align-items-center d-flex text-decoration-none">
                                                    <button class="btn btn-sm btn-danger py-1">
                                                        <i class="ti ti-trash"></i>
                                                    </button>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="my-3">
                        {{ $pelatihans->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
