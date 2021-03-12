<?php

namespace Database\Factories;

use App\Models\Booking;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class BookingFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Booking::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => \App\Models\User::factory(),
            'screening_id' => \App\Models\Screening::factory(),
            'reference'=> Str::random(8),
            'seats'=> rand(1, 8),
        ];
    }

    /**
     * Create a Screening that is in the past
     *
     * @return BookingFactory
     */
    public function past()
    {
        return $this->state(function (array $attributes)  {
            return [
                'screening_id' => \App\Models\Screening::factory()->past(),
            ];
        });
    }


    /**
     * Create a Screening assigned to a User
     *
     * @param $user
     * @return BookingFactory
     */
    public function user($user)
    {
        return $this->state(function (array $attributes) use($user)  {
            return [
                'user_id' => $user->id,
            ];
        });
    }

    /**
     * Specify the datetime for the Screening
     *
     * @param $datetime
     * @return BookingFactory
     */
    public function dateTime($datetime)
    {
        return $this->state(function (array $attributes) use($datetime)  {
            return [
                'screening_id' => \App\Models\Screening::factory()->dateTime($datetime),
            ];
        });
    }
}
