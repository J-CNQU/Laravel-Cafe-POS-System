<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Analytics - Felix Kantin</title>
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

        .stat-card {
            transition: all 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-5px);
        }

        .tab-content {
            transition: all 0.5s ease;
        }
    </style>
</head>

<body class="antialiased text-slate-800">
    <div class="min-h-screen p-8 lg:p-12">
        <div class="max-w-[1700px] mx-auto grid grid-cols-12 gap-10">

            <aside
                class="col-span-1 hidden xl:flex flex-col items-center py-12 island-card h-[fit-content] sticky top-10 z-50">
                <div class="w-16 h-16 bg-slate-900 rounded-[22px] flex items-center justify-center mb-16 shadow-2xl">
                    <i class="fas fa-bolt text-white text-2xl"></i>
                </div>

                <nav class="flex flex-col gap-12">
                    <a href="{{ route('pos.index') }}"
                        class="nav-link {{ request()->is('pos*') ? 'active' : '' }} text-2xl" title="Kasir">
                        <i class="fas fa-th-large"></i>
                    </a>
                    <a href="{{ route('products.index') }}"
                        class="nav-link {{ request()->is('products*') ? 'active' : '' }} text-2xl" title="Menu">
                        <i class="fas fa-utensils"></i>
                    </a>
                    <a href="{{ route('history') }}"
                        class="nav-link {{ request()->is('history*') ? 'active' : '' }} text-2xl" title="Riwayat">
                        <i class="fas fa-history"></i>
                    </a>
                    <a href="{{ route('analytics') }}"
                        class="nav-link {{ request()->is('analytics*') ? 'active' : '' }} text-2xl" title="Analytics">
                        <i class="fas fa-chart-line"></i>
                    </a>
                    <a href="{{ route('settings') }}"
                        class="nav-link {{ request()->is('settings*') ? 'active' : '' }} text-2xl" title="Settings">
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

                <header class="island-card p-10 lg:p-14">
                    <h1 class="text-4xl font-extrabold tracking-tighter text-slate-900">DATA <span
                            class="text-slate-400 font-light">ANALYTICS</span></h1>
                    <p
                        class="text-slate-400 font-bold uppercase tracking-[0.3em] text-[10px] mt-2 italic text-blue-600">
                        Laporan Keuangan & Performa Produk Real-time
                    </p>
                </header>

                <div class="island-card p-4 flex gap-4 bg-white/50 border-slate-50 shadow-inner">
                    <button onclick="switchTab('harian')" id="btn-harian"
                        class="tab-btn flex-1 py-5 rounded-[25px] font-black text-[11px] tracking-[0.3em] uppercase transition-all bg-slate-900 text-white shadow-2xl">HARIAN</button>
                    <button onclick="switchTab('mingguan')" id="btn-mingguan"
                        class="tab-btn flex-1 py-5 rounded-[25px] font-black text-[11px] tracking-[0.3em] uppercase transition-all text-slate-400 hover:text-slate-900">MINGGUAN</button>
                    <button onclick="switchTab('bulanan')" id="btn-bulanan"
                        class="tab-btn flex-1 py-5 rounded-[25px] font-black text-[11px] tracking-[0.3em] uppercase transition-all text-slate-400 hover:text-slate-900">BULANAN</button>
                </div>

                <div id="tab-container" class="relative">
                    <div id="content-harian" class="tab-content opacity-100">
                        <div class="island-card p-16 stat-card bg-white border-l-[20px] border-l-blue-600">
                            <span class="text-[11px] font-black uppercase tracking-[0.5em] text-slate-400">Pendapatan
                                Hari Ini</span>
                            <h2 class="text-7xl font-black tracking-tighter mt-6 text-slate-900">Rp
                                {{ number_format($earningToday, 0, ',', '.') }}</h2>
                            <div class="flex items-center gap-6 mt-10">
                                <span
                                    class="bg-blue-600 text-white px-8 py-3 rounded-full font-black text-[11px] uppercase tracking-widest">
                                    {{ $count }} TRANSAKSI
                                </span>
                            </div>
                        </div>
                    </div>

                    <div id="content-mingguan" class="tab-content hidden opacity-0">
                        <div class="island-card p-16 stat-card bg-white border-l-[20px] border-l-emerald-500">
                            <span class="text-[11px] font-black uppercase tracking-[0.5em] text-slate-400">Total 7 Hari
                                Terakhir</span>
                            <h2 class="text-7xl font-black tracking-tighter mt-6 text-emerald-600">Rp
                                {{ number_format($earningWeek, 0, ',', '.') }}</h2>
                            <div class="mt-10 flex items-center gap-4 text-slate-400">
                                <i class="fas fa-calendar-alt text-2xl"></i>
                                <p class="text-[11px] font-black uppercase tracking-widest">Akumulasi Penjualan Seminggu
                                </p>
                            </div>
                        </div>
                    </div>

                    <div id="content-bulanan" class="tab-content hidden opacity-0">
                        <div class="island-card p-16 stat-card bg-slate-900 text-white border-none shadow-2xl">
                            <span class="text-[11px] font-black uppercase tracking-[0.5em] text-blue-400">Laporan Bulan
                                Ini</span>
                            <h2 class="text-7xl font-black tracking-tighter mt-6">Rp
                                {{ number_format($earningMonth, 0, ',', '.') }}</h2>
                            <div class="mt-10 flex items-center gap-6">
                                <div
                                    class="w-14 h-14 bg-white/10 rounded-3xl flex items-center justify-center border border-white/20">
                                    <i class="fas fa-chart-line text-blue-400 text-xl"></i>
                                </div>
                                <div>
                                    <p class="text-[12px] font-black uppercase tracking-widest text-slate-300">
                                        {{ $bestSeller }}</p>
                                    <p class="text-[9px] font-bold uppercase text-slate-500 tracking-widest italic">
                                        Produk Paling Laris</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="island-card p-12 mt-10">
                    <div class="flex justify-between items-center mb-10 border-b-4 border-slate-50 pb-8">
                        <div>
                            <h3 class="text-3xl font-black tracking-tighter text-slate-900">PERFORMA PRODUK</h3>
                            <p
                                class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-1 text-emerald-500 italic">
                                Daftar Menu Terlaris & Total Omzet</p>
                        </div>
                        <div class="w-16 h-16 bg-amber-50 rounded-3xl flex items-center justify-center">
                            <i class="fas fa-trophy text-amber-500 text-2xl"></i>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 gap-4">
                        @forelse($productStats as $name => $stat)
                            <div
                                class="flex justify-between items-center p-6 bg-slate-50 rounded-[35px] border-2 border-transparent hover:border-blue-200 hover:bg-white transition-all group shadow-sm hover:shadow-xl">
                                <div class="flex items-center gap-6">
                                    <div
                                        class="w-16 h-16 bg-white rounded-[22px] flex flex-col items-center justify-center font-black text-slate-900 shadow-sm group-hover:bg-slate-900 group-hover:text-white transition-all border border-slate-100">
                                        <span class="text-lg leading-none">{{ $stat['qty'] }}</span>
                                        <span class="text-[8px] uppercase tracking-tighter">Terjual</span>
                                    </div>
                                    <div>
                                        <h4 class="font-black text-slate-900 uppercase tracking-tighter text-xl">{{ $name }}
                                        </h4>
                                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Harga
                                            Satuan: Rp {{ number_format($stat['price'], 0, ',', '.') }}</p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-1">
                                        Subtotal Omzet</p>
                                    <p
                                        class="text-3xl font-black text-slate-950 tracking-tighter group-hover:text-blue-600 transition-all">
                                        Rp {{ number_format($stat['revenue'], 0, ',', '.') }}</p>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-20">
                                <i class="fas fa-box-open text-slate-200 text-6xl mb-4"></i>
                                <p class="text-slate-400 font-bold uppercase tracking-widest">Belum ada data penjualan</p>
                            </div>
                        @endforelse
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-8">
                    <div class="island-card p-10 flex items-center justify-between">
                        <div class="text-left">
                            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Status Server</p>
                            <p class="text-sm font-black text-emerald-500 uppercase mt-1">Sangat Sehat</p>
                        </div>
                        <i class="fas fa-server text-slate-100 text-4xl"></i>
                    </div>
                    <div class="island-card p-10 flex items-center justify-between">
                        <div class="text-left">
                            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Juara Menu</p>
                            <p class="text-sm font-black text-slate-900 uppercase mt-1">{{ $bestSeller }}
                                ({{ $bestSellerQty }}x)</p>
                        </div>
                        <i class="fas fa-fire text-orange-400 text-4xl animate-pulse"></i>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <script>
        function switchTab(target) {
            // Hide all
            document.querySelectorAll('.tab-content').forEach(content => {
                content.classList.add('hidden');
                content.classList.replace('opacity-100', 'opacity-0');
            });

            // Show selected
            const selected = document.getElementById('content-' + target);
            selected.classList.remove('hidden');
            setTimeout(() => selected.classList.replace('opacity-0', 'opacity-100'), 10);

            // Update buttons
            document.querySelectorAll('.tab-btn').forEach(btn => {
                btn.classList.remove('bg-slate-900', 'text-white', 'shadow-2xl');
                btn.classList.add('text-slate-400');
            });

            const activeBtn = document.getElementById('btn-' + target);
            activeBtn.classList.add('bg-slate-900', 'text-white', 'shadow-2xl');
            activeBtn.classList.remove('text-slate-400');
        }
    </script>
</body>

</html>