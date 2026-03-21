<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Menu - Felix Kantin</title>
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

        /* Navigasi Styling */
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

        /* Table Styling */
        tr {
            transition: all 0.3s ease;
        }

        tr:hover {
            transform: scale(1.005);
            background-color: #f8fafc;
        }

        .input-custom {
            background-color: #f8fafc;
            border: 2px solid transparent;
            transition: all 0.3s ease;
        }

        .input-custom:focus {
            background-color: white;
            border-color: #3b82f6;
            outline: none;
            box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1);
        }
    </style>
</head>

<body class="antialiased text-slate-800 p-6 lg:p-12">

    <div class="max-w-[1700px] mx-auto grid grid-cols-12 gap-10">

        <aside
            class="col-span-1 hidden xl:flex flex-col items-center py-12 island-card h-[fit-content] sticky top-10 z-50">
            <div
                class="w-16 h-16 bg-slate-900 rounded-[22px] flex items-center justify-center mb-16 shadow-2xl shadow-slate-300">
                <i class="fas fa-bolt text-white text-2xl"></i>
            </div>

            <nav class="flex flex-col gap-12">
                <a href="{{ route('pos.index') }}" class="nav-link {{ request()->is('pos*') ? 'active' : '' }} text-2xl"
                    title="Kasir">
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

            <div class="flex justify-between items-end">
                <div class="space-y-2">
                    <h1 class="text-5xl font-extrabold tracking-tighter text-slate-900">Manajemen <span
                            class="text-slate-300">Menu</span></h1>
                    <p class="text-slate-400 font-bold uppercase tracking-[0.3em] text-[10px]">Total Produk:
                        {{ $products->count() }} Item
                    </p>
                </div>
                <div class="flex gap-4">
                    <div class="bg-white p-4 rounded-3xl flex items-center gap-4 border-4 border-white shadow-sm">
                        <div
                            class="w-10 h-10 bg-emerald-100 text-emerald-600 rounded-xl flex items-center justify-center">
                            <i class="fas fa-box"></i>
                        </div>
                        <div>
                            <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest leading-none">
                                Status Stok</p>
                            <p class="text-sm font-black text-slate-800">Normal</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="island-card p-10 lg:p-12 relative overflow-hidden">
                <div class="absolute top-0 right-0 w-32 h-32 bg-blue-500/5 rounded-full -mr-16 -mt-16 blur-3xl"></div>

                <h2 class="text-xl font-black mb-8 italic uppercase tracking-widest text-slate-800">
                    <i class="fas fa-plus-circle mr-3 text-blue-500"></i> Tambah Menu Baru
                </h2>

                <form action="{{ route('products.store') }}" method="POST"
                    class="grid grid-cols-1 md:grid-cols-4 gap-8">
                    @csrf
                    <div class="space-y-3">
                        <label class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 ml-2">Nama
                            Produk</label>
                        <input type="text" name="name" placeholder="Pudding Cokelat..."
                            class="input-custom w-full rounded-2xl p-5 font-bold" required>
                    </div>
                    <div class="space-y-3">
                        <label class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 ml-2">Harga
                            (Rp)</label>
                        <input type="number" name="price" placeholder="15000"
                            class="input-custom w-full rounded-2xl p-5 font-bold" required>
                    </div>
                    <div class="space-y-3">
                        <label
                            class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 ml-2">Stok</label>
                        <input type="number" name="stock" placeholder="100"
                            class="input-custom w-full rounded-2xl p-5 font-bold" required>
                    </div>
                    <div class="space-y-3">
                        <label
                            class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 ml-2">Kategori</label>
                        <select name="category" class="input-custom w-full rounded-2xl p-5 font-bold appearance-none">
                            <option value="makanan">Makanan</option>
                            <option value="minuman">Minuman</option>
                            <option value="dessert">Dessert</option>
                        </select>
                    </div>
                    <button type="submit"
                        class="md:col-span-4 bg-slate-900 text-white p-6 rounded-[25px] font-black uppercase tracking-[0.4em] text-xs hover:bg-blue-600 transition-all shadow-xl shadow-slate-200 active:scale-95">
                        Simpan Menu Ke Database
                    </button>
                </form>
            </div>

            <div class="island-card overflow-hidden">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-900 text-white text-[10px] font-black uppercase tracking-[0.3em]">
                            <th class="p-8">Informasi Menu</th>
                            <th>Kategori</th>
                            <th>Harga Satuan</th>
                            <th>Stok Tersedia</th>
                            <th class="text-center">Tindakan</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @foreach($products as $p)
                            <tr class="bg-white">
                                <td class="p-8">
                                    <div class="flex items-center gap-5">
                                        <div
                                            class="w-14 h-14 bg-slate-50 rounded-2xl flex items-center justify-center border-2 border-white shadow-sm">
                                            <i
                                                class="fas {{ $p->category == 'minuman' ? 'fa-coffee text-blue-400' : ($p->category == 'dessert' ? 'fa-ice-cream text-pink-400' : 'fa-hamburger text-orange-400') }} text-xl"></i>
                                        </div>
                                        <span
                                            class="font-black text-slate-800 uppercase tracking-tighter text-lg">{{ $p->name }}</span>
                                    </div>
                                </td>
                                <td>
                                    <span
                                        class="px-5 py-2 rounded-full text-[9px] font-black uppercase tracking-widest 
                                            {{ $p->category == 'dessert' ? 'bg-pink-100 text-pink-600' : ($p->category == 'minuman' ? 'bg-blue-100 text-blue-600' : 'bg-orange-100 text-orange-600') }}">
                                        {{ $p->category }}
                                    </span>
                                </td>
                                <td class="font-black text-slate-900">Rp {{ number_format($p->price, 0, ',', '.') }}</td>
                                <td>
                                    <div class="flex items-center gap-2">
                                        <div
                                            class="w-2 h-2 rounded-full {{ $p->stock < 10 ? 'bg-red-500 animate-pulse' : 'bg-emerald-500' }}">
                                        </div>
                                        <span class="font-bold text-sm">{{ $p->stock }} <span
                                                class="text-slate-400 font-medium italic">Pcs</span></span>
                                    </div>
                                </td>
                                <td class="p-8">
                                    <div class="flex justify-center gap-3">
                                        <button onclick="openEditModal({{ $p }})"
                                            class="w-12 h-12 bg-blue-50 text-blue-600 rounded-2xl hover:bg-blue-600 hover:text-white transition-all">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <form action="{{ route('products.destroy', $p->id) }}" method="POST"
                                            onsubmit="return confirm('Hapus menu ini secara permanen?')">
                                            @csrf @method('DELETE')
                                            <button
                                                class="w-12 h-12 bg-red-50 text-red-400 rounded-2xl hover:bg-red-600 hover:text-white transition-all">
                                                <i class="fas fa-trash-alt"></i>
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

    <div id="editModal"
        class="hidden fixed inset-0 bg-slate-900/60 backdrop-blur-md flex items-center justify-center p-6 z-[100] transition-all">
        <div class="bg-white p-12 rounded-[50px] w-full max-w-lg shadow-2xl border-[10px] border-white relative">
            <h2 class="text-3xl font-black mb-8 tracking-tighter uppercase">Edit <span class="text-blue-500">Menu</span>
            </h2>

            <form id="editForm" method="POST" class="space-y-6">
                @csrf @method('PUT')
                <div class="space-y-2">
                    <label class="text-[10px] font-black uppercase tracking-widest ml-2 text-slate-400">Nama
                        Produk</label>
                    <input type="text" name="name" id="edit_name" class="input-custom w-full rounded-2xl p-5 font-bold">
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div class="space-y-2">
                        <label class="text-[10px] font-black uppercase tracking-widest ml-2 text-slate-400">Harga
                            (Rp)</label>
                        <input type="number" name="price" id="edit_price"
                            class="input-custom w-full rounded-2xl p-5 font-bold">
                    </div>
                    <div class="space-y-2">
                        <label class="text-[10px] font-black uppercase tracking-widest ml-2 text-slate-400">Stok</label>
                        <input type="number" name="stock" id="edit_stock"
                            class="input-custom w-full rounded-2xl p-5 font-bold">
                    </div>
                </div>
                <div class="flex gap-4 pt-4">
                    <button type="button" onclick="closeEditModal()"
                        class="flex-1 p-5 bg-slate-100 rounded-[25px] font-black uppercase tracking-widest text-[10px]">Batal</button>
                    <button type="submit"
                        class="flex-1 p-5 bg-slate-900 text-white rounded-[25px] font-black uppercase tracking-widest text-[10px] shadow-lg">Simpan
                        Perubahan</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openEditModal(product) {
            document.getElementById('editModal').classList.remove('hidden');
            document.getElementById('edit_name').value = product.name;
            document.getElementById('edit_price').value = product.price;
            document.getElementById('edit_stock').value = product.stock;
            document.getElementById('editForm').action = `/products/${product.id}`;
        }
        function closeEditModal() {
            document.getElementById('editModal').classList.add('hidden');
        }
    </script>
</body>

</html>