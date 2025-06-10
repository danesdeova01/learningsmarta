<?php

namespace App\Http\Controllers;

use App\Models\Jawaban;
use App\Models\MataPelajaran;
use App\Models\JenisUjian;
use App\Models\Soal;
use App\Models\Tugas;
use App\Models\Forum;
use App\Models\ForumReply;
use App\Models\Kelas;
use App\Models\HasilUjian;
use App\Models\Topik;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class WebController extends Controller
{
    public function index()
    {
        if (!\Auth::check()) {
            return redirect()->route('login');
        }

        return view('welcome', [
            'menuActive' => 'beranda',
            'mata_pelajarans' => MataPelajaran::with('kelas')->latest()->limit(9)->get(),
        ]);
    }

    public function pilihKelas()
    {
        $kelas = Kelas::all();
        return view('matapelajaran-kelas', compact('kelas'));
    }

    // Daftar mata pelajaran per kelas
    public function showMatapelajaran($kelas)
    {
        $kelasModel = Kelas::where('slug', $kelas)->orWhere('id', $kelas)->firstOrFail();

        // Ambil mata pelajaran yang terkait dengan kelas ini melalui relasi many-to-many
        $mata_pelajarans = $kelasModel->mataPelajarans()->get();

        return view('matapelajaran-show', [
            'kelas' => $kelasModel,
            'mata_pelajarans' => $mata_pelajarans,
        ]);
    }

    public function matapelajaran()
    {
        return view('matapelajaran', [
            'menuActive' => 'matapelajaran',
            'matapelajarans' => MataPelajaran::with('mata_pelajarans')->latest()->get(),
        ]);
    }

    public function matpelDetail($matapelajaranId, Request $request)
    {
        $kelasId = $request->kelas ?? $request->kelas_id ?? null;
        $matapelajaran = MataPelajaran::findOrFail($matapelajaranId);
        $kelas = null;
        $topiks = collect();

        if ($kelasId) {
            $kelas = Kelas::where('slug', $kelasId)->orWhere('id', $kelasId)->first();
            $topiks = \App\Models\Topik::where('matapelajaran_id', $matapelajaran->id)
                ->where('kelas_id', $kelas->id)
                ->get();
        }

        return view('matapelajaran-detail', [
            'menuActive' => 'matapelajaran',
            'matapelajaran' => $matapelajaran,
            'kelas' => $kelas,
            'topiks' => $topiks,
        ]);
    }
    public function topik($id)
    {
        $topik = Topik::findOrFail($id);
        return view('topik', compact('topik'));
    }

    public function latihanSoalBefore()
    {
        $user = Auth::user();
        if (isset($user->kelas_id)) {
            $kelasId = $user->kelas_id;
            $mapels = MataPelajaran::whereHas('kelas', function ($query) use ($kelasId) {
                $query->where('kelas.id', $kelasId);
            })->get();
            return view('latihanSoalBefore', compact('mapels'));
        } else {
            return redirect()->to('/')->with('error', 'Ops, silahkan anda meminta admin untuk memberikan kelas anda');
        }
    }

    // Pilih kelas
    public function tugasPilihKelas()
    {
        $kelas = \App\Models\Kelas::all();
        return view('tugas-pilih-kelas', compact('kelas'));
    }

    // Pilih mata pelajaran berdasarkan kelas
    public function tugasPilihMapel($kelasId)
    {
        $kelas = \App\Models\Kelas::findOrFail($kelasId);
        $mata_pelajarans = $kelas->mataPelajarans; // relasi many-to-many
        return view('tugas-pilih-mapel', compact('kelas', 'mata_pelajarans'));
    }

    // Daftar tugas berdasarkan mata pelajaran
    public function tugasDaftar($kelasId, $mapelId)
    {
        $kelas = \App\Models\Kelas::findOrFail($kelasId);
        $mapel = \App\Models\MataPelajaran::findOrFail($mapelId);

        // Filter tugas berdasarkan kelas dan mata pelajaran
        $tugas = \App\Models\Tugas::where('matapelajaran_id', $mapelId)
            ->where('kelas_id', $kelasId)
            ->latest()
            ->get();

        $now = Carbon::now();

        return view('kirimtugas', compact('kelas', 'mapel', 'tugas'));
    }

    public function downloadMateriFile($filename)
    {
        $filePath = 'materi/file/' . $filename;

        if (!Storage::disk('public')->exists($filePath)) {
            abort(404, 'File tidak ditemukan.');
        }

        return Storage::disk('public')->download($filePath);
    }

    public function downloadTugasFile($filename)
    {
        $filePath = 'tugas/file/' . $filename;

        if (!Storage::disk('public')->exists($filePath)) {
            abort(404, 'File tidak ditemukan.');
        }

        return Storage::disk('public')->download($filePath);
    }

    public function downloadJawabanFile($filename)
    {
        $filePath = 'jawaban/file/' . $filename;

        if (!Storage::disk('public')->exists($filePath)) {
            abort(404, 'File tidak ditemukan.');
        }

        return Storage::disk('public')->download($filePath);
    }
    public function latihanSoalTipe($id)
    {
        // Ambil semua jenis ujian dari database
        $jenisUjianList = \App\Models\JenisUjian::all();

        return view('tipe-ujian', [
            'mapel_id' => $id,
            'jenisUjianList' => $jenisUjianList
        ]);
    }

    public function latihansoal(Request $request, $id)
    {
        $user = Auth::user();
        $tipe = $request->query('tipe');

        if (!isset($tipe)) {
            return redirect()->route('latihan.soal.tipe', ['id' => $id])
                ->with('error', 'Ops, harap pilih jenis UJIAN');
        }

        // Validasi apakah jenis ujian valid
        $jenisUjianValid = \App\Models\JenisUjian::pluck('nama')->toArray();
        if (!in_array($tipe, $jenisUjianValid)) {
            return redirect()->route('latihan.soal.tipe', ['id' => $id])
                ->with('error', 'Jenis ujian tidak valid');
        }

        if (isset($user->kelas_id)) {
            $kelas = Kelas::with('mataPelajarans')->where('id', $id)->first();

            if (!$kelas) {
                return abort(404, "Kelas tidak ditemukan");
            }

            $topikIds = Topik::where('matapelajaran_id', $id)
                ->where('kelas_id', $user->kelas_id)
                ->pluck('id')
                ->toArray();

            if (!is_array($id)) {
                $id = [$id];
            }

            $tipe = strtoupper($tipe); // pastikan $tipe huruf besar

            $soals = Soal::with('matapelajaran')
                ->whereIn('matapelajaran_id', $id)
                ->where('jenis_ujian', $tipe)
                ->get()
                ->map(function ($soal) {
                    if ($soal->jenis_soal === 'menjodohkan' && $soal->pencocokan) {
                        $decoded = json_decode($soal->pencocokan, true);
                        $soal->pencocokan_items = is_array($decoded) ? $decoded : [];
                    }
                    return $soal;
                });

            $optionMenjodohkan = $soals
                ->where('jenis_soal', 'menjodohkan')
                ->pluck('pencocokan')
                ->filter()
                ->shuffle()
                ->values()
                ->toArray();

            return view('latihansoal', [
                'menuActive' => 'kuis',
                'soals' => $soals,
                'jenisUjian' => JenisUjian::where('nama', $tipe)->first(),
                'optionMenjodohkan' => $optionMenjodohkan
            ]);
        } else {
            return redirect()->to('/')
                ->with('error', 'Ops, kamu belum memiliki kelas. Silakan meminta admin untuk memberikan kamu kelas terlebih dahulu!');
        }
    }

    public function submitLatihan(Request $request)
    {
        $pilihan = $request->pilihan;
        $uraian = $request->uraian;
        $menjodohkan = $request->menjodohkan;
        $id_soal = $request->id;
        $jumlah = $request->jumlah;

        $score = 0;
        $benar = 0;
        $salah = 0;
        $kosong = 0;

        for ($i = 0; $i < $jumlah; $i++) {
            $nomor = $id_soal[$i];
            $soal = Soal::find($nomor);

            // Periksa jenis soal dan jawaban yang sesuai
            if ($soal->jenis_soal == 'pilihan_ganda') {
                if (empty($pilihan[$nomor])) {
                    $kosong++;
                } else {
                    $jawaban = $pilihan[$nomor];

                    $where = array(
                        'id' => $nomor,
                        'kunci_jawaban' => $jawaban,
                    );
                    $cek = Soal::where($where)->count();
                    if ($cek == 1) {
                        $benar++;
                    } else {
                        $salah++;
                    }
                }
            } elseif ($soal->jenis_soal == 'uraian_singkat') {
                if (empty($uraian[$nomor])) {
                    $kosong++;
                } else {
                    $jawaban = $uraian[$nomor];
                    if (strtolower(trim($jawaban)) == strtolower(trim($soal->uraian))) {
                        $benar++;
                    } else {
                        $salah++;
                    }
                }
            } elseif ($soal->jenis_soal == 'pilihan_ganda_kompleks') {
                if (empty($pilihan[$nomor])) {
                    $kosong++;
                } else {
                    $jawaban = $pilihan[$nomor];
                    $cleaned_kunci_jawaban = str_replace(['[', ']', ' '], '', $soal->kunci_jawaban);

                    $correct_answers = explode(',', $cleaned_kunci_jawaban); // Assuming answers are stored comma-separated

                    sort($jawaban);
                    sort($correct_answers);

                    $jawaban = array_map(function ($item) {
                        return trim($item, '"');
                    }, $jawaban);

                    $correct_answers = array_map(function ($item) {
                        return trim($item, '"');
                    }, $correct_answers);

                    if ($jawaban == $correct_answers) {
                        $benar++;
                    } else {
                        $salah++;
                    }
                }
            } elseif ($soal->jenis_soal == 'menjodohkan') {
                if (empty($menjodohkan[$nomor])) {
                    $kosong++;
                } else {
                    $jawaban = $menjodohkan[$nomor];

                    // Jawaban siswa adalah array: [kiri => jawaban siswa]
                    // Kunci benar adalah JSON dari $soal->pencocokan
                    $correct_pairs = json_decode($soal->pencocokan, true);
                    $is_correct = true;

                    foreach ($correct_pairs as $kiri => $kanan) {
                        // Cek apakah jawaban siswa untuk $kiri sama dengan kunci
                        if (!isset($jawaban[$kiri]) || trim($jawaban[$kiri]) !== trim($kanan)) {
                            $is_correct = false;
                            break;
                        }
                    }

                    if ($is_correct) {
                        $benar++;
                    } else {
                        $salah++;
                    }
                }
            }
        }

        $score = 100 / $jumlah * $benar;

        $text = 'Score: ' . $score . ', Benar: ' . $benar . ', Salah: ' . $salah . ', Kosong: ' . $kosong;

        if ($score >= 75) {
            Alert::success('Baik', $text);
        }

        if ($score <= 74.9 && $score >= 50) {
            Alert::warning('Cukup', $text);
        }

        if ($score <= 49.5) {
            Alert::error('Tidak Lulus', $text);
        }

        return redirect()->back();
    }


    public function kirimtugas()
    {
        $user = auth()->user();

        // Ambil tugas yang sesuai kelas dan mata pelajaran
        $tugas = Tugas::where('kelas_id', $kelasId)->latest()->get();

        return view('kirimtugas', [
            'menuActive' => 'kirim-tugas',
            'tugas' => $tugas,
        ]);
    }

    public function kirimtugasForm($id)
    {
        return view('kirimtugas-submit', [
            'menuActive' => 'kirim-tugas',
            'tugas' => Tugas::find($id),
        ]);
    }

    public function kirimtugasSubmit(Request $request, $id)
    {
        $file = $request->file('file');
        $namaFile = time() . '_' . preg_replace('/\s+/', '_', $file->getClientOriginalName());

        $file->storeAs('jawaban/file', $namaFile, 'public');

        Jawaban::create([
            'tugas_id' => $id,
            'nama' => $request->nama,
            'no_induk' => $request->no_induk,
            'file_jawab' => $namaFile,
            'user_id' => auth()->id()
        ]);

        Alert::success('Berhasil', ucwords('Submit tugas Anda telah berhasil'));

        return redirect('kirimtugas');
    }

    public function forum()
    {
        return view('forum', [
            'menuActive' => 'forum',
            'forums' => Forum::withCount('replies')->latest()->get(),
        ]);
    }

    public function forumDetail($id)
    {
        return view('forum-detail', [
            'menuActive' => 'forum',
            'forum' => Forum::find($id),
        ]);
    }

    public function forumReply(Request $request, $id)
    {
        $request->validate([
            'konten' => 'required|string',
        ]);

        ForumReply::create([
            'forum_id' => $id,
            'user_id' => auth()->id(),
            'konten' => $request->konten,
        ]);

        Alert::success('Berhasil', ucwords('Balasan berhasil dikirim'));

        return redirect()->back();
    }


    public function riwayatSubmit()
    {

        $jawabans = Jawaban::where('user_id', auth()->id())->with('tugas', 'review', 'tugas.matapelajaran')->get();
        return view('riwayat', compact('jawabans'));
    }

    public function mulaiKuis($mapel_id, $tipe)
    {
        session([
            'kuis_matapelajaran_id' => $mapel_id,
            'kuis_jenis_ujian' => $tipe,
        ]);
        return redirect()->route('kuis.soal.show', ['nomor' => 1]);
    }
    public function selesai()
    {
        // Ambil data jawaban dari session
        $jawaban = session('jawaban_soal', []);

        // Ambil info soal untuk menampilkan jumlah soal
        $matapelajaran_id = session('kuis_matapelajaran_id');
        $jenis_ujian = session('kuis_jenis_ujian');
        $query = Soal::orderBy('id');
        if ($matapelajaran_id) {
            $query->where('matapelajaran_id', $matapelajaran_id);
        }
        if ($jenis_ujian) {
            $query->where('jenis_ujian', $jenis_ujian);
        }
        $soals = $query->get();
        $totalSoal = $soals->count();

        // Nomor lebih dari total soal supaya view menampilkan halaman selesai
        $nomor = $totalSoal + 1;

        return view('latihansoal', [
            'soal' => null,
            'nomor' => $nomor,
            'totalSoal' => $totalSoal,
            'jawaban' => $jawaban,
            'timer' => 0, // Tidak perlu timer di halaman selesai
        ]);
    }


    public function showSoal($nomor, Request $request)
    {
        $matapelajaran_id = session('kuis_matapelajaran_id');
        $jenis_ujian = session('kuis_jenis_ujian');

        $query = Soal::orderBy('id');
        if ($matapelajaran_id) {
            $query->where('matapelajaran_id', $matapelajaran_id);
        }
        if ($jenis_ujian) {
            $query->where('jenis_ujian', $jenis_ujian);
        }

        $soals = $query->get();
        $total = $soals->count();

        if ($nomor < 1 || $nomor > $total) {
            return redirect()->route('kuis.soal.show', ['nomor' => 1]);
        }

        $soal = $soals[$nomor - 1];
        $id_soal = $soal->id;

        // Ambil jawaban dari session jika sudah ada
        $jawaban_session = session('jawaban_soal', []);
        $jawaban = $jawaban_session[$id_soal] ?? null;

        return view('latihansoal', [
            'soal' => $soal,
            'nomor' => $nomor,
            'totalSoal' => $total,
            'jawaban' => $jawaban,
            'timer' => 90, // Atur timer sesuai kebutuhan
        ]);
    }


    protected function hitungNilai($soals, $jawaban)
    {
        $benar = 0;
        $total = $soals->count();

        foreach ($soals as $soal) {
            $id = $soal->id;

            if (!isset($jawaban[$id])) {
                \Log::info("Soal ID $id - Jawaban Siswa:", ['jawaban' => $jawaban[$id]]);
                \Log::info("Soal ID $id - Kunci Jawaban:", ['kunci' => $soal->kunci_jawaban]);
                // Jawaban tidak ada, anggap salah
                continue;
            }

            switch ($soal->jenis_soal) {
                case 'pilihan_ganda':
                    // Bandingkan jawaban siswa dengan kunci jawaban (string)
                    if ($jawaban[$id] == $soal->kunci_jawaban) {
                        $benar++;
                    }
                    break;

                case 'pilihan_ganda_kompleks':
                    // Kunci jawaban disimpan sebagai JSON array
                    $kunci = is_array($soal->kunci_jawaban) ? $soal->kunci_jawaban : json_decode($soal->kunci_jawaban, true);
                    // Jawaban siswa bisa array atau JSON string
                    $pilihanUser = is_array($jawaban[$id]) ? $jawaban[$id] : json_decode($jawaban[$id], true);

                    if (is_array($kunci) && is_array($pilihanUser)) {
                        // Sort agar urutan tidak mempengaruhi perbandingan
                        sort($kunci);
                        sort($pilihanUser);
                        if ($kunci == $pilihanUser) {
                            $benar++;
                        }
                    }
                    break;

                case 'uraian_singkat':
                    // Bandingkan tanpa case sensitive dan trim spasi
                    if (strcasecmp(trim($jawaban[$id]), trim($soal->kunci_jawaban)) == 0) {
                        $benar++;
                    }
                    break;

                case 'menjodohkan':
                    // Kunci jawaban dan jawaban siswa disimpan sebagai array asosiatif
                    $kunci = is_array($soal->kunci_jawaban) ? $soal->kunci_jawaban : json_decode($soal->kunci_jawaban, true);
                    $pilihanUser = is_array($jawaban[$id]) ? $jawaban[$id] : json_decode($jawaban[$id], true);

                    if (is_array($kunci) && is_array($pilihanUser)) {
                        // Cek jumlah pasangan sama
                        if (count($kunci) == count($pilihanUser)) {
                            $cocok = true;
                            foreach ($kunci as $k => $v) {
                                // Pastikan setiap pasangan cocok
                                if (!isset($pilihanUser[$k]) || $pilihanUser[$k] != $v) {
                                    $cocok = false;
                                    break;
                                }
                            }
                            if ($cocok) {
                                $benar++;
                            }
                        }
                    }
                    break;

                default:
                    // Soal jenis lain dianggap salah
                    break;
            }
        }

        // Hitung nilai dalam persen
        $nilai = ($total > 0) ? round(($benar / $total) * 100) : 0;

        return [
            'benar' => $benar,
            'total' => $total,
            'nilai' => $nilai,
        ];
    }

    public function submitSoal(Request $request, $nomor)
    {
        $matapelajaran_id = session('kuis_matapelajaran_id');
        $jenis_ujian = session('kuis_jenis_ujian');

        $query = Soal::orderBy('id');
        if ($matapelajaran_id) {
            $query->where('matapelajaran_id', $matapelajaran_id);
        }
        if ($jenis_ujian) {
            $query->where('jenis_ujian', $jenis_ujian);
        }
        $soals = $query->get();
        $total = $soals->count();

        if ($nomor < 1 || $nomor > $total) {
            return redirect()->route('kuis.soal.show', ['nomor' => 1]);
        }

        $soal = $soals[$nomor - 1];
        $id_soal = $soal->id;

        // Ambil session jawaban
        $jawaban_session = session('jawaban_soal', []);

        // Simpan jawaban sesuai tipe soal
        if ($soal->jenis_soal == 'pilihan_ganda' || $soal->jenis_soal == 'uraian_singkat') {
            $jawaban_session[$id_soal] = $request->input('jawaban');
        } elseif ($soal->jenis_soal == 'pilihan_ganda_kompleks' || $soal->jenis_soal == 'menjodohkan') {
            $jawaban_session[$id_soal] = $request->input('jawaban', []);
        }

        session(['jawaban_soal' => $jawaban_session]);

        // Navigasi
        if ($request->has('next')) {
            if ($nomor < $total) {
                return redirect()->route('kuis.soal.show', ['nomor' => $nomor + 1]);
            } else {
                // Soal terakhir, simpan hasil ujian terlebih dahulu
                return $this->simpanHasilUjian();
            }
        }

        if ($request->has('prev')) {
            if ($nomor > 1) {
                return redirect()->route('kuis.soal.show', ['nomor' => $nomor - 1]);
            }
        }

        // Default redirect ke soal sekarang
        return redirect()->route('kuis.soal.show', ['nomor' => $nomor]);
    }


    public function simpanHasilUjian()
    {
        $user_id = auth()->id();
        $matapelajaran_id = session('kuis_matapelajaran_id');
        $jenis_ujian = session('kuis_jenis_ujian');
        $jawaban = session('jawaban_soal', []);

        if (empty($jawaban)) {
            return redirect()->back()->with('error', 'Tidak ada jawaban yang disubmit.');
        }

        $soals = Soal::where('matapelajaran_id', $matapelajaran_id)
            ->where('jenis_ujian', $jenis_ujian)
            ->get();

        // Gunakan method hitungNilai untuk perhitungan benar dan nilai
        $hasil = $this->hitungNilai($soals, $jawaban);

        HasilUjian::updateOrCreate(
            [
                'user_id' => $user_id,
                'matapelajaran_id' => $matapelajaran_id,
                'jenis_ujian' => $jenis_ujian,
            ],
            [
                'jumlah_soal' => $hasil['total'],
                'jawaban_benar' => $hasil['benar'],
                'nilai' => $hasil['nilai'],
                'tanggal_ujian' => now(),
            ]
        );

        // Hapus session jawaban setelah submit
        session()->forget('jawaban_soal');
        session()->forget('kuis_matapelajaran_id');
        session()->forget('kuis_jenis_ujian');

        return redirect()->route('kuis.selesai')->with('success', 'Hasil ujian berhasil disimpan.');
    }


    public function changePassword()
    {
        $menuActive = 'Change Password';
        return view('change-password', compact('menuActive'));
    }

    public function changePasswordPost(Request $request)
    {
        $validated = $request->validate(
            [
                'password' => 'required|min:6|confirmed'
            ]
        );

        Auth::user()->update(
            [
                'password' => Hash::make($validated['password'])
            ]
        );

        Alert::success('berhasil mengganti password');

        return redirect()->back()->with('success', 'berhasil mengganti password');
    }
}
