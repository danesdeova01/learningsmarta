@extends('layouts.web')

@section('title')
Materi Kelas {{ $kelas->nama }}
@endsection

@section('content')
<div class="container">
    <a href="{{route('matapelajaran.index')}}" class="btn btn-secondary mb-3">Ganti Kelas</a>
    <div class="row">
        @if($matapelajarans->count() > 0)
        @foreach($matapelajarans as $matapelajaran)
        <div class="col-md-4 mb-3">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">{{ $matapelajaran->nama }}</h5>
                    <p class="card-text">Jumlah Topik: {{ $matapelajaran->mata_pelajarans->count() }}</p>
                    <a href="{{ route('matpelDetail', $matapelajaran->id) }}" class="btn btn-primary">Lihat Materi</a>
                </div>
            </div>
        </div>
        @endforeach
        @else
        <div class="col-12">
            <p class="text-center">Tidak ada materi untuk kelas ini.</p>
        </div>
        @endif
    </div>
</div>
@endsection
