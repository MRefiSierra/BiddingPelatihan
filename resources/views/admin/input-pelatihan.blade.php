@extends('main-layout.main-layout')

@section('title', 'Input Pelatihan')

@section('content')

    <div class="page-wrapper">
        <div class="page-header d-print-none">
            <div class="container-xl">
                <div class="row g-2 align-items-center">
                    <div class="col">
                        <h1 class="page-title fs-1">
                            Input Pelatihan
                        </h1>
                    </div>
                </div>
            </div>
        </div>

        <div class="page-body">
            <div class="container-xl p-2">
                <form class="px-5 pt-3">
                    <div class="mb-3">
                        <label class="form-label fs-1">PRL</label>
                        <input type="text" class="form-control" name="PRL" placeholder="Input placeholder" />
                    </div>
                    <div class="mb-3">
                        <label class="form-label fs-1">Nama</label>
                        <input type="text" class="form-control" name="Nama" placeholder="Input placeholder" />
                    </div>
                    <div class="d-flex">
                        <div class="mb-3 me-5">
                            <label class="form-label fs-1">Tanggal Mulai</label>
                            <input type="date" class="form-control" name="TanggalMulai"
                                placeholder="Input placeholder" />
                        </div>
                        <div class="mb-3">
                            <label class="form-label fs-1">Tanggal Akhir</label>
                            <input type="date" class="form-control" name="TanggalAkhir"
                                placeholder="Input placeholder" />
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fs-1">Kuota Instruktur</label>
                        <input type="text" class="form-control" name="Kuota" placeholder="Input placeholder" />
                    </div>
                    <div class="mb-3">
                        <label class="form-label fs-1">Lokasi</label>
                        <input type="text" class="form-control" name="Lokasi" placeholder="Input placeholder" />
                    </div>
                    <div class="mt-auto text-right">
                        <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                    </div>

                </form>
            </div>
        </div>

    </div>


@endsection
