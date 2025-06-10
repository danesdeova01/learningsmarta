<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kelas;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use RealRashid\SweetAlert\Facades\Alert;

class MahasiswaController extends Controller
{
    //

    public function store(Request $request)
    {
        $validated = $request->validate(
            [
                'name' => 'required',
                'email' => 'required|email',
                'password' => 'required'
            ]
        );


        $validated['level'] = 'mahasiswa';
        $validated['password'] = Hash::make($validated['password']);

        Mahasiswa::create(
            $validated
        );

        Alert::success('Berhasil menambahkan siswa');
        return redirect()->route('admin.mahasiswa.index');
    }

    public function index()
    {
        $menuActive = 'siswa';
        $mahasiswas = Mahasiswa::with('kelas')->get();
        $kelas = Kelas::all();

        return view('admin.mahasiswa.index', compact('menuActive', 'mahasiswas', 'kelas'));
    }


    public function addKelasForm($id)
    {
        $menuActive = 'siswa';
        $siswa = Mahasiswa::findOrFail($id);
        $kelas = Kelas::all();
        return view('admin.mahasiswa.add-kelas', compact('menuActive', 'siswa', 'kelas'));
    }


    public function editKelasForm($id)
    {
        $menuActive = 'siswa';
        $siswa = Mahasiswa::findOrFail($id);
        $kelas = Kelas::all();

        return view('admin.mahasiswa.edit-kelas', compact('menuActive', 'siswa', 'kelas'));
    }

    public function create()
    {
        $menuActive = 'siswa';

        return view('admin.mahasiswa.create', compact('menuActive'));
    }

    public function addKelas(Request $request, $id)
    {
        $siswa = Mahasiswa::find($id);
        $request->validate(
            [
                'kelas_id' => 'required'
            ]
        );

        $siswa->kelas_id = $request->input('kelas_id');

        $siswa->save();

        Alert::success('Berhasil menambahkan kelas ke siswa');
        return redirect()->route('admin.mahasiswa.index');
    }


    public function updateKelas(Request $request, $id)
    {
        $siswa = Mahasiswa::find($id);

        if (!$siswa) {
            return redirect()->route('admin.mahasiswa.index')->with('error', 'siswa tidak ditemukan');
        }

        $request->validate([
            'kelas_id' => 'required|exists:kelas,id',
        ]);

        $siswa->kelas_id = $request->input('kelas_id');

        $siswa->save();

        Alert::success('Berhasil mengupdate kelas siswa');

        return redirect()->route('admin.mahasiswa.index');
    }


    public function destroy($id)
    {
        $siswa = Mahasiswa::findOrFail($id);
        $siswa->delete();
        Alert::success('Berhasil menghapus  siswa');
        return redirect()->route('admin.mahasiswa.index');
    }
}
