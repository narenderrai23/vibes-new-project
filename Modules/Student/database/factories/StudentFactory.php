<?php

namespace Modules\Student\database\factories;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class StudentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = \Modules\Student\Models\Student::class;

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
            'password'          => 'student',
            'mobile'            => $this->faker->numerify('9#########'),
            'gender'            => $this->faker->randomElement(['male', 'female', 'other']),
            'date_of_birth'     => $this->faker->date('Y-m-d', '-18 years'),
            'address'           => $this->faker->address(),
            'enrollment_number' => $this->faker->unique()->bothify('STU######'),
            'course'            => $this->faker->randomElement(['Wellness Program', 'Fitness Program', 'Nutrition Program']),
            'batch'             => $this->faker->randomElement(['Batch A', 'Batch B', 'Batch C']),
            'status'            => 1,
            'created_at'        => Carbon::now(),
            'updated_at'        => Carbon::now(),
        ];
    }
}
