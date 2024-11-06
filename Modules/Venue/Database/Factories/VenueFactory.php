<?php

namespace Modules\Venue\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Venue\Entities\Venue;

class VenueFactory extends Factory
{
    protected $model = Venue::class;

    public function definition()
    {
        return [
            'name'     => $this->faker->company . ' ' . $this->faker->word,
            'capacity' => $this->faker->numberBetween(50, 500),
        ];
    }
}