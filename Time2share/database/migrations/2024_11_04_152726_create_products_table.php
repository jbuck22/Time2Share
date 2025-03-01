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
            $table->string('name');
            $table->string('description')->nullable();
            $table->string('category');
            $table->date('deadline')->nullable();
            $table->unsignedBigInteger('owner_id');
            $table->unsignedBigInteger('loaner_id')->nullable();

            $table->string('image')->nullable();

            $table->foreign('owner_id')->references('id')->on('users')->cascadeOnDelete();
            $table->foreign('loaner_id')->references('id')->on('users')->nullable()->cascadeOnDelete();
            $table->boolean('loaned_out')->default(false);
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
