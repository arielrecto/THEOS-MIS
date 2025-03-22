<?php

use App\Models\AcademicRecord;
use App\Models\Classroom;
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
        Schema::create('grades', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(AcademicRecord::class)->constrained()->cascadeOnDelete();
            $table->string(column: 'quarter');
            $table->string('grade');
            $table->string('remarks')->nullable();
            $table->string('status')->default('Pending');
            $table->foreignId('created_by')->constrained('users')->cascadeOnDelete();
            $table->foreignIdFor(Classroom::class)->constrained()->cascadeOnDelete();
            $table->string('subject');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('grades');
    }
};
