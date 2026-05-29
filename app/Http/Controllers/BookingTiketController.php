<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pendaftaran;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage; // Penting untuk fungsi upload
use Illuminate\Support\Facades\Hash;    // DITAMBAHKAN: Wajib untuk fungsi update password

class BookingTiketController extends Controller
{
    // Form booking
    public function index()
    {
        return view('booking');
    }

    // Simpan booking
    public function store(Request $request)
    {
        $request->validate([
            'nama_ketua'        => 'required|string|max:255',
            'no_hp'             => 'required|string|max:20',
            'tanggal_pendakian' => 'required|date|after:today',
            'jumlah_pendaki'    => 'required|integer|min:1|max:10',
            'nama_darurat'      => 'required|string|max:255',
            'hp_darurat'        => 'required|string|max:20',
            'foto_ktp'          => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $user = Auth::user();

        // Pastikan folder exist
        $path = $request->file('foto_ktp')->store('ktp_pendaki', 'public');

        $booking = Pendaftaran::create([
            'user_id'           => $user->id,
            'nama_ketua'        => $request->nama_ketua,
            'no_hp'             => $request->no_hp,
            'tanggal_pendakian' => $request->tanggal_pendakian,
            'jumlah_pendaki'    => $request->jumlah_pendaki,
            'nama_darurat'      => $request->nama_darurat,
            'hp_darurat'        => $request->hp_darurat,
            'foto_ktp'          => $path,
            'status'            => 'menunggu_pembayaran',
            'kode_booking'      => 'SMR-' . strtoupper(Str::random(8)),
        ]);

        return redirect()->route('pembayaran', ['id' => $booking->id])
                         ->with('success', 'Data berhasil disimpan! Segera selesaikan pembayaran.');
    }

    // Halaman pembayaran
    public function pembayaran($id)
    {
        $booking = Pendaftaran::where('id', $id)
                    ->where('user_id', Auth::id())
                    ->firstOrFail();

        return view('pembayaran', compact('booking'));
    }

    // --- FUNGSI BARU ---
    public function uploadBukti(Request $request, $id)
    {
        $request->validate([
            'bukti_pembayaran' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $booking = Pendaftaran::where('id', $id)
                    ->where('user_id', Auth::id())
                    ->firstOrFail();

        $path = $request->file('bukti_pembayaran')->store('bukti_pembayaran', 'public');

        $booking->update([
            'bukti_pembayaran' => $path,
            'status'           => 'menunggu_verifikasi',
        ]);

        return redirect()->back()->with('success', 'Bukti pembayaran berhasil diupload!');
    }

    // Konfirmasi pembayaran
    public function konfirmasiBayar($id)
    {
        $booking = Pendaftaran::where('id', $id)
                    ->where('user_id', Auth::id())
                    ->firstOrFail();

        $booking->update(['status' => 'sudah_bayar']);

        return redirect()->route('pembayaran.sukses', $booking->id)
                         ->with('success', 'Pembayaran berhasil dikonfirmasi!');
    }

    // Halaman sukses
    public function sukses($id)
    {
        $booking = Pendaftaran::where('id', $id)
                    ->where('user_id', Auth::id())
                    ->firstOrFail();

        return view('sukses', compact('booking'));
    }

    // Riwayat transaksi
    public function riwayat(Request $request)
    {
        // 1. Memulai query dasar untuk user yang sedang login
        $query = Pendaftaran::where('user_id', Auth::id())
                             ->latest();

        // 2. Filter berdasarkan status jika ada input dari user
        if ($request->has('status') && !empty($request->status)) {
            $query->where('status', $request->status);
        }

        // 3. Eksekusi data dengan pagination
        $transaksi = $query->paginate(5);

        // 4. Menghitung statistik untuk ditampilkan di view (sangat berguna untuk user)
        $sudahBayar = Pendaftaran::where('user_id', Auth::id())->where('status', 'sudah_bayar')->count();
        $menunggu   = Pendaftaran::where('user_id', Auth::id())->where('status', 'menunggu_pembayaran')->count();

        return view('riwayat', compact('transaksi', 'sudahBayar', 'menunggu'));
    } // DITAMBAHKAN: Penutup fungsi riwayat yang sebelumnya hilang

    public function destroy($id)
    {
        $booking = Pendaftaran::where('user_id', Auth::id())->findOrFail($id);

        if ($booking->status !== 'menunggu_pembayaran') {
            return redirect()->back()->with('error', 'Transaksi yang sudah diproses tidak dapat dibatalkan.');
        }

        $booking->delete();
        return redirect()->back()->with('success', 'Pemesanan tiket berhasil dibatalkan.');
    }

    public function profile()
    {
        $user = Auth::user();
        return view('profil', compact('user'));
    }

    public function profileUpdate(Request $request)
{
    $user = Auth::user();

    $request->validate([
        'name'     => 'required|string|max:255',
        'email'    => 'required|string|email|max:255|unique:users,email,' . $user->id,
        'no_hp'    => 'nullable|string|max:20',
        'nik'      => 'nullable|string|max:16',
        'password' => 'nullable|string|min:8|confirmed',
    ]);

    // Update data dasar
    $user->name = $request->name;
    $user->email = $request->email;

    // Pastikan kolom ini ada di migrasi tabel users Anda, jika tidak ada bisa dilewati sementara
    if ($request->has('no_hp')) $user->no_hp = $request->no_hp;
    if ($request->has('nik')) $user->nik = $request->nik;

    // Jika password baru diisi
    if ($request->filled('password')) {
        $user->password = Hash::make($request->password);
    }

    return redirect()->back()->with('success', 'Profil Agung Anda berhasil diperbarui!');
}
}
