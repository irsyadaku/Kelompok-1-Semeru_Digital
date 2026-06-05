<?php

namespace App\Http\Controllers;

use App\Models\User;        // MENGAKTIFKAN MODEL USER
use App\Models\Pendaftaran; // MENGAKTIFKAN MODEL PENDAFTARAN
use App\Models\MetodePembayaran; // MENGAKTIFKAN MODEL METODE PEMBAYARAN
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage; // UNTUK MENGELOLA FILE GAMBAR

class AdminController extends Controller
{
    /**
     * Halaman Utama Dashboard Admin
     */
    public function index()
    {
        $totalUser       = User::where('role', 'pendaki')->count();
        $totalBooking    = Pendaftaran::count();
        $sudahBayar      = Pendaftaran::where('status', 'disetujui')->count();
        $menunggu        = Pendaftaran::where('status', 'menunggu_verifikasi')->count();
        $totalPendapatan = Pendaftaran::where('status', 'disetujui')->sum('jumlah_pendaki') * 100000;

        $bookingTerbaru  = Pendaftaran::latest()->take(5)->get();
        $userTerbaru     = User::where('role', 'pendaki')->latest()->take(5)->get();

        return view('admin_dashboard', compact(
            'totalUser', 'totalBooking', 'sudahBayar', 'menunggu',
            'totalPendapatan', 'bookingTerbaru', 'userTerbaru'
        ));
    }


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
        $bookings = Pendaftaran::latest()->paginate(10);

        return view('admin_booking', compact('bookings'));
    }

    public function profile()
    {
        // Mengambil data user/admin yang sedang bertahta saat ini
        $admin = auth()->user();

        return view('admin_profile', compact('admin'));
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

    /**
     * Halaman Pengaturan Metode Pembayaran
     */
    public function paymentSettings()
    {
        // Variabel di view menggunakan $methods
        $methods = MetodePembayaran::latest()->get();
        return view('payment_settings', compact('methods'));
    }

    /**
     * Fungsi Dinamis: Simpan Baru & Update Metode Pembayaran
     */
    public function savePaymentSetting(Request $request)
    {
        // 1. Validasi Input
        $request->validate([
            'nama'      => 'required|string|max:255',
            'kategori'  => 'required|string|max:255',
            'tipe'      => 'required|in:rekening,qris',
            'nomor'     => 'nullable|string',
            'atas_nama' => 'nullable|string',
            'qr_code'   => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // 2. Cek apakah ini mode Edit (memiliki ID) atau mode Tambah (ID kosong)
        if ($request->filled('id')) {
            $method = MetodePembayaran::findOrFail($request->id);
            $pesanSukses = 'Data metode pembayaran berhasil diperbarui, Yang Mulia!';
        } else {
            $method = new MetodePembayaran();
            $pesanSukses = 'Metode Pembayaran baru berhasil ditambahkan, Yang Mulia!';
        }

        // 3. Masukkan Data Umum
        $method->nama      = $request->nama;
        $method->kategori  = $request->kategori;
        $method->tipe      = $request->tipe;
        $method->is_active = $request->has('is_active') ? 1 : 0;

        // 4. Logika Pemisahan Tipe Inputan
        if ($request->tipe === 'rekening') {
            $method->nomor        = $request->nomor;
            $method->atas_nama    = $request->atas_nama;

            // Opsional: Hapus gambar QRIS lama dari storage jika tipe diubah dari QRIS ke Rekening
            if ($method->qr_code_path && Storage::disk('public')->exists($method->qr_code_path)) {
                Storage::disk('public')->delete($method->qr_code_path);
                $method->qr_code_path = null;
            }
        } else {
            // Tipe QRIS: Kosongkan nomor dan atas nama
            $method->nomor     = null;
            $method->atas_nama = null;

            // Proses Upload Gambar QRIS (Jika ada file yang diunggah)
            if ($request->hasFile('qr_code')) {
                // Hapus gambar lama jika sedang mode edit dan file diganti
                if ($method->qr_code_path && Storage::disk('public')->exists($method->qr_code_path)) {
                    Storage::disk('public')->delete($method->qr_code_path);
                }

                $qrCodePath = $request->file('qr_code')->store('qris_codes', 'public');
                $method->qr_code_path = $qrCodePath;
            }
        }

        // 5. Simpan ke Database
        $method->save();

        return redirect()->back()->with('success', $pesanSukses);
    }

    /**
     * Fungsi Eksekutif: Hapus Metode Pembayaran
     */
    public function deletePaymentSetting($id)
    {
        $method = MetodePembayaran::findOrFail($id);

        // Hapus file gambar dari server sebelum menghapus data dari database
        if ($method->qr_code_path && Storage::disk('public')->exists($method->qr_code_path)) {
            Storage::disk('public')->delete($method->qr_code_path);
        }

        $method->delete();

        return redirect()->back()->with('success', 'Metode pembayaran tersebut telah berhasil dihapus secara permanen, Yang Mulia.');
    }
}
