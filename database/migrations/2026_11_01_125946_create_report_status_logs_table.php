<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('report_status_logs', function (Blueprint $table) {
            $table->id();

            $table->foreignId('report_id')
                ->constrained()
                ->restrictOnDelete();

            $table->string('old_status');
            $table->string('new_status');

            $table->foreignId('actor_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->timestamp('changed_at');

            $table->index(['report_id', 'changed_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('report_status_logs');
    }
};
