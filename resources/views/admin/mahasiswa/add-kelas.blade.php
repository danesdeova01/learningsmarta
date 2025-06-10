@extends('layouts.app')

@section('title', 'Enroll Siswa Ke Kelas')



@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                Informasi Siswa
            </div>
            <div class="card-body">
                <ol>
                    <li>Nama : {{ $siswa->name }} </li>
                    <li>Email : {{ $siswa->email }} </li>
                </ol>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <form action="{{ route('admin.mahasiswa.addKelas.store', ['id' => $siswa->id]) }}" method="post">
                    @csrf
                    <div class="form-group mb-3">
                        <label for="">Kelas</label>
                        <select name="kelas_id" class="form-control" id="">
                            <option value="">Pilih Kelas</option>
                            @foreach ($kelas as $item)
                                <option value="{{ $item->id }}">{{ $item->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    <button class="btn btn-primary btn-sm">Simpan</button>
                    <a href="{{ route('admin.mahasiswa.index', ['id' => 1]) }}" class="btn btn-secondary btn-sm">Kembali</a>

                </form>
            </div>
        </div>
    </div>
@endsection
