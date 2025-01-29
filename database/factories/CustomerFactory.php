<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\customer;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Customer>
 */
class CustomerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = customer::class;
    private static $idCounter = 1;

    public function definition(): array
    {
        $id = 'EST-' . str_pad(self::$idCounter++, 2, '0', STR_PAD_LEFT);
        return [
            'national_id' => $this->faker->unique()->numerify('##########'),
            'name' => $this->faker->name,
            'phone' => $this->faker->phoneNumber,
            'email' => $this->faker->unique()->safeEmail,
            'address' => $this->faker->address,
        ];
    }
}
