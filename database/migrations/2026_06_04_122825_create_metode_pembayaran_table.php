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
    Schema::create('metode_pembayaran', function (Blueprint $table) {
        $table->id();
        $table->string('nama'); // Contoh: BCA, QRIS, DANA
        $table->string('kategori'); // Contoh: Transfer Bank, Dompet Digital
        $table->enum('tipe', ['rekening', 'qris']); // Pemisah layout text vs gambar
        $table->string('nomor')->nullable(); // Nomor Rekening atau Nomor HP
        $table->string('atas_nama')->nullable(); // Atas Nama Pemilik
        $table->string('qr_code_path')->nullable(); // Tempat simpan file gambar QRIS
        $table->boolean('is_active')->default(true); // Status aktif/nonaktif
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('metode_pembayaran');
    }
};
