<?php

namespace Database\Seeders;

use App\Models\Materi;
use App\Models\Soal;
use Illuminate\Database\Seeder;

class SoalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $materi = Materi::first();

        // Cek kalau materi ada
        if (!$materi) {
            $this->command->error('Tidak ada materi ditemukan. Seeder Soal dibatalkan.');
            return;
        }




        Soal::create([
            'materi_id'     => $materi->id,
            'pertanyaan'    => 'Di bawah ini yang termasuk majas perbandingan?',
            'pilihan_a'     => 'Ironi',
            'pilihan_b'     => 'Repetisi',
            'pilihan_c'     => 'Sinisme',
            'pilihan_d'     => 'Metafora',
            'pilihan_e'     => 'Sarkasme',
            'kunci_jawaban' => 'a',
        ]);

        Soal::create([
            'materi_id'     => $materi->id,
            'pertanyaan'    => 'Di bawah ini yang bukan termasuk majas perbandingan?',
            'pilihan_a'     => 'Alegori',
            'pilihan_b'     => 'Metafora',
            'pilihan_c'     => 'Litotes',
            'pilihan_d'     => 'Pleonasme',
            'pilihan_e'     => 'Hiperbola',
            'kunci_jawaban' => 'd',
        ]);

        Soal::create([
            'materi_id'     => $materi->id,
            'pertanyaan'    => 'Sistem persamaan linear berkembang di Eropa bersamaan dengan dikenalkannya konsep koordinat dalam geometri, oleh René Descartes pada tahun?',
            'pilihan_a'     => '1633',
            'pilihan_b'     => '1634',
            'pilihan_c'     => '1635',
            'pilihan_d'     => '1636',
            'pilihan_e'     => '1637',
            'kunci_jawaban' => 'e',
        ]);

        Soal::create([
            'materi_id'     => $materi->id,
            'pertanyaan'    => 'kata, frasa, atau imbuhan yang muncul bersamaan dengan noun atau noun phrase?',
            'pilihan_a'     => 'Noun',
            'pilihan_b'     => 'Determiner',
            'pilihan_c'     => 'Tense',
            'pilihan_d'     => 'Verb',
            'pilihan_e'     => 'Article',
            'kunci_jawaban' => 'b',
        ]);
    }
}
