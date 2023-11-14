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
            $table->unsignedBigInteger('industry_partner_id'); // FK to industry partners
            $table->string('title');
            $table->string('description');
            $table->unsignedInteger('team_size');
            $table->unsignedInteger('trimester');  
            $table->unsignedInteger('year');
            $table->unique(['title', 'trimester', 'year'], 'unique_project_offering');
            $table->timestamps();
    
            $table->foreign('industry_partner_id')->references('id')->on('industry_partners')->onDelete('cascade');
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
