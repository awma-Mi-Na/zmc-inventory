<?php

namespace Database\Seeders;

use App\Models\Item;
use App\Models\TestKitReport;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TestKitReportSeeder extends Seeder
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
            foreach (Item::where('type', 'test_kit')->get() as $test_kit) {
                TestKitReport::factory()->create([
                    'entry_date' => $date,
                    'item_id' => $test_kit->id
                ]);
            }
            $start_date->addDay();
        }
    }
}
