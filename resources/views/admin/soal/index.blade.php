@extends('layouts.app')

@section('title')
    Ujian
@endsection

@section('content')
<div class="card mb-4">
    <div class="card-header">
        <strong>Timer Ujian</strong>
    </div>
    <div class="card-body">
        <form action="{{ url('/admin/jenis-ujian/update') }}" method="POST">
            @csrf
            <div class="row align-items-end">
                @foreach ($jenisUjian as $ujian)
                    <div class="col-md-4">
                        <label for="nama_{{ $ujian->id }}" class="form-label">{{ $ujian->nama }}</label>
                        <div class="input-group">
                            <input type="text" class="form-control" value="{{ $ujian->nama }}" readonly>
                            <input type="number" class="form-control" id="timer_{{ $ujian->id }}"
                                name="timer[{{ $ujian->id }}]" value="{{ $ujian->timer }}" required>
                            <span class="input-group-text">menit</span>
                        </div>
                    </div>
                @endforeach
                <div class="col-md-2">
                    <button type="submit" class="btn btn-success w-100">Update</button>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <a href="{{ route('admin.soal.create') }}" class="btn btn-primary mb-4">
            Tambah Data
        </a>
        <div class="table-responsive">
            <table class="table table-striped datatable">
                <thead>
                    <tr>
                        <th class="text-center">#</th>
                        <th>Pertanyaan</th>
                        <th>Materi</th>
                        <th>Jenis Soal</th>
                        <th>Jenis Ujian</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($soals as $item)
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td>{!! $item->pertanyaan !!}</td>
                            <td>{{ optional($item->matapelajaran)->nama ?? '-' }}</td>
                            <td>{{ ucfirst(str_replace('_', ' ', $item->jenis_soal)) }}</td>
                            <td>{{ $item->jenis_ujian }}</td>
                            <td class="text-center">
                                <a href="{{ route('admin.soal.edit', $item->id) }}" class="btn btn-sm btn-warning">Edit</a>

                                <form action="{{ route('admin.soal.destroy', $item->id) }}" method="POST" class="d-inline"
                                    onsubmit="return confirm('Yakin ingin menghapus soal ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
    $(".datatable").dataTable();
</script>
@endsection
