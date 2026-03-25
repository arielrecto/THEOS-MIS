<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('enrollment_forms', function (Blueprint $table) {
            $table->string('section')->nullable()->after('grade_level');
        });
    }

    public function down(): void
    {
        Schema::table('enrollment_forms', function (Blueprint $table) {
            $table->dropColumn('section');
        });
    }
};
