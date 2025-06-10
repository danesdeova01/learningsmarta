<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HasilUjian;
use Illuminate\Http\Request;

class HasilUjianController extends Controller
{
    public function index()
    {
        $hasilUjian = HasilUjian::with(['user', 'matapelajaran'])
            ->orderBy('tanggal_ujian', 'desc')
            ->paginate(20);

        $menuActive = 'hasil-ujian';

        return view('admin.hasil_ujian.index', compact('hasilUjian', 'menuActive'));
    }

    public function destroy($id)
    {
        $hasil = HasilUjian::findOrFail($id);
        $hasil->delete();

        return redirect()->route('admin.hasil_ujian.index')->with('success', 'Data hasil ujian berhasil dihapus.');
    }
}
