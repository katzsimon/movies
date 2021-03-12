<?php

namespace Database\Factories;

use App\Models\Theatre;
use Illuminate\Database\Eloquent\Factories\Factory;

class TheatreFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Theatre::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'cinema_id' => \App\Models\Cinema::factory(),
            'name' => 'Theatre '.rand(1, 20),
            'max_seats'=> rand(20, 30),
        ];
    }
}
