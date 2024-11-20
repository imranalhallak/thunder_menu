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
        Schema::create('menus', function (Blueprint $table) {
            $table->id(); // Auto-incrementing primary key
            $table->string('slug')->unique();
            $table->integer('position')->nullable(); 
            $table->string('arabic_name'); // Name in Arabic
            $table->string('english_name'); // Name in English
            $table->string('turkish_name'); // Name in Turkish
            $table->string('image')->nullable(); // Path or URL to the image
            $table->foreignId('branch_id')->constrained('branches')->onDelete('cascade'); // Foreign key to branches table
            $table->timestamps(); // Created and updated timestamps
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menus');
    }
};
