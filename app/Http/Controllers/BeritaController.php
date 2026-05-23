<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BeritaController extends Controller
{
    public function index()
    {
        return view('DaftarBerita');
    }
    public function show($id)
{
    // Simulasi data berita berdasarkan ID tanpa mengubah database dulu
    $semua_berita = [
        1 => [
            'tanggal' => '12 Mei 2026',
            'kategori' => 'Info Jalur',
            'slug_judul' => 'RANUPANI DIBUKA',
            'kutipan' => 'Jalur Pendakian Ranupani Dibuka Kembali Dengan Pembatasan Kuota Resmi.',
            'penulis' => 'Admin Semeru',
            'gambar' => 'https://images.unsplash.com/photo-1500530855697-b586d89ba3ee?q=80&w=800'
        ],
        2 => [
            'tanggal' => '11 Mei 2026',
            'kategori' => 'Cuaca',
            'slug_judul' => 'WASPADA BADAI',
            'kutipan' => 'Waspada Badai & Angin Kencang di Area Camp Kalimati Seminggu Kedepan.',
            'penulis' => 'BMKG Maritim',
            'gambar' => 'https://images.unsplash.com/photo-1464822759023-fed622ff2c3b?q=80&w=800'
        ],
        3 => [
            'tanggal' => '09 Mei 2026',
            'kategori' => 'Edukasi',
            'slug_judul' => 'MANAJEMEN LOGISTIK',
            'kutipan' => 'Panduan Manajemen Logistik Pendakian Mandiri Di Atas 3000 MDPL.',
            'penulis' => 'Saver Semeru',
            'gambar' => 'https://images.unsplash.com/photo-1544644181-1484b3fdfc62?q=80&w=800'
        ]
    ];

    // Jika id berita ditemukan, kirim data ke view detail
    if (array_key_exists($id, $semua_berita)) {
        return view('detail_berita', $semua_berita[$id]);
    }

    // Jika tidak ada, kembalikan ke halaman utama berita
    return redirect('/berita');
}
}
