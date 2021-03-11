<?php

namespace Database\Seeders;

use App\Models\Cinema;
use App\Models\Theatre;
use Illuminate\Database\Seeder;

class TheatreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        Theatre::factory()->count(5)->create();
    }
}
