<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pendaftaran extends Model
{
    protected $table = 'pendaftaran'; // Sesuaikan dengan nama tabel di DB

    protected $fillable = [
    'user_id',
    'nama_ketua',
    'no_hp',
    'tanggal_pendakian',
    'jumlah_pendaki',
    'nama_darurat',
    'hp_darurat',
    'foto_ktp',
    'bukti_pembayaran',
    'status',
    'kode_booking',
];
}
