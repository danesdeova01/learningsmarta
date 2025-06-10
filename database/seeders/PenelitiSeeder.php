<?php

namespace Database\Seeders;

use App\Models\Peneliti;
use Illuminate\Database\Seeder;

class PenelitiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Peneliti::create([
            'nim'         => 'djardev',
            'nama'        => 'djardev',
            'dospem'      => 'djardev',
            'ahli_materi' => 'djardev',
            'ahli_media'  => 'djardev',
        ]);
    }
}
