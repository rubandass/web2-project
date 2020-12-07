<?php

use Illuminate\Database\Seeder;

class ActivitiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('activities')->insert([
            ['name' => 'Yoga', 'user_id' => 1],
            ['name' => 'Run', 'user_id' => 1],
            ['name' => 'Surf-ocean view', 'user_id' => 1]
        ]);
    }
}
