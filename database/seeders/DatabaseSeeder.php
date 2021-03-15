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
    	// Create 5 Movies
        $movies = \App\Models\Movie::factory(5)->create();

        // Create Screenings for 3 of the Movies
		\App\Models\Screening::factory(3)->movie($movies[0])->create();
		\App\Models\Screening::factory(3)->movie($movies[1])->create();
		\App\Models\Screening::factory(3)->movie($movies[2])->create();
    }
}
