@extends('layouts.app')

@section('title')
    Detail Submit Tugas
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <p><strong>Due Date:</strong> {{ \Carbon\Carbon::parse($tugas->due_date)->format('d-m-Y H:i') }}</p>

            <div class="table-responsive">
                <table class="table table-striped datatable">
                    <thead>
                        <tr>
                            <th class="text-center">#</th>
                            <th class="text-center">No Induk</th>
                            <th class="text-center">Nama</th>
                            <th class="text-center">Jawaban</th>
                            <th class="text-center">Waktu Upload</th> {{-- Kolom baru --}}
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($tugas->jawabans as $item)
                            <tr>
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td class="text-center">{{ $item->no_induk }}</td>
                                <td class="text-center">{{ $item->nama }}</td>
                                <td class="text-center">
                                    @if ($item->file_jawab == null)
                                        <span class="badge badge-secondary">
                                            <small>Tidak ada</small>
                                        </span>
                                    @else
                                        <a href="{{ route('jawaban.download', $item->file_jawab) }}" 
                                           class="badge badge-info" target="_blank">
                                            <small>Download</small>
                                        </a>
                                    @endif
                                </td>
                                <td class="text-center">
                                    {{-- Tampilkan waktu upload dengan format d-m-Y H:i --}}
                                    {{ $item->created_at ? \Carbon\Carbon::parse($item->created_at)->format('d-m-Y H:i') : '-' }}
                                </td>
                                <td class="text-center">
                                    @if ($item->review)
                                        <button class="btn btn-primary btn-sm btn-review" data-id="{{ $item->id }}"
                                            data-nama="{{ $item->nama }}">
                                            Detail Review
                                        </button>
                                    @else
                                        <button class="btn btn-primary btn-sm btn-review" data-id="{{ $item->id }}"
                                            data-nama="{{ $item->nama }}">
                                            Berikan Review
                                        </button>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

<!-- Modal Review -->
<div class="modal fade" id="modalReview" tabindex="-1" role="dialog" aria-labelledby="modalReviewLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form action="{{ route('admin.review.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="jawaban_id" id="jawaban_id">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Beri Review</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="review">Review</label>
                        <textarea name="review" id="review" rows="3" class="form-control" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="nilai">Nilai: <span id="nilaiValue">0</span></label>
                        <input type="range" name="nilai" id="nilai" class="form-control-range" min="0"
                            max="100" value="0"
                            oninput="document.getElementById('nilaiValue').textContent = this.value">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Simpan Review</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Modal Detail Review -->
<div class="modal fade" id="modalDetailReview" tabindex="-1" role="dialog" aria-labelledby="modalDetailReviewLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detail Review</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p><strong>Review:</strong></p>
                <p id="detailReviewText">-</p>
                <p><strong>Nilai:</strong> <span id="detailNilaiText">-</span></p>
                <p><strong>File Feedback:</strong> <span id="detailFileFeedback"><small class="text-muted">Tidak ada file</small></span></p>
            </div>
        </div>
    </div>
</div>

@section('script')
<script>
    $(".datatable").dataTable();

    $(document).on('click', '.btn-review', function() {
        const jawabanId = $(this).data('id');
        const nama = $(this).data('nama');
        const reviewData = @json($tugas->jawabans->keyBy('id')->map->review);

        if (reviewData[jawabanId]) {
            const data = reviewData[jawabanId];
            $('#detailReviewText').text(data.review ?? '-');
            $('#detailNilaiText').text(data.nilai ?? '-');

            if (data.file_feedback) {
                const fileUrl = `/feedback/${data.file_feedback}`;
                $('#detailFileFeedback').html(
                    `<a href="${fileUrl}" target="_blank" class="badge badge-info">Download File</a>`
                );
            } else {
                $('#detailFileFeedback').html(`<small class="text-muted">Tidak ada file</small>`);
            }

            $('#modalDetailReview').modal('show');
        } else {
            $('#jawaban_id').val(jawabanId);
            $('#review').val('');
            $('#nilai').val(0);
            $('#nilaiValue').text('0');
            $('#modalReview').modal('show');
        }
    });
</script>
@endsection
