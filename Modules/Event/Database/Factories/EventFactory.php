<?php

namespace Modules\Event\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Event\Entities\Event;
use Modules\Venue\Entities\Venue;

class EventFactory extends Factory
{
    protected $model = Event::class;

    public function definition()
    {
        return [
            'name'                  => $this->faker->sentence(3),
            'venue_id'              => Venue::factory(),
            'ticket_sales_end_date' => $this->faker->dateTimeBetween('now', '+1 month'),
        ];
    }
}