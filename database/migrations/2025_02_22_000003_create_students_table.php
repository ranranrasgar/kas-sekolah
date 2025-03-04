<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use function Laravel\Prompts\table;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->string('nisn', 13)->unique();
            // $table->foreignId('class_id')->constrained('classes')->onDelete('cascade');
            // $table->foreignId('major_id')->constrained('majors')->onDelete('cascade');
            $table->unsignedBigInteger('class_id');
            $table->unsignedBigInteger('major_id');
            $table->unsignedBigInteger('agama_id');
            $table->text('address')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->date('birth_date')->nullable();
            $table->string('student_photo', 255)->nullable();
            $table->enum('gender', ['L', 'P'])->nullable();
            $table->timestamps();

            $table->foreign('class_id')->references('id')->on('classes')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('major_id')->references('id')->on('majors')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('agama_id')->references('id')->on('agamas')->onUpdate('cascade')->onDelete('cascade');
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
