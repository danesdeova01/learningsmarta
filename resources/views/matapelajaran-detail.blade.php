@extends('layouts.web')
@section('title', $matapelajaran->nama)
@section('content')
<div class="container">
    <p><strong>Kelas:</strong> {{ $kelas ? $kelas->nama : '-' }}</p>
    <a href="{{ route('matapelajaran.show', $kelas ? $kelas->slug : '') }}" class="btn btn-secondary mb-3">Kembali ke Materi Kelas {{ $kelas ? $kelas->nama : '' }}</a>
    <div class="row">
        @if(isset($topiks) && $topiks->count() > 0)
            @foreach($topiks as $topik)
            <div class="col-md-4 mb-3">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">{{ $topik->nama }}</h5>
                        <a href="{{ route('topik.detail', $topik->id) }}" class="btn btn-primary">Lihat Detail Topik</a>
                    </div>
                </div>
            </div>
            @endforeach
        @else
        <div class="col-12">
            <p class="text-center">Belum ada topik untuk materi ini.</p>
        </div>
        @endif
    </div>
</div>
@endsection
