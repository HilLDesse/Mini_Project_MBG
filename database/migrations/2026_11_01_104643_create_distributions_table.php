<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('distributions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('school_id')
                ->constrained()
                ->restrictOnDelete();

            $table->foreignId('sppg_id')
                ->constrained()
                ->restrictOnDelete();

            $table->date('distribution_date');
            $table->timestamps();

            $table->index(['school_id', 'sppg_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('distributions');
    }
};