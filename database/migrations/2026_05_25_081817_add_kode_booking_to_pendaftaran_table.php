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
    Schema::table('pendaftaran', function (Blueprint $table) {
        $table->string('kode_booking')->unique()->nullable()->after('status');
        $table->string('bukti_pembayaran')->nullable()->after('kode_booking');
    });
}

public function down(): void
{
    Schema::table('pendaftaran', function (Blueprint $table) {
        $table->dropColumn(['kode_booking', 'bukti_pembayaran']);
    });
}
    };
