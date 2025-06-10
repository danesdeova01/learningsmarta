@extends('layouts.web')
@section('title', $topik->nama)
@section('content')
    <div class="container">
        <div class="mb-3">
            {!! $topik->konten !!}
        </div>
       @if ($topik->file)
    <a href="{{ route('materi.download', $topik->file) }}" class="btn btn-outline-primary">
        Download Materi
    </a>
@else
    <button class="btn btn-secondary mb-2" disabled>
        Tidak ada file
    </button>
@endif

    </div>
@endsection
