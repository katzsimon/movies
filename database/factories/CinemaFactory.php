<?php

namespace Database\Factories;

use App\Models\Cinema;
use Illuminate\Database\Eloquent\Factories\Factory;

class CinemaFactory extends Factory
{

    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Cinema::class;

    protected $locations = array(
        'Cape Town', 'Johannesburg', 'Pretoria', 'Durban'
    );

    protected $names = array(
        'Waterfront', 'Century City', 'Bayside', 'Fourways', 'Sandton', 'Rosebank', 'South Gate', 'Boardwalk', 'Gateway'
    );


    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->names[array_rand($this->names)],
            'location' => $this->locations[array_rand($this->locations)],
        ];
    }
}
