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
        Schema::create('applications', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->String("Cv");
            $table->String("Applicant Name");
            $table->String("Cover Letter");
            $table->String("Status");
            $table->String("position applied");
            $table->unsignedBigInteger('jobb_id');
            $table->foreign('jobb_id')->references('id')->on('jobb')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('applications');
    }
};
