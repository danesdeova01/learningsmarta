@extends('layouts.app')

@section('title', $isEdit ? 'Edit Topik' : 'Tambah Topik')

@section('content')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>{{ $isEdit ? 'Edit Topik' : 'Tambah Topik' }}</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="{{ url('/home') }}">Dashboard</a></div>
                    <div class="breadcrumb-item"><a href="{{ url('admin/forum') }}">Forum Diskusi</a></div>
                    <div class="breadcrumb-item">{{ $isEdit ? 'Edit' : 'Tambah' }} Topik</div>
                </div>
            </div>

            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Form {{ $isEdit ? 'Edit' : 'Tambah' }} Topik Diskusi</h4>
                            </div>
                            <div class="card-body">
                                <form action="{{ $url }}" method="POST">
                                    @csrf
                                    @if($isEdit)
                                        @method('PUT')
                                    @endif
                                    <div class="form-group">
                                        <label>Judul</label>
                                        <input type="text" class="form-control" name="judul" placeholder="Judul Topik" value="{{ $isEdit ? $data->judul : '' }}" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Konten</label>
                                        <textarea name="konten" class="form-control" rows="5" placeholder="Isi Topik" required>{{ $isEdit ? $data->konten : '' }}</textarea>
                                    </div>
                                    <div class="card-footer text-right">
                                        <button type="submit" class="btn btn-primary">Simpan</button>
                                        <a href="{{ url('admin/forum') }}" class="btn btn-secondary">Batal</a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
