@extends('main-layout.main-layout')

@section('title', 'Input Pelatihan')

@section('content')

    <div class="page-wrapper align-items-center justify-content-center d-flex vh-100">
        <div class="row col-xl-6 col-md-8 col-sm-8 col-10" style="margin: 0px">
            <div class="page-center">
                <div class="container py-4">
                    <div class="card w-100">
                        <div class="card-body shadow">
                            <p class="fs-1 fw-semibold text-center mb-4">Edit User {{ $user->name }}</p>
                            <form method="POST" action="{{ route('managementUser.update', $user->id) }}">
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
                                            name="nama" placeholder="Masukkan nama user" value="{{ $user->name }}" />
                                        @error('Nama')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <div class="has-validation">
                                        <label class="form-label fs-3">Email</label>
                                        <input type="email" class="form-control @error('Email') is-invalid @enderror"
                                            name="email" placeholder="Masukkan Email user" value="{{ $user->email }}" />
                                        @error('Email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fs-3">Role</label>
                                    <div class="form-selectgroup">
                                        <label class="form-selectgroup-item">
                                            <input type="radio" name="role" value="admin"
                                                class="form-selectgroup-input" {{ $user->role === 'admin' ? 'checked' : '' }} />
                                            <span class="form-selectgroup-label">Admin</span>
                                        </label>
                                        <label class="form-selectgroup-item">
                                            <input type="radio" name="role" value="instruktur"
                                                class="form-selectgroup-input" {{ $user->role === 'instruktur' ? 'checked' : '' }}/>
                                            <span class="form-selectgroup-label"> Instruktur</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <div class="has-validation">
                                        <label class="form-label fs-3">Password</label>
                                        <input type="text" class="form-control @error('Password') is-invalid @enderror"
                                            name="password" placeholder="Masukkan password" value="{{ old('Password') }}" />
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
