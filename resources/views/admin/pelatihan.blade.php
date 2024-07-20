@extends('main-layout.main-layout')

@section('title', 'Input Pelatihan')

@section('content')

    <div class="page-wrapper">
        <div class="page-header d-print-none">
            <div class="container-xl">
                <div class="row g-2 align-items-center">
                    <div class="col">
                        <h2 class="page-title">
                            Listing Pelatihan
                        </h2>
                    </div>
                    <div class="col text-end align-items-center">
                        <a href="/input-pelatihan" class="text-light text-decoration-none">
                            <button class="btn btn-large btn-success">
                                <i class="ti ti-plus pe-2 fs-2"></i>
                                Tambah Pelatihan
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
                                <th>Nama Pelatihan</th>
                                <th>Tanggal Pelatihan</th>
                                <th>Lokasi</th>
                                <th>Kuota</th>
                                <th>Kuota Instruktur</th>
                                <th>Instruktur 1</th>
                                <th>Instruktur 2</th>
                                <th>Aksi</th>
                                <th class="w-1"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td>Melatih keasabaran</td>
                                <td class="text-secondary">
                                    20-12-2022 s/d 29-12-2022
                                </td>
                                <td>
                                    Amerika
                                </td>
                                <td>
                                    120
                                </td>
                                <td>
                                    2
                                </td>
                                <td>
                                    <div class="d-flex gap-1">
                                        <i>Tidak ada</i>
                                        <button class="btn btn-sm btn-success">
                                            <i class="ti ti-eye"></i>
                                        </button>
                                        <button class="btn btn-sm btn-danger">
                                            <i class="ti ti-trash"></i>
                                        </button>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex gap-1">
                                        <i>Tidak ada</i>
                                        <a href="/user-detail" class="align-items-center d-flex text-decoration-none">
                                            <button class="btn btn-sm btn-success py-1">
                                                <i class="ti ti-eye"></i>
                                            </button>
                                        </a>
                                        <a href="" class="align-items-center d-flex text-decoration-none">
                                            <button class="btn btn-sm btn-danger py-1">
                                                <i class="ti ti-trash"></i>
                                            </button>
                                        </a>
                                    </div>
                                </td>
                                <td>
                                    <div>
                                        <button class="btn btn-sm btn-warning">Edit</button>
                                        <button class="btn btn-sm btn-danger">Delete</button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>

@endsection
