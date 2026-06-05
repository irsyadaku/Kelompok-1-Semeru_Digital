<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MetodePembayaran extends Model
{
    // Menghubungkan model secara kokoh ke tabel 'metode_pembayaran'
    protected $table = 'metode_pembayaran';

    // Daftar kolom yang diizinkan untuk diisi secara massal
    protected $fillable = [
        'nama',
        'kategori',
        'tipe',
        'nomor',
        'atas_nama',
        'qr_code_path',
        'is_active'
    ];

    /**
     * Konversi Otomatis Tipe Data (Casting)
     * Menjamin nilai 'is_active' dibaca sebagai boolean (true/false) di Laravel
     */
    protected $casts = [
        'is_active' => 'boolean',
    ];
}
