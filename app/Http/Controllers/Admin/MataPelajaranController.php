<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kelas;
use App\Models\MataPelajaran;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use RealRashid\SweetAlert\Facades\Alert;

class MataPelajaranController extends Controller
{
    /**
     * Tampilkan daftar mata pelajaran dengan relasi kelas.
     */
    public function index()
    {
        $mata_pelajarans = MataPelajaran::with('kelas')->latest()->get();

        return view('admin.matapelajaran.index', [
            'menuActive' => 'matapelajaran',
            'mata_pelajarans' => $mata_pelajarans,
        ]);
    }

    /**
     * Tampilkan form tambah mata pelajaran baru.
     */
    public function create()
    {
        $kelas = Kelas::all();

        return view('admin.matapelajaran.form', [
            'menuActive' => 'matapelajaran',
            'isEdit' => false,
            'url' => url('admin/matapelajaran'),
            'kelas' => $kelas,
        ]);
    }

    /**
     * Simpan data mata pelajaran baru ke database.
     */
    public function store(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'nama' => 'required|string|max:255|unique:mata_pelajarans,nama',
        ]);

        // Buat slug otomatis dari nama
        $slug = Str::slug($validated['nama']);

        // Simpan data mata pelajaran baru
        $matapelajaran = MataPelajaran::create([
            'nama' => $validated['nama'],
            'slug' => $slug,
        ]);

    // Ambil semua kelas
    $kelasAll = Kelas::all();

    // Attach mata pelajaran ke semua kelas
    $matapelajaran->kelas()->attach($kelasAll->pluck('id')->toArray());

    return redirect()->route('admin.matapelajaran.index')->with('success', 'Mata pelajaran berhasil ditambahkan');
}

    /**
     * Tampilkan form edit data mata pelajaran.
     */
    public function edit($id)
    {
        $data = MataPelajaran::findOrFail($id);
        $kelas = Kelas::all();

        return view('admin.matapelajaran.form', [
            'menuActive' => 'matapelajaran',
            'isEdit' => true,
            'url' => url('admin/matapelajaran/' . $id),
            'data' => $data,
            'kelas' => $kelas,
        ]);
    }

    // Tampilkan daftar topik dari mata pelajaran yang dipilih
    public function detail($matapelajaran)
    {
        $matapelajaranModel = MataPelajaran::with('kelas', 'topiks')
        ->where('slug', $matapelajaran)
        ->orWhere('id', $matapelajaran)
        ->firstOrFail();

        $kelas = $matapelajaranModel->kelas->first();

        return view('matapelajaran-detail', [
            'matapelajaran' => $matapelajaranModel,
            'kelas' => $kelas,
        ]);

    }

    public function topiks()
{
    return $this->hasMany(\App\Models\Topik::class, 'matapelajaran_id');
}


    /**
     * Update data mata pelajaran di database.
     */
    public function update(Request $request, $id)
    {
        // Validasi input
        $validatedData = $request->validate([
            'nama' => 'required|string|max:255',
            'kelas_id' => 'required|exists:kelas,id',
        ]);

        // Buat slug otomatis dari nama
        $validatedData['slug'] = Str::slug($validatedData['nama']);

        // Update data
        MataPelajaran::findOrFail($id)->update($validatedData);

        Alert::warning('Berhasil', 'Data mata pelajaran telah diperbarui');

        return redirect()->route('admin.matapelajaran.index');
    }

    /**
     * Hapus data mata pelajaran dari database.
     */
    public function destroy($id)
    {
        MataPelajaran::findOrFail($id)->delete();

        Alert::error('Berhasil', 'Data mata pelajaran telah dihapus');

        return redirect()->route('admin.matapelajaran.index');
    }
}
