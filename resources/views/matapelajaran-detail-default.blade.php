@extends('layouts.web')

@section('title')
    {{ $matapelajaran->nama }}
@endsection

@section('breadcrumb')
    <div class="breadcrumb-item">Mata Pelajaran</div>
    <div class="breadcrumb-item">{{ $matapelajaran->nama }}</div>
@endsection

@section('content')
    <div class="row mb-2">
        <div class="col-md-3 col-12">
            @foreach ($matapelajaran->$mata_pelajarans as $data)
                <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#matapelajaran{{ $data->id }}"
                    aria-expanded="false" aria-controls="matapelajaran{{ $data->id }}">
                    {{ $loop->iteration . '. ' . $data->nama }}
                </button>
            @endforeach
        </div>
        <div class="col-md-9 col-12">
            @foreach ($matapelajaran->mata_pelajarans as $data)
                <div class="collapse multi-collapse" id="matapelajaran{{ $data->id }}">
                    <div class="card card-body">

                        <h2 class="mb-2">{{ $loop->iteration . '. ' . $data->nama }}</h2>
                        <div class="mb-3 embed-responsive embed-responsive-16by9 rounded">
                            <iframe src="{{ asset('storage/materi/file/' . $data->file) }}" frameborder="0"
                                width="100%"></iframe>
                        </div>

                        {!! $data->konten !!}

                        <a href="{{ asset('storage/materi/file/' . $data->file) }}" target="_blank"
                            class="btn btn-outline-primary mt-3">
                            Download Materi
                        </a>
                    </div>

                </div>
            @endforeach
        </div>
    </div>
@endsection
