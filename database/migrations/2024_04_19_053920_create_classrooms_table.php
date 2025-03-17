<?php

use App\Models\User;
use App\Models\Strand;
use App\Models\Subject;
use App\Models\AcademicYear;
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
        Schema::create('classrooms', function (Blueprint $table) {
            $table->id();
            $table->string('image')->nullable();
            $table->string('name');
            $table->string('class_code');
            $table->longText('description');
            $table->foreignIdFor(Subject::class)->constrained()->onDelete('cascade');
            $table->foreignIdFor(Strand::class)->constrained()->onDelete('cascade');
            $table->foreignIdFor(User::class, 'teacher_id')->constrained('users')->onDelete('cascade');
            $table->foreignIdFor(AcademicYear::class)->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('classrooms');
    }
};
