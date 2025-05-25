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
        Schema::create('jobbs', function (Blueprint $table) {
            $table->id();
            $table->String("Requirements");
            $table->String("Location");
            $table->String("Job Type");
            $table->String("Title");
            $table->longText("Description");
            $table->String("Status");
            $table->String("Type");
            $table->integer("Salary");
            $table->String("Frequency");
            $table->String("Currency");
            $table->foreignId('employeer_id')
                ->constrained('employeers')
                ->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jobbs');
    }
};
