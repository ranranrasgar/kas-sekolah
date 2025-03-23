<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('payment_methods', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->timestamps();
        });
        DB::table('payment_methods')->insert([
            ['name' => 'Cash', 'description' => 'Pembayaran tunai'],
            ['name' => 'Credit Card', 'description' => 'Pembayaran menggunakan kartu kredit'],
            ['name' => 'Bank Transfer', 'description' => 'Transfer antar bank'],
            ['name' => 'E-Wallet', 'description' => 'Pembayaran melalui e-wallet seperti Gopay, OVO, dll.'],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_methods');
    }
};
