@extends('layouts.app')

@section('title', 'Detail Kelas')

@section('content')
    <div class="section-body">
        <h2 class="mb-4">Kelas {{ $kelas->nama }}</h2>

        <div class="row">
            <div class="col-md-6">
                <div class="card text-white bg-info mb-3">
                    <div class="card-body">
                        <h5 class="card-title">Total Siswa</h5>
                        <p class="card-text display-4">{{ $kelas->siswa->count() }}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card text-white bg-success mb-3">
                    <div class="card-body">
                        <h5 class="card-title">Total Materi</h5>
                        <p class="card-text display-4">{{ $kelas->matapelajarans->count() }}</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Daftar Siswa --}}
        <div class="card mb-4">
            <div class="card-header bg-primary text-white">Daftar Siswa</div>
            <div class="card-body">
                @if ($kelas->siswa->count())
                    <ul class="list-group">
                        @foreach ($kelas->siswa as $siswa)
                            <li class="list-group-item">{{ $siswa->name . '-' . $siswa->email }}</li>
                        @endforeach
                    </ul>
                @else
                    <p class="text-muted">Belum ada siswa di kelas ini.</p>
                @endif
            </div>
        </div>

        {{-- Daftar Materi --}}
        <div class="card">
            <div class="card-header bg-dark text-white">Daftar Materi</div>
            <div class="card-body">
                @if ($kelas->materis->count())
                    <ul class="list-group">
                        @foreach ($kelas->materis as $materi)
                            <li class="list-group-item">{{ $materi->nama }}</li>
                        @endforeach
                    </ul>
                @else
                    <p class="text-muted">Belum ada materi di kelas ini.</p>
                @endif
            </div>
        </div>
    </div>
@endsection
