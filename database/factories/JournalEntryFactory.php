<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\JournalEntry;
use App\Models\Journal;;

use App\Models\Coa;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\JournalEntry>
 */
class JournalEntryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = JournalEntry::class;
    public function definition(): array
    {
        return [
            'journal_id' => Journal::inRandomOrder()->first()->id ?? 1,
            'coa_id' => Coa::inRandomOrder()->first()->id ?? 1,
            'debit' => $this->faker->randomFloat(2, 0, 1000000),
            'credit' => $this->faker->randomFloat(2, 0, 1000000),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
