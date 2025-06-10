@extends('layouts.app')

@section('title', $isEdit ? 'Edit Mata Pelajaran' : 'Tambah Mata Pelajaran')

@section('content')
<form action="{{ $url }}" method="POST">
    @csrf
    @if($isEdit)
        @method('PUT')
    @endif

    <div class="form-group">
        <label for="nama">Nama Mata Pelajaran</label>
        <input type="text" name="nama" id="nama" class="form-control" value="{{ old('nama', $data->nama ?? '') }}" required>
    </div>

    <button type="submit" class="btn btn-primary">Simpan</button>
    <a href="{{ route('admin.matapelajaran.index') }}" class="btn btn-secondary">Kembali</a>
</form>
@endsection
