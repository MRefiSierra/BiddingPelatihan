@extends('main-layout.main-layout')

@section('title', 'Management User')

@section('content')
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
                        <h4 class="alert-title fs-2">Congrats, </h4>
                        <div class="text-secondary">{{ session('error') }}</div>
                        <a class="btn-close" data-bs-dismiss="alert" aria-label="close"></a>
                    </div>
                @endif
                <div class="row g-2 align-items-center">
                    <div class="col">
                        <h2 class="page-title">
                            Management User
                        </h2>
                    </div>
                    <div class="col d-flex text-end align-items-center justify-content-end gap-2">
                        <form action="" method="GET">
                            <div class="input-group">
                                <input type="text" name="keyword" class="form-control" placeholder="Cari user...">
                                <button type="submit" class="btn btn-primary">Cari</button>
                            </div>
                        </form>
                        <a class="btn btn-large btn-success" href="{{ route('managementUser.view.form') }}">
                            <i class="ti ti-plus pe-2 fs-2"></i>
                            Tambah User
                        </a>
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
                                    <td class="text-secondary">{{ $user->role }}</td>
                                    <td class="d-flex gap-1">
                                        <a class="btn btn-sm btn-primary rounded"
                                            href="{{ route('managementUser.view.form.edit', ['id' => $user->id]) }}">Edit</a>
                                        <a class="btn btn-sm btn-danger rounded"
                                            href="{{ route('managementUser.delete', ['id' => $user->id]) }}">Delete</a>
                                        @if ($user->role == 'instruktur')
                                            <a class="btn btn-sm btn-success rounded" href="{{ route('exportExcelInstruktur.store', $user->id)}}"><i
                                                    class="ti ti-file-spreadsheet"></i></a>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                {{ $users->withQueryString()->links() }}
            </div>
        </div>
    </div>
@endsection
