<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('career_education_weights', function (Blueprint $table) {
            $table->unsignedInteger('career_id');
            $table->unsignedInteger('education_id');
            $table->unsignedInteger('frequency');
            $table->decimal('weight', 6, 4);

            $table->primary(['career_id', 'education_id']);

            $table->foreign('career_id')
                ->references('career_id')
                ->on('careers')
                ->cascadeOnDelete();

            $table->foreign('education_id')
                ->references('education_id')
                ->on('educations')
                ->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('career_education_weights');
    }
};
