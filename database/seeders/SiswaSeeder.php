<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class SiswaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        User::create([
            'name' => 'Indah',
            'email' => 'indah@gmail.com',
            'password' => Hash::make('123456'),
            'level' => 'mahasiswa',
            'kelas_id' => 1
        ]);
    }
}
