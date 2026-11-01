<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reports', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                ->constrained()
                ->restrictOnDelete();

            $table->foreignId('distribution_id')
                ->constrained()
                ->restrictOnDelete();

            $table->string('title');
            $table->text('description');
            $table->date('incident_date');
            $table->string('status')->default('menunggu_peninjauan');
            $table->string('evidence_path')->nullable();

            $table->timestamps();

            $table->index('status');
            $table->index('incident_date');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reports');
    }
};