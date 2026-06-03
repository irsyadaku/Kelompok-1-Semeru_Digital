<?php

namespace App\Http\Controllers;

use App\Models\User;        // MENGAKTIFKAN MODEL USER
use App\Models\Pendaftaran; // MENGAKTIFKAN MODEL PENDAFTARAN
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
        $sudahBayar      = Pendaftaran::where('status', 'disetujui')->count(); // Disesuaikan dengan status 'disetujui'
        $menunggu        = Pendaftaran::where('status', 'menunggu_verifikasi')->count();
        $totalPendapatan = Pendaftaran::where('status', 'disetujui')->sum('jumlah_pendaki') * 100000;

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
     * Tampilan Detail Validasi Dokumen & KTP
     */
    public function showValidasi($id)
    {
        $booking = Pendaftaran::findOrFail($id);
        return view('validasi_detail', compact('booking'));
    }

    /**
     * Fungsi Eksekutif: Hapus Data Booking secara Permanen
     */
    public function destroyBooking($id)
    {
        $booking = Pendaftaran::findOrFail($id);
        $booking->delete();

        return redirect()->back()->with('success', 'Data booking pendakian berhasil dihapus dari sistem, Yang Mulia.');
    }

    /**
     * Fungsi Tolak Pembayaran / Validasi (REJECT)
     */
    public function reject($id)
    {
        $booking = Pendaftaran::findOrFail($id);

        // Memastikan status tertulis 'ditolak' ke database
        $booking->update([
            'status' => 'ditolak'
        ]);

        return redirect()->back()->with('error', 'Pembayaran ' . $booking->kode_booking . ' telah resmi DITOLAK. User harus mengunggah ulang bukti transfer.');
    }

    /**
     * Fungsi Terima / Setujui Pembayaran (APPROVE)
     */
    public function approve($id)
    {
        $booking = Pendaftaran::findOrFail($id);

        // Memastikan status tertulis 'disetujui' agar sesuai dengan badge hijau di antrean
        $booking->update([
            'status' => 'disetujui'
        ]);

        return redirect()->back()->with('success', 'Validasi berhasil, Yang Mulia! SIMAKSI untuk kode tiket #' . ($booking->kode_booking ?? 'SMR-'.$booking->id) . ' telah aktif.');
    }
}
