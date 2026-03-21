<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Menu - Kantin Digital</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap"
        rel="stylesheet">

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #F1F3F6;
            overflow-x: hidden;
        }

        .island-card {
            background: white;
            border: 4px solid #FFFFFF;
            border-radius: 40px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.04);
        }

        .nav-link {
            transition: all 0.4s ease;
            position: relative;
            color: #CBD5E1;
        }

        .nav-link.active {
            color: #0f172a;
            transform: scale(1.2);
        }

        .nav-link.active::after {
            content: '';
            position: absolute;
            right: -25px;
            width: 5px;
            height: 20px;
            background: #0f172a;
            border-radius: 10px;
        }

        input:focus,
        select:focus {
            background-color: white !important;
            border-color: #F1F5F9 !important;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.02) !important;
        }

        .btn-update {
            background: #2563eb;
            box-shadow: 0 20px 40px -10px rgba(37, 99, 235, 0.3);
            transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }

        .btn-update:hover {
            transform: translateY(-5px);
            background: #1d4ed8;
        }
    </style>
</head>

<body class="antialiased text-slate-800">

    <div class="min-h-screen p-8 lg:p-12">
        <div class="max-w-[1700px] mx-auto grid grid-cols-12 gap-10">

            <aside
                class="col-span-1 hidden xl:flex flex-col items-center py-12 island-card h-[fit-content] sticky top-10 z-50">
                <div
                    class="w-16 h-16 bg-slate-900 rounded-[22px] flex items-center justify-center mb-16 shadow-2xl shadow-slate-300">
                    <i class="fas fa-bolt text-white text-2xl"></i>
                </div>

                <nav class="flex flex-col gap-12">
                    <a href="{{ route('pos.index') }}"
                        class="nav-link {{ request()->is('pos*') ? 'active' : '' }} text-2xl" title="Kasir">
                        <i class="fas fa-th-large"></i>
                    </a>

                    @if(Auth::user()->role == 'admin' || Auth::user()->role == 'kasir')
                        <a href="{{ route('products.index') }}"
                            class="nav-link {{ request()->is('products*') ? 'active' : '' }} text-2xl" title="Menu Makanan">
                            <i class="fas fa-utensils"></i>
                        </a>
                    @endif

                    <a href="{{ route('history') }}"
                        class="nav-link {{ request()->is('history*') ? 'active' : '' }} text-2xl" title="Riwayat">
                        <i class="fas fa-history"></i>
                    </a>

                    <a href="{{ route('analytics') }}"
                        class="nav-link {{ request()->is('analytics*') ? 'active' : '' }} text-2xl" title="Analytics">
                        <i class="fas fa-chart-line"></i>
                    </a>

                    <a href="{{ route('settings') }}"
                        class="nav-link {{ request()->is('settings*') ? 'active' : '' }} text-2xl" title="Pengaturan">
                        <i class="fas fa-cog"></i>
                    </a>

                </nav>

                <div class="mt-32">
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit"
                            class="w-12 h-12 flex items-center justify-center rounded-2xl text-red-400 hover:bg-red-50 transition-all text-xl">
                            <i class="fas fa-power-off"></i>
                        </button>
                    </form>
                </div>
            </aside>

            <main class="col-span-12 xl:col-span-11 space-y-10">

                <header class="island-card p-10 lg:p-14 flex justify-between items-center">
                    <div class="flex items-center gap-10">
                        <div
                            class="w-24 h-24 bg-slate-50 rounded-[35px] flex items-center justify-center border-4 border-white shadow-inner">
                            <i class="fas fa-pen-nib text-slate-300 text-3xl"></i>
                        </div>
                        <div>
                            <h1 class="text-5xl font-extrabold tracking-tighter text-slate-900">Perbarui <span
                                    class="text-slate-400 font-light">Menu</span></h1>
                            <p class="text-slate-400 font-bold uppercase tracking-[0.3em] text-[10px] mt-2 italic">
                                Sedang mengedit: {{ $product->name }}</p>
                        </div>
                    </div>
                    <a href="{{ route('products.index') }}"
                        class="group flex items-center gap-4 bg-slate-100 text-slate-500 pl-8 pr-3 py-3 rounded-[30px] font-black text-xs hover:bg-slate-900 hover:text-white transition-all active:scale-95">
                        KEMBALI KE DAFTAR
                        <span
                            class="w-10 h-10 bg-white/50 group-hover:bg-white/10 rounded-full flex items-center justify-center transition-colors">
                            <i class="fas fa-arrow-left"></i>
                        </span>
                    </a>
                </header>

                <div class="grid grid-cols-12 gap-10">
                    <div class="col-span-12 lg:col-span-8 island-card p-12 lg:p-20 relative overflow-hidden">
                        <div class="absolute -top-24 -right-24 w-80 h-80 bg-slate-50 rounded-full blur-3xl opacity-50">
                        </div>

                        <form action="{{ route('products.update', $product->id) }}" method="POST"
                            class="space-y-12 relative z-10">
                            @csrf
                            @method('PUT')

                            <div class="space-y-6">
                                <label
                                    class="text-[11px] font-black text-slate-400 uppercase tracking-[0.4em] ml-8 flex items-center gap-3">
                                    <span class="w-2 h-2 bg-blue-500 rounded-full"></span> Nama Produk
                                </label>
                                <input type="text" name="name" value="{{ $product->name }}" required
                                    class="w-full bg-slate-50 border-4 border-slate-50 rounded-[40px] py-9 px-12 font-bold text-xl text-slate-800 transition-all outline-none">
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
                                <div class="space-y-6">
                                    <label
                                        class="text-[11px] font-black text-slate-400 uppercase tracking-[0.4em] ml-8 flex items-center gap-3">
                                        <span class="w-2 h-2 bg-emerald-500 rounded-full"></span> Harga Jual (Rp)
                                    </label>
                                    <div class="relative">
                                        <span
                                            class="absolute left-10 top-1/2 -translate-y-1/2 font-black text-slate-300 text-lg">Rp</span>
                                        <input type="number" name="price" value="{{ $product->price }}" required
                                            class="w-full bg-slate-50 border-4 border-slate-50 rounded-[40px] py-9 pl-24 pr-12 font-bold text-xl text-slate-800 transition-all outline-none">
                                    </div>
                                </div>
                                <div class="space-y-6">
                                    <label
                                        class="text-[11px] font-black text-slate-400 uppercase tracking-[0.4em] ml-8 flex items-center gap-3">
                                        <span class="w-2 h-2 bg-orange-500 rounded-full"></span> Stok Tersedia
                                    </label>
                                    <input type="number" name="stock" value="{{ $product->stock }}" required
                                        class="w-full bg-slate-50 border-4 border-slate-50 rounded-[40px] py-9 px-12 font-bold text-xl text-slate-800 transition-all outline-none">
                                </div>
                            </div>

                            <div class="space-y-6">
                                <label
                                    class="text-[11px] font-black text-slate-400 uppercase tracking-[0.4em] ml-8 flex items-center gap-3">
                                    <span class="w-2 h-2 bg-purple-500 rounded-full"></span> Kategori Produk
                                </label>
                                <div class="relative">
                                    <select name="category" required
                                        class="w-full bg-slate-50 border-4 border-slate-50 rounded-[40px] py-9 px-12 font-bold text-xl text-slate-800 transition-all outline-none appearance-none cursor-pointer">
                                        <option value="Makanan" {{ $product->category == 'Makanan' ? 'selected' : '' }}>
                                            Makanan</option>
                                        <option value="Minuman" {{ $product->category == 'Minuman' ? 'selected' : '' }}>
                                            Minuman</option>
                                    </select>
                                    <i
                                        class="fas fa-chevron-down absolute right-12 top-1/2 -translate-y-1/2 text-slate-300 pointer-events-none"></i>
                                </div>
                            </div>

                            <div class="pt-10 flex flex-col items-center gap-8">
                                <button type="submit"
                                    class="btn-update w-full text-white font-black py-10 rounded-[45px] uppercase tracking-[0.6em] text-xs active:scale-95">
                                    SIMPAN PERUBAHAN DATA
                                </button>
                                <div class="flex items-center gap-4">
                                    <div class="w-12 h-[1px] bg-slate-100"></div>
                                    <p class="text-[10px] font-black text-slate-300 uppercase tracking-widest">Sistem
                                        POS Premium</p>
                                    <div class="w-12 h-[1px] bg-slate-100"></div>
                                </div>
                            </div>
                        </form>
                    </div>

                    <div class="col-span-12 lg:col-span-4 space-y-10">
                        <div class="island-card p-12 text-center relative overflow-hidden group">
                            <div
                                class="absolute inset-0 bg-slate-900 opacity-0 group-hover:opacity-[0.02] transition-opacity">
                            </div>
                            <div
                                class="w-48 h-48 bg-slate-50 rounded-[60px] mx-auto mb-10 border-4 border-white shadow-xl flex items-center justify-center transform group-hover:rotate-6 transition-transform">
                                <i
                                    class="fas {{ strtolower($product->category) == 'minuman' ? 'fa-coffee text-blue-400' : 'fa-utensils text-orange-400' }} text-6xl"></i>
                            </div>
                            <h3 class="text-3xl font-black text-slate-800 uppercase tracking-tighter">
                                {{ $product->name }}</h3>
                            <div class="mt-4 flex justify-center gap-2">
                                <span
                                    class="px-4 py-1 bg-slate-100 rounded-full text-[10px] font-black text-slate-400 uppercase tracking-widest">{{ $product->category }}</span>
                            </div>
                        </div>

                        <div class="island-card p-12 bg-slate-900 text-white relative overflow-hidden">
                            <i
                                class="fas fa-shield-alt absolute -right-4 -bottom-4 text-9xl text-white/5 rotate-12"></i>
                            <h4 class="text-lg font-black uppercase tracking-tighter mb-4">Informasi Keamanan</h4>
                            <p class="text-xs text-slate-400 leading-relaxed font-bold italic">Update data menu akan
                                langsung merubah tampilan di layar kasir secara real-time. Pastikan input harga sudah
                                benar sebelum menyimpan.</p>
                        </div>
                    </div>
                </div>

                <footer
                    class="flex justify-between items-center px-10 text-[10px] font-black text-slate-300 uppercase tracking-[0.5em] pt-10">
                    <p>© 2024 DIGITAL CANTEEN SYSTEM</p>
                    <p>REVISION_LOG: #UPD-{{ $product->id }}</p>
                </footer>
            </main>
        </div>
    </div>

</body>

</html>