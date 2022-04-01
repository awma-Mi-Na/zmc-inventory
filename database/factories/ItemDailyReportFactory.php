<?php

namespace Database\Factories;

use App\Models\Item;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ItemDailyReport>
 */
class ItemDailyReportFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'entry_date' => $this->faker->dateTimeBetween('-30 days'),
            'item_id' => rand(Item::where('type', 'item')->orderBy('id', 'asc')->first('id')->id, Item::where('type', 'item')->orderBy('id', 'desc')->first('id')->id),
            'opening_balance' => rand(400, 1000),
            'received' => rand(100, 300),
            'issued' => rand(100, 300),
            'total' => rand(100, 300),
            'closing_balance' => rand(100, 300),
            'cumulative_stock' => rand(1000, 3000),
        ];
    }
}
