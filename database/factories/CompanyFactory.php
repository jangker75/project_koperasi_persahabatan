<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Company>
 */
class CompanyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => 'Koperasi Karya Husada',
            'address' => 'Rawamangun',
            'phone' => '0857123232',
            'description' => 'Koperasi Karya Husada di RS Persahabatan Rawaamangun',
        ];
    }
}
