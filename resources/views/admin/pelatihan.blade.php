@extends('main-layout.main-layout')

@section('title', 'Input Pelatihan')

@section('content')

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
                    <div class="col">
                        <h2 class="page-title">
                            Listing Pelatihan
                        </h2>
                    </div>
                    <div class="col text-end align-items-center">
                        <a href="/input-pelatihan" class="text-light text-decoration-none">
                            <button class="btn btn-large btn-success">
                                <i class="ti ti-plus pe-2 fs-2"></i>
                                Tambah Pelatihan
                            </button>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="page-body">
            <div class="container-xl">
                <div class="table-responsive">
                    <table class="table table-vcenter">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Pelatihan</th>
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
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $pelatihan->nama }}</td>
                                    <td class="text-secondary">
                                        @if ($pelatihan->relasiDenganRangeTanggal)
                                            {{ \Carbon\Carbon::parse($pelatihan->relasiDenganRangeTanggal->tanggal_mulai)->format('d') }}
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
                                        <div class="d-flex gap-1">
                                            @if ($pelatihan->relasiDenganInstruktur->isEmpty())
                                                <p>Belum ada yang bid</p>
                                            @else
                                                @foreach ($pelatihan->relasiDenganInstruktur as $index => $instruktur)
                                                    @if ($index == 0)
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
                                            <a href="/user-detail/delete/"
                                                class="align-items-center d-flex text-decoration-none">
                                                <button class="btn btn-sm btn-warning py-1">
                                                    <i class="ti ti-edit"></i>
                                                </button>
                                                <a href="/user-detail/delete/"
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

            </div>
        </div>
    </div>

@endsection
