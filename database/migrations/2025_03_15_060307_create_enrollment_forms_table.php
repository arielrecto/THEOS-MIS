<?php

use App\Enums\GeneralStatus;
use App\Models\User;
use App\Models\Enrollment;
use App\Models\AcademicYear;
use App\Models\EnrollmentForm;
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
        Schema::create('enrollment_forms', function (Blueprint $table) {
            $table->id();
            $table->string('school_year');
            $table->string('grade_level');
            $table->boolean('balik_aral')->default(false);
            $table->string('lrn')->nullable();

            // Learner Information
            $table->string('last_name');
            $table->string('first_name');
            $table->string('middle_name')->nullable();
            $table->string('extension_name')->nullable();
            $table->date('birthdate')->nullable();
            $table->string('birthplace')->nullable();

            // Current Address
            $table->string('house_no')->nullable();
            $table->string('street')->nullable();
            $table->string('barangay')->nullable();
            $table->string('city')->nullable();
            $table->string('province')->nullable();
            $table->string('zip_code')->nullable();

            // Permanent Address
            $table->string('perm_house_no')->nullable();
            $table->string('perm_street')->nullable();
            $table->string('perm_barangay')->nullable();
            $table->string('perm_city')->nullable();
            $table->string('perm_province')->nullable();
            $table->string('perm_zip_code')->nullable();

            // Parent/Guardian Information
            $table->string('parent_name')->nullable();
            $table->string('parent_last_name')->nullable();
            $table->string('parent_middle_name')->nullable();
            $table->string('relationship')->nullable()->default('father');
            $table->string('contact_number')->nullable();
            $table->string('occupation')->nullable();


            $table->string('mother_name')->nullable();
            $table->string('mother_last_name')->nullable();
            $table->string('mother_middle_name')->nullable();
            $table->string('mother_relationship')->nullable()->default('mother');
            $table->string('mother_contact_number')->nullable();
            $table->string('mother_occupation')->nullable();


            // Senior High School Preferences
            $table->string('preferred_track')->nullable();
            $table->string('preferred_strand')->nullable();

            // Distance Learning Modalities (JSON for multiple selections)
            $table->json('modality')->nullable();


            $table->string('email')->nullable();

            $table->string('type')->default('new');

            $table->string('status')->default('pending');
            // Foreign key constraint
            $table->foreignIdFor(AcademicYear::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(Enrollment::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(User::class)->nullable()->constrained()->cascadeOnDelete();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('enrollment_forms');
    }
};
