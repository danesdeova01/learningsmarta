@extends('layouts.app')

@section('title', 'Forum Diskusi')

@section('content')

            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Daftar Topik Diskusi</h4>
                                <div class="card-header-action">
                                    <a href="{{ url('admin/forum/create') }}" class="btn btn-primary">
                                        <i class="fas fa-plus"></i> Tambah Topik
                                    </a>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>Judul</th>
                                                <th>Pembuat</th>
                                                <th>Tanggal</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($forums as $forum)
                                                <tr>
                                                    <td>{{ $forum->judul }}</td>
                                                    <td>{{ $forum->user->name }}</td>
                                                    <td>{{ $forum->created_at->format('d M Y') }}</td>
                                                    <td>
                                                        <form action="{{ route('admin.forum.destroy', $forum->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus topik ini?')">
    @csrf
    @method('DELETE')
    <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
</form>

                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
