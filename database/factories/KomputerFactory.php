<?php

namespace Database\Factories;

use App\Models\Model;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Model>
 */
class KomputerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        $namaKomputer = ['Komputer 1', 'Komputer 2', 'Komputer 3', 'Komputer 4', 'Komputer 5', 'Komputer 6', 'Komputer 7', 'Komputer 8'];    
    
        return [
            'nama_komputer'     =>  fake()->unique()->randomElement($namaKomputer),
            'id_laboratorium'       =>  null,
        ];
    }
}