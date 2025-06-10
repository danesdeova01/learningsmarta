@extends('layouts.web')

@section('title', 'Daftar Kelas')

@section('content')
    <div class="section-body">
        <div class="row">
            @foreach ($kelas as $key => $item)
                <div class="col-md-4">
                    <a href="{{ route('siswa.kelas.detail', ['id' => $item->id]) }}" style="text-decoration: none;">
                        <div class="card text-white bg-primary mb-3" style="cursor: pointer;">
                            <div class="card-body">
                                <h5 class="card-title text-white">Kelas {{ $item->nama }}</h5>
                            </div>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    </div>
@endsection
