<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('career_specialization_weights', function (Blueprint $table) {
            $table->unsignedInteger('career_id');
            $table->unsignedInteger('specialization_id');
            $table->unsignedInteger('frequency');
            $table->decimal('weight', 6, 4);

            $table->primary(['career_id', 'specialization_id']);

            $table->foreign('career_id')
                ->references('career_id')
                ->on('careers')
                ->cascadeOnDelete();

            $table->foreign('specialization_id')
                ->references('specialization_id')
                ->on('specializations')
                ->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('career_specialization_weights');
    }
};
