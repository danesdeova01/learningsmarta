<?php

namespace Database\Seeders;

use App\Models\MataPelajaran;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class MataPelajaranSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        MataPelajaran::create([
            'nama' => 'Matematika',
            'slug' => Str::slug('Matematika'),
        ]);

        MataPelajaran::create([
            'nama' => 'Bahasa Indonesia',
            'slug' => Str::slug('Bahasa Indonesia'),
        ]);

        MataPelajaran::create([
            'nama' => 'Bahasa Inggris',
            'slug' => Str::slug('Bahasa Inggris'),
        ]);
    }
}
