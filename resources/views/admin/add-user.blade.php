@extends('main-layout.main-layout')

@section('title', 'Input Pelatihan')

@section('content')

    <div class="page-wrapper align-items-center justify-content-center d-flex vh-100">
        <div class="row col-xl-6 col-md-8 col-sm-8 col-10" style="margin: 0px">
            <div class="page-center">
                <div class="container py-4">
                    <div class="card w-100">
                        <div class="card-body shadow">
                            <p class="fs-1 fw-semibold text-center mb-4">Tambah User</p>
                            <form method="POST" action="{{ route('storePelatihan') }}">
                                @csrf
                                {{-- <div class="mb-3">
                                    <label class="form-label fs-3">PRL</label>
                                    <input type="text" class="form-control fs-4" name="PRL"
                                        placeholder="Masukkan PRL" />
                                </div> --}}
                                <div class="mb-3">
                                    <div class="has-validation">
                                        <label class="form-label fs-3">Nama</label>
                                        <input type="text" class="form-control @error('Nama') is-invalid @enderror"
                                            name="Nama" placeholder="Masukkan nama user" value="{{ old('Nama') }}" />
                                        @error('Nama')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <div class="has-validation">
                                        <label class="form-label fs-3">Email</label>
                                        <input type="email" class="form-control @error('Email') is-invalid @enderror"
                                            name="Email" placeholder="Masukkan Email user" value="{{ old('Email') }}" />
                                        @error('Email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fs-3">Role</label>
                                    <div class="form-selectgroup">
                                        <label class="form-selectgroup-item">
                                            <input type="radio" name="icons" value="admin"
                                                class="form-selectgroup-input" checked />
                                            <span class="form-selectgroup-label">Admin</span>
                                        </label>
                                        <label class="form-selectgroup-item">
                                            <input type="radio" name="icons" value="instruktur"
                                                class="form-selectgroup-input" />
                                            <span class="form-selectgroup-label"> Instruktur</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <div class="has-validation">
                                        <label class="form-label fs-3">Password</label>
                                        <input type="text" class="form-control @error('Password') is-invalid @enderror"
                                            name="Password" placeholder="Masukkan password" value="{{ old('Password') }}" />
                                        @error('Password')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
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
@endsection
