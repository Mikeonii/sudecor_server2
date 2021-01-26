<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
// use Faker\Factory as Faker;
use App\Models\Attendance;

class AttendanceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
   		// factory(Attendance::class,10)->create();
   		\App\Models\Attendance::factory()->count(100)->create();
    }
}
