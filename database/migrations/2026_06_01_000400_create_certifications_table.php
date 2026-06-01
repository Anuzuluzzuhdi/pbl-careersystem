<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('certifications', function (Blueprint $table) {
            $table->increments('certification_id');
            $table->string('certification_name');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('certifications');
    }
};
