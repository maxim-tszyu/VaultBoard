<?php

use App\Enums\Priority;
use App\Enums\Status;
use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(Task::class, 'parent_task_id')->nullable()->constrained()->cascadeOnDelete();
            $table->string('title');
            $table->vector('embedding', 64)->nullable();
            $table->text('description')->nullable();
            $table->datetime('due_date');
            $table->datetime('started_at')->nullable();
            $table->datetime('completed_at')->nullable();
            $table->datetime('aborted_at')->nullable();
            $table->enum('status', Status::values());
            $table->enum('priority', Priority::values());
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
