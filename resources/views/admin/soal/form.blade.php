@extends('layouts.app')

@section('title')
    {{ $isEdit ? 'Edit Soal' : 'Tambah Soal' }}
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ $url }}" method="POST">
            @csrf
            @if($isEdit)
                @method('PUT')
            @endif

            <div class="mb-3 row">
                <label for="matapelajaran_id" class="col-sm-2 col-form-label">Mata Pelajaran</label>
                <div class="col-sm-10">
                    <select name="matapelajaran_id" id="matapelajaran_id" class="form-control" required>
                        <option value="">Pilih Mata Pelajaran</option>
                        @foreach ($mata_pelajarans as $mp)
                            <option value="{{ $mp->id }}"
                                {{ (old('matapelajaran_id', $isEdit ? $data->matapelajaran_id : '') == $mp->id) ? 'selected' : '' }}>
                                {{ $mp->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="mb-3 row">
                <label for="jenis_ujian" class="col-sm-2 col-form-label">Jenis Ujian</label>
                <div class="col-sm-10">
                    <select name="jenis_ujian" id="jenis_ujian" class="form-control" required>
                        <option value="">Pilih Jenis Ujian</option>
                        <option value="UTS" {{ old('jenis_ujian', $isEdit ? $data->jenis_ujian : '') == 'UTS' ? 'selected' : '' }}>UTS</option>
                        <option value="UAS" {{ old('jenis_ujian', $isEdit ? $data->jenis_ujian : '') == 'UAS' ? 'selected' : '' }}>UAS</option>
                    </select>
                </div>
            </div>

            <div class="mb-3 row">
    <label for="jenis_soal" class="col-sm-2 col-form-label">Jenis Soal</label>
    <div class="col-sm-10">
        <select name="jenis_soal" id="jenis_soal" class="form-control" required>
            <option value="">Pilih Jenis Soal</option>
            <option value="pilihan_ganda" {{ old('jenis_soal', $isEdit ? $data->jenis_soal : '') == 'pilihan_ganda' ? 'selected' : '' }}>Pilihan Ganda</option>
            <option value="pilihan_ganda_kompleks" {{ old('jenis_soal', $isEdit ? $data->jenis_soal : '') == 'pilihan_ganda_kompleks' ? 'selected' : '' }}>Pilihan Ganda Kompleks</option>
            <option value="menjodohkan" {{ old('jenis_soal', $isEdit ? $data->jenis_soal : '') == 'menjodohkan' ? 'selected' : '' }}>Menjodohkan</option>
            <option value="uraian_singkat" {{ old('jenis_soal', $isEdit ? $data->jenis_soal : '') == 'uraian_singkat' ? 'selected' : '' }}>Uraian Singkat</option>
        </select>
    </div>
</div>

<div class="mb-3 row">
    <label for="pertanyaan" class="col-sm-2 col-form-label">Pertanyaan</label>
    <div class="col-sm-10">
        <textarea name="pertanyaan" id="pertanyaan" class="form-control" rows="4" required>{{ old('pertanyaan', $isEdit ? $data->pertanyaan : '') }}</textarea>
    </div>
</div>

{{-- Pilihan Ganda --}}
<div id="pilihan-ganda-fields" style="display: none;">
    @foreach(['a','b','c','d','e'] as $opt)
    <div class="mb-3 row">
        <label class="col-sm-2 col-form-label">Pilihan {{ strtoupper($opt) }}</label>
        <div class="col-sm-10">
            <input type="text" name="pilihan_{{ $opt }}" class="form-control"
                value="{{ old('pilihan_'.$opt, $isEdit ? $data->{'pilihan_'.$opt} : '') }}">
        </div>
    </div>
    @endforeach
    <div class="mb-3 row" id="kunci-jawaban-pg">
        <label for="kunci_jawaban" class="col-sm-2 col-form-label">Kunci Jawaban</label>
        <div class="col-sm-10">
            <select name="kunci_jawaban" id="kunci_jawaban" class="form-control" required>
                @foreach(['a','b','c','d','e'] as $opt)
                    <option value="{{ $opt }}" {{ old('kunci_jawaban', $isEdit ? $data->kunci_jawaban : '') == $opt ? 'selected' : '' }}>{{ strtoupper($opt) }}</option>
                @endforeach
            </select>
        </div>
    </div>
</div>

            {{-- Pilihan Ganda Kompleks --}}
<div id="pilihan-ganda-kompleks-fields" style="display: none;">
    @foreach(['a','b','c','d','e'] as $opt)
    <div class="mb-3 row">
        <label class="col-sm-2 col-form-label">Pilihan {{ strtoupper($opt) }}</label>
        <div class="col-sm-10">
            <input type="text" name="pilihan_{{ $opt }}" class="form-control"
                value="{{ old('pilihan_'.$opt, $isEdit ? $data->{'pilihan_'.$opt} : '') }}">
        </div>
    </div>
    @endforeach

    @php
        // Ambil nilai lama dari old input (jika ada) atau data lama
        $oldKunci = old('kunci_jawaban');

        if ($oldKunci) {
            // Jika old input ada, pastikan berupa array
            $kunciJawabanKompleks = is_array($oldKunci) ? $oldKunci : explode(',', $oldKunci);
        } elseif ($isEdit && !empty($data->kunci_jawaban)) {
            // Jika edit dan data ada, explode string menjadi array
            $kunciJawabanKompleks = explode(',', $data->kunci_jawaban);
        } else {
            $kunciJawabanKompleks = [];
        }
    @endphp

    <div class="mb-3 row" id="kunci-jawaban-pgk">
        <label class="col-sm-2 col-form-label">Kunci Jawaban (boleh lebih dari satu)</label>
        <div class="col-sm-10">
            @foreach(['a','b','c','d','e'] as $opt)
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" name="kunci_jawaban[]" id="kunci_jawaban_{{ $opt }}" value="{{ $opt }}"
                        {{ in_array($opt, $kunciJawabanKompleks) ? 'checked' : '' }}>
                    <label class="form-check-label" for="kunci_jawaban_{{ $opt }}">{{ strtoupper($opt) }}</label>
                </div>
            @endforeach
            <small class="form-text text-muted">Centang satu atau lebih jawaban yang benar.</small>
        </div>
    </div>
</div>


            @php
    $pencocokanData = $isEdit && $data->pencocokan ? json_decode($data->pencocokan, true) : null;
    $menjodohkanPlain = old('menjodohkan_plain');
    if (!$menjodohkanPlain && $pencocokanData) {
        $lines = [];
        foreach ($pencocokanData as $kiri => $kanan) {
            $lines[] = $kiri . ' | ' . $kanan;
        }
        $menjodohkanPlain = implode("\n", $lines);
    }
@endphp

<div id="menjodohkan-fields" style="display: none;">
    <div class="mb-3 row">
        <label class="col-sm-2 col-form-label">Pasangan Menjodohkan (Plain Text)</label>
        <div class="col-sm-10">
            <textarea name="menjodohkan_plain" class="form-control" rows="6" placeholder="Format: soal | jawaban, satu pasangan per baris">{{ $menjodohkanPlain }}</textarea>
            <small class="form-text text-muted">
                Masukkan pasangan satu per baris, pisahkan soal dan jawaban dengan tanda <code>|</code><br>
                Contoh:<br>
                <code>Ibu Kota Indonesia | Jakarta</code><br>
                <code>Ibu Kota Jawa Barat | Bandung</code>
            </small>
        </div>
    </div>
</div>




            {{-- Uraian Singkat --}}
            <div id="uraian-singkat-field" style="display: none;">
                <div class="mb-3 row">
                    <label for="jawaban_uraian" class="col-sm-2 col-form-label">Jawaban Uraian</label>
                    <div class="col-sm-10">
                        <textarea name="jawaban_uraian" class="form-control" rows="3">{{ old('jawaban_uraian', $isEdit ? $data->uraian : '') }}</textarea>
                    </div>
                </div>
            </div>

            <div class="text-right">
                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="{{ route('admin.soal.index') }}" class="btn btn-secondary">Kembali</a>
            </div>
        </form>
    </div>
</div>
@endsection

@section('script')
<script>
    function toggleFields() {
        var jenisSoal = document.getElementById('jenis_soal').value;
        document.getElementById('pilihan-ganda-fields').style.display = (jenisSoal === 'pilihan_ganda') ? 'block' : 'none';
        document.getElementById('pilihan-ganda-kompleks-fields').style.display = (jenisSoal === 'pilihan_ganda_kompleks') ? 'block' : 'none';
        document.getElementById('menjodohkan-fields').style.display = (jenisSoal === 'menjodohkan') ? 'block' : 'none';
        document.getElementById('uraian-singkat-field').style.display = (jenisSoal === 'uraian_singkat') ? 'block' : 'none';
    }
    document.getElementById('jenis_soal').addEventListener('change', toggleFields);
    window.onload = toggleFields;
</script>
@endsection
