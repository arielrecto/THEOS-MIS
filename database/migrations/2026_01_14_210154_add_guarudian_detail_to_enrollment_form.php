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
        Schema::table('enrollment_forms', function (Blueprint $table) {
            $table->string('guardian_name')->nullable()->after('mother_occupation');
            $table->string('guardian_last_name')->nullable()->after('guardian_name');
            $table->string('guardian_middle_name')->nullable()->after('guardian_last_name');
            $table->string('guardian_relationship')->nullable()->after('guardian_middle_name');
            $table->string('guardian_contact_number')->nullable()->after('guardian_relationship');
            $table->string('guardian_occupation')->nullable()->after('guardian_contact_number');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('enrollment_forms', function (Blueprint $table) {
            $table->dropColumn([
                'guardian_name',
                'guardian_last_name',
                'guardian_middle_name',
                'guardian_relationship',
                'guardian_contact_number',
                'guardian_occupation',
            ]);
        });
    }
};
