<?php

namespace Database\Factories;


use App\Models\Screening;
use Illuminate\Database\Eloquent\Factories\Factory;

class ScreeningFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Screening::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'theatre_id'=>\App\Models\Theatre::factory(),
            'movie_id'=>\App\Models\Movie::factory(),
            'datetime'=>$this->dateTimeBetween('+0 days', '+1 month'),
        ];
    }
}
