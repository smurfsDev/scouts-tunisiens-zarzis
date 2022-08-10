<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Event;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Workshop>
 */
class WorkshopFactory extends Factory
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
            "description" => $this->faker->sentence(),
            "heure_debut" => $this->faker->datetimeBetween('-1 days', 'now'),
            "heure_fin" => $this->faker->datetimeBetween('-1 days', 'now'),
            "organisateur_id" => User::get('id')->random(),
            "leader_id" => User::get('id')->random(),
            "event_id" => Event::get('id')->random(),
            "status" => 0
        ];
    }
}
