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
        Schema::create('learner_observed_values', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('student_id');
            $table->unsignedBigInteger('academic_year_id');
            $table->string('core_value');
            $table->string('behavior_statement');
            $table->string('quarter_1')->nullable();
            $table->string('quarter_2')->nullable();
            $table->string('quarter_3')->nullable();
            $table->string('quarter_4')->nullable();
            $table->timestamps();

            $table->unique(['student_id', 'academic_year_id', 'core_value', 'behavior_statement'], 'unique_value');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('learner_observed_values');
    }
};
