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
        Schema::create('profiles', function (Blueprint $table) {
            $table->id();
            $table->String ('Skill');
            $table->String ('Cv')->nullable();
            $table->String ('Summary');
            $table->String ('Email');
            $table->String ('Experience');
            $table->String ('Education');
            $table->String ('Country');
            $table->String ('City');
            $table->String ('Phone Number');
            $table->String ('FirstName');
            $table->String ('LastName');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profiles');
    }
};
