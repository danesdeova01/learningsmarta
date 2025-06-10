@extends('layouts.app')

@section('title', 'Tambah Data Siswa')

@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('admin.mahasiswa.store', ['id' => 1]) }}" method="post">
                    @csrf
                    <div class="form-group mb-3">
                        <label for="">Nama</label>
                        <input type="text" required class="form-control" name="name">
                    </div>
                    <div class="form-group mb-3">
                        <label for="">Email</label>
                        <input type="email" required class="form-control" name="email">
                    </div>
                    <div class="form-group mb-3">
                        <label for="">Password</label>
                        <input type="password" required class="form-control" name="password">
                    </div>
                    <button class="btn btn-primary btn-sm" type="submit">Submit</button>
                    <a href="{{ route('admin.mahasiswa.index', ['id' => 1]) }}" class="btn btn-secondary btn-sm">Kembali</a>
                </form>
            </div>
        </div>
    </div>
@endsection
