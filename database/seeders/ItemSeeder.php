<?php

namespace Database\Seeders;

use App\Models\Item;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Item::factory(50)->create(['type' => 'item']);
        Item::factory(3)->create(['type' => 'oxygen_tank']);
        Item::factory(3)->create(['type' => 'test_kit']);
        Item::factory(3)->create(['type' => 'ward']);
    }
}
