<?php

namespace Database\Seeders;

use App\Models\Komputer;
use App\Models\Laboratorium;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KomputerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $lab = Laboratorium::where(['id_laboratorium' => 1])->first();

        Komputer::factory(8)->create(['id_laboratorium' => $lab->id_laboratorium]);
    }
}