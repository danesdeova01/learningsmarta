@extends('layouts.web')
@section('title', 'Pilih Mata Pelajaran')
@section('content')
<div class="container">
    <div class="row">
        @forelse($mata_pelajarans as $mapel)
            <div class="col-md-4 mb-3">
                <div class="card h-100">
                    <div class="card-body d-flex flex-column justify-content-between">
                        <h5 class="card-title">{{ $mapel->nama }}</h5>
                        <a href="{{ route('tugas.daftar', [$kelas->id, $mapel->id]) }}" class="btn btn-primary mt-3">
                            Pilih Mata Pelajaran
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <p class="text-center">Tidak ada mata pelajaran untuk kelas ini.</p>
            </div>
        @endforelse
    </div>
</div>
@endsection
