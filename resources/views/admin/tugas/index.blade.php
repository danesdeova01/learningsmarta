@extends('layouts.app')

@section('title')
    Daftar Tugas
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <a href="{{ url('/admin/tugas/create') }}" class="btn btn-primary mb-4">
            Tambah Data
        </a>
        <div class="table-responsive">
            <table class="table table-striped datatable">
                <thead>
                    <tr>
                        <th class="text-center">No</th>
                        <th class="text-center">Konten</th>
                        <th class="text-center">Mata Pelajaran</th>
                        <th class="text-center">Kelas</th>
                        <th class="text-center">Due Date</th>
                        <th class="text-center">File Tugas</th>
                        <th class="text-center">Submit</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($tugas as $item)
                    <tr>
                        <td class="text-center">{{ $loop->iteration }}</td>
                        <td class="text-center">{{ strip_tags($item->konten) }}</td>
                        <td class="text-center">{{ $item->matapelajaran->nama ?? '-' }}</td>
                        <td class="text-center">{{ optional($item->kelas)->nama ?? '-' }}</td>
                        <td class="text-center">
                            {{ $item->due_date ? \Carbon\Carbon::parse($item->due_date)->format('d-m-Y H:i') : '-' }}
                        </td>
                        <td class="text-center">
                            @if ($item->file)
                                <a href="{{ route('tugas.download', $item->file) }}" class="btn btn-sm btn-info">
                                    Download Tugas
                                </a>
                            @else
                                <span class="badge badge-secondary">Tidak ada</span>
                            @endif
                        </td>
                        <td class="text-center">
                            <strong>{{ $item->jawabans->count() }} Orang</strong>
                        </td>
                            <td class="text-center">
    <div class="btn-group" role="group">
        <a href="{{ url('/admin/tugas/' . $item->id) }}" class="btn btn-sm btn-success">Detail</a>
        <a href="{{ url('/admin/tugas/' . $item->id . '/edit') }}" class="btn btn-sm btn-warning">Edit</a>
        <form id="delete-{{ $item->id }}" action="{{ url('/admin/tugas/' . $item->id) }}" method="POST" style="display:inline;">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-sm btn-danger"
                onclick="return confirm('Apakah Anda yakin ingin menghapus Tugas ini?')">
                Hapus
            </button>
        </form>
    </div>
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
