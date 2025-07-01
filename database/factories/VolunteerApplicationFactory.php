<?php

namespace Database\Factories;

use App\Models\VolunteerApplication;
use App\Models\Volunteer;
use Illuminate\Database\Eloquent\Factories\Factory;

class VolunteerApplicationFactory extends Factory
{
    protected $model = VolunteerApplication::class;

    public function definition(): array
    {
        return [
            'volunteer_id' => Volunteer::factory(),
            'why_volunteer' => $this->faker->sentence(10),
            'interested_programs' => $this->faker->words(2, true),
            'skills_experience' => $this->faker->words(3, true),
            'availability' => $this->faker->randomElement(['Weekdays', 'Weekends', 'Evenings']),
            'commitment_hours' => $this->faker->numberBetween(1, 20),
            'physical_limitations' => $this->faker->optional()->sentence(5),
            'emergency_contact' => $this->faker->name . ', ' . $this->faker->phoneNumber,
            'contact_consent' => $this->faker->randomElement(['yes', 'no']),
            'volunteered_before' => $this->faker->randomElement(['yes', 'no']),
            'outdoor_ok' => $this->faker->randomElement(['yes', 'no', 'depends']),
            'short_bio' => $this->faker->paragraph(2),
            'is_active' => $this->faker->boolean(),
            'submitted_at' => $this->faker->dateTimeThisYear(),
        ];
    }
} 