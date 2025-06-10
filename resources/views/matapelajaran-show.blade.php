@extends('layouts.web')
@section('title', 'Materi Kelas ' . $kelas->nama)
@section('content')
<div class="container">
    <a href="{{ route('matapelajaran.index') }}" class="btn btn-secondary mb-3">Ganti Kelas</a>
    <div class="row">
        @forelse($mata_pelajarans as $matapelajaran)
        <div class="col-md-4 mb-3">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">{{ $matapelajaran->nama }}</h5>
                    <!-- GUNAKAN SLUG di sini -->
                    <a href="{{ route('matapelajaran.detail', ['matapelajaran' => $matapelajaran->id, 'kelas' => $kelas->id]) }}" class="btn btn-primary">
                         Lihat Materi</a>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12">
            <p class="text-center">Tidak ada materi untuk kelas ini.</p>
        </div>
        @endforelse
    </div>
</div>
@endsection
