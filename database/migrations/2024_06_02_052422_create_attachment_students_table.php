<?php

use App\Models\StudentTask;
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
        Schema::create('attachment_students', function (Blueprint $table) {
            $table->id();
            $table->longText('file_dir');
            $table->string('name')->nullable();
            $table->string('type');
            $table->string('extension');
            $table->foreignIdFor(StudentTask::class)->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attachment_students');
    }
};
