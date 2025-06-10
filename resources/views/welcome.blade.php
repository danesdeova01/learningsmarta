@extends('layouts.web')

@section('title', 'Beranda')

@section('breadcrumb')
{{-- Kosong atau sesuaikan --}}
@endsection

@section('content')
<div class="container py-5">
    <div class="row align-items-center mb-5">
        <div class="col-lg-6 mb-4 mb-lg-0">
            <h1 class="hero-title text-primary">
                 Selamat Datang di <br>
                <span class="text-dark">{{ env('APP_NAME') }}</span>
            </h1>

            <p class="lead text-dark">
                Platform pembelajaran digital yang mempermudah siswa dan guru dalam mengakses proses belajar mengajar secara fleksibel, interaktif, dan efisien.
            </p>
            <a href="{{ url('/matapelajaran') }}" class="btn btn-primary btn-lg shadow-sm">
                Mulai Belajar
            </a>
        </div>
        <div class="col-lg-6 text-center">
            <img src="{{ asset('img/banner.svg') }}" alt="Banner" class="img-fluid" style="max-height: 400px; max-width: 100%;">
        </div>
    </div>

    {{-- Foto Sekolah --}}
    <div class="row mb-4 justify-content-center">
        <div class="col-auto">
            <img src="{{ asset('img/sman-1-rejotangan.jpeg') }}" alt="Foto SMAN 1 Rejotangan" class="img-fluid rounded shadow" style="max-height: 500px;">
        </div>
    </div>

    {{-- Profil Sekolah --}}
    <div class="row mb-5">
        <div class="col-12">
            <div class="card shadow-sm border-0 rounded-lg">
                <div class="card-body">
                    <h3 class="card-title font-weight-bold mb-4 text-primary">Profil Sekolah</h3>
                    <div class="row">
                        <div class="col-md-6">
                            <ul class="list-unstyled text-dark">
                                <li><strong>Nama Sekolah :</strong> SMAN 1 Rejotangan</li>
                                <li><strong>Alamat :</strong> Jl. Raya Buntaran, Rejotangan, Tulungagung, Jawa Timur, 66253</li>
                                <li><strong>Email :</strong> smanrejotangan@yahoo.co.id</li>
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <ul class="list-unstyled text-dark">
                                <li><strong>Akreditasi :</strong> A (BAIK)</li>
                                <li><strong>Tanggal Pendirian :</strong> 5 Mei 1992</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Visi dan Misi --}}
    <div class="row mb-5">
        <div class="col-md-6 mb-4">
            <div class="card shadow-sm border-0 rounded-lg h-100">
                <div class="card-body">
                    <h4 class="card-title font-weight-bold text-primary mb-3">Visi Sekolah</h4>
                    <p class="text-dark">
                        Menjadikan SMAN 1 Rejotangan sekolah yang menghasilkan lulusan yang beriman, bertakwa, cerdas, terampil, mandiri, dan berwawasan lingkungan.
                    </p>
                </div>
            </div>
        </div>
        <div class="col-md-6 mb-4">
            <div class="card shadow-sm border-0 rounded-lg h-100">
                <div class="card-body">
                    <h4 class="card-title font-weight-bold text-primary mb-3">Misi Sekolah</h4>
                    <ul class="text-dark pl-3">
                        <li>Menanamkan nilai-nilai keimanan dan akhlak mulia.</li>
                        <li>Mengembangkan potensi siswa melalui pembelajaran efektif dan berbasis TIK.</li>
                        <li>Meningkatkan prestasi akademik dan non-akademik.</li>
                        <li>Menciptakan lingkungan sekolah yang bersih, hijau, dan nyaman.</li>
                        <li>Mempersiapkan lulusan yang siap bersaing di jenjang pendidikan tinggi dan masyarakat global.</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    {{-- Materi Terbaru --}}
    <div class="row mb-4">
        <div class="col-12 text-center">
            <h3 class="font-weight-bold text-primary mb-2">Materi Terbaru</h3>
            <p class="text-dark mb-4">Ikuti setiap materi terbaru untuk mengasah diri kamu</p>
        </div>
    </div>

    <div class="row">
        @forelse ($mata_pelajarans as $matapelajaran)
            <div class="col-12 col-md-4 col-lg-4 mb-4 d-flex align-items-stretch">
                <div class="card shadow-sm border-0 rounded-lg w-100">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title font-weight-bold">{{ $matapelajaran->nama }}</h5>
                        <p class="card-text text-dark mb-4">
                            <small>{{ $matapelajaran->created_at->diffForHumans() }}</small>
                        </p>
                        <a href="{{ url('/matapelajaran')}}" class="btn btn-outline-primary mt-auto">
                            Lihat Materi
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <p class="text-center text-dark">Belum ada materi yang tersedia.</p>
            </div>
        @endforelse
    </div>
</div>
@endsection
