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
        Schema::create('issues', function (Blueprint $table) {
            $table->id();
            $table->foreignId('assigner_id')->constrained('users');
            $table->foreignId('assignee_id')->constrained('users');
            $table->string('title');
            $table->text('description');

            $table->unsignedSmallInteger('priority')
                ->default(\App\Enums\IssuePriority::Low->value);
            $table->unsignedSmallInteger('status_id')
                ->default(\App\Enums\IssueStatus::Todo->value);
            $table->unsignedSmallInteger('story_points');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('issues');
    }
};
