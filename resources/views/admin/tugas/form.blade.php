@extends('layouts.app')

@section('title')
    Form Tugas
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <form action="{{ isset($data) ? route('admin.tugas.update', $data->id) : route('admin.tugas.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @if(isset($data))
                    @method('PUT')
                @endif

                @php
                    function isSelected($data1, $data2)
                    {
                        return $data1 == $data2 ? 'selected' : '';
                    }
                @endphp

                <div class="form-group row mb-4">
                    <label for="kelas_id" class="col-sm-2 col-form-label">Kelas</label>
                    <div class="col-sm-10">
                        <select name="kelas_id" id="kelas_id" class="form-control" required>
                            <option value="" selected>Silakan Pilih Kelas</option>
                            @foreach ($kelas as $item)
                                <option value="{{ $item->id }}" {{ isset($data) ? isSelected($data->kelas_id, $item->id) : '' }}>
                                    Kelas {{ $item->nama }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-group row mb-4">
                    <label for="matapelajaran_id" class="col-sm-2 col-form-label">Mata Pelajaran</label>
                    <div class="col-sm-10">
                        <select name="matapelajaran_id" id="matapelajaran_id" class="form-control" required>
                            <option value="" selected>Silakan Pilih Mata Pelajaran</option>
                            @foreach ($matapelajaran as $item)
                                <option value="{{ $item->id }}" {{ isset($data) ? isSelected($data->matapelajaran_id, $item->id) : '' }}>
                                    {{ $item->nama }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-group row mb-4">
                    <label for="konten" class="col-sm-2 col-form-label">Pertanyaan</label>
                    <div class="col-sm-10">
                        <textarea name="konten" id="konten" class="summernote" required>{{ old('konten', $data->konten ?? '') }}</textarea>
                    </div>
                </div>

                <div class="form-group row mb-4">
                    <label for="file" class="col-sm-2 col-form-label">File Tugas</label>
                    <div class="col-sm-10">
                        <input type="file" name="file" id="file" class="form-control-file" />
                        @if(isset($data->file))
                            <small class="form-text text-muted">File saat ini: {{ $data->file }}</small>
                        @endif
                        <small class="form-text text-danger">
                            Kosongkan jika tidak ingin menambahkan atau mengubah file tugas
                        </small>
                    </div>
                </div>

                <div class="form-group row mb-4">
                    <label for="due_date" class="col-sm-2 col-form-label">Due Date</label>
                    <div class="col-sm-10">
                        <input type="datetime-local" name="due_date" id="due_date" class="form-control"
                            value="{{ old('due_date', isset($data->due_date) ? \Carbon\Carbon::parse($data->due_date)->format('Y-m-d\TH:i') : '') }}">
                    </div>
                </div>

                <div class="form-group text-right">
                    <button type="submit" class="btn btn-primary">
                        {{ isset($data) ? 'Update' : 'Simpan' }}
                    </button>
                    <a href="{{ url('/admin/tugas') }}" class="btn btn-warning ml-2">Kembali ke Daftar</a>
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
