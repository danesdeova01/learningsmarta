@extends('layouts.web')

@section('title')
    Kirim Tugas
@endsection

@section('breadcrumb')
    <div class="breadcrumb-item">Kirim Tugas</div>
@endsection

@section('content')
    <div class="row mb-2">
        <div class="col-md-7 col-12">
            <div class="mb-4">
                <h4 class="text-dark">Materi</h4>
                {{ $tugas->matapelajaran->nama }}
            </div>
            <div class="mb-4">
                <h4 class="text-dark">Pertanyaan</h4>
                {!! $tugas->konten !!}
            </div>
        </div>
        <div class="col-md-5 col-12">
            <form class="bg-white p-3 shadow" action="{{ url('kirimtugas/submit/' . $tugas->id, []) }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                <div class="mb-4">
                    <label for="nama">Nama Lengkap</label>
                    <input type="text" class="form-control" name="nama" placeholder="Masukkan Nama Lengkap" required>
                </div>
                <div class="mb-4">
                    <label for="no_induk">No. Induk</label>
                    <input type="text" class="form-control" name="no_induk" placeholder="Masukkan No. Induk" required>
                </div>
                <div class="mb-4">
                    <label for="file">File Jawaban</label>
                    <input name="file" type="file" class="form-control" required />
                </div>
                <button type="submit" class="btn btn-primary btn-block">Submit Jawaban</button>
            </form>
        </div>
    </div>
@endsection
