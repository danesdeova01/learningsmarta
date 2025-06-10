<?php

namespace App\Http\Controllers;

use App\Models\MataPelajaran;
use App\Models\Topik;
use App\Models\Soal;
use App\Models\Tugas;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user = \Auth::user();
        if ($user->level === 'admin' || $user->level === 'guru') {
            // Panel admin/guru
            return view('home', [
                'menuActive'   => 'home',
                'total_matapelajaran' => MataPelajaran::count(),
                'total_topik'  => Topik::count(),
                'total_kuis'   => Soal::count(),
                'total_tugas'  => Tugas::count(),
            ]);
        } elseif ($user->level === 'mahasiswa' || $user->level === 'siswa') {
            // Siswa/mahasiswa ke halaman utama siswa
            return redirect()->route('welcome');
        } else {
            // Default: redirect ke siswa
            return redirect()->route('welcome');
        }
    }
}
