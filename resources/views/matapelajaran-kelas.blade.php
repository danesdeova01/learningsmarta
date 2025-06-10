@extends('layouts.web')
@section('title', 'Pilih Kelas')
@section('content')
<div class="container">
    <div class="row">
        @foreach($kelas as $kelasItem)
        <div class="col-md-3 mb-3">
            <a href="{{ route('matapelajaran.show', $kelasItem->slug) }}" class="btn btn-primary btn-block">
                Kelas {{ $kelasItem->nama }}
            </a>
        </div>
        @endforeach
    </div>
</div>
@endsection
