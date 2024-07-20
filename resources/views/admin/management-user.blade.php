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
                        <a href="/add-user" class="text-light text-decoration-none">
                            <button class="btn btn-large btn-success">
                                <i class="ti ti-plus pe-2 fs-2"></i>
                                Tambah Instruktur
                            </button>
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
                                <th>Aksi</th>
                                <th class="w-1"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td>Paweł Kuna</td>
                                <td class="text-secondary"><a href="#"
                                        class="text-reset">paweluna@howstuffworks.com</a>
                                </td>
                                <td>
                                    <button class="btn btn-sm btn-success rounded" href="#">Edit</button>
                                    <button class="btn btn-sm btn-danger rounded" href="#">Delete</button>
                                </td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td>Paweł Kuna</td>
                                <td class="text-secondary"><a href="#"
                                        class="text-reset">paweluna@howstuffworks.com</a>
                                </td>
                                <td>
                                    <button class="btn btn-sm btn-success rounded" href="#">Edit</button>
                                    <button class="btn btn-sm btn-danger rounded" href="#">Delete</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
@endsection
