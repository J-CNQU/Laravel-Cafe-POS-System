<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Settings - Kantin Digital</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap"
        rel="stylesheet">
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #F1F3F6;
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

        input[type="checkbox"]:checked {
            background-color: #0f172a;
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
                <header class="island-card p-10 lg:p-14">
                    <h1 class="text-4xl font-extrabold tracking-tighter text-slate-900">Sistem <span
                            class="text-slate-400 font-light">Settings</span></h1>
                    <p class="text-slate-400 font-bold uppercase tracking-[0.3em] text-[10px] mt-2 italic">Konfigurasi
                        Toko & Keamanan</p>
                </header>

                <div class="grid grid-cols-12 gap-10">
                    <div class="col-span-12 lg:col-span-7 island-card p-14 space-y-12">
                        <div class="space-y-4">
                            <h3 class="font-black uppercase tracking-widest text-sm text-slate-800">Identitas Kantin
                            </h3>
                            <div class="space-y-8">
                                <div class="space-y-3">
                                    <label
                                        class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-4">Nama
                                        Gerai</label>
                                    <input type="text" value="Kantin Digital Premium"
                                        class="w-full bg-slate-50 border-none rounded-[25px] py-6 px-8 font-bold text-slate-700 focus:ring-2 focus:ring-slate-100">
                                </div>
                                <div class="space-y-3">
                                    <label
                                        class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-4">Alamat
                                        Singkat</label>
                                    <input type="text" value="Gedung Utama, Lantai 1"
                                        class="w-full bg-slate-50 border-none rounded-[25px] py-6 px-8 font-bold text-slate-700 focus:ring-2 focus:ring-slate-100">
                                </div>
                            </div>
                        </div>

                        <div class="pt-8 border-t border-slate-50 space-y-6">
                            <div class="flex items-center justify-between p-6 bg-slate-50 rounded-[30px]">
                                <div>
                                    <p class="font-black text-slate-800 text-sm uppercase">Auto-Print Receipt</p>
                                    <p class="text-[10px] font-bold text-slate-400">Cetak struk otomatis setelah bayar
                                    </p>
                                </div>
                                <div class="w-14 h-8 bg-slate-900 rounded-full relative">
                                    <div class="absolute right-1 top-1 w-6 h-6 bg-white rounded-full"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-span-12 lg:col-span-5 space-y-10">
                        <div class="island-card p-12 bg-red-50 border-red-100">
                            <h4 class="font-black text-red-600 uppercase tracking-tighter text-lg mb-4">Zona Bahaya</h4>
                            <p class="text-xs font-bold text-red-400 leading-relaxed mb-8">Menghapus database akan
                                menghilangkan semua riwayat transaksi secara permanen.</p>
                            <button
                                class="w-full py-5 bg-white border-2 border-red-200 text-red-600 rounded-2xl font-black text-[10px] uppercase tracking-widest hover:bg-red-600 hover:text-white transition-all">
                                Reset Semua Data
                            </button>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
</body>

</html>