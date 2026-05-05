<?php

namespace Database\Factories;

use App\Models\Teknisi;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Permission\Traits\HasRoles;

/**
 * @extends Factory<Teknisi>
 */
class TeknisiFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nama_teknisi'  =>  fake()->name(),
        ];
    }
}