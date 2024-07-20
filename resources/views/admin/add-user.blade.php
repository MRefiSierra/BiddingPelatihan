@extends('main-layout.main-layout')


@section('title', 'Tambah User')


@section('content')
<div class="page-wrapper align-items-center justify-content-center d-flex vh-100">
    <div class="row col-xl-6 col-md-8 col-sm-8 col-10" style="margin: 0px">
        <div class="page-center">
            <div class="container py-4">
                <div class="card w-100">
                    <div class="card-body shadow">
                        <p class="fs-1 fw-semibold text-center mb-4">Tambah User</p>
                        <form method="POST" action="{{route('managementUser.store')}} " enctype="multipart/form-data">
                            @csrf
                            {{-- <div class="mb-3">
                                <label class="form-label fs-3">PRL</label>
                                <input type="text" class="form-control fs-4" name="PRL"
                                    placeholder="Masukkan PRL" />
                            </div> --}}
                            <div class="mb-3">
                                <div class="has-validation">
                                    <label class="form-label fs-3">Nama</label>
                                    <input type="text" class="form-control" name="nama" placeholder="Nama Lengkap"/>
                                </div>
                            </div>
                            <div class="d-flex gap-sm-3">
                                <div class="mb-3 col-sm col-6">
                                    <label class="form-label fs-3">Email</label>
                                    <input type="email" id="TanggalMulai" name="email"
                                        class="form-control"/>
                                </div>
                                <div class="mb-3 col-sm col-6">
                                    <label class="form-label fs-3">Password</label>
                                    <input type="password" id="TanggalAkhir" name="password"
                                        class="form-control" />
                                </div>
                            </div>
                            <div>
                                <label for="role">Role:</label>
                                <div>
                                    <input type="radio" id="admin" name="role" value="admin" {{ old('role') == 'admin' ? 'checked' : '' }}>
                                    <label for="admin">Admin</label>
                                </div>
                                <div>
                                    <input type="radio" id="instruktur" name="role" value="instruktur" {{ old('role') == 'instruktur' ? 'checked' : '' }}>
                                    <label for="instruktur">instruktur</label>
                                </div>
                                @error('role')
                                    <div>{{ $message }}</div>
                                @enderror
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
@endsection
