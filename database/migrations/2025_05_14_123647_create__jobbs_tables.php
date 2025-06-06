<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('jobbs', function (Blueprint $table) {
            $table->id();
            $table->string('Requirements');
            $table->string('Location');
            $table->string('Job Type');
            $table->string('Title');
            $table->longText('Description');
            $table->enum('publication_status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->string('Type');
            $table->integer('Salary');
            $table->string('Frequency');
            $table->string('Currency');
            $table->enum('Status', ['open', 'closed'])->default('open');
            $table->unsignedBigInteger('employeer_id');
            $table->foreign('employeer_id')->references('id')->on('employeer')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('jobbs');
    }
};
