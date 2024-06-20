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
        //
        Schema::create('consultation_slots', function (Blueprint $table) {
            $table->id();
            $table->string('lecturer_id');
            $table->foreign('lecturer_id')->references('id')->on('lecturers')->onDelete('cascade');

            $table->string('student_id');
            $table->foreign('student_id')->references('id')->on('students')->onDelete('cascade');
            
            // $table->foreignId('student_id')->constrained('students')->onDelete('cascade');
            $table->date('date'); // (Y-m-d H:i:s)
            $table->time('start_time');
            $table->time('end_time');
            $table->string('status');
            $table->longText('topic')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
