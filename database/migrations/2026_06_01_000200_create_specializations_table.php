<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('specializations', function (Blueprint $table) {
            $table->increments('specialization_id');
            $table->string('specialization_name');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('specializations');
    }
};
