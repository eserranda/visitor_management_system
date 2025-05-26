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
            $table->string('verify_status')->nullable()->change();
            $table->enum('verify_status', ['pending', 'verified', 'rejected'])->default('pending')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('future_visitors', function (Blueprint $table) {
            $table->string('verify_status')->nullable()->change();
            $table->enum('verify_status', ['pending', 'verified', 'rejected'])->default('pending')->change();
        });
    }
};
