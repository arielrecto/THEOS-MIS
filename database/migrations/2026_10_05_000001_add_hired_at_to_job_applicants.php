<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('job_applicants', function (Blueprint $table) {
            $table->timestamp('hired_at')->nullable()->after('status');
        });

        // Applicants hired before this column existed: their last update is the best
        // available record of when they were hired.
        DB::table('job_applicants')
            ->where('status', 'hired')
            ->update(['hired_at' => DB::raw('updated_at')]);
    }

    public function down(): void
    {
        Schema::table('job_applicants', function (Blueprint $table) {
            $table->dropColumn('hired_at');
        });
    }
};
