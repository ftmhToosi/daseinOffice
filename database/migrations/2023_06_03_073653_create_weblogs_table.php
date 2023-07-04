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
        Schema::create('weblogs', function (Blueprint $table) {
            $table->id();
            $table->string('title_fa');
            $table->string('slug');
//            $table->date('date');
            $table->string('body_fa')->nullable();
            $table->string('link')->nullable();
            $table->string('description')->nullable();
            $table->string('keyword')->nullable();
            $table->string('image')->nullable();
            $table->boolean('is_english')->default(false);
            $table->string('title_en')->nullable();
            $table->string('body_en')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('weblogs');
    }
};
