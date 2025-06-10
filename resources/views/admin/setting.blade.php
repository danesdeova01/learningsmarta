@extends('layouts.app')

@section('title')
    Setting
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <form action="{{ url('admin/setting', []) }}" method="POST">
                @csrf
                <div class="row mb-3">
                    <label for="name" class="col-sm-2 col-form-label">Nama Lengkap</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="name" value="{{ Auth::user()->name }}" required>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="email" class="col-sm-2 col-form-label">Email</label>
                    <div class="col-sm-10">
                        <input type="email" class="form-control" name="email" value="{{ Auth::user()->email }}"
                            required>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="password" class="col-sm-2 col-form-label">Password</label>
                    <div class="col-sm-10">
                        <input type="password" class="form-control" name="password" placeholder="*****">
                        <small class="form-text text-danger">
                            Kosongkan jika tidak ingin mengubah password
                        </small>
                    </div>
                </div>
                <div class="text-right">
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    <a href="{{ url('/home', []) }}" class="btn btn-warning ml-2">Kembali ke Dashboard</a>
                </div>
            </form>
        </div>
    </div>
@endsection
