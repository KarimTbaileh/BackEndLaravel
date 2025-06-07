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
            $table->string('job_type');
            $table->string('Title');
            $table->longText('Description');
            $table->enum('publication_status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->string('Type');
            $table->integer('Salary');
            $table->string('Frequency');
            $table->string('Currency');
            $table->enum('Status', ['open', 'closed'])->default('open');
            $table->unsignedBigInteger('employer_id'); // تعديل من employeer_id إلى employer_id
            $table->foreign('employer_id')->references('id')->on('employers')->onDelete('cascade'); // تعديل الجدول إلى employers
            $table->timestamps();
            $table->string('logo');
            $table->string('document')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('jobbs');
    }
};
