@extends('main-layout.main-layout')

@section('title', 'Management User')

@section('content')
    <div class="page-wrapper">
        <div class="page-header d-print-none">
            <div class="container-xl">
                <div class="row g-2 align-items-center">
                    <div class="col">
                        <h2 class="page-title">
                            Management User
                        </h2>
                    </div>
                    <div class="col text-end align-items-center">
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
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td class="text-secondary">{{ $user->email }}</td>
                                    <td class="text-secondary">{{ $user->role }}</td>
                                    <td>
                                        <a class="btn btn-sm btn-success rounded" href="{{ route('managementUser.view.form.edit', ['id' => $user->id]) }}">Edit</button>
                                        <a class="btn btn-sm btn-danger rounded" href="{{ route('managementUser.delete', ['id' => $user->id]) }}">Delete</button>
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
