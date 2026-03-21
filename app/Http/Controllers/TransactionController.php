<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>History Transaksi - Felix Kantin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap"
        rel="stylesheet">

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        @media print {
            .no-print {
                display: none !important;
            }

            .print-only {
                display: block !important;
            }

            body {
                background: white;
                p: 0;
            }

            .island-card {
                border: none;
                shadow: none;
            }
        }
    </style>
</head>

<body class="bg-slate-100 p-6 lg:p-12">
    <div class="max-w-6xl mx-auto space-y-10">

        <header class="flex justify-between items-center no-print">
            <div class="space-y-1">
                <h1 class="text-4xl font-extrabold tracking-tighter text-slate-900">RIWAYAT <span
                        class="text-slate-400 font-light">PESANAN</span></h1>
                <p class="text-slate-500 text-xs font-bold uppercase tracking-[0.2em]">Felix Kantin POS System</p>
            </div>
            <div class="flex gap-4">
                <a href="{{ route('pos.index') }}"
                    class="bg-white text-slate-900 border-2 border-slate-200 px-6 py-3 rounded-2 font-bold hover:bg-slate-50 transition-all flex items-center">
                    <i class="fas fa-arrow-left mr-2"></i> KEMBALI
                </a>
                <button onclick="window.print()"
                    class="bg-slate-900 text-white px-8 py-3 rounded-2xl font-black text-xs uppercase tracking-widest hover:bg-slate-800 transition-all shadow-xl shadow-slate-200">
                    <i class="fas fa-print mr-2"></i> Cetak Laporan
                </button>
            </div>
        </header>

        <div class="bg-white rounded-[40px] shadow-sm overflow-hidden border-4 border-white island-card">
            <table class="w-full text-left border-collapse">
                <thead class="bg-slate-50 border-b border-slate-100">
                    <tr class="text-[10px] font-black uppercase tracking-widest text-slate-400">
                        <th class="p-8">No. Invoice</th>
                        <th>Waktu</th>
                        <th>Detail Pesanan</th>
                        <th>Total Harga</th>
                        <th>Status</th>
                        <th class="text-center no-print">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($transactions as $trx)
                    <tr
                        class="{{ $trx->trashed() ? 'bg-red-50/50 opacity-60' : 'hover:bg-slate-50/50' }} transition-colors">
                        <td class="p-8 font-black text-slate-800 tracking-tighter">
                            {{ $trx->invoice_number }}
                        </td>
                        <td class="text-xs font-bold text-slate-500">
                            {{ $trx->created_at->format('d/m/Y') }}<br>
                            <span class="text-[10px] opacity-60">{{ $trx->created_at->format('H:i') }} WIB</span>
                        </td>
                        <td class="py-6">
                            <ul class="space-y-1">
                                @foreach($trx->items as $item)
                                <li class="flex items-center gap-2">
                                    <span
                                        class="w-5 h-5 bg-slate-100 rounded flex items-center justify-center text-[9px] font-black text-slate-500">{{
                                        $item['qty'] }}x</span>
                                    <span class="text-xs font-bold text-slate-600 uppercase tracking-tight">{{
                                        $item['name'] }}</span>
                                </li>
                                @endforeach
                            </ul>
                        </td>
                        <td class="font-black text-slate-900 text-lg tracking-tighter">
                            Rp {{ number_format($trx->total_price, 0, ',', '.') }}
                        </td>
                        <td>
                            @if($trx->trashed())
                            <span
                                class="text-[9px] bg-red-100 text-red-600 px-4 py-1.5 rounded-full font-black tracking-widest">DIHAPUS</span>
                            @else
                            <span
                                class="text-[9px] bg-emerald-100 text-emerald-600 px-4 py-1.5 rounded-full font-black tracking-widest">BERHASIL</span>
                            @endif
                        </td>
                        <td class="text-center no-print">
                            <div class="flex justify-center items-center gap-3">
                                @if($trx->trashed())
                                <form action="{{ route('history.restore', $trx->id) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit"
                                        class="text-blue-500 text-[10px] font-black uppercase tracking-widest hover:underline">
                                        <i class="fas fa-undo-alt mr-1"></i> Restore
                                    </button>
                                </form>
                                @else
                                <button onclick="window.print()"
                                    class="w-10 h-10 flex items-center justify-center bg-slate-100 text-slate-500 rounded-xl hover:bg-slate-900 hover:text-white transition-all">
                                    <i class="fas fa-receipt text-xs"></i>
                                </button>

                                <form action="{{ route('history.destroy', $trx->id) }}" method="POST" class="inline"
                                    onsubmit="return confirm('Pindahkan transaksi ini ke tempat sampah?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="w-10 h-10 flex items-center justify-center bg-red-50 text-red-400 rounded-xl hover:bg-red-500 hover:text-white transition-all">
                                        <i class="fas fa-trash-alt text-xs"></i>
                                    </button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="p-20 text-center">
                            <div class="flex flex-col items-center opacity-20">
                                <i class="fas fa-receipt text-6xl mb-4"></i>
                                <p class="font-black uppercase tracking-[0.3em] text-sm">Belum ada data transaksi</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <footer class="hidden print-only mt-10 text-center border-t pt-8">
            <p class="text-sm font-bold">Laporan Dicetak Pada: {{ now()->format('d M Y H:i:s') }}</p>
            <p class="text-xs text-slate-500">Felix Kantin POS - Official Report</p>
        </footer>
    </div>
</body>

</html>