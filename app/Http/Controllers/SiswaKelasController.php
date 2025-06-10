<?php

namespace App\Http\Controllers;

use App\Models\Kelas;

class SiswaKelasController extends Controller
{
    public function index()
    {
        $kelas = Kelas::with('siswa')->orderBy('nama')->get();
        return view('admin.siswa.index', compact('kelas'));
    }



    public function kelasShow($id)
    {
        $kelas = Kelas::where('id', $id)->with('siswa', 'matapelajarans')->first();
        return view('admin.siswa.kelas.index', compact('kelas'));
    }
}
