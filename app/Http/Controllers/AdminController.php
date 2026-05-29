<?php

namespace App\Http\Controllers;

use App\Models\User;        // MENGAKTIFKAN MODEL USER
use App\Models\Pendaftaran; // MENGAKTIFKAN MODEL PENDAFTARAN (Penghilang Garis Merah)
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Halaman Utama Dashboard Admin
     */
    public function index()
    {
        $totalUser       = User::where('role', 'pendaki')->count();
        $totalBooking    = Pendaftaran::count();
        $sudahBayar      = Pendaftaran::where('status', 'sudah_bayar')->count();
        $menunggu        = Pendaftaran::where('status', 'menunggu_pembayaran')->count();
        $totalPendapatan = Pendaftaran::where('status', 'sudah_bayar')->sum('jumlah_pendaki') * 100000; // Asumsi harga tiket per pendaki adalah 100.000

        $bookingTerbaru  = Pendaftaran::latest()->take(5)->get();
        $userTerbaru     = User::where('role', 'pendaki')->latest()->take(5)->get();

        return view('admin_dashboard', compact(
            'totalUser', 'totalBooking', 'sudahBayar', 'menunggu',
            'totalPendapatan', 'bookingTerbaru', 'userTerbaru'
        ));
    }

    /**
     * Halaman Manajemen Pengguna
     */
    public function users()
    {
        $users = User::where('role', 'pendaki')->latest()->get();
        return view('admin_users', compact('users'));
    }

    /**
     * Halaman Manajemen Booking/Pendaftaran
     */
    public function booking()
    {
        $bookings = Pendaftaran::latest()->get();
        return view('admin_booking', compact('bookings'));
    }

    /**
     * Halaman Daftar Pembayaran yang Butuh Verifikasi
     */
    public function daftarVerifikasi()
    {
        $bookings = Pendaftaran::where('status', 'menunggu_verifikasi')
                               ->orderBy('updated_at', 'desc')
                               ->paginate(10);

        return view('verifikasi', compact('bookings'));
    }

    /**
     * Fungsi Terima Pembayaran
     */
    public function terimaPembayaran($id)
    {
        $booking = Pendaftaran::findOrFail($id);

        $booking->update([
            'status' => 'sudah_bayar'
        ]);

        return redirect()->back()->with('success', 'Pembayaran tiket ' . $booking->kode_booking . ' berhasil diverifikasi!');
    }

    /**
     * Fungsi Tolak Pembayaran
     */
    public function tolakPembayaran($id)
    {
        $booking = Pendaftaran::findOrFail($id);

        $booking->update([
            'status' => 'menunggu_pembayaran'
        ]);

        return redirect()->back()->with('error', 'Pembayaran ' . $booking->kode_booking . ' ditolak. User harus mengunggah ulang bukti transfer.');
    }

    /**
     * Halaman Manajemen Berita
     */
    public function berita()
    {
        return view('admin_berita');
    }

    /**
     * Halaman Manajemen Tips
     */
    public function tips()
    {
        return view('admin_tips');
    }

    /**
     * Halaman Manajemen Kuota Pendakian
     */
    public function kuota()
    {
        return view('admin_kuota');
    }
}
