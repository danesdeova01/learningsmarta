@extends('layouts.web')

@section('title', 'Silahkan Pilih Mapel')

@section('content')
    <div class="section-body">
        <div class="row">
            @foreach ($mapels as $key => $item)
                <div class="col-md-6 col-lg-4 mb-4">
                    <a href="{{ route('latihan.soal.tipe', ['id' => $item->id]) }}" style="text-decoration: none;">
                        <div class="card text-white bg-primary">
                            <div class="card-body">
                                <h5 class="card-title">{{ $item->nama }}</h5>
                            </div>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    </div>
@endsection
