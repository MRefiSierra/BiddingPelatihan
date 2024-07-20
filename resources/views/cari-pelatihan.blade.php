@extends('main-layout.main-layout')

@section('title', 'Cari Pelatihan')

@section('content')

    <div class="table-responsive">
        <table class="table table-vcenter">
            <thead>
                <tr>
                    <th>Nama Pelatihan</th>
                    <th>Tanggal</th>
                    <th>Lokasi</th>
                    <th>Kuota</th>
                    <th>Kuota Instruktur</th>
                    <th class="w-1">Action</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Paweł Kuna</td>
                    <td class="text-secondary">
                        UI Designer, Training
                    </td>
                    <td class="text-secondary"><a href="#" class="text-reset">paweluna@howstuffworks.com</a></td>
                    <td class="text-secondary">
                        User
                    </td>
                    <td class="text-secondary">
                        User
                    </td>
                    <td>
                        <div>
                            <a href="#">Edit</a>
                            <a href="#" class="text-danger">Delete</a>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>


@endsection
