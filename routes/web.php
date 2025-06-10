<?php

use App\Http\Controllers\Admin\MahasiswaController;
use App\Http\Controllers\WebController;
use App\Http\Controllers\SiswaKelasController;
use App\Http\Controllers\Admin\HasilUjianController;
use App\Http\Controllers\Admin\TopikController;
use App\Http\Controllers\Admin\MataPelajaranController;
use App\Http\Controllers\Admin\TugasController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Auth::routes([
    'register' => false,
    'reset' => false,
]);

Route::get('/', [WebController::class, 'index'])->name('welcome');

Route::middleware(['auth'])->group(function () {
    // Route umum user
    Route::get('/kirimtugas', [WebController::class, 'tugasPilihKelas'])->name('tugas.pilih.kelas');
    Route::get('/riwayat', [WebController::class, 'riwayatSubmit'])->name('riwayat');
    Route::get('/kirimtugas/kelas/{kelas}', [WebController::class, 'tugasPilihMapel'])->name('tugas.pilih.mapel');
    Route::get('/kirimtugas/kelas/{kelas}/mapel/{mapel}', [WebController::class, 'tugasDaftar'])->name('tugas.daftar');

    Route::get('/kirimtugas/submit/{id}', [WebController::class, 'kirimtugasForm']);
    Route::post('/kirimtugas/submit/{id}', [WebController::class, 'kirimtugasSubmit']);
    Route::get('/matapelajaran', [WebController::class, 'pilihKelas'])->name('matapelajaran.index');
    Route::get('/matapelajaran/kelas/{kelas}', [WebController::class, 'showMatapelajaran'])->name('matapelajaran.show');
    Route::get('/matapelajaran/materi/{matapelajaran}', [WebController::class, 'matpelDetail'])->name('matapelajaran.detail');
    Route::get('/topik/{id}', [WebController::class, 'topik'])->name('topik.detail');

    // Soal satu per halaman dengan prefix kuis/soal
    Route::get('/kuis/soal/{nomor}', [WebController::class, 'showSoal'])->name('kuis.soal.show');
Route::post('/kuis/soal/{nomor}', [WebController::class, 'submitSoal'])->name('kuis.soal.submit');
Route::get('/kuis/selesai', [WebController::class, 'selesai'])->name('kuis.selesai');


    Route::get('/kuis/soal', function () {
        return redirect()->route('kuis.soal.show', ['nomor' => 1]);
    })->name('kuis.soal.start');

    // Route tipe ujian
    Route::get('/kuis/before-kelas', [WebController::class, 'latihanSoalBefore']);
    Route::get('/kuis/before-kelas/pilih-tipe/{id}', [WebController::class, 'latihanSoalTipe'])->name('latihan.soal.tipe');
    Route::get('/kuis/mulai/{mapel_id}/{tipe}', [WebController::class, 'mulaiKuis'])->name('kuis.mulai');
    // Route halaman selesai ujian
    Route::get('/kuis/selesai', [WebController::class, 'selesai'])->name('kuis.selesai');


    Route::post('/kuis', [WebController::class, 'submitLatihan']);

    Route::get('/forum', [WebController::class, 'forum']);
    Route::get('/forum/{id}', [WebController::class, 'forumDetail']);
    Route::post('/forum/{id}', [WebController::class, 'forumReply']);
    

    // Route Download File Tugas
    Route::get('/download/tugas/{filename}', [TugasController::class, 'downloadTugas'])->name('tugas.download');
    Route::get('/download/jawaban/{filename}', [TugasController::class, 'downloadJawaban'])->name('jawaban.download');
    Route::get('/download/materi/{filename}', [WebController::class, 'downloadMateriFile'])->name('materi.download');

    // Route lain dalam middleware auth
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::get('/admin/setting', [App\Http\Controllers\SettingController::class, 'index']);
    Route::post('/admin/setting', [App\Http\Controllers\SettingController::class, 'update']);
    Route::get('/kelas', [SiswaKelasController::class, 'index'])->name('siswa.kelas.index');
    Route::get('/kelas/{id}', [SiswaKelasController::class, 'kelasShow'])->name('siswa.kelas.detail');


    Route::get('change-password', [WebController::class, "changePassword"])->name('siswa.change-password');
    Route::post('change-password', [WebController::class, "changePasswordPost"])->name('siswa.change-password.store');


});

Route::prefix('admin')->name('admin.')->middleware('auth')->group(function () {
    Route::resource('matapelajaran', MataPelajaranController::class)->except('show');
    Route::resource('topik', TopikController::class)->except('show');
    Route::resource('kuis', App\Http\Controllers\Admin\SoalController::class)->except('show');
    Route::resource('tugas', TugasController::class);
    Route::resource('forum', App\Http\Controllers\Admin\ForumController::class);
    Route::resource('kelas', App\Http\Controllers\Admin\KelasController::class);
    Route::resource('soal', App\Http\Controllers\Admin\SoalController::class);
    Route::resource('review', App\Http\Controllers\ReviewController::class);
    Route::resource('siswa', MahasiswaController::class)->names([
        'index' => 'mahasiswa.index',
        'create' => 'mahasiswa.create',
        'store' => 'mahasiswa.store',
        'show' => 'mahasiswa.show',
        'edit' => 'mahasiswa.edit',
        'update' => 'mahasiswa.update',
        'destroy' => 'mahasiswa.destroy',
    ]);
    Route::put('siswa/update-kelas/{id}', [MahasiswaController::class, 'updateKelas'])->name('mahasiswa.updateKelas');
    Route::post('siswa/add-kelas/{id}', [MahasiswaController::class, 'addKelas'])->name('mahasiswa.addKelas.store');
    Route::get('siswa/{id}/add-kelas', [MahasiswaController::class, 'addKelasForm'])->name('mahasiswa.addKelas');
    Route::get('siswa/{id}/edit-kelas', [MahasiswaController::class, 'editKelasForm'])->name('mahasiswa.editKelas');
    Route::get('/hasil-ujian', [HasilUjianController::class, 'index'])->name('hasil_ujian.index');
    Route::delete('/hasil-ujian/{id}', [HasilUjianController::class, 'destroy'])->name('hasil_ujian.destroy');

    // Update Timer
    Route::post('/jenis-ujian/update', [App\Http\Controllers\Admin\SoalController::class, 'updateJenisUjianTimer']);
});
