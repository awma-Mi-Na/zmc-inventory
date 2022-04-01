<?php

namespace Database\Seeders;

use App\Models\Item;
use App\Models\OxygenTankReport;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OxygenTankReportSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $start_date = Carbon::createFromDate(2022, 3, 1);
        $no_days = 30;
        for ($i = 0; $i < $no_days; $i++) {
            $date = $start_date->toDateString();
            foreach (Item::where('type', 'oxygen_tank')->get() as $oxygen_tank) {
                OxygenTankReport::factory()->create([
                    'entry_date' => $date,
                    'item_id' => $oxygen_tank->id
                ]);
            }
            $start_date->addDay();
        }
    }
}
