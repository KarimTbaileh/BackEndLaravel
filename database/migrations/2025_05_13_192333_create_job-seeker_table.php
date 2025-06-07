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
        // تغيير اسم الجدول من job_seeker إلى job_seekers ليتوافق مع ملف الهجرة create__applications.php
        Schema::create('job_seekers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('country');
            $table->integer('day');
            $table->integer('month');
            $table->integer('year');
            $table->string('gender');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // إضافة كود لحذف الجدول
        Schema::dropIfExists('job_seekers');
    }
};
