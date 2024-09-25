<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Car>
 */
class CarFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'brand' => fake()->randomElement(['Honda', 'Toyota', 'Suzuki', 'Nissan', 'Mitsubishi', 'BMW']),
            'model' => fake()->randomElement(['City', 'Corolla', 'Civic', 'Accord', 'Camry', 'X5']),
            'license_plate' => $this->generateCustomString(),
            'rates' => fake()->numberBetween(100000, 500000),
            'status' => fake()->randomElement(['Available', 'Not Available']),
        ];
    }

    private function generateCustomString(): string
    {
        $firstPart = strtoupper($this->faker->lexify('??'));
        $secondPart = $this->faker->numerify('####');
        $thirdPart = strtoupper($this->faker->lexify('???'));

        return "{$firstPart} {$secondPart} {$thirdPart}";
    }
}
