<?php

namespace Modules\Trainer\database\factories;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class TrainerFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = \Modules\Trainer\Models\Trainer::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name'              => $this->faker->name(),
            'email'             => $this->faker->unique()->safeEmail(),
            'email_verified_at' => Carbon::now(),
            'password'          => 'trainer',
            'mobile'            => $this->faker->numerify('9#########'),
            'gender'            => $this->faker->randomElement(['male', 'female', 'other']),
            'date_of_birth'     => $this->faker->date('Y-m-d', '-25 years'),
            'address'           => $this->faker->address(),
            'specialization'    => $this->faker->randomElement(['Wellness Coaching', 'Fitness Training', 'Nutrition Coaching']),
            'qualification'     => $this->faker->randomElement(['Certified Trainer', 'Diploma in Fitness', 'Wellness Coach']),
            'experience_years'  => $this->faker->numberBetween(1, 15),
            'bio'               => $this->faker->paragraph(),
            'status'            => 1,
            'created_at'        => Carbon::now(),
            'updated_at'        => Carbon::now(),
        ];
    }
}
