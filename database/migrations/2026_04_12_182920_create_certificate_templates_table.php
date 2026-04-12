<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('certificate_templates', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // e.g., "Good Moral Certificate"
            $table->string('type')->unique(); // e.g., "good_moral"
            $table->text('title'); // Certificate title
            $table->text('content'); // Main content with placeholders
            $table->text('footer')->nullable();
            $table->string('signatory_name')->nullable();
            $table->string('signatory_title')->nullable();
            $table->string('signatory_name_2')->nullable(); // Class Adviser
            $table->string('signatory_title_2')->nullable();
            $table->string('signatory_name_3')->nullable(); // School Registrar
            $table->string('signatory_title_3')->nullable();
            $table->text('header_text')->nullable(); // For Form 137 header
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('certificate_templates');
    }
};
