@extends('layouts.web')

@section('title')
    Riwayat Pengiriman Tugas
@endsection

@section('breadcrumb')
    <div class="breadcrumb-item">Riwayat Tugas</div>
@endsection

@section('content')
    <div class="row mb-2">
        @forelse ($jawabans as $jawaban)
            <div class="col-md-6">
                <div class="card mb-3 shadow">
                    <div class="card-body">
                        <h5 class="card-title">
                            {{ optional(optional($jawaban->tugas)->matapelajaran)->nama ?? '-' }}
                        </h5>
                        <p class="card-text mb-1">
                            <strong>Tugas:</strong>
                            {!! optional($jawaban->tugas)->konten ?? '<em>Tugas tidak tersedia</em>' !!}
                        </p>
                        <p class="card-text mb-1">
                            <strong>File Jawaban:</strong>
                            @if ($jawaban->file_jawab)
                                <a href="{{ route('jawaban.download', $jawaban->file_jawab) }}" target="_blank"
                                    class="badge badge-primary">Download</a>
                            @else
                                <span class="text-muted">Tidak ada file jawaban</span>
                            @endif
                        </p>

                        @if ($jawaban->review)
                            <p class="card-text mb-1">
                                <strong>Nilai:</strong> {{ $jawaban->review->nilai ?? '-' }}
                            </p>
                            <p class="card-text mb-1">
                                <strong>Review:</strong> {{ $jawaban->review->review ?? '-' }}
                            </p>
                            <p class="card-text mb-1">
                                <strong>File Feedback:</strong>
                                @if (!empty($jawaban->review->file_feedback))
                                    <a href="{{ asset('/feedback/' . $jawaban->review->file_feedback) }}"
                                        class="badge badge-info" target="_blank">Download</a>
                                @else
                                    <span class="text-muted">Tidak ada</span>
                                @endif
                            </p>
                        @else
                            <p class="card-text text-warning">Belum direview</p>
                        @endif

                        <p class="card-text">
                            <small class="text-muted">Dikirim pada
                                {{ \Carbon\Carbon::parse($jawaban->created_at)->translatedFormat('d F Y H:i') }}</small>
                        </p>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-info">
                    Belum ada tugas yang dikirim.
                </div>
            </div>
        @endforelse
    </div>
@endsection
