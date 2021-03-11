<?php

namespace Database\Factories;


use App\Models\Screening;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

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
            'datetime'=>$this->faker->dateTimeBetween('+0 days', '+1 month'),
        ];
    }

    public function randomTime($past=false) {
        if ($past===true) {
            $time = Carbon::parse($this->faker->dateTimeBetween('-1 month', '-1 day'));
        } else {
            $time = Carbon::parse($this->faker->dateTimeBetween('+1 days', '+1 month'));
        }

        $time->minute = 0;
        $time->second = 0;
        if ($time->hour<10) $time->hour = 10;
        elseif ($time->hour>22) $time->hour = 22;

        return $time->format('Y-m-d H:i:s');
    }

    public function past()
    {
        return $this->state(function (array $attributes) {
            return [
                //'datetime'=>Carbon::parse($this->faker->dateTimeBetween('-1 month', '-1 day'))->format('Y-m-d H:i'),
                'datetime'=>$this->randomTime(true),
            ];
        });
    }

    public function movie($movieId)
    {
        return $this->state(function (array $attributes) use($movieId) {
            return [
                'movie_id'=>$movieId,
            ];
        });
    }

    public function dateTime($datetime)
    {
        return $this->state(function (array $attributes) use($datetime)  {
            return [
                'datetime' => $datetime,
            ];
        });
    }
}
