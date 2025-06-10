@extends('layouts.web')

@section('title')
Forum Diskusi
@endsection

@section('breadcrumb')
<div class="breadcrumb-item">Forum Diskusi</div>
@endsection

@section('content')
<div class="row mb-2">
    <div class="col-12">
        <div class="text-center">
            <h3 class="text-dark">Topik Terbaru</h3>
            <p class="text-muted">Gunakan Sebagai Tempat Diskusi</p>
        </div>
    </div>
</div>
<div class="row">
    @foreach ($forums as $forum)
    <div class="col-12 col-md-4 col-lg-4">
        <article class="article article-style-c">
            <div class="article-details">
                <div class="article-title">
                    <h5>
                        {{ $forum->judul }}
                    </h5>
                </div>
                <div class="article-category"><a href="#">{{ $forum->replies_count }} Reply</a>
                    <div class="bullet"></div> <a href="#">{{ $forum->created_at->diffForHumans() }}</a>
                </div>
                <a href="{{ url('forum/' . $forum->id, []) }}" class="btn btn-outline-primary w-100 mt-3">
                    Lihat Selengkapnya
                </a>
            </div>
        </article>
    </div>
    @endforeach
</div>
@endsection