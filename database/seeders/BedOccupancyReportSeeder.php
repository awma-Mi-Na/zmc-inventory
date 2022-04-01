<?php

namespace Database\Seeders;

use App\Models\BedOccupancyReport;
use App\Models\Item;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BedOccupancyReportSeeder extends Seeder
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
            foreach (Item::where('type', 'ward')->get() as $item) {
                BedOccupancyReport::factory()->create(
                    [
                        'entry_date' => $date,
                        'item_id' => $item->id
                    ]
                );
            }
            $start_date->addDay();
        }
    }
}
