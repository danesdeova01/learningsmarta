@extends('layouts.app')

@section('title')
    Form Topik
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            {{-- Tampilkan error validasi --}}
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ $url }}" method="POST" enctype="multipart/form-data">
                @csrf
                @if ($isEdit)
                    @method('PUT')
                @endif

                <div class="row mb-4">
                    <label for="nama" class="col-sm-2 col-form-label">Nama Topik</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="nama" id="nama"
                            value="{{ old('nama', $isEdit ? $data->nama : '') }}"
                            placeholder="Contoh: Berpikir Komputasional" required>
                    </div>
                </div>

                <div class="row mb-4">
                    <label for="matapelajaran_id" class="col-sm-2 col-form-label">Mata Pelajaran</label>
                    <div class="col-sm-10">
                        <select name="matapelajaran_id" id="matapelajaran_id" class="form-control" required>
                            <option value="">Silakan Pilih Mata Pelajaran</option>
                            @foreach ($mata_pelajarans as $item)
                                <option value="{{ $item->id }}"
                                    {{ old('matapelajaran_id', $isEdit ? $data->matapelajaran_id : '') == $item->id ? 'selected' : '' }}>
                                    {{ $item->nama }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="row mb-4">
                    <label for="kelas_id" class="col-sm-2 col-form-label">Kelas</label>
                    <div class="col-sm-10">
                        <select name="kelas_id" id="kelas_id" class="form-control" required>
                            <option value="">Pilih Kelas</option>
                            @foreach ($kelas as $item)
                                <option value="{{ $item->id }}"
                                    {{ old('kelas_id', $isEdit ? $data->kelas_id : '') == $item->id ? 'selected' : '' }}>
                                    Kelas {{ $item->nama }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="row mb-4">
                    <label for="konten" class="col-sm-2 col-form-label">Konten</label>
                    <div class="col-sm-10">
                        <textarea name="konten" id="konten" class="summernote">{{ old('konten', $isEdit ? $data->konten : '') }}</textarea>
                    </div>
                </div>

                <div class="row mb-4">
                    <label for="file" class="col-sm-2 col-form-label">
                        File Topik <sup class="text-muted">(opsional)</sup>
                    </label>
                    <div class="col-sm-10">
                        <input name="file" type="file" accept="" class="form-control-file" />

                        @if ($isEdit && !empty($data->file))
                            <small class="form-text text-muted">
                                File saat ini: <a href="{{ asset('storage/materi/file/' . $data->file) }}"
                                    target="_blank">{{ $data->file }}</a><br>
                                Kosongkan jika tidak ingin mengubah file
                            </small>
                        @else
                            <small class="form-text text-muted">
                                File boleh dikosongkan, hanya upload jika ingin menambahkan atau mengganti file PDF
                            </small>
                        @endif
                    </div>
                </div>

                <div class="text-right">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <a href="{{ route('admin.topik.index') }}" class="btn btn-warning ml-2">Kembali ke Daftar</a>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(".summernote").summernote({
            dialogsInBody: true,
            minHeight: 200,
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'underline', 'clear']],
                ['fontname', ['fontname']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['table', ['table']],
            ]
        });
    </script>
@endsection
