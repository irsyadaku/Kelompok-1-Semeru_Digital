@extends('Layout.App')

@section('content')
<div class="p-6 bg-slate-950 min-h-screen text-white fade-up delay-1">
    <div class="max-w-5xl mx-auto mt-8">

        {{-- Header Halaman --}}
        <div class="bg-[#0D1B2A] border border-emerald-500/10 p-8 rounded-3xl flex justify-between items-center mb-8 shadow-xl">
            <div>
                <span class="bg-emerald-500/10 text-emerald-400 border border-emerald-500/20 px-3 py-0.5 rounded-full text-[9px] font-black uppercase tracking-widest">
                    Manajemen Finansial
                </span>
                <h2 class="text-white text-2xl font-black italic uppercase tracking-tight mt-1.5">
                    Metode <span class="text-emerald-400">Pembayaran</span>
                </h2>
                <p class="text-white/40 text-xs mt-0.5">Atur nomor rekening dan QRIS yang akan ditampilkan kepada pendaki.</p>
            </div>
            <a href="{{ route('admin.dashboard') }}" class="bg-white/5 border border-white/10 hover:bg-white/10 text-white/80 font-black px-4 py-2 rounded-xl text-[10px] uppercase tracking-wider transition flex items-center gap-2">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>

        {{-- Notifikasi Sukses --}}
        @if(session('success'))
            <div class="bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 text-sm p-4 rounded-xl font-bold flex items-center gap-2 mb-6">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            {{-- KOLOM 1: FORM TAMBAH / EDIT --}}
            <div class="lg:col-span-1 bg-[#0D1B2A] border border-white/5 rounded-3xl p-6 h-fit sticky top-6">
                <div class="flex justify-between items-center mb-5">
                    <h3 class="text-sm font-black uppercase tracking-wider text-white">
                        <i class="fas fa-edit text-emerald-400 mr-2" id="form_icon"></i>
                        <span id="form_title">Tambah</span> Metode
                    </h3>
                    <button type="button" id="btn_batal" onclick="resetForm()" class="hidden text-[10px] font-bold text-red-400 hover:underline uppercase tracking-wider">
                        Batal Edit
                    </button>
                </div>

                <form action="{{ route('admin.metode_pembayaran_save') }}" method="POST" enctype="multipart/form-data" class="space-y-4" id="form_metode">
                    @csrf
                    {{-- Input Hidden untuk mode Edit --}}
                    <input type="hidden" name="id" id="method_id">

                    <div>
                        <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1.5">Nama Metode (Cth: BCA, QRIS)</label>
                        <input type="text" name="nama" id="input_nama" required class="w-full bg-slate-950/50 border border-slate-800 rounded-xl px-4 py-2.5 text-sm text-white focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 outline-none transition">
                    </div>
                    <div>
                        <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1.5">Kategori (Cth: Transfer Bank)</label>
                        <input type="text" name="kategori" id="input_kategori" required class="w-full bg-slate-950/50 border border-slate-800 rounded-xl px-4 py-2.5 text-sm text-white focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 outline-none transition">
                    </div>
                    <div>
                        <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1.5">Tipe Inputan</label>
                        <select name="tipe" id="tipe_input" onchange="toggleFormInput(this.value)" class="w-full bg-slate-950/50 border border-slate-800 rounded-xl px-4 py-2.5 text-sm text-white focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 outline-none transition appearance-none">
                            <option value="rekening" class="bg-slate-900">Nomor Rekening / HP</option>
                            <option value="qris" class="bg-slate-900">Upload Gambar QRIS</option>
                        </select>
                    </div>

                    {{-- Group Input Nomor Rekening --}}
                    <div id="group_rekening" class="space-y-4 pt-2 border-t border-white/5">
                        <div>
                            <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1.5">Nomor Rekening / HP</label>
                            <input type="text" name="nomor" id="input_nomor" class="w-full bg-slate-950/50 border border-slate-800 rounded-xl px-4 py-2.5 text-sm text-white focus:border-emerald-500 outline-none transition">
                        </div>
                        <div>
                            <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1.5">Atas Nama Pemilik</label>
                            <input type="text" name="atas_nama" id="input_atas_nama" class="w-full bg-slate-950/50 border border-slate-800 rounded-xl px-4 py-2.5 text-sm text-white focus:border-emerald-500 outline-none transition">
                        </div>
                    </div>

                    {{-- Group Input QRIS --}}
                    <div id="group_qris" class="hidden pt-2 border-t border-white/5">
                        <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1.5">Upload Kode QRIS (Maks 2MB)</label>
                        <div class="border-2 border-dashed border-slate-800 rounded-xl p-4 text-center hover:border-emerald-500/50 transition cursor-pointer relative bg-slate-950/30">
                            <input type="file" name="qr_code" id="input_qr_code" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10" onchange="previewFile(this)">
                            <i class="fas fa-qrcode text-2xl text-slate-500 mb-2" id="qr_icon"></i>
                            <div class="text-xs text-emerald-400 font-bold" id="qr_text">Pilih File Gambar</div>
                            <div class="text-[9px] text-slate-500 mt-1" id="qr_subtext">PNG, JPG, JPEG</div>
                        </div>
                        <div id="edit_qr_info" class="hidden text-[10px] text-amber-400/80 italic mt-1.5">
                            * Biarkan kosong jika tidak ingin mengubah gambar QRIS yang lama.
                        </div>
                    </div>

                    {{-- Checkbox Status Aktif --}}
                    <div class="flex items-center gap-3 pt-4 border-t border-white/5">
                        <div class="relative flex items-center">
                            <input type="checkbox" name="is_active" id="is_active" value="1" class="peer h-5 w-5 cursor-pointer appearance-none rounded-md border border-slate-700 bg-slate-950/50 checked:border-emerald-500 checked:bg-emerald-500 transition-all">
                            <i class="fas fa-check absolute left-1/2 top-1/2 -translate-x-1/2 -translate-y-1/2 text-[10px] text-slate-950 opacity-0 peer-checked:opacity-100 pointer-events-none"></i>
                        </div>
                        <label for="is_active" class="text-xs font-bold text-slate-300 cursor-pointer select-none">Aktifkan Metode Ini</label>
                    </div>

                    <button type="submit" id="btn_submit" class="w-full bg-emerald-500 hover:bg-emerald-600 text-slate-950 font-black tracking-widest py-3.5 rounded-xl text-xs transition mt-2 shadow-lg shadow-emerald-500/20">
                        SIMPAN DATA
                    </button>
                </form>
            </div>

            {{-- KOLOM 2: DAFTAR METODE AKTIF --}}
            <div class="lg:col-span-2 bg-[#0D1B2A] border border-white/5 rounded-3xl p-6">
                <h3 class="text-sm font-black uppercase tracking-wider text-white mb-5">
                    <i class="fas fa-list text-emerald-400 mr-2"></i> Daftar Metode Tersimpan
                </h3>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    @forelse($methods as $method)
                        <div class="bg-slate-950/50 border border-slate-800 hover:border-emerald-500/30 rounded-2xl p-5 transition group relative overflow-hidden flex flex-col justify-between min-h-[170px]">

                            <div>
                                <div class="flex justify-between items-start mb-3">
                                    <div>
                                        <span class="bg-emerald-500/10 text-emerald-400 border border-emerald-500/20 px-2 py-0.5 rounded text-[10px] font-black uppercase tracking-wider">
                                            {{ $method->nama }}
                                        </span>
                                        <div class="text-[10px] text-slate-500 font-bold uppercase tracking-wider mt-2">{{ $method->kategori }}</div>
                                    </div>
                                    <span class="text-[9px] font-black px-2 py-1 rounded-full {{ $method->is_active ? 'bg-emerald-500/10 text-emerald-400' : 'bg-red-500/10 text-red-400' }}">
                                        <i class="fas fa-circle text-[6px] mr-1 {{ $method->is_active ? 'text-emerald-400 animate-pulse' : 'text-red-400' }}"></i>
                                        {{ $method->is_active ? 'AKTIF' : 'NONAKTIF' }}
                                    </span>
                                </div>

                                @if($method->tipe == 'rekening')
                                    <div class="text-lg font-mono font-bold text-white tracking-widest">{{ $method->nomor }}</div>
                                    <div class="text-xs text-slate-400 mt-1">An. {{ $method->atas_nama }}</div>
                                @else
                                    <div class="flex items-center gap-3 mt-2 bg-slate-900 p-2 rounded-xl border border-slate-800 w-fit">
                                        @if($method->qr_code_path)
                                            <img src="{{ asset('storage/' . $method->qr_code_path) }}" alt="QRIS" class="w-12 h-12 rounded bg-white p-1 object-contain">
                                        @else
                                            <div class="w-12 h-12 rounded bg-slate-800 flex items-center justify-center">
                                                <i class="fas fa-image text-slate-600"></i>
                                            </div>
                                        @endif
                                        <div class="text-xs text-amber-400 font-bold pr-3"><i class="fas fa-qrcode mr-1"></i> QRIS Tersimpan</div>
                                    </div>
                                @endif
                            </div>

                            {{-- PANEL AKSI: EDIT & HAPUS --}}
                            <div class="flex items-center justify-end gap-2 mt-5 pt-3 border-t border-white/5 opacity-80 group-hover:opacity-100 transition">
                                {{-- Tombol Edit --}}
                                <button type="button" onclick="editMethod({{ json_encode($method) }})" class="bg-blue-500/10 hover:bg-blue-500 text-blue-400 hover:text-slate-950 text-[10px] font-black uppercase tracking-wider px-3 py-1.5 rounded-lg transition flex items-center gap-1">
                                    <i class="fas fa-edit text-[9px]"></i> Edit
                                </button>

                                {{-- Form Hapus --}}
                                <form action="{{ route('admin.metode_pembayaran_delete', $method->id) }}" method="POST" onsubmit="return confirm('Apakah Yang Mulia yakin ingin menghapus metode pembayaran ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-500/10 hover:bg-red-500 text-red-400 hover:text-slate-950 text-[10px] font-black uppercase tracking-wider px-3 py-1.5 rounded-lg transition flex items-center gap-1">
                                        <i class="fas fa-trash text-[9px]"></i> Hapus
                                    </button>
                                </form>
                            </div>

                        </div>
                    @empty
                        <div class="col-span-1 sm:col-span-2 text-center py-12 border-2 border-dashed border-slate-800 rounded-2xl">
                            <i class="fas fa-wallet text-3xl text-slate-600 mb-3"></i>
                            <div class="text-slate-400 text-sm font-bold">Belum ada metode pembayaran</div>
                            <div class="text-slate-500 text-xs mt-1">Gunakan form di samping untuk menambahkan rekening atau QRIS.</div>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // 1. Fungsi Toggle Visibilitas Inputan
    function toggleFormInput(val) {
        if(val === 'qris') {
            document.getElementById('group_qris').classList.remove('hidden');
            document.getElementById('group_rekening').classList.add('hidden');
            document.getElementById('input_nomor').removeAttribute('required');
            document.getElementById('input_atas_nama').removeAttribute('required');
        } else {
            document.getElementById('group_qris').classList.add('hidden');
            document.getElementById('group_rekening').classList.remove('hidden');
            document.getElementById('input_nomor').setAttribute('required', 'required');
            document.getElementById('input_atas_nama').setAttribute('required', 'required');
        }
    }

    // 2. Fungsi Mengisi Data Form Saat Tombol Edit Ditekan
    function editMethod(data) {
        window.scrollTo({ top: 0, behavior: 'smooth' });

        // Ubah Teks Atribut Form
        document.getElementById('form_title').innerText = 'Edit';
        document.getElementById('form_icon').className = 'fas fa-pen-square text-blue-400 mr-2';
        document.getElementById('btn_batal').classList.remove('hidden');
        document.getElementById('btn_submit').innerText = 'UPDATE DATA';
        document.getElementById('btn_submit').className = 'w-full bg-blue-500 hover:bg-blue-600 text-slate-950 font-black tracking-widest py-3.5 rounded-xl text-xs transition mt-2 shadow-lg shadow-blue-500/20';

        // Masukkan value data ke form
        document.getElementById('method_id').value = data.id;
        document.getElementById('input_nama').value = data.nama;
        document.getElementById('input_kategori').value = data.kategori;
        document.getElementById('tipe_input').value = data.tipe;

        toggleFormInput(data.tipe);

        if(data.tipe === 'rekening') {
            document.getElementById('input_nomor').value = data.nomor;
            document.getElementById('input_atas_nama').value = data.atas_nama;
            document.getElementById('edit_qr_info').classList.add('hidden');
            document.getElementById('input_qr_code').removeAttribute('required');
        } else {
            document.getElementById('input_nomor').value = '';
            document.getElementById('input_atas_nama').value = '';
            document.getElementById('edit_qr_info').classList.remove('hidden');
            document.getElementById('input_qr_code').removeAttribute('required');
        }

        // Status Checkbox aktif / nonaktif
        document.getElementById('is_active').checked = (data.is_active == 1);
    }

    // 3. Fungsi Reset Form ke Mode "Tambah" Semula
    function resetForm() {
        document.getElementById('form_title').innerText = 'Tambah';
        document.getElementById('form_icon').className = 'fas fa-plus-circle text-emerald-400 mr-2';
        document.getElementById('btn_batal').classList.add('hidden');
        document.getElementById('btn_submit').innerText = 'SIMPAN DATA';
        document.getElementById('btn_submit').className = 'w-full bg-emerald-500 hover:bg-emerald-600 text-slate-950 font-black tracking-widest py-3.5 rounded-xl text-xs transition mt-2 shadow-lg shadow-emerald-500/20';

        document.getElementById('form_metode').reset();
        document.getElementById('method_id').value = '';
        toggleFormInput('rekening');
        document.getElementById('edit_qr_info').classList.add('hidden');

        // Reset tampilan upload file placeholder
        document.getElementById('qr_icon').className = 'fas fa-qrcode text-2xl text-slate-500 mb-2';
        document.getElementById('qr_text').innerText = 'Pilih File Gambar';
        document.getElementById('qr_subtext').innerText = 'PNG, JPG, JPEG';
    }

    // 4. Efek Interaktif Penamaan File QRIS saat Dipilih
    function previewFile(input) {
        if (input.files && input.files[0]) {
            document.getElementById('qr_icon').className = 'fas fa-check-circle text-2xl text-emerald-400 mb-2';
            document.getElementById('qr_text').innerText = input.files[0].name;
            document.getElementById('qr_subtext').innerText = 'File siap diunggah';
        }
    }

    // Inisialisasi awal saat halaman pertama kali dibuka
    document.addEventListener('DOMContentLoaded', function() {
        toggleFormInput(document.getElementById('tipe_input').value);
    });
</script>
@endsection
