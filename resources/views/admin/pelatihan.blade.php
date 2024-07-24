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
                display: none
            }
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
                    <div class="col d-lg-flex justify-content-end gap-2">
                        <div class="row">
                            <div class=" text-center">
                                <form action="{{ route('exportExcel.store') }}" method="GET" class="d-inline-block w-100">
                                    <div class="input-group">
                                        <input type="month" name="bulan" class="form-control">
                                        <button type="submit" class="btn btn-large btn-success">
                                            <i class="ti ti-file-excel pe-2 fs-2"></i>
                                            Print Excel
                                        </button>
                                    </div>
                                </form>
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
