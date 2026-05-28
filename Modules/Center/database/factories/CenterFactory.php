<?php

namespace Modules\Center\database\factories;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class CenterFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = \Modules\Center\Models\Center::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'code'              => $this->faker->unique()->bothify('CTR-###'),
            'name'              => $this->faker->unique()->words(2, true),
            'mobile'            => $this->faker->phoneNumber,
            'email'             => $this->faker->safeEmail,
            'address'           => $this->faker->address,
            'city'              => $this->faker->city,
            'gst_no'            => $this->faker->bothify('??######'),
            'status'            => 1,
            'created_at'        => Carbon::now(),
            'updated_at'        => Carbon::now(),
        ];
    }
}
