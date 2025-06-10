@extends('layouts.web')

@section('title', 'Pilih Tipe Ujian')

@section('content')
    <div class="container">
        <div class="row">
            @php
                $jenisUjianList = \App\Models\JenisUjian::all();
                $colClass = 'col-md-' . 12 / max(1, $jenisUjianList->count());
            @endphp

            @foreach ($jenisUjianList->sortByDesc('id') as $jenisUjian)
                <div class="{{ $colClass }} mb-3">
                    <a href="{{ route('kuis.mulai', ['mapel_id' => $mapel_id, 'tipe' => $jenisUjian->nama]) }}">
                        <div class="card text-white bg-primary text-center">
                            <div class="card-body">
                                <h3>{{ $jenisUjian->nama }}</h3>
                                <p class="mb-0">{{ $jenisUjian->timer }} menit</p>
                            </div>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    </div>
@endsection
