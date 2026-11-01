<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('report_follow_ups', function (Blueprint $table) {
            $table->id();

            $table->foreignId('report_id')
                ->constrained()
                ->restrictOnDelete();

            $table->foreignId('coordinator_id')
                ->constrained('users')
                ->restrictOnDelete();

            $table->string('destination');
            $table->text('notes');
            $table->timestamp('forwarded_at')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('report_follow_ups');
    }
};