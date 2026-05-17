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
        Schema::table('attendance_students', function (Blueprint $table) {
            if (!Schema::hasColumn('attendance_students', 'days_of_school')) {
                $table->integer('days_of_school')->nullable();
            }
            if (!Schema::hasColumn('attendance_students', 'academic_year_id')) {
                $table->foreignId('academic_year_id')->nullable()->constrained('academic_years')->onDelete('cascade');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('attendance_students', function (Blueprint $table) {
            if (Schema::hasColumn('attendance_students', 'days_of_school')) {
                $table->dropColumn('days_of_school');
            }
            if (Schema::hasColumn('attendance_students', 'academic_year_id')) {
                $table->dropForeign(['academic_year_id']);
                $table->dropColumn('academic_year_id');
            }
        });
    }
};
