<?php

namespace Database\Seeders;

use App\Models\Item;
use App\Models\ItemDailyReport;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ItemDailyReportSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $start_date = Carbon::createFromDate(2022, 4, 1);
        for ($start_date; $start_date->toDateString() <= now()->toDateString(); $start_date->addDay()) {
            $date = $start_date->toDateString();
            foreach (Item::where('type', 'item')->get() as $item) {
                ItemDailyReport::factory()->create(
                    [
                        'entry_date' => $date,
                        'item_id' => $item->id
                    ]
                );
            }
        }
    }
}
