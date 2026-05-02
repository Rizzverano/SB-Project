<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class LegislativeRecordFactory extends Factory
{
    public function definition(): array
    {
        return [
            'session' => 'Session ' . $this->faker->numberBetween(1, 10),
            'date' => $this->faker->date(),
            'title' => $this->faker->randomElement(['LOCAL CHIEF EXECUTIVE HOUR', 'READING AND REFERRAL OF THE PROPOSED MEASURES', 'COMMITTEE REPORT', 'UNFINISHED BUSINESS', 'BUSINESS FOR THE DAY', 'UNASSIGNED BUSINESS', 'OTHER MATTERS']),
            'description' => $this->faker->paragraph(),
            'sponsor' => 'Hon. ' . $this->faker->name(),
            'action_taken' => $this->faker->randomElement([
                'Approved',
                'Marked as Noted',
                'Laid on Table',
                'NONE',
            ]),
        ];
    }
}
