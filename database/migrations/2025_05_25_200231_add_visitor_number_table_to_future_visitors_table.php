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
            // $table->string('visitor_number')->after('id');
            // $table->index('visitor_number')->after('id');
            // $table->unique('visitor_number', 'unique_visitor_number');
            $table->boolean('verify_status')->default(false)->after('status');
            $table->string('phone_number')->nullable()->after('visitor_name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('future_visitors', function (Blueprint $table) {
            // $table->dropColumn('visitor_number');
            // $table->dropUnique('unique_visitor_number');
            $table->dropColumn('verify_status');
            $table->dropColumn('phone_number');
        });
    }
};
