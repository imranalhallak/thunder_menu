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
        Schema::create('meals', function (Blueprint $table) {
            $table->id(); // Auto-incrementing primary key

            // Prices
            $table->decimal('price_1', 8, 2)->nullable(); // Price 1
            $table->decimal('price_2', 8, 2)->nullable(); // Price 2
            $table->decimal('price_3', 8, 2)->nullable(); // Price 3

            // Multilingual names
            $table->string('arabic_name'); // Arabic name
            $table->string('english_name'); // English name
            $table->string('turkish_name'); // Turkish name

            $table->integer('position')->nullable(); 
            // Multilingual descriptions
            $table->text('arabic_description')->nullable(); // Arabic description
            $table->text('english_description')->nullable(); // English description
            $table->text('turkish_description')->nullable(); // Turkish description

            // Images
            $table->string('images')->nullable(); // Path or URL to meal images

            // Relationships
            $table->foreignId('menu_id')->constrained('menus')->onDelete('cascade'); // Foreign key to menus table
            $table->foreignId('branch_id')->constrained('branches')->onDelete('cascade'); // Foreign key to branches table

            $table->timestamps(); // Created and updated timestamps
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('meals');
    }
};
