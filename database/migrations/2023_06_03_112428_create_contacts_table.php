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
        Schema::create('contacts', function (Blueprint $table) {
            $table->id();
            $table->string('address_fa');
            $table->integer('postal_code');
            $table->string('phone_number');
            $table->string('fax_number')->nullable();
            $table->string('email');
            $table->string('body_fa')->nullable();
            $table->boolean('is_english')->default(false);
            $table->string('address_en')->nullable();
            $table->string('body_en')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contacts');
    }
};
