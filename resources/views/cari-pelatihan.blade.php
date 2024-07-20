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
            {{$pelatihans}}
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
                                <td>1</td>
                                <td>{{$pelatihan->nama}}</td>
                                <td class="text-secondary"><a href="#"
                                        class="text-reset">{{$pelatihan->relasi_dengan_range_tanggal}}</a>
                                </td>
                                <td class="text-secondary"><a href="#"
                                        class="text-reset">50</a>
                                </td>
                                <td class="text-secondary"><a href="#"
                                        class="text-reset">50</a>
                                </td>
                                <td class="text-secondary"><a href="#"
                                        class="text-reset">50</a>
                                </td>
                                <td>
                                    <button class="btn btn-sm btn-primary rounded" href="#">Pilih Pelatihan</button>

                                    <button class="btn btn-sm btn-secondary rounded" href="#">Terpilih</button>

                                    <button class="btn btn-sm btn-danger rounded" href="#">Full</button>
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
