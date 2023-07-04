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
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('title_fa');
//            $table->foreignId('type_id')->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('status_id')->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('scale_id')->constrained()->cascadeOnDelete()->cascadeOnUpdate();
//            $table->enum('status', ['completed', 'concept', 'in_progress', 'under_construction']);
//            $table->enum('scale', ['large', 'medium', 'small']);
            $table->string('slug');
            $table->string('body_fa');
            $table->string('image');
            $table->string('video')->nullable();
            $table->string('location_fa')->nullable();
            $table->string('team_fa')->nullable();
            $table->string('client_fa')->nullable();
            $table->string('supervision_fa')->nullable();
            $table->string('construction_fa')->nullable();
            $table->string('landscape_fa')->nullable();
            $table->string('structural_design_fa')->nullable();
            $table->string('mechanical_fa')->nullable();
            $table->string('electrical_fa')->nullable();
            $table->string('revolving_rooms_fa')->nullable();
            $table->string('photographer_fa')->nullable();


            $table->boolean('is_english')->default(false);
            $table->string('title_en')->nullable();
            $table->string('body_en')->nullable();
            $table->string('location_en')->nullable();
            $table->string('team_en')->nullable();
            $table->string('client_en')->nullable();
            $table->string('supervision_en')->nullable();
            $table->string('construction_en')->nullable();
            $table->string('landscape_en')->nullable();
            $table->string('structural_design_en')->nullable();
            $table->string('mechanical_en')->nullable();
            $table->string('electrical_en')->nullable();
            $table->string('revolving_rooms_en')->nullable();
            $table->string('photographer_en')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
