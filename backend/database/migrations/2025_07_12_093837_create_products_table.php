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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('name', 255);
            $table->string('sku', 100)->unique()->nullable()->comment('Stock Keeping Unit');
            $table->string('category', 100)->nullable();
            $table->text('features')->nullable();
            $table->text('keywords')->nullable();
            $table->string('tone', 50)->nullable()->comment('e.g., formal, casual, enthusiastic');
            $table->string('length', 50)->nullable()->comment('e.g., short, medium, long');
            $table->text('final_description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
