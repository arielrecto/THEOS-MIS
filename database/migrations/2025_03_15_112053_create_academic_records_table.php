<?php

use App\Models\Enrollment;
use App\Models\AcademicYear;
use App\Models\StudentProfile;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('academic_records', function (Blueprint $table) {
            $table->id();
            $table->string('school_year');
            $table->string('grade_level');
            $table->foreignIdFor(Enrollment::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(AcademicYear::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(StudentProfile::class)->constrained()->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('academic_records');
    }
};
