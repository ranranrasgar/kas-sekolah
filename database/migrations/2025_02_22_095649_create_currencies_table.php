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
        Schema::create('currencies', function (Blueprint $table) {
            $table->id();
            $table->string('code', 3)->unique(); // Kode mata uang (IDR, USD, EUR)
            $table->string('name'); // Nama mata uang
            $table->string('symbol', 5); // Simbol mata uang ($, €, Rp)
            $table->decimal('exchange_rate', 15, 6); // Kurs terhadap mata uang dasar
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('currencies');
    }
};
