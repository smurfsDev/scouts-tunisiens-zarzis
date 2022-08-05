<?php

namespace Database\Factories;

use App\Models\Troupe;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Event>
 */
class EventFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            "name" => $this->faker->word(),
            "date_debut" => $this->faker->dateTimeBetween('-3 days', 'now'),
            "date_fin" => $this->faker->dateTimeBetween('now', '+3 days'),
            "troupe_id" => Troupe::get('id')->random(),
            "type" => rand(0,1),
        ];
    }
}
