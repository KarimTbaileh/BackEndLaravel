<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('profiles', function (Blueprint $table) {
            $table->id();
            $table->string('Skill');
            $table->string('Cv')->nullable();
            $table->string('Summary');
            $table->string('Email');
            $table->string('Experience');
            $table->string('Education');
            $table->string('Country');
            $table->string('City');
            $table->string('phone_number');
            $table->string('FirstName');
            $table->string('LastName');
            $table->unsignedBigInteger('user_id')->unique();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('profiles');
    }
};
