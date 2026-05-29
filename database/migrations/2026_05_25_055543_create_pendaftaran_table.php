<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Menjalankan perintah cor tabel ke database.
     */
   public function up(): void
{
    Schema::create('pendaftaran', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained('users')->onDelete('cascade');

        // Data Ketua Rombongan
        $table->string('nama_ketua');
        $table->string('no_hp');

        // Detail Pendakian
        $table->date('tanggal_pendakian');
        $table->integer('jumlah_pendaki');

        // Kontak Darurat
        $table->string('nama_darurat');
        $table->string('hp_darurat');

        // File & Status
        $table->string('foto_ktp');
        $table->string('status')->default('pending');

        $table->timestamps();
    });
}

    /**
     * Membatalkan/menghapus tabel.
     */
    public function down(): void
    {
        Schema::dropIfExists('pendaftaran');
    }
};

$table->string('bukti_pembayaran')->nullable();
$table->enum('status', ['menunggu_pembayaran', 'menunggu_konfirmasi', 'sudah_bayar', 'dibatalkan'])
      ->default('menunggu_pembayaran');
