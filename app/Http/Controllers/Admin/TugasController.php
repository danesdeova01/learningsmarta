<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MataPelajaran;
use App\Models\Kelas;
use App\Models\Tugas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;

class TugasController extends Controller
{
    public function index()
    {
        return view('admin.tugas.index', [
            'menuActive' => 'tugas',
            'tugas'      => Tugas::with('jawabans', 'matapelajaran', 'kelas')->latest()->get(),
        ]);
    }

    public function create()
    {
        return view('admin.tugas.form', [
            'menuActive'    => 'tugas',
            'isEdit'        => false,
            'url'           => route('admin.tugas.store'),
            'matapelajaran' => MataPelajaran::latest()->get(),
            'kelas'         => Kelas::orderBy('nama')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'konten'           => 'required|string',
            'matapelajaran_id' => 'required|exists:mata_pelajarans,id',
            'kelas_id'         => 'required|exists:kelas,id',
            'due_date'         => 'nullable|date|after:now',
            'file'             => 'nullable|file|mimes:pdf|max:25000',
        ]);

        $namaFile = null;
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $namaFile = time() . '_' . preg_replace('/\s+/', '_', $file->getClientOriginalName());
            $file->storeAs('tugas/file', $namaFile, 'public');
        }

        Tugas::create([
            'konten'           => $validated['konten'],
            'matapelajaran_id' => $validated['matapelajaran_id'],
            'kelas_id'         => $validated['kelas_id'],
            'file'             => $namaFile,
            'due_date'         => $validated['due_date'] ?? null,
        ]);

        Alert::success('Berhasil', 'Data tugas telah ditambahkan');
        return redirect()->route('admin.tugas.index');
    }

    public function show($id)
    {
        $tugas = Tugas::with('jawabans', 'matapelajaran', 'kelas')->findOrFail($id);

        return view('admin.tugas.detail', [
            'menuActive' => 'tugas',
            'tugas'      => $tugas,
        ]);
    }

public function downloadTugas($filename)
{
    $filePath = 'tugas/file/' . $filename;

    if (Storage::exists($filePath)) {
        return Storage::download($filePath);
    } else {
        abort(404, 'File not found.');
    }

}
 
public function uploadJawaban(Request $request)
{
    $validated = $request->validate([
        'tugas_id' => 'required|exists:tugas,id',
        'siswa_id' => 'required|exists:siswa,id',
        'file'     => 'nullable|file|mimes:pdf|max:25000',
    ]);

    $namaFile = null;
    if ($request->hasFile('file_jawab')) {
    $file = $request->file('file_jawab');
    $namaFile = time() . '_' . preg_replace('/\s+/', '_', $file->getClientOriginalName());
    $file->storeAs('jawaban/file', $namaFile, 'public');
}


    Jawaban::create([
        'tugas_id' => $validated['tugas_id'],
        'siswa_id' => $validated['siswa_id'],
        'file'     => $namaFile,
    ]);
Alert::success('Berhasil', 'Jawaban berhasil dikirim!');
        return redirect()->route('admin.jawaban.index');

}

    public function downloadJawaban($filename)
{

  $filePath = 'jawaban/file/' . $filename;   

if (!Storage::disk('public')->exists($filePath)) {
        abort(404, 'File jawaban tidak ditemukan.');
    }

    return Storage::disk('public')->download($filePath);
}

    public function edit($id)
    {
        $tugas = Tugas::findOrFail($id);

        return view('admin.tugas.form', [
            'menuActive'    => 'tugas',
            'isEdit'        => true,
            'url'           => route('admin.tugas.update', $id),
            'matapelajaran' => MataPelajaran::latest()->get(),
            'kelas'         => Kelas::orderBy('nama')->get(),
            'data'          => $tugas,
        ]);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'konten'           => 'required|string',
            'matapelajaran_id' => 'required|exists:mata_pelajarans,id',
            'kelas_id'         => 'required|exists:kelas,id',
            'due_date'         => 'nullable|date|after:now',
            'file'             => 'nullable|file|mimes:pdf|max:25000',
        ]);

        $tugas = Tugas::findOrFail($id);
        $namaFile = $tugas->file;

        if ($request->hasFile('file')) {
            // Hapus file lama jika ada
            if ($tugas->file && Storage::exists('public/tugas/file/' . $tugas->file)) {
                Storage::delete('public/tugas/file/' . $tugas->file);
            }

            $file = $request->file('file');
            $namaFile = time() . '_' . preg_replace('/\s+/', '_', $file->getClientOriginalName());
            $file->storeAs('public/tugas/file', $namaFile);
        }

        $tugas->update([
            'konten'           => $validated['konten'],
            'matapelajaran_id' => $validated['matapelajaran_id'],
            'kelas_id'         => $validated['kelas_id'],
            'file'             => $namaFile,
            'due_date'         => $validated['due_date'] ?? null,
        ]);

        Alert::success('Berhasil', 'Data tugas telah diperbarui');
        return redirect()->route('admin.tugas.index');
    }

    public function destroy($id)
    {
        $tugas = Tugas::findOrFail($id);

        if ($tugas->file && Storage::exists('public/tugas/file/' . $tugas->file)) {
            Storage::delete('public/tugas/file/' . $tugas->file);
        }

        $tugas->delete();

        Alert::success('Berhasil', 'Data tugas telah dihapus');
        return redirect()->route('admin.tugas.index');
    }
    
}



