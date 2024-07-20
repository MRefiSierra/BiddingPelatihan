@extends('main-layout.main-layout')

@section('title', 'Input Pelatihan')

@section('content')

    <div class="page-wrapper align-items-center justify-content-center d-flex vh-100">
        <div class="row col-xl-6 col-md-8 col-sm-8 col-10" style="margin: 0px">
            <div class="page-center">
                <div class="container py-4">
                    <div class="card w-100">
                        <div class="card-body shadow">
                            <p class="fs-1 fw-semibold text-center mb-4">Input Pelatihan</p>
                            <form method="POST" action="{{ route('storePelatihan') }}">
                                @csrf
                                {{-- <div class="mb-3">
                                    <label class="form-label fs-3">PRL</label>
                                    <input type="text" class="form-control fs-4" name="PRL"
                                        placeholder="Masukkan PRL" />
                                </div> --}}
                                <div class="mb-3">
                                    <label class="form-label fs-3">Nama</label>
                                    <input type="text" class="form-control" name="Nama"
                                        placeholder="Masukkan nama pelatihan" />
                                </div>
                                <div class="d-flex gap-sm-3">
                                    <div class="mb-3 col-sm col-6">
                                        <label class="form-label fs-3">Tanggal Mulai</label>
                                        <input type="date" class="form-control" name="TanggalMulai"
                                            placeholder="Input placeholder" min="{{ date('Y-m-d') }}" />
                                    </div>
                                    <div class="mb-3 col-sm col-6">
                                        <label class="form-label fs-3">Tanggal Akhir</label>
                                        <input type="date" class="form-control" name="TanggalAkhir"
                                            placeholder="Input placeholder" min="{{ date('Y-m-d') }}" />
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label fs-3">Kuota Instruktur</label>
                                        <input type="text" class="form-control" name="KuotaInstruktur"
                                            placeholder="Input placeholder" />
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label fs-3">Kuota</label>
                                        <input type="text" class="form-control" name="Kuota"
                                            placeholder="Input placeholder" />
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label fs-3">Lokasi</label>
                                        <input type="text" class="form-control" name="Lokasi"
                                            placeholder="Input placeholder" />
                                    </div>
                                    <div class="form-footer text-center">
                                        <button type="submit" class="btn btn-primary w-50 text-center shadow">Submit</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- <div class="page-body">
            <div class="container-xl p-2">
                <form class="px-5 pt-3">
                    @csrf
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
                        <input type="number" class="form-control" name="KuotaInstruktur" placeholder="Input placeholder" />
                    </div>
                    <div class="mb-3">
                        <label class="form-label fs-1">Kuota Instruktur</label>
                        <input type="number" class="form-control" name="Kuota" placeholder="Input placeholder" />
                    </div>
                    <div class="mb-3">
                        <label class="form-label fs-1">Lokasi</label>
                        <input type="text" class="form-control" name="Lokasi" placeholder="Input placeholder" />
                    </div>
                    <div class="mt-auto text-right">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>

                </form>
            </div>
        </div> --}}
        </div>
        </div>

        </div>

@endsection
