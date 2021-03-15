<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $movies = \App\Models\Movie::factory(5)->create();
		\App\Models\Screening::factory(3)->movie($movies[0])->create();
		\App\Models\Screening::factory(3)->movie($movies[1])->create();
		\App\Models\Screening::factory(3)->movie($movies[2])->create();
    }
}
