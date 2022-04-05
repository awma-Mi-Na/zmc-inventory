<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $actions = ['daily', 'bed', 'oxygen', 'kit'];
        foreach ($actions as $key => $action) {
            User::factory()->create([
                'username' => "user" . (int)$key + 1,
                'actions' => $action
            ]);
        }
    }
}
