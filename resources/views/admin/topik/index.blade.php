@extends('layouts.app')

@section('title')
    Topik
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-6">
                            <h4>Data Topik</h4>
                        </div>
                        <div class="col-6 text-right">
                            <a href="{{ route('admin.topik.create') }}" class="btn btn-primary">Tambah Topik</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Nama Topik</th>
                                <th>Materi</th>
                                <th>Kelas</th>
                                <th>Waktu Dibuat</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $no = 1;
                            @endphp
                            @forelse ($topiks as $row)
                                <tr>
                                    <td>{{ $no++ }}</td>
                                    <td>{{ $row->nama }}</td>
                                    <td>{{ $row->matapelajaran->nama ?? '-' }}</td>
                                    <td>{{ $row->kelas->nama ?? '-' }}</td>
                                    <td>{{ $row->created_at->format('d M Y, H:i') }}</td>
                                    <td>
                                        <a href="{{ route('admin.topik.edit', $row->id) }}"
                                            class="btn btn-warning">Edit</a>
                                        <form action="{{ route('admin.topik.destroy', $row->id) }}" method="POST"
                                            class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger" 
                                                onclick="return confirm('Apakah Anda yakin ingin menghapus topik ini?')">
                                                Hapus
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center">Belum ada data topik</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
