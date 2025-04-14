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
            $table->date('check_in')->nullable()->after('status');
            $table->date('check_out')->nullable()->after('check_in');
            $table->string('img_url')->nullable()->after('check_out');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('future_visitors', function (Blueprint $table) {
            //
        });
    }
};
