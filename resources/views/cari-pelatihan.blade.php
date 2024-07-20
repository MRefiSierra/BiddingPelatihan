@extends('main-layout.main-layout')

@section('title', 'Cari Pelatihan')

@section('content')
    <div class="page-wrapper">
        <div class="page-header d-print-none">
            <div class="container-xl">
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
                                        {{ \Carbon\Carbon::parse($pelatihan->relasiDenganRangeTanggal->tanggal_mulai)->format('d') }}
                                        -
                                        {{ \Carbon\Carbon::parse($pelatihan->relasiDenganRangeTanggal->tanggal_selesai)->format('d F Y') }}
                                    </td>
                                    <td class="text-secondary">{{ $pelatihan->lokasi }}</td>
                                    <td class="text-secondary">{{ $pelatihan->kuota }}</td>
                                    <td class="text-secondary">{{ $pelatihan->kuota_instruktur }}</td>
                                    <td>
                                        <form action="{{ route('cariPelatihan.store', ['id' => $pelatihan->id]) }}"
                                            method="POST">
                                            @csrf
                                            <input type="hidden" name="pelatihan_id" value="{{ $pelatihan->id }}">
                                            @if ($pelatihan->KuotaInstruktur)
                                                <p class="btn btn-sm btn-danger rounded" href="#">Full</p>
                                            @elseif($pelatihan->sudahBid)
                                                <p class="btn btn-sm btn-secondary rounded"
                                                    href="#">Terpilih</p>
                                            @else
                                                <button class="btn btn-sm btn-primary rounded" type="submit">Pilih
                                                    Pelatihan</button>
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
