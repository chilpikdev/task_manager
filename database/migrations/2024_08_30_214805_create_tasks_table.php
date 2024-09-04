<?php

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
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('chief_id')->constrained('users')->restrictOnDelete()->cascadeOnUpdate();
            $table->foreignId('employee_id')->constrained('users')->restrictOnDelete()->cascadeOnUpdate();
            $table->string('title');
            $table->text('description')->nullable();
            $table->timestamp('deadline');
            $table->boolean('archived')->default(false);
            $table->enum('priority', ['high', 'medium']);
            // todo: new deadline, status for deadline
            $table->enum('status', ['new', 'in_progress', ' ', 'correction', 'completed', 'canceled']);
            $table->timestamps();
            $table->softDeletes();
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
