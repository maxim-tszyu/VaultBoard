<?php

namespace App\Jobs;

use App\Enums\Expense;
use App\Models\Finance;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class CreateExpenseJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public int $userid,
        public string $category,
        public string $comment,
        public float $sum
    ) {
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Finance::create([
            'user_id' => $this->userid,
            'type' => Expense::INCOME,
            'amount' => $this->sum,
            'title' => "Category:$this->category",
            'content' => $this->comment
        ]);
    }
}
