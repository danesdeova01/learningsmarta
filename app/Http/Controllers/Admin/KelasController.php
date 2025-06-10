<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kelas;
use Illuminate\Http\Request;

class KelasController extends Controller
{
    public function index()
    {
        $menuActive = 'kelas';  // Menandai bahwa menu 'kelas' aktif
        $kelas = Kelas::all();

        return view('admin.kelas.index', compact('kelas', 'menuActive'));
    }
    public function showKelas()
    {
        $kelasList = Kelas::with('siswa')->orderBy('nama_kelas')->get();
        return view('kelas.index', compact('kelasList'));
    }

    public function create()
    {
        return view('admin.kelas.create');
    }

    public function store(Request $request)
    {
        Kelas::create($request->all());
        return redirect()->route('admin.kelas.index');
    }

    public function show($id)
    {
        $kelas = Kelas::where('id', $id)->with('siswa', 'matapelajarans')->first();
        $menuActive = 'Detail kelas';
        return view('admin.kelas.show', compact('kelas' , 'menuActive'));
    }

    public function edit(Kelas $kelas)
    {
        return view('admin.kelas.edit', compact('kelas'));
    }

    public function update(Request $request, Kelas $kelas)
    {
        $kelas->update($request->all());
        return redirect()->route('admin.kelas.index');
    }

    public function destroy(Kelas $kelas)
    {
        $kelas->delete();
        return redirect()->route('admin.kelas.index');
    }
}
