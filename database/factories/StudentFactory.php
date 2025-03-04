<?php

namespace Database\Factories;

use App\Models\Agama;
use App\Models\Major;
use App\Models\Classe;
use App\Models\Student;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Student>
 */
class StudentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Student::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'nisn' => $this->faker->unique()->numerify('##########'),
            'gender' => $this->faker->randomElement(['L', 'P']),
            'student_photo' => 'students/no_image.jpg',
            'class_id' => Classe::factory(),
            'major_id' => Major::factory(),
            'agama_id' => Agama::inRandomOrder()->first()->id,
            // 'agama_id' => Agama::factory(),
            'address' => $this->faker->address(),
            'phone' => $this->faker->phoneNumber(),
            'birth_date' => $this->faker->date('Y-m-d'),
            'created_at' => now(),
        ];
    }
}
