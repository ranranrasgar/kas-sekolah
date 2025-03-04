<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Journal;
use App\Models\JournalEntry;
use App\Models\Coa;
use App\Models\JournalCategory;

class SeedJournals extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:seed-journals {count=1000}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate journal transactions with corresponding journal entries';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $count = (int) $this->argument('count');
        $this->info("Seeding {$count} journal transactions...");

        $journals = Journal::factory()->count($count)->create();
        foreach ($journals as $journal) {
            // $coaAccounts = Coa::inRandomOrder()->limit(2)->pluck('id')->toArray();
            $coaAccounts = Coa::whereNotNull('parent_id')->inRandomOrder()->limit(2)->pluck('id')->toArray();

            $amount = fake()->randomFloat(2, 10000, 1000000); // Nominal transaksi acak

            JournalEntry::factory()->create([
                'journal_id' => $journal->id,
                'coa_id' => $coaAccounts[0],

                'debit' => $amount,
                'credit' => 0,
            ]);

            JournalEntry::factory()->create([
                'journal_id' => $journal->id,
                'coa_id' => $coaAccounts[1],

                'debit' => 0,
                'credit' => $amount,
            ]);
        }
        $this->info("✅ Successfully seeded {$count} journals with balanced entries.");
    }
}
