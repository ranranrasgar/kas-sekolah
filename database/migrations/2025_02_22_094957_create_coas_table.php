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
        Schema::create('coas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('coa_type_id')->constrained()->onDelete('cascade'); // Kategori akun
            $table->string('code')->unique(); // Kode akun (misalnya 101, 201, 301)
            $table->string('name'); // Nama akun (Kas, Piutang, Hutang, dll.)
            $table->foreignId('parent_id')->nullable()->constrained('coas')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coas');
    }
};
