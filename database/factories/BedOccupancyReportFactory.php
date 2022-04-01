<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\BedOccupancyReport>
 */
class BedOccupancyReportFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'on_ventilator_invasive' => rand(1, 8),
            'on_ventilator_niv' => rand(5, 10),
            'on_oxygen' => rand(8, 15),
            'empty' => rand(5, 10),
            'positive_attendants' => rand(1, 10),
            'attendants' => rand(10, 25),
            'patients' => rand(15, 45),
            'total' => rand(20, 50),
        ];
    }
}
