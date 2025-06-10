@extends('layouts.web')

@section('title', 'Ubah Password')

@section('content')
    <div class="">
        <form action="{{ route('siswa.change-password.store', ['id' => 1]) }}" method="post">
            @csrf
            <div class="card col-lg-12">
                <div class="card-body">
                    <div class="mb-3">
                        <label>Password Baru</label>
                        <input name="password" type="password" class="form-control @error('password') is-invalid @enderror">
                        @error('password')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label>Konfirmasi Password</label>
                        <input name="password_confirmation" type="password"
                            class="form-control @error('password_confirmation') is-invalid @enderror">
                        @error('password_confirmation')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary btn-sm">Simpan</button>
                </div>
            </div>
        </form>
    </div>
@endsection
