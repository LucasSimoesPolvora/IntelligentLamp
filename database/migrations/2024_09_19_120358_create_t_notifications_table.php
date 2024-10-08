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
        Schema::create('t_notifications', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('content');
            $table->unsignedBigInteger('fkLampadaire');
            $table->timestamps();
            $table->foreign('fkLampadaire')->references('id')->on('t_lampadaire')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('t_notifications');
    }
};
