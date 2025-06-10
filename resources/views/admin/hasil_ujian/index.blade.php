@extends('layouts.app')

@section('title', 'Data Hasil Ujian')

@section('content')
<div class="container mt-4">

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="table-responsive">
        <table class="table table-bordered table-striped mt-3">
            <thead class="thead-dark">
                <tr>
                    <th>No</th>
                    <th>Nama Siswa</th>
                    <th>Mata Pelajaran</th>
                    <th>Jenis Ujian</th>
                    <th>Jumlah Soal</th>
                    <th>Jawaban Benar</th>
                    <th>Nilai</th>
                    <th>Tanggal Ujian</th>
                    <th>Aksi</th> {{-- Kolom aksi --}}
                </tr>
            </thead>
            <tbody>
                @forelse ($hasilUjian as $key => $hasil)
                <tr>
                    <td>{{ $hasilUjian->firstItem() + $key }}</td>
                    <td>{{ $hasil->user->name ?? '-' }}</td>
                    <td>{{ $hasil->matapelajaran->nama ?? '-' }}</td>
                    <td>{{ $hasil->jenis_ujian ?? '-' }}</td>
                    <td>{{ $hasil->jumlah_soal }}</td>
                    <td>{{ $hasil->jawaban_benar }}</td>
                    <td>{{ $hasil->nilai }}</td>
                    <td>
                        {{ $hasil->tanggal_ujian ? \Carbon\Carbon::parse($hasil->tanggal_ujian)->format('d-m-Y H:i') : '-' }}
                    </td>
                    <td>
                        <form action="{{ route('admin.hasil_ujian.destroy', $hasil->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus data ini?');">
    @csrf
    @method('DELETE')
    <button type="submit" class="btn btn-danger btn-sm">
        <i class="fas fa-trash"></i> Hapus
    </button>
</form>


                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="9" class="text-center">Belum ada data hasil ujian.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
        {{ $hasilUjian->links() }}
    </div>
</div>
@endsection
