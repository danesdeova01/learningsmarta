@extends('layouts.app')

@section('title', 'Detail Topik')

@section('content')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Detail Topik</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="{{ url('/home') }}">Dashboard</a></div>
                    <div class="breadcrumb-item"><a href="{{ url('admin/forum') }}">Forum Diskusi</a></div>
                    <div class="breadcrumb-item">Detail Topik</div>
                </div>
            </div>

            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Detail Topik: {{ $forum->judul }}</h4>
                            </div>
                            <div class="card-body">
                                <h4>{{ $forum->judul }}</h4>
                                <p><strong>Oleh:</strong> {{ $forum->user->name }}</p>
                                <p>{{ $forum->konten }}</p>
                                <hr>
                                <h5>Balasan:</h5>
                                @foreach ($forum->replies as $reply)
                                    <div class="card">
                                        <div class="card-body">
                                            <p>{{ $reply->konten }}</p>
                                            <small>Oleh: {{ $reply->user->name }} - {{ $reply->created_at->format('d M Y') }}</small>
                                        </div>
                                    </div>
                                @endforeach

                                <hr>
                                <h5>Tambah Balasan:</h5>
                                <form action="{{ route('forum.reply.store', $forum->id) }}" method="POST">
                                    @csrf
                                    <div class="form-group">
                                        <textarea name="konten" class="form-control" rows="3" placeholder="Balasan Anda" required></textarea>
                                    </div>
                                    <button type="submit" class="btn btn-primary">Balas</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
