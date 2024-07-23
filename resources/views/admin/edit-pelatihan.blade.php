@extends('main-layout.main-layout')

@section('title', 'Edit Pelatihan')

@section('content')

    <div class="page-wrapper align-items-center justify-content-center d-flex vh-100">
        <div class="row col-xl-6 col-md-8 col-sm-8 col-10" style="margin: 0px">
            <div class="page-center">
                <div class="container py-4">
                    <div class="card w-100">
                        <div class="card-body shadow">
                            <p class="fs-1 fw-semibold text-center mb-4">Edit Pelatihan {{ $pelatihan->nama }}</p>
                            <form method="POST" action="{{ route('Pelatihan.update.store', $pelatihan->id) }}">
                                @csrf
                                @method('PUT')
                                {{-- <div class="mb-3">
                                    <label class="form-label fs-3">PRL</label>
                                    <input type="text" class="form-control fs-4" name="PRL"
                                        placeholder="Masukkan PRL" />
                                </div> --}}
                                <div class="mb-3">
                                    <div class="has-validation">
                                        <label class="form-label fs-3">Nama</label>
                                        <input type="text" class="form-control @error('Nama') is-invalid @enderror"
                                            name="nama" placeholder="Masukkan nama pelatihan"
                                            value="{{ $pelatihan->nama }}" />
                                        @error('nama')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="d-flex gap-sm-3">
                                    <div class="mb-3 col-sm col-6">
                                        <label class="form-label fs-3">Tanggal Mulai</label>
                                        <input type="date" id="TanggalMulai"
                                            class="form-control @error('TanggalMulai') is-invalid @enderror"
                                            name="TanggalMulai" placeholder="Input placeholder" min="{{ date('Y-m-d') }}"
                                            value="{{ $pelatihan->relasiDenganRangeTanggal->tanggal_mulai }}" />
                                        @error('TanggalMulai')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="mb-3 col-sm col-6">
                                        <label class="form-label fs-3">Tanggal Akhir</label>
                                        <input type="date" id="TanggalAkhir"
                                            class="form-control @error('TanggalAkhir') is-invalid @enderror"
                                            name="TanggalAkhir" placeholder="Input placeholder"
                                            value="{{ $pelatihan->relasiDenganRangeTanggal->tanggal_selesai }}" />
                                        @error('TanggalAkhir')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <div class="d-flex gap-3">
                                        <div class="col">
                                            <label class="form-label fs-3">Kuota Instruktur</label>
                                            <input type="number"
                                                class="form-control @error('KuotaInstruktur') is-invalid @enderror"
                                                name="KuotaInstruktur" placeholder="Masukkan Kuota Instruktur" value="{{ $pelatihan->kuota_instruktur }}" min="1" max="2" />
                                            @error('KuotaInstruktur')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col">
                                            <label class="form-label fs-3">Kuota</label>
                                            <input type="number" class="form-control @error('Kuota') is-invalid @enderror"
                                                name="Kuota" placeholder="Masukkan Kuota" value="{{ $pelatihan->kuota }}" />
                                            @error('Kuota')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <div class="d-flex gap-3">
                                        <div class="col">
                                            <label class="form-label fs-3">Lokasi</label>
                                            <input type="text" class="form-control @error('Lokasi') is-invalid @enderror"
                                                name="Lokasi" placeholder="Masukkan Lokasi" value="{{ $pelatihan->lokasi }}" />
                                            @error('Lokasi')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col">
                                            <label class="form-label fs-3">PRL</label>
                                            <input type="text" class="form-control @error('PRL') is-invalid @enderror"
                                                name="PRL" placeholder="Masukkan PRL" value="{{ $pelatihan->prl }}" />
                                            @error('PRL')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
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
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const startDateInput = document.getElementById('TanggalMulai');
            const endDateInput = document.getElementById('TanggalAkhir');
            const today = new Date().toISOString().split('T')[0];
            startDateInput.min = today

            startDateInput.addEventListener('change', function() {
                endDateInput.min = startDateInput.value;
            });

            // Set initial min value for end date if start date is already selected
            if (startDateInput.value) {
                endDateInput.min = startDateInput.value;
            }
        });
    </script>

@endsection
