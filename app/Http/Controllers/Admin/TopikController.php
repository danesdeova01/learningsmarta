<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MataPelajaran;
use App\Models\Kelas;
use App\Models\Topik;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;

class TopikController extends Controller
{
    public function index()
    {
        $topiks = Topik::with('mataPelajaran', 'kelas')->latest()->get();

        return view('admin.topik.index', [
            'menuActive' => 'topik',
            'topiks' => $topiks,
        ]);
    }

    public function create()
    {
        return view('admin.topik.form', [
            'menuActive' => 'topik',
            'isEdit' => false,
            'url' => route('admin.topik.store'),
            'mata_pelajarans' => MataPelajaran::latest()->get(),
            'kelas' => Kelas::all(),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'matapelajaran_id' => 'required|exists:mata_pelajarans,id',
            'kelas_id' => 'required|exists:kelas,id',
            'konten' => 'nullable|string',
            'file' => 'nullable|file|max:25000',
        ]);

        $namaFile = null;
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $namaFile = time() . '_' . preg_replace('/\s+/', '_', $file->getClientOriginalName());
            $file->storeAs('materi/file', $namaFile, 'public');
        }

        Topik::create([
            'nama' => $validated['nama'],
            'matapelajaran_id' => $validated['matapelajaran_id'],
            'kelas_id' => $validated['kelas_id'],
            'konten' => $validated['konten'] ?? null,
            'file' => $namaFile,
        ]);

        Alert::success('Berhasil', 'Topik berhasil ditambahkan');
        return redirect()->route('admin.topik.index');
    }

    public function edit($id)
    {
        $topik = Topik::findOrFail($id);

        return view('admin.topik.form', [
            'menuActive' => 'topik',
            'isEdit' => true,
            'url' => route('admin.topik.update', $id),
            'mata_pelajarans' => MataPelajaran::latest()->get(),
            'kelas' => Kelas::all(),
            'data' => $topik,
        ]);
    }

    public function update(Request $request, $id)
    {
        try {
            $topik = Topik::findOrFail($id);

            $validated = $request->validate([
                'nama' => 'required|string|max:255',
                'matapelajaran_id' => 'required|exists:mata_pelajarans,id',
                'kelas_id' => 'required|exists:kelas,id',
                'konten' => 'nullable|string',
                'file' => 'nullable|file|max:25000',
            ]);

            $namaFile = $topik->file; // default file lama
            if ($request->hasFile('file')) {
                // Hapus file lama jika ada
                if ($topik->file && Storage::disk('public')->exists('materi/file/' . $topik->file)) {
                    Storage::disk('public')->delete('materi/file/' . $topik->file);
                }
                $file = $request->file('file');
                $namaFile = time() . '_' . preg_replace('/\s+/', '_', $file->getClientOriginalName());
                $file->storeAs('materi/file', $namaFile, 'public');
            }

            $topik->update([
                'nama' => $validated['nama'],
                'matapelajaran_id' => $validated['matapelajaran_id'],
                'kelas_id' => $validated['kelas_id'],
                'konten' => $validated['konten'] ?? null,
                'file' => $namaFile,
            ]);

            Alert::success('Berhasil', 'Topik berhasil diperbarui');
            return redirect()->route('admin.topik.index');
        } catch (\Exception $e) {
            return back()->withInput()->withErrors(['error' => 'Error: ' . $e->getMessage()]);
        }
    }
public function downloadMateri($filename)
{
    $filePath = 'materi/file/' . $filename;

    if (Storage::disk('public')->exists($filePath)) {
        return Storage::disk('public')->download($filePath);
    } else {
        abort(404, 'File not found.');
    }
}


    public function destroy($id)
    {
        $topik = Topik::findOrFail($id);

        if ($topik->file && Storage::disk('public')->exists('materi/file/' . $topik->file)) {
            Storage::disk('public')->delete('materi/file/' . $topik->file);
        }

        $topik->delete();

        Alert::success('Berhasil', 'Topik berhasil dihapus');
        return redirect()->route('admin.topik.index');
    }
}
