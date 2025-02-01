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
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('curp')->unique();
            $table->string('matricula')->unique();
            $table->string('nombre');
            $table->string('apellidoP');
            $table->string('apellidoM');
            $table->string('edad');
            $table->string('fechaNacimiento');
            $table->string('sexo');
            $table->integer('status')->default(1);
            $table->string('foto')->nullable();
            $table->unsignedBigInteger('level_id');
            $table->unsignedBigInteger('grade_id');
            $table->json('grupo')->nullable();
            // $table->unsignedBigInteger('group_id');
            $table->unsignedBigInteger('generation_id');
            $table->unsignedBigInteger('tutor_id')->nullable();
            $table->integer('order');


            $table->foreign('level_id')->references('id')->on('levels');
            $table->foreign('grade_id')->references('id')->on('grades');
            // $table->foreign('group_id')->references('id')->on('groups');
            $table->foreign('generation_id')->references('id')->on('generations');
            $table->foreign('tutor_id')->references('id')->on('tutors');




            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
