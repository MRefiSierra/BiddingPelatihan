@extends('main-layout.main-layout')

@section('title', 'Cari Pelatihan')

@section('content')
    <style>
        .p-sm-0 {
            @media screen and (max-width: 576px) {
                padding: 0px !important
            }
        }

        .ps-sm-1 {
            @media screen and (max-width: 576px) {
                padding: 0px !important
            }
        }

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
                    <div class="col">
                        <h2 class="page-title">
                            Cari Pelatihan
                        </h2>
                    </div>
                    <div class="col-xl-3 col-lg-3 col-md-4 col-sm-5 col-12">
                        <form action="" method="GET">
                            <div class="input-group">
                                <input type="text" name="keyword" class="form-control" placeholder="Cari pelatihan...">
                                <button type="submit" class="btn btn-primary">Cari</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="page-body">
            <div class="container-xl">
                {{-- mobile --}}
                <div class="mobile">
                    @foreach ($pelatihans as $pelatihan)
                        <div class="card mb-2" style="height: 250px">
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
                                <div class="row align-items-center ">
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
                            </div>
                            <!-- Card footer -->
                            <div class="card-footer">
                                <div class="d-flex align-items-center justify-content-center">
                                    <div class="col">
                                        <p class="text-secondary m-0"><span>Sisa Kuota :
                                                {{ $pelatihan->kuota_instruktur }}</span></p>
                                    </div>
                                    <div class="col">
                                        <form class="d-flex align-items-center justify-content-center" action="{{ route('cariPelatihan.store', ['id' => $pelatihan->id]) }}"
                                            method="POST">
                                            @csrf
                                            <input type="hidden" name="pelatihan_id" value="{{ $pelatihan->id }}">
                                            @if ($pelatihan->sudahBid && $pelatihan->kuota_instruktur != 0)
                                                <p class="btn btn-sm btn-secondary rounded w-100 m-0" href="#">Terpilih</p>
                                            @elseif ($pelatihan->sudahBid == 0 && $pelatihan->kuota_instruktur != 0)
                                                <button class="btn btn-sm btn-primary rounded w-100 m-0" type="submit">Pilih
                                                    Pelatihan</button>
                                            @else
                                                <p class="btn btn-sm btn-danger rounded w-100 m-0" href="#">Full</p>
                                            @endif
                                        </form>
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
                                    <th>Tanggal</th>
                                    <th>Lokasi</th>
                                    <th>Kuota</th>
                                    <th>Kuota Instruktur</th>
                                    <th class="w-1">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($pelatihans as $pelatihan)
                                    <tr>
                                        <td>{{ $loop->iteration + $pelatihans->firstItem() - 1 }}</td>
                                        <td>{{ $pelatihan->nama }}</td>
                                        <td>{{ $pelatihan->prl }}</td>
                                        <td class="text-secondary">
                                            @if (is_null($pelatihan->relasiDenganRangeTanggal))
                                                <p>Belum ada</p>
                                            @else
                                                {{ \Carbon\Carbon::parse(optional($pelatihan->relasiDenganRangeTanggal)->tanggal_mulai)->format('d F') }}
                                                -
                                                {{ \Carbon\Carbon::parse(optional($pelatihan->relasiDenganRangeTanggal)->tanggal_selesai)->format('d F Y') }}
                                            @endif

                                        </td>
                                        <td class="text-secondary">{{ $pelatihan->lokasi }}</td>
                                        <td class="text-secondary">{{ $pelatihan->kuota }}</td>
                                        <td class="text-secondary">{{ $pelatihan->kuota_instruktur }}</td>
                                        <td>
                                            <form action="{{ route('cariPelatihan.store', ['id' => $pelatihan->id]) }}"
                                                method="POST">
                                                @csrf
                                                <input type="hidden" name="pelatihan_id" value="{{ $pelatihan->id }}">
                                                @if ($pelatihan->sudahBid && $pelatihan->kuota_instruktur != 0)
                                                    <p class="btn btn-sm btn-secondary rounded" href="#">Terpilih</p>
                                                @elseif ($pelatihan->sudahBid == 0 && $pelatihan->kuota_instruktur != 0)
                                                    <button class="btn btn-sm btn-primary rounded" type="submit">Pilih
                                                        Pelatihan</button>
                                                @else
                                                    <p class="btn btn-sm btn-danger rounded" href="#">Full</p>
                                                @endif
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="my-3">
                            {{ $pelatihans->withQueryString()->links() }}
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>


@endsection
