@extends('layouts.web')

@section('title', 'Pilih Tipe Ujian')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-6 mb-3">
            <a href="{{ route('kuis.mulai', ['mapel_id' => $mapel_id, 'tipe' => 'UTS']) }}">
                <div class="card text-white bg-primary text-center">
                    <div class="card-body">
                        <h3>UTS</h3>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-6 mb-3">
            <a href="{{ route('kuis.mulai', ['mapel_id' => $mapel_id, 'tipe' => 'UAS']) }}">
                <div class="card text-white bg-primary text-center">
                    <div class="card-body">
                        <h3>UAS</h3>
                    </div>
                </div>
            </a>
        </div>
    </div>
</div>
@endsection
