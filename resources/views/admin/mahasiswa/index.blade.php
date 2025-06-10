@extends('layouts.app')

@section('title', 'Daftar Siswa')



@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <a class="btn btn-sm btn-primary" href="{{ route('admin.mahasiswa.create', ['id' => 1]) }}">Tambah Siswa</a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Email</th>
                                <th>Kelas</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($mahasiswas as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->name }}</td>
                                    <td>{{ $item->email }}</td>
                                    <td>{{ optional($item->kelas)->nama ?? '-' }}</td>
                                    <td>
                                        @if (!isset($item->kelas))
                                            <a href="{{ route('admin.mahasiswa.addKelas', ['id' => $item->id]) }}"
                                                class="btn btn-primary btn-sm">Tambah Kelas</a>
                                        @endif
                                        <a href="{{ route('admin.mahasiswa.editKelas', ['id' => $item->id]) }}"
                                            class="btn btn-warning btn-sm">Edit Kelas</a>
                                        <form action="{{ route('admin.mahasiswa.destroy', $item->id) }}" method="POST"
                                            class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-danger btn-sm"
                                                onclick="return confirm('Yakin hapus siswa ini?')">Hapus Siswa</button>
                                        </form>
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
