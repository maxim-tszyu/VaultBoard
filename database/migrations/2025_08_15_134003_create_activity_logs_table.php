<?php

use App\Models\Task;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
	/**
	 * Run the migrations.
	 */
	public function up(): void
	{
		Schema::create('activity_logs', function (Blueprint $table) {
			$table->id();
			$table->foreignIdFor(Task::class)->constrained()->cascadeOnDelete();
			$table->datetime('started_at');
			$table->datetime('ended_at');
			$table->string('title');
			$table->text('content');
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 */
	public function down(): void
	{
		Schema::dropIfExists('activity_logs');
	}
};
