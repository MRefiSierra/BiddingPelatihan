@extends('main-layout.main-layout')

@section('title', 'Cari Pelatihan')

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
                            Cari Pelatihan
                        </h2>
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
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $pelatihan->nama }}</td>
                                    <td class="text-secondary">
                                        @if (is_null($pelatihan->relasiDenganRangeTanggal))
                                            <p>Belum ada</p>
                                        @else
                                            {{ \Carbon\Carbon::parse(optional($pelatihan->relasiDenganRangeTanggal)->tanggal_mulai)->format('d') }}
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
                                            @elseif ($pelatihan->sudahBid == 0)
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
                </div>

            </div>
        </div>
    </div>


@endsection
