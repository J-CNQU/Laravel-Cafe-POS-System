<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Felix Kantin - POS System Premium</title>
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

        .menu-grid-card {
            background: white;
            border: 4px solid #FFFFFF;
            border-radius: 50px;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            position: relative;
            overflow: hidden;
        }

        .menu-grid-card:hover {
            transform: translateY(-12px);
            box-shadow: 0 30px 60px -12px rgba(0, 0, 0, 0.12);
            border-color: #F8FAFC;
        }

        .custom-scroll::-webkit-scrollbar {
            width: 6px;
        }

        .custom-scroll::-webkit-scrollbar-thumb {
            background: #E2E8F0;
            border-radius: 20px;
        }

        .no-scrollbar::-webkit-scrollbar {
            display: none;
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
            animation: slideIn 0.3s ease;
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateX(-10px);
            }

            to {
                opacity: 1;
                transform: translateX(0);
            }
        }
    </style>
</head>

<body class="antialiased text-slate-800">

    <div class="min-h-screen p-6 lg:p-12">
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
                            class="nav-link {{ request()->is('products*') ? 'active' : '' }} text-2xl"
                            title="Manajemen Menu">
                            <i class="fas fa-utensils"></i>
                        </a>
                    @endif

                    <a href="{{ route('history') }}"
                        class="nav-link {{ request()->is('history*') ? 'active' : '' }} text-2xl"
                        title="Riwayat Transaksi">
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
                            class="w-12 h-12 flex items-center justify-center rounded-2xl text-red-400 hover:bg-red-50 hover:text-red-600 transition-all text-xl"
                            title="Keluar">
                            <i class="fas fa-power-off"></i>
                        </button>
                    </form>
                </div>
            </aside>

            <main class="col-span-12 xl:col-span-7 space-y-12">
                <header class="island-card p-10 lg:p-14 flex flex-col gap-10 border-b-8 border-slate-50">
                    <div class="flex justify-between items-start">
                        <div class="space-y-2">
                            <h1 class="text-5xl font-extrabold tracking-tighter text-slate-900">Felix <span
                                    class="text-slate-400 font-light">Kantin</span></h1>
                            <div class="flex items-center gap-3">
                                <span
                                    class="px-3 py-1 bg-slate-900 text-white text-[9px] font-black uppercase tracking-widest rounded-lg">
                                    {{ Auth::user()->role }} MODE
                                </span>
                                <p class="text-slate-400 font-bold uppercase tracking-[0.3em] text-[10px]">User:
                                    {{ Auth::user()->name }}</p>
                            </div>
                        </div>

                        <div class="flex flex-col items-end">
                            <span id="real-clock"
                                class="font-black text-slate-800 tracking-tighter text-2xl uppercase">00:00:00</span>
                            <span
                                class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">{{ now()->format('D, d M Y') }}</span>
                        </div>
                    </div>

                    <div class="relative group">
                        <div
                            class="absolute left-8 top-1/2 -translate-y-1/2 flex items-center gap-4 pointer-events-none">
                            <i
                                class="fas fa-search text-slate-300 group-focus-within:text-slate-900 transition-colors text-xl"></i>
                        </div>
                        <input type="text" id="search-input" onkeyup="searchMenu()"
                            placeholder="Cari menu lezat untuk pelangganmu..."
                            class="w-full bg-slate-50 border-4 border-slate-50 rounded-[35px] py-8 pl-20 pr-10 focus:bg-white focus:border-slate-100 focus:ring-0 font-bold text-lg text-slate-700 transition-all outline-none placeholder:text-slate-300 shadow-inner">
                    </div>
                </header>

                <section class="flex gap-6 overflow-x-auto no-scrollbar pb-4 px-2">
                    <button onclick="filterMenu('semua')"
                        class="cat-btn px-10 py-5 bg-slate-900 text-white rounded-[25px] font-black text-xs uppercase tracking-[0.2em] shadow-2xl shadow-slate-300 transition-all active:scale-95">
                        <i class="fas fa-border-all mr-2"></i> Semua
                    </button>
                    <button onclick="filterMenu('makanan')"
                        class="cat-btn px-10 py-5 bg-white text-slate-400 rounded-[25px] font-black text-xs uppercase tracking-[0.2em] border-4 border-transparent hover:border-slate-100 transition-all active:scale-95">
                        <i class="fas fa-hamburger mr-2"></i> Makanan
                    </button>
                    <button onclick="filterMenu('minuman')"
                        class="cat-btn px-10 py-5 bg-white text-slate-400 rounded-[25px] font-black text-xs uppercase tracking-[0.2em] border-4 border-transparent hover:border-slate-100 transition-all active:scale-95">
                        <i class="fas fa-coffee mr-2"></i> Minuman
                    </button>
                    <button onclick="filterMenu('dessert')"
                        class="cat-btn px-10 py-5 bg-white text-slate-400 rounded-[25px] font-black text-xs uppercase tracking-[0.2em] border-4 border-transparent hover:border-slate-100 transition-all active:scale-95">
                        <i class="fas fa-ice-cream mr-2"></i> Dessert
                    </button>
                </section>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10" id="menu-container">
                    @forelse($products as $product)
                        <div class="menu-grid-card p-10 flex flex-col items-center text-center menu-item"
                            data-category="{{ strtolower($product->category) }}"
                            data-name="{{ strtolower($product->name) }}">

                            <div class="relative group">
                                <div
                                    class="w-40 h-40 bg-slate-50 rounded-[50px] mb-8 flex items-center justify-center transition-all group-hover:scale-110">
                                    @php 
                                                                        $icon = 'fa-utensils';
                                        $color = 'text-orange-200';
                                        if (strtolower($product->category) == 'minuman') {
                                            $icon = 'fa-coffee';
                                            $color = 'text-blue-200';
                                        }
                                        if (strtolower($product->category) == 'dessert') {
                                            $icon = 'fa-ice-cream';
                                            $color = 'text-pink-200';
                                        }
                                    @endphp
                                    <i class="fas {{ $icon }} {{ $color }} text-6xl"></i>
                                </div>
                                <div class="absolute -top-2 -right-2 w-12 h-12 bg-white rounded-2xl flex items-center justify-center shadow-lg border-2 border-slate-50">
                                    <span class="text-[10px] font-black {{ $product->stock < 10 ? 'text-red-500' : 'text-emerald-500' }}">{{ $product->stock }}</span>
                                </div
                           >        
                            </div>

                            <div class="space-y-2 mb-8 w-full">

                                                                <span class="text-[9px] font-black uppercase tr
                        a           cking-[0.3em] {{ strtolower($product->category) == 'minuman' ? 'text-blue-500' : (strtolower($product->category) == 'dessert' ? 'text-pink-500' : 'text-orange-500') }}">
                                    {{ $product->category }}
                                </span>
                                <h3 class="text-xl font-black text-slate-800 uppercase tracking-tighter truncate w-full">{{ $product->name }}</h3>
                                <p class="text-lg font-black text-slate-900">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                            </div>

                            <button onclick="addToCart({{ $product->id }}, '{{ $product->name }}', {{ $product->price }})" class="w-full bg-slate-900 text-white hover:bg-blue-600 py-5 rounded-3xl font-black text-[10px] uppercase tracking-[0.2em] transition-all shadow-xl shadow-slate-200 active:scale-95">
                                TAMBAH KE POS
                            </button>
                        </div>
                    @empty
                        <div class="col-span-full text-center py-20 island-card">
                            <p class="font-bold text-slate-400">Belum ada menu di kategori ini.</p>
                        </div>
                    @endforelse
                </div>
            </main>

            <aside class="col-span-12 xl:col-span-4 h-fit sticky top-10 z-10">
    <div class="island-card p-12 lg:p-14 shadow-xl border-[8px] border-white flex flex-col min-h-[800px]">
        <div class="flex justify-between items-center mb-12">
            <h2 class="text-3xl font-extrabold uppercase tracking-tighter text-slate-900">Pesanan</h2>
            <div class="w-12 h-12 bg-slate-50 rounded-2xl flex items-center justify-center text-slate-300">
                <i class="fas fa-shopping-basket"></i>
            </div>
        </div>

        <div id="cart-items-list" class="flex-1 overflow-y-auto custom-scroll pr-2 mb-10 space-y-6">
            <div id="empty-msg" class="text-center py-20 opacity-20 flex flex-col items-center">
                <i class="fas fa-receipt text-6xl mb-4"></i>
                <p class="text-[10px] font-black uppercase tracking-[0.4em]">Keranjang Kosong</p>
            </div>
        </div>

        <div id="cart-footer">
            <div class="bg-slate-900 rounded-[40px] p-10 text-white space-y-6">
                <div class="flex justify-between items-center text-[10px] font-black uppercase tracking-[0.2em] text-slate-500">
                    <span>Subtotal</span>
                    <span class="text-white text-base" id="subtotal-display">Rp 0</span>
                </div>
                <div class="pt-6 border-t border-slate-800 flex justify-between items-end">
                    <span class="text-[9px] font-black uppercase tracking-[0.3em] text-blue-400">Total Akhir</span>
                    <span class="text-4xl font-black tracking-tighter" id="total-display">Rp 0</span>
                </div>
            </div>

            <button onclick="checkout()" class="w-full bg-blue-600 text-white font-black py-7 rounded-[30px] mt-8 shadow-2xl shadow-blue-100 hover:bg-blue-700 transition-all uppercase tracking-[0.3em] text-[11px] active:scale-95">
                KONFIRMASI BAYAR
            </button>
        </div>
    </div>
</aside>

        </div>
    </div>

    <script>
    let cart = [];

    // 1. TAMBAH KE CART (Pastikan parameter name masuk)
    function addToCart(id, name, price) {
        // Cek apakah produk sudah ada di keranjang
        const existingItem = cart.find(item => item.id === id);

        if (existingItem) {
            existingItem.qty += 1;
        } else {
            cart.push({
                id: id,
                name: name, // Baris krusial!
                price: price,
                qty: 1
            });
        }
        renderCart();
    }

    // 2. UPDATE QTY
    function updateQty(index, delta) {
        cart[index].qty += delta;
        if (cart[index].qty < 1) {
            cart.splice(index, 1);
        }
        renderCart();
    }

    // 3. RENDER TAMPILAN KERANJANG
    function renderCart() {
        const listContainer = document.getElementById('cart-items-list');
        const subtotalText = document.getElementById('subtotal-display');
        const totalText = document.getElementById('total-display');

        if (cart.length === 0) {
            listContainer.innerHTML = `
                <div class="text-center py-20 opacity-20 flex flex-col items-center">
                    <i class="fas fa-receipt text-6xl mb-4"></i>
                    <p class="text-[10px] font-black uppercase tracking-[0.4em]">Keranjang Kosong</p>
                </div>`;
            subtotalText.innerText = "Rp 0";
            totalText.innerText = "Rp 0";
            return;
        }

        listContainer.innerHTML = '';
        let totalSemua = 0;

        cart.forEach((item, index) => {
            const subtotalItem = item.price * item.qty;
            totalSemua += subtotalItem;

            listContainer.innerHTML += `
                <div class="bg-white border-4 border-slate-50 p-6 rounded-[35px] flex items-center justify-between shadow-sm">
                    <div class="max-w-[150px]">
                        <h4 class="font-black text-[10px] uppercase tracking-tighter text-slate-800 truncate">${item.name}</h4>
                        <p class="text-[9px] font-bold text-slate-400 mt-1">Rp ${item.price.toLocaleString('id-ID')}</p>
                    </div>
                    <div class="flex items-center gap-4 bg-slate-50 px-4 py-2 rounded-2xl">
                        <button onclick="updateQty(${index}, -1)" class="text-xs text-slate-400 hover:text-red-500 transition-colors">
                            <i class="fas fa-minus"></i>
                        </button>
                        <span class="font-black text-xs text-slate-900">${item.qty}</span>
                        <button onclick="updateQty(${index}, 1)" class="text-xs text-slate-400 hover:text-blue-500 transition-colors">
                            <i class="fas fa-plus"></i>
                        </button>
                    </div>
                </div>
            `;
        });

        subtotalText.innerText = `Rp ${totalSemua.toLocaleString('id-ID')}`;
        totalText.innerText = `Rp ${totalSemua.toLocaleString('id-ID')}`;
    }

    // 4. CHECKOUT (Hanya gunakan SATU fungsi checkout)
    async function checkout() {
        if (cart.length === 0) {
            alert("Keranjang masih kosong!");
            return;
        }

        let grandTotal = cart.reduce((sum, item) => sum + (item.price * item.qty), 0);

        // Payload yang dikirim ke Laravel
        const payload = {
            total_price: grandTotal,
            items: cart.map(item => ({
                id: item.id,
                name: item.name, // TAMBAHKAN INI AGAR TIDAK UNKNOWN
                qty: item.qty,
                price: item.price
            }))
        };

        try {
            const response = await fetch("{{ route('pos.store') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify(payload)
            });

            const res = await response.json();

            if (res.success) {
                showSuccessPopup(res.invoice);
                cart = [];
                renderCart();
            } else {
                alert("Gagal: " + res.message);
            }
        } catch (error) {
            console.error(error);
            alert("Terjadi kesalahan sistem saat menyimpan transaksi.");
        }
    }

    // 5. SUCCESS POPUP
    function showSuccessPopup(invoiceNumber) {
        const overlay = document.createElement('div');
        overlay.className = "fixed inset-0 flex items-center justify-center z-[999] bg-slate-900/60 backdrop-blur-md px-4";
        overlay.innerHTML = `
            <div class="bg-white p-10 rounded-[50px] text-center shadow-2xl max-w-sm w-full transform transition-all duration-500 scale-110 opacity-0" id="success-modal">
                <div class="w-20 h-20 bg-emerald-100 text-emerald-600 rounded-full flex items-center justify-center mx-auto mb-6 text-3xl">
                    <i class="fas fa-check"></i>
                </div>
                <h2 class="text-2xl font-black uppercase tracking-tighter text-slate-900">Pembayaran Berhasil</h2>
                <p class="text-slate-400 font-bold text-[10px] mt-2 uppercase tracking-widest">${invoiceNumber}</p>
                <button onclick="window.location.reload()" class="mt-8 w-full py-4 bg-slate-900 text-white rounded-2xl font-black text-[10px] tracking-[0.2em] uppercase hover:bg-emerald-600 transition-all">Selesai</button>
            </div>
        `;
        document.body.appendChild(overlay);

        setTimeout(() => {
            const modal = document.getElementById('success-modal');
            modal.classList.remove('scale-110', 'opacity-0');
            modal.classList.add('scale-100', 'opacity-100');
        }, 10);
    }

    // 6. TOOLS (Clock, Search, Filter)
    function updateTime() {
        const clock = document.getElementById('real-clock');
        if (clock) clock.innerText = new Date().toLocaleTimeString('id-ID', { hour12: false });
    }
    setInterval(updateTime, 1000);
    updateTime();

    function filterMenu(cat) {
        document.querySelectorAll('.cat-btn').forEach(btn => {
            btn.classList.remove('bg-slate-900', 'text-white', 'shadow-2xl', 'shadow-slate-300');
            btn.classList.add('bg-white', 'text-slate-400');
        });
        event.currentTarget.classList.add('bg-slate-900', 'text-white', 'shadow-2xl', 'shadow-slate-300');

        document.querySelectorAll('.menu-item').forEach(item => {
            const itemCat = item.getAttribute('data-category');
            item.style.display = (cat === 'semua' || itemCat === cat) ? 'flex' : 'none';
        });
    }

    function searchMenu() {
        const val = document.getElementById('search-input').value.toLowerCase();
        document.querySelectorAll('.menu-item').forEach(item => {
            const name = item.getAttribute('data-name');
            item.style.display = name.includes(val) ? 'flex' : 'none';
        });
    }
</script>
</body>

</html>