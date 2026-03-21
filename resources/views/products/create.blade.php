<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kantin Digital - Tambah Menu Baru</title>
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

        input focus,
        select focus {
            box-shadow: 0 0 0 4px rgba(15, 23, 42, 0.05);
        }
    </style>
</head>

<body class="antialiased text-slate-800">

    <div class="min-h-screen p-8 lg:p-20">
        <div class="max-w-4xl mx-auto space-y-12">

            <header class="island-card p-12 lg:p-16 flex justify-between items-center border-b-8 border-slate-200">
                <div class="space-y-2">
                    <h1 class="text-5xl font-extrabold tracking-tighter text-slate-900">Input <span
                            class="text-slate-400 font-light">Menu</span></h1>
                    <p class="text-slate-400 font-bold uppercase tracking-[0.3em] text-[10px] mt-2">Manajemen Inventaris
                        Digital</p>
                </div>
                <a href="{{ route('pos.index') }}"
                    class="flex items-center gap-3 bg-slate-900 text-white px-8 py-5 rounded-[25px] font-black text-xs hover:bg-slate-700 transition-all shadow-xl shadow-slate-200 active:scale-95">
                    <i class="fas fa-arrow-left"></i> KEMBALI KE KASIR
                </a>
            </header>

            <div class="island-card p-12 lg:p-20 relative overflow-hidden">
                <div class="absolute top-0 right-0 w-64 h-64 bg-slate-50 rounded-full blur-3xl -mr-32 -mt-32 -z-10">
                </div>

                <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data"
                    class="space-y-12">
                    @csrf

                    <div class="space-y-6">
                        <label class="text-[21px] font-black text-slate-400 uppercase tracking-[0.4em] ml-6">Nama Produk
                            Menu</label>
                        <input type="text" name="name" placeholder="Masukan nama kopi atau makanan..." required
                            class="w-full bg-slate-50 border-4 border-slate-200 rounded-[35px] py-8 px-12 focus:bg-white focus:border-slate-100 focus:ring-0 font-bold text-lg text-slate-700 transition-all outline-none">
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
                        <div class="space-y-6">
                            <label class="text-[11px] font-black text-slate-400 uppercase tracking-[0.4em] ml-6">Harga
                                Jual (Rp)</label>
                            <div class="relative">
                                <span
                                    class="absolute left-10 top-1/2 -translate-y-1/2 font-black text-slate-300">Rp</span>
                                <input type="number" name="price" placeholder="15000" required
                                    class="w-full bg-slate-50 border-4 border-slate-200 rounded-[35px] py-8 pl-20 pr-12 focus:bg-white focus:border-slate-100 focus:ring-0 font-bold text-lg text-slate-700 transition-all outline-none">
                            </div>
                        </div>
                        <div class="space-y-6">
                            <label class="text-[11px] font-black text-slate-400 uppercase tracking-[0.4em] ml-6">Stok
                                Inventaris</label>
                            <input type="number" name="stock" placeholder="0" required
                                class="w-full bg-slate-50 border-4 border-slate-200 rounded-[35px] py-8 px-12 focus:bg-white focus:border-slate-100 focus:ring-0 font-bold text-lg text-slate-700 transition-all outline-none">
                        </div>
                    </div>

                    <div class="space-y-6">
                        <label class="text-[11px] font-black text-slate-400 uppercase tracking-[0.4em] ml-6">Kategori
                            Produk</label>
                        <div class="relative">
                            <select name="category" required
                                class="w-full bg-slate-50 border-4 border-slate-200 rounded-[35px] py-8 px-12 focus:bg-white focus:border-slate-100 focus:ring-0 font-bold text-lg text-slate-700 transition-all outline-none appearance-none">
                                <option value="Makanan">Makanan</option>
                                <option value="Minuman">Minuman</option>
                            </select>
                            <i
                                class="fas fa-chevron-down absolute right-12 top-1/2 -translate-y-1/2 text-slate-300 pointer-events-none"></i>
                        </div>
                    </div>

                    <div class="pt-8 flex flex-col items-center gap-8">
                        <button type="submit"
                            class="w-full bg-blue-600 text-white font-black py-9 rounded-[40px] shadow-2xl shadow-blue-200 hover:bg-blue-700 hover:translate-y-[-5px] transition-all uppercase tracking-[0.6em] text-xs active:scale-95">
                            SIMPAN MENU BARU
                        </button>
                        <p class="text-[10px] font-black text-slate-300 uppercase tracking-widest italic">Data akan
                            langsung tersinkronisasi dengan mesin kasir</p>
                    </div>
                </form>
            </div>

        </div>
    </div>

</body>

</html>