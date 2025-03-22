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
        Schema::create('visitors', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedBigInteger('user_id')->nullable(); // Relasi ke user (tujuan kunjungan)
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null'); // Relasi dengan tabel users
            $table->string('visitor_type');
            $table->unsignedBigInteger('company_id')->nullable(); // Relasi ke perusahaan
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('set null'); // Relasi dengan tabel companies
            $table->string('phone_number')->nullable();
            $table->string('purpose'); // Tujuan kunjungan
            $table->dateTime('check_in'); // Tanggal kunjungan
            $table->dateTime('check_out')->nullable(); // Waktu check-out
            $table->string('img_url')->nullable(); // Foto saat check-in
            $table->enum('status', ['scheduled', 'visiting', 'completed', 'cancelled'])->default('scheduled'); // Menyederhanakan status dengan enum
            $table->string('information')->nullable(); // Informasi tambahan

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('visitors');
    }
};
