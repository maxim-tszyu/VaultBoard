<?php

use App\Models\Category;
use App\Models\Task;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('category_task', function (Blueprint $table) {
            $table->foreignIdFor(Category::class)->constrained('categories')->cascadeOnDelete();
            $table->foreignIdFor(Task::class)->constrained('tasks')->cascadeOnDelete();
            $table->primary(['category_id', 'task_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('category_task');
    }
};
