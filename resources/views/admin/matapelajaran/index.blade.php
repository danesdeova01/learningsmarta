@extends('layouts.app')

@section('title')
    Daftar Mata Pelajaran
@endsection

@section('content')
    <div class="container">

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        
        <a href="{{ route('admin.matapelajaran.create') }}" class="btn btn-primary mb-3">Tambah Mata Pelajaran</a>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Nama Mata Pelajaran</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($mata_pelajarans as $matapelajaran)
                    <tr>
                        <td>{{ $matapelajaran->nama }}</td>
                        <td>
                            <a href="{{ route('admin.matapelajaran.edit', $matapelajaran->id) }}" class="btn btn-sm btn-warning">Edit</a>
                            <form action="{{ route('admin.matapelajaran.destroy', $matapelajaran->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Yakin hapus mata pelajaran ini?')">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="2" class="text-center">Belum ada mata pelajaran.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
