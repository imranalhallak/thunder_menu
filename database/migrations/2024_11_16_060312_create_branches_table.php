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
        Schema::create('branches', function (Blueprint $table) {
            $table->id(); // Auto-incrementing primary key
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Branch belongs to user
            $table->string('name'); // Name of the branch
            $table->string('slogan'); // link of the location
            $table->string('phone')->nullable(); // Phone number
            $table->string('address1'); // Address of the branch
            $table->string('address2'); // Address of the branch
            $table->string('location'); // link of the location


            $table->string('slug')->unique();

            $table->string('image')->nullable(); // Path or URL to the image
            $table->string('logo')->nullable(); // Path or URL to the image
            $table->enum('mode', ['dark', 'light'])->default('light'); // Mode (dark or light)
            $table->string('facebook')->nullable(); // Facebook URL
            $table->string('instagram')->nullable(); // Instagram URL
            $table->string('whatsapp')->nullable(); // WhatsApp contact link
            $table->timestamps(); // Created and updated timestamps
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('branches');
    }
};
