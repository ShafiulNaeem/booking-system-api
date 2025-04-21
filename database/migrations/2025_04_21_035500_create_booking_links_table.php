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
        Schema::create('booking_links', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('host_id');
            $table->string('slug')->unique();
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->foreign('host_id')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('booking_links');
    }
};
