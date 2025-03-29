<?php

use App\Models\User;
use App\Enums\LeaveStatus;
use App\Models\EmployeeProfile;
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
        Schema::create('leaves', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(EmployeeProfile::class)->constrained()->cascadeOnDelete();
            $table->string('leave_type');
            $table->date('start_date');
            $table->date('end_date');
            $table->integer('days');
            $table->longText('reason');
            $table->string('status', LeaveStatus::PENDING->value);
            $table->foreignIdFor(User::class, 'approved_by')->nullable()->constrained('users')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leaves');
    }
};
