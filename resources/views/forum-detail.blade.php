@extends('layouts.web')

@section('title')
    {{ $forum->judul }}
@endsection

@section('breadcrumb')
    <div class="breadcrumb-item">Forum Diskusi</div>
    <div class="breadcrumb-item">{{ $forum->judul }}</div>
@endsection

@section('content')
<div class="row">
    <div class="col-12 mb-4">
        <div class="card" style="border-radius: 1rem">
            <div class="card-body">
                <h4>{{ $forum->judul }}</h4>
                <p class="mb-1">
                    <strong>Oleh:</strong> {{ $forum->user->name }}
                    <span class="text-muted">| {{ $forum->created_at->format('d M Y H:i') }}</span>
                </p>
                <div>{!! nl2br(e($forum->konten)) !!}</div>
            </div>
        </div>
    </div>

    {{-- Ganti bagian balasan dan form balasan dengan Livewire --}}
    <div class="col-12">
        @livewire('forum-replies', ['forumId' => $forum->id])
    </div>
</div>
@endsection
