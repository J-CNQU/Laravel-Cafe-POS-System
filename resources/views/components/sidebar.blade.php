<aside class="fixed left-0 top-0 h-screen w-64 bg-slate-900 text-white p-6 z-50 no-print">
    <div class="mb-10 px-4">
        <h2 class="text-2xl font-black tracking-tighter italic text-white">FELIX<span
                class="text-emerald-400">POS</span></h2>
        <div class="mt-4 p-3 bg-slate-800 rounded-xl">
            <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest">Login Sebagai:</p>
            <p class="text-xs font-black text-emerald-400 uppercase">{{ Auth::user()->name }}</p>
            <p class="text-[9px] text-slate-500 font-bold uppercase">Role: {{ Auth::user()->role }}</p>
        </div>
    </div>

    <nav class="space-y-2">
        <a href="/pos"
            class="flex items-center gap-4 px-4 py-3 rounded-xl hover:bg-slate-800 transition-all font-bold text-sm {{ request()->is('pos*') ? 'bg-emerald-500 text-white shadow-lg shadow-emerald-500/20' : 'text-slate-400' }}">
            <i class="fas fa-cash-register w-5 text-center"></i> POS (Kasir)
        </a>

        <a href="/history"
            class="flex items-center gap-4 px-4 py-3 rounded-xl hover:bg-slate-800 transition-all font-bold text-sm {{ request()->is('history*') ? 'bg-emerald-500 text-white shadow-lg shadow-emerald-500/20' : 'text-slate-400' }}">
            <i class="fas fa-history w-5 text-center"></i> Riwayat Transaksi
        </a>

        @if(in_array(Auth::user()->role, ['admin', 'dapur']))
            <a href="/kitchen"
                class="flex items-center gap-4 px-4 py-3 rounded-xl hover:bg-slate-800 transition-all font-bold text-sm {{ request()->is('kitchen*') ? 'bg-emerald-500 text-white' : 'text-slate-400' }}">
                <i class="fas fa-utensils w-5 text-center"></i> Pesanan Dapur
            </a>
        @endif

        <hr class="border-slate-800 my-6">

        @if(Auth::user()->role == 'admin')
            <p class="text-[10px] font-black text-slate-600 uppercase tracking-widest px-4 mb-2">Owner Management</p>
            <a href="/analytics"
                class="flex items-center gap-4 px-4 py-3 rounded-xl hover:bg-slate-800 transition-all font-bold text-sm text-slate-400">
                <i class="fas fa-chart-line w-5 text-center"></i> Analytics
            </a>
            <a href="/products"
                class="flex items-center gap-4 px-4 py-3 rounded-xl hover:bg-slate-800 transition-all font-bold text-sm text-slate-400">
                <i class="fas fa-hamburger w-5 text-center"></i> Kelola Menu Makanan
            </a>
            <a href="/users"
                class="flex items-center gap-4 px-4 py-3 rounded-xl hover:bg-slate-800 transition-all font-bold text-sm text-slate-400">
                <i class="fas fa-users-cog w-5 text-center"></i> Kelola Karyawan
            </a>
        @endif
    </nav>

    <div class="absolute bottom-8 left-6 right-6">
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit"
                class="w-full flex items-center justify-center gap-3 bg-red-500/10 text-red-500 py-3 rounded-xl font-bold text-sm hover:bg-red-500 hover:text-white transition-all">
                <i class="fas fa-sign-out-alt"></i> Keluar
            </button>
        </form>
    </div>
</aside>

<style>
    body {
        padding-left: 16rem;
    }

    @media print {
        body {
            padding-left: 0;
        }
    }
</style>