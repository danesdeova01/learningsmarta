@extends('layouts.web')

@section('title', 'Kirim Tugas')

@section('breadcrumb')
    <div class="breadcrumb-item">Kirim Tugas</div>
@endsection

@section('content')
    <div class="container">
        {{-- Judul Halaman dan Tombol di satu baris --}}
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h1 class="mb-0"></h1>
            <a href="{{ route('riwayat') }}" class="btn btn-outline-primary">
                Report Tugas
            </a>
        </div>

        <div class="row mb-2">
            <div class="col-md-4 col-12">
                {{-- Tombol untuk collapse tugas --}}
                @foreach ($tugas as $data)
                    <button 
                        class="btn btn-outline-primary mb-3 w-100 text-left d-flex align-items-center justify-content-start"
                        type="button" 
                        data-toggle="collapse"
                        data-target="#tugas{{ $data->id }}" 
                        aria-expanded="false" 
                        aria-controls="tugas{{ $data->id }}"
                        style="font-size: 1.1rem; padding: 1rem 1.25rem; border-radius: 0.5rem;"
                    >
                        {{ $loop->iteration . '. ' . ($data->matapelajaran?->nama ?? '-') }} - Kelas {{ $data->kelas?->nama ?? '-' }}
                    </button>
                @endforeach
            </div>

            <div class="col-md-8 col-12">
                @php
                    use Carbon\Carbon;
                    $now = Carbon::now();
                @endphp

                @foreach ($tugas as $data)
                    <div class="collapse multi-collapse" id="tugas{{ $data->id }}">
                        <div class="card card-body">
                            {{-- Tampilkan Due Date --}}
                            @if ($data->due_date)
                                <p><strong>Tenggat Waktu :</strong> {{ Carbon::parse($data->due_date)->format('d-m-Y H:i') }}</p>
                            @else
                                <p><strong>Tenggat Waktu:</strong> Tidak ada batas waktu</p>
                            @endif

                            {{-- Konten tugas --}}
                            {!! $data->konten !!}

                            <div class="mt-3">
                                {{-- Tombol Download File Tugas --}}
                                @if ($data->file)
                                    <a href="{{ route('tugas.download', $data->file) }}" class="btn btn-primary mb-2">
                                        Download File Tugas
                                    </a>
                                @else
                                    <button class="btn btn-secondary mb-2" disabled>
                                        Tidak ada file
                                    </button>
                                @endif

                                {{-- Tombol Kirim Jawaban --}}
                                @php
                                    $isExpired = $data->due_date ? Carbon::parse($data->due_date)->lt($now) : false;
                                @endphp

                                @if ($isExpired)
                                    <button class="btn btn-secondary" disabled>
                                        Waktu Pengumpulan Habis
                                    </button>
                                @else
                                    <a href="{{ url('kirimtugas/submit/' . $data->id) }}" class="btn btn-warning ml-2">
                                        Kirim Jawaban
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
