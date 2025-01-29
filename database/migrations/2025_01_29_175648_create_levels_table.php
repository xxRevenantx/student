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
        Schema::create('levels', function (Blueprint $table) {
            $table->id();
            $table->string('level');
            $table->string('slug')->unique();
            $table->string('imagen')->nullable();
            $table->string('color')->nullable();
            $table->string('cct')->nullable();
            $table->unsignedBigInteger('director_id')->nullable();
            $table->unsignedBigInteger('supervisor_id')->nullable();
            $table->integer('order');

            $table->foreign('director_id')->references('id')->on('directors')->onDelete('set null');
            $table->foreign('supervisor_id')->references('id')->on('supervisors')->onDelete('set null');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('levels');
    }
};
