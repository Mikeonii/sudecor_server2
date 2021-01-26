<?php

namespace Database\Factories;

use App\Models\Attendance;
use Illuminate\Database\Eloquent\Factories\Factory;

class AttendanceFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Attendance::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'client_id'=> $this->faker->randomDigit(),
            'time_in'=> $this->faker->dateTimeBetween('now','+20 days'),
            'time_out'=>$this->faker->dateTimeBetween('now','+20 days'),
            'regular_hour'=> $this->faker->randomDigit(),
            'over_time'=> $this->faker->randomDigit(),
            'holiday'=> $this->faker->randomDigit(),
            'sunday'=> $this->faker->randomDigit()
        ];
    }
}
