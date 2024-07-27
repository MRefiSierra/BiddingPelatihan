@extends('main-layout.main-layout')

@section('title', 'Management User')

@section('content')
    <style>
        .computer {
            @media screen and (min-width: 576px) {
                display: block;
            }

            @media screen and (max-width: 575px) {
                display: none
            }
        }

        .mobile {
            @media screen and (max-width: 576px) {
                display: block;
            }

            @media screen and (min-width: 575px) {
                display: none
            }
        }
    </style>
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
                        <h4 class="alert-title fs-2">Oops, </h4>
                        <div class="text-secondary">{{ session('error') }}</div>
                        <a class="btn-close" data-bs-dismiss="alert" aria-label="close"></a>
                    </div>
                @endif
                <div class="row g-2 align-items-center">
                    <div class="col-12 col-xl-6 col-lg-4 col-md-12 col-sm-12">
                        <h2 class="page-title">
                            Management User
                        </h2>
                    </div>
                    <div class="col d-lg-flex text-end align-items-center justify-content-end gap-2">
                        <div class="row">
                            <div class="text-center">
                                <form action="" method="GET">
                                    <div class="input-group">
                                        <input type="text" name="keyword" class="form-control"
                                            placeholder="Cari user...">
                                        <button type="submit" class="btn btn-primary">Cari</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="row pt-lg-0 pt-2">
                            <div class="text-center">
                                <a class="btn btn-large btn-success w-100" href="{{ route('managementUser.view.form') }}">
                                    <i class="ti ti-plus pe-2 fs-2"></i>
                                    Tambah User
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="page-body">
            <div class="container-xl">
                {{-- mobile --}}
                <div class="mobile">
                    @foreach ($users as $user)
                        <div class="card mb-2" style="height: 180px">
                            <div class="card-body">
                                <p class="card-title fs-2">{{ $user->name }}</p>
                                <p class="text-secondary m-0 my-1">
                                    <span class="fw-bold">
                                        Email
                                    </span> :
                                    {{ $user->email }}
                                </p>
                                <p class="text-secondary m-0 my-1">
                                    <span class="fw-bold">
                                        Role
                                    </span> :
                                    {{ ucfirst($user->role) }}
                                </p>
                            </div>
                            <!-- Card footer -->
                            <div class="card-footer">
                                <div class="d-flex align-items-center justify-content-center gap-2">
                                    <div class="col">
                                        <a class="btn btn-sm btn-primary rounded w-100"
                                            href="{{ route('managementUser.view.form.edit', ['id' => $user->id]) }}">Edit</a>
                                    </div>
                                    <div class="col">
                                        <div class="d-flex gap-2">
                                            <a class="btn btn-sm btn-danger rounded 
                                            @if ($user->role == 'instruktur') w-50 @else w-100 @endif  "
                                                href="{{ route('managementUser.delete', ['id' => $user->id]) }}">Delete</a>
                                            {{-- @if ($user->role == 'instruktur')
                                                <a class="btn btn-sm btn-success rounded w-50"
                                                    href="{{ route('exportExcelInstruktur.store', $user->id) }}"><i
                                                        class="ti ti-file-spreadsheet"></i></a>
                                            @endif --}}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    {{ $users->withQueryString()->links() }}
                </div>


                {{-- computer --}}
                <div class="computer">
                    <div class="table-responsive">
                        <table class="table table-vcenter mb-3">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th>Aksi</th>
                                    <th class="w-1"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $user)
                                    <tr>
                                        <td>{{ $loop->iteration + $users->firstItem() - 1 }}</td>
                                        <td>{{ $user->name }}</td>
                                        <td class="text-secondary">{{ $user->email }}</td>
                                        <td class="text-secondary">{{ ucfirst($user->role) }}</td>
                                        <td class="d-flex gap-1">
                                            <a class="btn btn-sm btn-primary rounded"
                                                href="{{ route('managementUser.view.form.edit', ['id' => $user->id]) }}">Edit</a>
                                            <a class="btn btn-sm btn-danger rounded"
                                                href="{{ route('managementUser.delete', ['id' => $user->id]) }}">Delete</a>
                                            {{-- @if ($user->role == 'instruktur')
                                                <a class="btn btn-sm btn-success rounded"
                                                    href="{{ route('exportExcelInstruktur.store', $user->id) }}"><i
                                                        class="ti ti-file-spreadsheet"></i></a>
                                            @endif --}}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{ $users->withQueryString()->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
