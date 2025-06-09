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
            $table->enum('Status', ['pending', 'Accepted', 'Rejected'])->default('pending');
            $table->string('position applied');
            $table->unsignedBigInteger('jobb_id');
            $table->foreign('jobb_id')->references('id')->on('jobbs')->onDelete('cascade');
            $table->unsignedBigInteger('job_seeker_id');
            // تم الإبقاء على job_seekers لأننا قمنا بتغيير اسم الجدول في ملف JobSeeker.php
            $table->foreign('job_seeker_id')->references('id')->on('job_seekers')->onDelete('cascade');
            $table->index(['jobb_id', 'job_seeker_id']);
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
