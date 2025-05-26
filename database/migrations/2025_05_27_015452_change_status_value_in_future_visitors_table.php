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
        Schema::table('future_visitors', function (Blueprint $table) {
            // tambahkan enum pada status
            $table->enum('status', ['pending', 'approved', 'completed', 'rejected'])->default('pending')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('future_visitors', function (Blueprint $table) {
            // kembalikan ke string jika perlu
            $table->string('status')->default('pending')->change();
        });
    }
};
