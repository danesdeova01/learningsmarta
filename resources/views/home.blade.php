@extends('layouts.app')

@section('title')
    Dashboard
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
            <div class="card card-statistic-1">
                <div class="card-icon bg-primary">
                    <i class="fas fa-book"></i>
                </div>
                <div class="card-wrap">
                    <div class="card-header">
                        <h4>Materi</h4>
                    </div>
                    <div class="card-body">
                        {{ $total_matapelajaran }}
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
            <div class="card card-statistic-1">
                <div class="card-icon bg-danger">
                    <i class="fas fa-book-reader"></i>
                </div>
                <div class="card-wrap">
                    <div class="card-header">
                        <h4>Topik</h4>
                    </div>
                    <div class="card-body">
                        {{ $total_topik }}
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
            <div class="card card-statistic-1">
                <div class="card-icon bg-warning">
                    <i class="fas fa-question-circle"></i>
                </div>
                <div class="card-wrap">
                    <div class="card-header">
                        <h4>Kuis</h4>
                    </div>
                    <div class="card-body">
                        {{ $total_kuis }}
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
            <div class="card card-statistic-1">
                <div class="card-icon bg-success">
                    <i class="fas fa-poll-h"></i>
                </div>
                <div class="card-wrap">
                    <div class="card-header">
                        <h4>Tugas</h4>
                    </div>
                    <div class="card-body">
                        {{ $total_tugas }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="alert alert-light alert-has-icon">
                <div class="alert-icon"><i class="far fa-lightbulb"></i></div>
                <div class="alert-body">
                    <div class="alert-title">Teacher Panel</div>
                    Selamat datang <strong>Guru</strong>. Sekarang Anda bisa menambahkan materi, topik, latihan kuis, dan
                    daftar tugas!
                </div>
            </div>
        </div>
    </div>
@endsection
