@extends('main-layout.main-layout')

@section('title', 'History Pelatihan')

@section('content')
    <div class="page">
        <div class="page-wrapper">
            <div class="page-header d-print-none">
                <div class="container-xl">
                    <div class="row g-2 align-items-center">
                        <div class="col">
                            <p class="page-title fs-1">
                                History Pelatihan
                            </p>
                        </div>
                        <div class="col text-end">
                            <a href="{{ route('pelatihan-aktif') }}" class="btn btn-secondary">Kembali ke Pelatihan Aktif</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="page-body">
                <div class="container-xl">
                    @foreach ($pelatihanPerBulan as $bulan => $pelatihans)
                        <h2>{{ $bulan }}</h2>
                        <div class="row mb-3">
                            @foreach ($pelatihans as $pelatihan)
                                <div class="col-3 mb-3">
                                    <div class="card">
                                        <div class="card-status-top bg-secondary"></div>
                                        <div class="card-body">
                                            <h3 class="card-title">{{ $pelatihan->nama }}</h3>
                                            <p class="text-secondary">
                                                Tanggal: {{ \Carbon\Carbon::parse($pelatihan->relasiDenganRangeTanggal->tanggal_mulai)->format('d') }} -
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
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection
