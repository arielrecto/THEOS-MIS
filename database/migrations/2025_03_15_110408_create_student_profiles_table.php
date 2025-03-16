<?php

use App\Models\User;
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
        Schema::create('student_profiles', function (Blueprint $table) {
            $table->id();
            // Learner Information
            $table->string('last_name');
            $table->string('lrn')->nullable();
            $table->string('first_name');
            $table->string('middle_name')->nullable();
            $table->string('extension_name')->nullable();
            $table->date('birthdate')->nullable();
            $table->string('birthplace')->nullable();
            $table->string('house_no')->nullable();
            $table->string('street')->nullable();
            $table->string('barangay')->nullable();
            $table->string('city')->nullable();
            $table->string('province')->nullable();
            $table->string('zip_code')->nullable();
            $table->string('perm_house_no')->nullable();
            $table->string('perm_street')->nullable();
            $table->string('perm_barangay')->nullable();
            $table->string('perm_city')->nullable();
            $table->string('perm_province')->nullable();
            $table->string('perm_zip_code')->nullable();
            $table->string('parent_name')->nullable();
            $table->string('relationship')->nullable();
            $table->string('contact_number')->nullable();
            $table->string('occupation')->nullable();
            $table->string('preferred_track')->nullable();
            $table->string('preferred_strand')->nullable();
            $table->json('modality')->nullable();
            $table->string('email')->nullable();
            $table->foreignIdFor(User::class)->constrained()->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_profiles');
    }
};
