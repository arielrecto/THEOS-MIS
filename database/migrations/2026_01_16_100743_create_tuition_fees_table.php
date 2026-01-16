<?php

use App\Models\TuitionFeeBracket;
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
        Schema::create('tuition_fees', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('type')->nullable();
            $table->decimal('amount', 10, 2);
            $table->boolean('is_active')->default(true);
            $table->boolean('is_monthly')->default(false);
            $table->boolean('is_onetime_fee')->default(false);
            $table->foreignIdFor(TuitionFeeBracket::class)
                ->nullable()
                ->constrained()
                ->onDelete('set null');

            $table->enum('payment_agreement', ['full', 'installment'])->default('full'); // full, installment
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tuition_fees');
    }
};
