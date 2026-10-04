<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('classrooms', function (Blueprint $table) {
            $table->timestamp('archived_at')->nullable()->after('is_archived');
        });

        // Classrooms archived before this column existed: their last update is the
        // best available record of when they were archived.
        DB::table('classrooms')
            ->where('is_archived', true)
            ->update(['archived_at' => DB::raw('updated_at')]);
    }

    public function down(): void
    {
        Schema::table('classrooms', function (Blueprint $table) {
            $table->dropColumn('archived_at');
        });
    }
};
