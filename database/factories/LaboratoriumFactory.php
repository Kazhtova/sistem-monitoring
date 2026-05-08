<?php

namespace Database\Factories;

use App\Models\Model;
use App\Models\Teknisi;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Model>
 */
class LaboratoriumFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        $namaLab = ['Lab 1', 'Lab 2', 'Lab 3'];    
    
        return [
            'nama_lab'          => fake()->randomElement($namaLab),
            'jumlah_komputer'   => fake()->numberBetween(1, 20),
            'id_teknisi'        => Teknisi::factory(),     
        ];
    }
}