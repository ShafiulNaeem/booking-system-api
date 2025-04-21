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
        Schema::create('appoinments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('guest_id')->index();
            $table->unsignedBigInteger('avaiability_id');
            $table->date('date')->index();
            $table->enum('status', ['pending', 'confirmed', 'cancelled'])->default('pending');
            $table->longText('notes')->nullable();
            $table->timestamps();

            $table->foreign('guest_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('avaiability_id')->references('id')->on('avaiabilities')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appoinments');
    }
};
