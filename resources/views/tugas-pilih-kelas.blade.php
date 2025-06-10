@extends('layouts.web')
@section('title', 'Pilih Kelas')
@section('content')
<div class="container">
    <div class="row">
        @foreach($kelas as $kls)
            <div class="col-md-3 mb-3">
                <a href="{{ route('tugas.pilih.mapel', $kls->id) }}" class="btn btn-primary btn-block">
                    Kelas {{ $kls->nama }}
                </a>
            </div>
        @endforeach
    </div>
</div>
@endsection
