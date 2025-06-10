<?php

namespace Database\Seeders;

use App\Models\Kelas;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {



        // Seed kelas table with class options from A to K
        $kelasOptions = range('A', 'K');

        foreach ($kelasOptions as $kelasOption) {
            Kelas::create([
                'nama' => $kelasOption,
                'slug' => Str::slug($kelasOption), // Ensures a consistent, lowercase slug
            ]);
        }

        $this->call([AdminSeeder::class, MataPelajaranSeeder::class, PenelitiSeeder::class, TopikSeeder::class, SoalSeeder::class, SiswaSeeder::class]);
    }
}
