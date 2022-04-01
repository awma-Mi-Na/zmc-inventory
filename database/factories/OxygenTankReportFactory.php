<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\OxygenTankReport>
 */
class OxygenTankReportFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'full' => rand(50, 200),
            'empty' => rand(30, 70),
            'in_use' => rand(25, 60)
        ];
    }
}
