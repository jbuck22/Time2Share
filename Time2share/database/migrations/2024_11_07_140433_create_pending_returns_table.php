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
        Schema::create('pending_returns', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product'); // Voeg de product kolom toe
            $table->unsignedBigInteger('owner_id');
            $table->unsignedBigInteger('loaner_id')->nullable();
            $table->timestamps();

            // Foreign key constraints
            $table->foreign('product')->references('id')->on('products')->cascadeOnDelete();
            $table->foreign('owner_id')->references('id')->on('users')->cascadeOnDelete();
            $table->foreign('loaner_id')->references('id')->on('users')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pending_returns');
    }
};
