<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MataPelajaran;
use App\Models\Soal;
use App\Models\JenisUjian;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class SoalController extends Controller
{
    public function index()
    {
        return view('admin.soal.index', [
            'menuActive'   => 'kuis',
            'soals'        => Soal::with('matapelajaran')->latest()->get(),
            'jenisUjian'   => JenisUjian::all(),
        ]);
    }

    public function updateJenisUjianTimer(Request $request)
    {
        foreach ($request->timer as $id => $value) {
            JenisUjian::where('id', $id)->update(['timer' => $value]);
        }

        Alert::success('Berhasil', 'Timer berhasil diperbarui');
        return redirect()->back();
    }

    public function create()
    {
        return view('admin.soal.form', [
            'menuActive' => 'kuis',
            'isEdit'     => false,
            'url'        => route('admin.soal.store'),
            'mata_pelajarans' => MataPelajaran::all(),
            'jenis_ujian_list' => JenisUjian::all(), // Tambahkan ini
            'plainMenjodohkan' => '', // Untuk textarea menjodohkan saat create
        ]);
    }

    public function store(Request $request)
    {
        // Update validasi untuk mendukung semua jenis ujian dari database
        $jenisUjianValid = JenisUjian::pluck('nama')->toArray();

        $request->validate([
            'matapelajaran_id' => 'required|exists:mata_pelajarans,id',
            'jenis_ujian' => 'required|in:' . implode(',', $jenisUjianValid),
            'jenis_soal' => 'required',
            'pertanyaan' => 'required',
        ]);

        $soal = new Soal();
        $soal->matapelajaran_id = $request->input('matapelajaran_id');
        $soal->jenis_ujian = $request->input('jenis_ujian');
        $soal->jenis_soal = $request->input('jenis_soal');
        $soal->pertanyaan = $request->input('pertanyaan');

        if ($soal->jenis_soal == 'menjodohkan') {
            // Ambil input plain text
            $plainInput = $request->input('menjodohkan_plain', '');
            $pairs = [];
            $lines = preg_split('/\r\n|\r|\n/', trim($plainInput));
            foreach ($lines as $line) {
                if (strpos($line, '|') !== false) {
                    list($key, $value) = explode('|', $line, 2);
                } elseif (strpos($line, '-') !== false) {
                    list($key, $value) = explode('-', $line, 2);
                } else {
                    continue; // Lewatkan baris tanpa pemisah
                }
                $key = trim($key);
                $value = trim($value);
                if ($key !== '' && $value !== '') {
                    $pairs[$key] = $value;
                }
            }
            $soal->pencocokan = json_encode($pairs);
        } elseif ($soal->jenis_soal == 'pilihan_ganda') {
            $soal->pilihan_a = $request->pilihanganda_a;
            $soal->pilihan_b = $request->pilihanganda_b;
            $soal->pilihan_c = $request->pilihanganda_c;
            $soal->pilihan_d = $request->pilihanganda_d;
            $soal->pilihan_e = $request->pilihanganda_e;
            $soal->kunci_jawaban = $request->kunci_jawaban;
        } elseif ($soal->jenis_soal == 'pilihan_ganda_kompleks') {
            $soal->pilihan_a = $request->pilihan_a;
            $soal->pilihan_b = $request->pilihan_b;
            $soal->pilihan_c = $request->pilihan_c;
            $soal->pilihan_d = $request->pilihan_d;
            $soal->pilihan_e = $request->pilihan_e;
            $kunci = $request->input('kunci_jawaban', []);
            $soal->kunci_jawaban = is_array($kunci) ? json_encode($kunci) : json_encode([]);
        } elseif ($soal->jenis_soal == 'uraian_singkat') {
            $soal->uraian = $request->jawaban_uraian;
        }

        $soal->save();

        Alert::success('Berhasil', 'Soal berhasil ditambahkan');
        return redirect()->route('admin.soal.index');
    }

    public function edit($id)
    {
        $soal = Soal::findOrFail($id);

        // Untuk menjodohkan, tampilkan pasangan dalam format plain text
        $plainMenjodohkan = '';
        if ($soal->jenis_soal == 'menjodohkan' && $soal->pencocokan) {
            $pairs = json_decode($soal->pencocokan, true) ?? [];
            foreach ($pairs as $k => $v) {
                $plainMenjodohkan .= $k . ' | ' . $v . "\n";
            }
        }

        return view('admin.soal.form', [
            'menuActive' => 'kuis',
            'isEdit'     => true,
            'url'        => route('admin.soal.update', $id),
            'data'       => $soal,
            'mata_pelajarans' => MataPelajaran::all(),
            'jenis_ujian_list' => JenisUjian::all(), // Tambahkan ini
            'plainMenjodohkan' => $plainMenjodohkan,
        ]);
    }

    public function update(Request $request, $id)
    {
        // Update validasi untuk mendukung semua jenis ujian dari database
        $jenisUjianValid = JenisUjian::pluck('nama')->toArray();

        $request->validate([
            'matapelajaran_id' => 'required|exists:mata_pelajarans,id',
            'jenis_ujian' => 'required|in:' . implode(',', $jenisUjianValid),
            'jenis_soal' => 'required',
            'pertanyaan' => 'required',
        ]);

        $soal = Soal::findOrFail($id);
        $soal->matapelajaran_id = $request->input('matapelajaran_id');
        $soal->jenis_ujian = $request->input('jenis_ujian');
        $soal->jenis_soal = $request->input('jenis_soal');
        $soal->pertanyaan = $request->input('pertanyaan');

        if ($soal->jenis_soal == 'menjodohkan') {
            $plainInput = $request->input('menjodohkan_plain', '');
            $pairs = [];
            $lines = preg_split('/\r\n|\r|\n/', trim($plainInput));
            foreach ($lines as $line) {
                if (strpos($line, '|') !== false) {
                    list($key, $value) = explode('|', $line, 2);
                } elseif (strpos($line, '-') !== false) {
                    list($key, $value) = explode('-', $line, 2);
                } else {
                    continue;
                }
                $key = trim($key);
                $value = trim($value);
                if ($key !== '' && $value !== '') {
                    $pairs[$key] = $value;
                }
            }
            $soal->pencocokan = json_encode($pairs);
        } elseif ($soal->jenis_soal == 'pilihan_ganda') {
            $soal->pilihan_a = $request->pilihan_a;
            $soal->pilihan_b = $request->pilihan_b;
            $soal->pilihan_c = $request->pilihan_c;
            $soal->pilihan_d = $request->pilihan_d;
            $soal->pilihan_e = $request->pilihan_e;
            $soal->kunci_jawaban = $request->kunci_jawaban;
        } elseif ($soal->jenis_soal == 'pilihan_ganda_kompleks') {
            $soal->pilihan_a = $request->pilihan_a;
            $soal->pilihan_b = $request->pilihan_b;
            $soal->pilihan_c = $request->pilihan_c;
            $soal->pilihan_d = $request->pilihan_d;
            $soal->pilihan_e = $request->pilihan_e;
            $kunci = $request->input('kunci_jawaban', []);
            $soal->kunci_jawaban = is_array($kunci) ? json_encode($kunci) : json_encode([]);
        } elseif ($soal->jenis_soal == 'uraian_singkat') {
            $soal->uraian = $request->jawaban_uraian;
        }

        $soal->save();

        Alert::success('Berhasil', 'Soal berhasil diperbarui');
        return redirect()->route('admin.soal.index');
    }

    public function destroy($id)
    {
        Soal::findOrFail($id)->delete();
        Alert::success('Berhasil', 'Soal berhasil dihapus');
        return redirect()->route('admin.soal.index');
    }
}
