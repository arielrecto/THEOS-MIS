<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('about_us', function (Blueprint $table) {
            $table->text('vision')->nullable()->after('description');
            $table->text('mission')->nullable()->after('vision');
        });
    }

    public function down(): void
    {
        Schema::table('about_us', function (Blueprint $table) {
            $table->dropColumn(['vision', 'mission']);
        });
    }
};
