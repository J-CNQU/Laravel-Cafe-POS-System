<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Arsip Transaksi - Felix Kantin</title>
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

        .custom-scroll::-webkit-scrollbar {
            width: 6px;
        }

        .custom-scroll::-webkit-scrollbar-thumb {
            background: #E2E8F0;
            border-radius: 20px;
        }
    </style>
</head>

<body class="antialiased text-slate-800">

    <div class="min-h-screen p-6 lg:p-12">
        <div class="max-w-[1700px] mx-auto grid grid-cols-12 gap-10">

            <aside
                class="col-span-1 hidden xl:flex flex-col items-center py-12 island-card h-[fit-content] sticky top-10 z-50">
                <div class="w-16 h-16 bg-slate-900 rounded-[22px] flex items-center justify-center mb-16 shadow-2xl">
                    <i class="fas fa-bolt text-white text-2xl"></i>
                </div>
                <nav class="flex flex-col gap-12">
                    <a href="{{ route('pos.index') }}"
                        class="nav-link {{ request()->is('pos*') ? 'active' : '' }} text-2xl">
                        <i class="fas fa-th-large"></i>
                    </a>
                    <a href="{{ route('products.index') }}"
                        class="nav-link {{ request()->is('products*') ? 'active' : '' }} text-2xl">
                        <i class="fas fa-utensils"></i>
                    </a>
                    <a href="{{ route('history') }}"
                        class="nav-link {{ request()->is('history*') ? 'active' : '' }} text-2xl">
                        <i class="fas fa-history"></i>
                    </a>
                    <a href="{{ route('analytics') }}"
                        class="nav-link {{ request()->is('analytics*') ? 'active' : '' }} text-2xl">
                        <i class="fas fa-chart-line"></i>
                    </a>
                    <a href="#" class="nav-link text-2xl"><i class="fas fa-cog"></i></a>
                </nav>
            </aside>

            <main class="col-span-12 xl:col-span-11 space-y-8">
                <header class="island-card p-10 lg:p-14">
                    <div class="flex justify-between items-center">
                        <div>
                            <h1 class="text-5xl font-black tracking-tighter text-slate-950">RIWAYAT <span
                                    class="text-slate-300">PENJUALAN</span></h1>
                            <p class="text-slate-400 font-bold text-[11px] uppercase tracking-[0.4em] mt-2">Pusat Data
                                Transaksi Pelanggan</p>
                        </div>

                        <div class="flex items-center gap-4">
                            <form action="{{ route('history.clearAll') }}" method="POST"
                                onsubmit="return confirm('Hapus SEMUA riwayat? Ini tidak bisa dibatalkan!')">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="px-6 py-4 bg-red-50 text-red-500 rounded-[22px] font-black text-[10px] uppercase tracking-widest hover:bg-red-500 hover:text-white transition-all shadow-sm">
                                    <i class="fas fa-trash-alt mr-2"></i> Bersihkan Semua
                                </button>
                            </form>

                            <div class="flex bg-slate-50 p-2 rounded-[25px] gap-2">
                                <a href="?range=hari"
                                    class="px-8 py-4 {{ request()->range == 'hari' ? 'bg-white shadow-md text-slate-900' : 'text-slate-400' }} rounded-[20px] font-black text-[10px] uppercase tracking-widest transition-all">Hari
                                    Ini</a>
                                <a href="?range=minggu"
                                    class="px-8 py-4 {{ request()->range == 'minggu' ? 'bg-white shadow-md text-slate-900' : 'text-slate-400' }} rounded-[20px] font-black text-[10px] uppercase tracking-widest transition-all">Minggu
                                    Ini</a>
                            </div>
                        </div>
                    </div>
                </header>

                <div class="island-card overflow-hidden p-6">
                    <table class="w-full text-left border-separate border-spacing-y-4">
                        <thead>
                            <tr class="text-[11px] font-black text-slate-400 uppercase tracking-[0.2em]">
                                <th class="px-10 pb-2">Invoice</th>
                                <th class="pb-2">Rincian Menu</th>
                                <th class="pb-2">Waktu</th>
                                <th class="pb-2">Total</th>
                                <th class="pb-2 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($transactions as $trans)
                                @php
                                    // Memastikan items didecode dengan benar dari JSON
                                    $items = is_array($trans->items) ? $trans->items : json_decode($trans->items, true);
                                @endphp
                                <tr
                                    class="bg-slate-50/50 rounded-[35px] transition-all hover:bg-white hover:shadow-xl group border-2 border-transparent hover:border-slate-100">
                                    <td class="px-10 py-8 rounded-l-[35px]">
                                        <div class="flex flex-col">
                                            <span
                                                class="text-blue-600 font-mono font-black text-2xl tracking-tighter leading-none">
                                                {{ $trans->invoice_number }}
                                            </span>
                                            <span
                                                class="text-[9px] font-black text-slate-400 uppercase tracking-[0.2em] mt-1">
                                                KASIR: {{ $trans->user->name ?? 'ADMIN' }}
                                            </span>
                                        </div>
                                    </td>

                                    <td class="py-8">
                                        <div class="flex flex-col gap-2">
                                            @if(!empty($items) && is_array($items))
                                                @foreach($items as $item)
                                                    <div class="flex items-center gap-2">
                                                        <span
                                                            class="bg-blue-100 text-blue-600 px-2 py-0.5 rounded-lg text-[10px] font-bold">
                                                            {{ $item['qty'] ?? 1 }}x
                                                        </span>
                                                        <span class="text-[11px] font-bold text-slate-700">
                                                            {{ $item['name'] ?? 'Menu Tidak Diketahui' }}
                                                        </span>
                                                        <span class="text-[10px] text-slate-400">
                                                            @ Rp {{ number_format($item['price'] ?? 0, 0, ',', '.') }}
                                                        </span>
                                                    </div>
                                                @endforeach
                                            @else
                                                <span class="text-xs text-slate-400 italic">Tidak ada rincian data</span>
                                            @endif
                                        </div>
                                    </td>

                                    <td>
                                        <div class="flex flex-col">
                                            <span
                                                class="text-slate-900 font-bold text-sm">{{ $trans->created_at->format('d M Y') }}</span>
                                            <span class="text-[10px] font-medium text-slate-400 tracking-widest uppercase">
                                                {{ $trans->created_at->format('H:i') }} WIB
                                            </span>
                                        </div>
                                    </td>

                                    <td>
                                        <span class="text-2xl font-black text-slate-950 tracking-tighter">
                                            Rp{{ number_format($trans->total_price, 0, ',', '.') }}
                                        </span>
                                    </td>

                                    <td class="px-8 text-center rounded-r-[35px]">
                                        <div class="flex items-center justify-center gap-3">
                                            <button
                                                onclick="showDetail('{{ $trans->invoice_number }}', {{ json_encode($items) }}, {{ $trans->total_price }}, '{{ $trans->created_at->format('d M Y, H:i') }}')"
                                                class="w-11 h-11 bg-slate-950 text-white rounded-2xl flex items-center justify-center hover:bg-blue-600 transition-all shadow-lg active:scale-95">
                                                <i class="fas fa-receipt text-xs"></i>
                                            </button>

                                            <form action="{{ route('history.destroy', $trans->id) }}" method="POST"
                                                onsubmit="return confirm('Hapus transaksi ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="w-11 h-11 bg-white border-2 border-slate-100 text-red-400 rounded-2xl flex items-center justify-center hover:bg-red-50 hover:text-red-600 hover:border-red-100 transition-all shadow-sm">
                                                    <i class="fas fa-trash text-xs"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </main>
        </div>
    </div>

    <div id="modal-detail"
        class="fixed inset-0 bg-slate-950/80 backdrop-blur-xl hidden z-[1000] flex items-center justify-center p-6">
        <div class="bg-white rounded-[55px] max-w-xl w-full shadow-2xl overflow-hidden border-[10px] border-white">
            <div class="p-12">
                <div class="flex justify-between items-start mb-10">
                    <div>
                        <span id="detail-date"
                            class="text-[10px] font-black text-slate-400 uppercase tracking-[0.3em]">-- -- ----</span>
                        <h3 id="detail-invoice" class="text-4xl font-black tracking-tighter text-slate-950 mt-1">
                            #INV-XXXX</h3>
                    </div>
                    <div
                        class="w-16 h-16 bg-slate-900 text-white rounded-[24px] flex items-center justify-center text-2xl shadow-xl shadow-slate-200">
                        <i class="fas fa-file-invoice-dollar"></i>
                    </div>
                </div>
                <div id="detail-list" class="space-y-5 mb-10 max-h-[350px] overflow-y-auto pr-4 custom-scroll"></div>
                <div class="space-y-4 pt-6 border-t-4 border-dashed border-slate-50">
                    <div
                        class="flex justify-between items-center text-slate-400 font-bold text-xs uppercase tracking-widest">
                        <span>Metode Pembayaran</span>
                        <span class="text-slate-900">Tunai / Cash</span>
                    </div>
                    <div class="bg-slate-950 rounded-[35px] p-8 text-white flex justify-between items-center">
                        <span class="font-black text-slate-500 text-[10px] uppercase tracking-[0.3em]">Total
                            Akhir</span>
                        <span id="detail-total" class="text-4xl font-black tracking-tighter">Rp 0</span>
                    </div>
                </div>
                <button onclick="closeDetail()"
                    class="w-full mt-8 py-6 bg-slate-50 rounded-[28px] font-black text-[11px] uppercase tracking-[0.3em] text-slate-400 hover:bg-red-50 hover:text-red-600 transition-all">Tutup</button>
            </div>
        </div>
    </div>

    <script>
        function showDetail(invoice, items, total, date) {
            document.getElementById('detail-invoice').innerText = '#' + invoice;
            document.getElementById('detail-date').innerText = date;
            document.getElementById('detail-total').innerText = 'Rp ' + Number(total).toLocaleString('id-ID');
            let html = '';
            const itemArray = Array.isArray(items) ? items : [];
            itemArray.forEach(item => {
                html += `
                    <div class="flex justify-between items-center bg-slate-50 p-6 rounded-[30px] border-2 border-transparent hover:border-slate-100 transition-all">
                        <div class="flex items-center gap-4">
                            <div class="w-10 h-10 bg-white rounded-xl flex items-center justify-center font-black text-slate-900 text-xs shadow-sm">${item.qty}x</div>
                            <div>
                                <p class="font-black text-slate-900 text-sm uppercase tracking-tighter">${item.name || 'Produk'}</p>
                                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">@ Rp ${Number(item.price).toLocaleString('id-ID')}</p>
                            </div>
                        </div>
                        <span class="font-black text-slate-900 text-lg tracking-tighter">Rp ${(item.qty * item.price).toLocaleString('id-ID')}</span>
                    </div>`;
            });
            document.getElementById('detail-list').innerHTML = html || '<p class="text-center py-10">Data kosong</p>';
            document.getElementById('modal-detail').classList.remove('hidden');
        }
        function closeDetail() { document.getElementById('modal-detail').classList.add('hidden'); }
    </script>
</body>

</html>