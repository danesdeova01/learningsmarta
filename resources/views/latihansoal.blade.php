@extends('layouts.web')

@section('title')
    @if ($nomor <= $totalSoal)
        Ujian - Soal Nomor {{ $nomor }}
    @else
        Ujian Selesai
    @endif
@endsection

@section('breadcrumb')
    <div class="breadcrumb-item">Ujian</div>
@endsection

@section('content')

@if ($nomor > $totalSoal)
    {{-- Halaman selesai --}}
    <div class="row mb-2">
        <div class="col-12 text-center">
            <h3 class="text-success">Selamat! Anda telah menyelesaikan kuis</h3>
            <p>Terima kasih telah mengerjakan soal.</p>
            <a href="{{ route('home') }}" class="btn btn-primary">Kembali ke Beranda</a>
        </div>
    </div>
@else

    {{-- Halaman soal --}}
    <div class="row mb-2">
        <div class="col-12 text-center">
            <h3 class="text-dark">Ujian</h3>
            <p class="text-muted">
                Silakan kerjakan soal berikut dengan teliti dan benar
            </p>
            <div id="timer-container">
                <span><strong>Waktu Tersisa :</strong></span>
                <span id="timer"></span>
            </div>
        </div>
    </div>

    <form method="POST" action="{{ route('kuis.soal.submit', ['nomor' => $nomor]) }}">
        @csrf
        <input type="hidden" name="soal_id" value="{{ $soal->id }}">

        <div class="card mb-3">
            <div class="card-body">
                <h3>Soal. {{ $nomor }} dari {{ $totalSoal }}</h3>
                {!! nl2br(e($soal->pertanyaan)) !!}

                @if ($soal->jenis_soal == 'pilihan_ganda')
                    <div class="form-check mt-3">
                        @foreach(['a','b','c','d','e'] as $opt)
                            @php $pilihan = $soal->{'pilihan_'.$opt}; @endphp
                            @if($pilihan)
                            <input class="form-check-input" type="radio" name="jawaban" id="pg_{{ $soal->id }}_{{ $opt }}" value="{{ $opt }}"
                                {{ (old('jawaban', $jawaban ?? '') == $opt) ? 'checked' : '' }} required>
                            <label class="form-check-label" for="pg_{{ $soal->id }}_{{ $opt }}">{{ $pilihan }}</label><br>
                            @endif
                        @endforeach
                    </div>
                @elseif ($soal->jenis_soal == 'uraian_singkat')
                    <div class="form-group mt-3">
                        <label for="uraian_{{ $soal->id }}">Jawaban:</label>
                        <textarea class="form-control" name="jawaban" id="uraian_{{ $soal->id }}" rows="3" required>{{ old('jawaban', $jawaban ?? '') }}</textarea>
                    </div>
                @elseif ($soal->jenis_soal == 'pilihan_ganda_kompleks')
                    <div class="form-group mt-3">
                        <label>Pilih Beberapa Jawaban:</label>
                        @foreach(['a','b','c','d','e'] as $opt)
                            @php $pilihan = $soal->{'pilihan_'.$opt}; @endphp
                            @if($pilihan)
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="jawaban[]" id="pgk_{{ $soal->id }}_{{ $opt }}" value="{{ $opt }}"
                                    {{ (is_array(old('jawaban', $jawaban ?? [])) && in_array($opt, old('jawaban', $jawaban ?? []))) ? 'checked' : '' }}>
                                <label class="form-check-label" for="pgk_{{ $soal->id }}_{{ $opt }}">{{ $pilihan }}</label>
                            </div>
                            @endif
                        @endforeach
                    </div>
                @elseif ($soal->jenis_soal == 'menjodohkan')
                    @php
                        $pairs = json_decode($soal->pencocokan, true) ?? [];
                        $options = collect($pairs)->values()->unique()->shuffle();
                    @endphp
                    <div class="form-group mt-3">
                        <label>Cocokkan pasangan berikut:</label>
                        @foreach($pairs as $kiri => $kanan)
                            <div class="row mb-2 align-items-center">
                                <div class="col-md-5 col-12">
                                    <input type="text" class="form-control" value="{{ $kiri }}" readonly>
                                </div>
                                <div class="col-md-7 col-12">
                                    <select name="jawaban[{{ $kiri }}]" class="form-control" required>
                                        <option value="">Pilih Jawaban</option>
                                        @foreach($options as $opt)
                                            <option value="{{ $opt }}" {{ (old('jawaban.' . $kiri, $jawaban[$kiri] ?? '') == $opt) ? 'selected' : '' }}>{{ $opt }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>

        <div class="d-flex justify-content-between">
            @if ($nomor > 1)
                <button type="submit" name="prev" class="btn btn-secondary">Sebelumnya</button>
            @endif

            <button type="submit" name="next" class="btn btn-primary">
                @if ($nomor < $totalSoal)
                    Selanjutnya
                @else
                    Selesai
                @endif
            </button>
        </div>
    </form>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const waktuMenit = {{ $timer }};
        const totalDetik = waktuMenit * 60;
        const timerElement = document.getElementById('timer');
        const form = document.querySelector('form');

        let waktuMulai = localStorage.getItem('waktuMulaiKuis');

        if (!waktuMulai) {
            waktuMulai = new Date().getTime();
            localStorage.setItem('waktuMulaiKuis', waktuMulai);
        } else {
            waktuMulai = parseInt(waktuMulai);
        }

        function formatWaktu(s) {
            const m = Math.floor(s / 60);
            const d = s % 60;
            return `${m.toString().padStart(2, '0')}:${d.toString().padStart(2, '0')}`;
        }

        const hitungMundur = setInterval(() => {
            const sekarang = new Date().getTime();
            const selisih = Math.floor((sekarang - waktuMulai) / 1000);
            const waktuTersisa = totalDetik - selisih;

            if (waktuTersisa <= 0) {
                clearInterval(hitungMundur);
                timerElement.innerText = "00:00";
                alert('Waktu habis! Jawaban kamu akan otomatis disubmit.');
                localStorage.removeItem('waktuMulaiKuis');
                form.submit();
            } else {
                timerElement.innerText = formatWaktu(waktuTersisa);
            }
        }, 1000);
    });
    </script>
@endif

@endsection
