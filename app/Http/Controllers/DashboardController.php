<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Pendaftaran; // Pastikan model Pendaftaran Anda sudah ada

class DashboardController extends Controller
{
    /**
     * Menampilkan halaman utama dashboard untuk pendaki.
     */
    public function index()
    {
        // Mengambil data pendaftaran/booking milik pendaki yang sedang login saat ini
        $riwayatBooking = Pendaftaran::where('user_id', Auth::id())
            ->latest()
            ->get();

        // Menghitung jumlah tiket aktif milik pendaki tersebut
        $tiketAktifCount = Pendaftaran::where('user_id', Auth::id())
            ->whereIn('status', ['menunggu_pembayaran', 'sudah_bayar'])
            ->count();

        // Mengirimkan data ke view 'dashboard.blade.php' yang telah kita buat
        return view('dashboard', compact('riwayatBooking', 'tiketAktifCount'));
    }
}
