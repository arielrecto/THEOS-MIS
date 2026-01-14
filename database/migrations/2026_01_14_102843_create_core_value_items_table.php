<?php

use App\Models\CoreValue;
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
        Schema::create('core_value_items', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(CoreValue::class)->constrained()->onDelete('cascade');
            $table->string('item_name');
            $table->longText('item_description')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('core_value_items');
    }
};
