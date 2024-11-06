<?php

namespace Modules\Payment\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Payment\Entities\Purchase;
use Modules\Event\Entities\Event;

class PurchaseFactory extends Factory
{
    protected $model = Purchase::class;

    public function definition()
    {
        return [
            'event_id'       => Event::factory(),
            'email'          => $this->faker->unique()->safeEmail,
            'transaction_id' => $this->faker->uuid,
        ];
    }
}