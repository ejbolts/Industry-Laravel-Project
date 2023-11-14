<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('project_files', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('project_id'); // FK to projects
        $table->string('file_path');
        $table->enum('file_type', ['image', 'pdf']); 
        $table->timestamps();
        
        $table->foreign('project_id')->references('id')->on('projects')->onDelete('cascade');
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('project_files');
    }
};
