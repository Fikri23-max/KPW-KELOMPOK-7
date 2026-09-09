<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Pesan makanan dan minuman favorit Anda secara online di Resto Kita.">
    <link rel="icon" href="data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 100 100%22><text y=%22.9em%22 font-size=%2290%22>🍽️</text></svg>">
    <title>@yield('title', 'Sistem Pemesanan Makanan')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['Poppins', 'sans-serif'] },
                    colors: {
                        brand: {
                            50: '#fff7ed', 100: '#ffedd5', 400: '#fb923c',
                            500: '#f97316', 600: '#ea580c', 700: '#c2410c',
                        },
                    },
                },
            },
        };
    </script>
    <style>
        body { font-family: 'Poppins', sans-serif; }
        .card-hover { transition: transform .2s ease, box-shadow .2s ease; }
        .card-hover:hover { transform: translateY(-4px); box-shadow: 0 12px 24px -8px rgba(234,88,12,.25); }
        .hero-gradient { background: linear-gradient(120deg, #ea580c 0%, #f97316 45%, #fb923c 100%); }
    </style>
</head>
<body class="bg-orange-50/40 min-h-screen flex flex-col text-gray-800">
    @php($cartCount = collect(session('cart', []))->sum('quantity'))

    <nav class="bg-white/90 backdrop-blur sticky top-0 z-30 shadow-sm border-b border-orange-100">
        <div class="max-w-6xl mx-auto px-4 py-3 flex items-center justify-between">
            <a href="{{ route('menu.index') }}" class="text-xl font-extrabold text-brand-600 flex items-center gap-2">
                <span class="bg-brand-600 text-white w-9 h-9 rounded-xl flex items-center justify-center">
                    <i class="fas fa-utensils"></i>
                </span>
                Resto Kita
            </a>

            <div class="flex items-center gap-5 text-sm font-medium text-gray-600">
                <a href="{{ route('menu.index') }}" class="hover:text-brand-600 transition {{ request()->routeIs('menu.index') ? 'text-brand-600' : '' }}">Menu</a>
                <a href="{{ route('cart.index') }}" class="hover:text-brand-600 transition relative {{ request()->routeIs('cart.index') ? 'text-brand-600' : '' }}">
                    <i class="fas fa-shopping-basket mr-1"></i> Keranjang
                    @if($cartCount > 0)
                        <span class="absolute -top-2 -right-3 bg-brand-600 text-white text-[10px] w-5 h-5 rounded-full flex items-center justify-center">{{ $cartCount }}</span>
                    @endif
                </a>

                @auth
                    <a href="{{ route('orders.index') }}" class="hover:text-brand-600 transition {{ request()->routeIs('orders.*') ? 'text-brand-600' : '' }}">Pesanan Saya</a>
                    @if(auth()->user()->isAdmin())
                        <a href="{{ route('admin.dashboard') }}" class="text-white bg-gray-800 px-3 py-1.5 rounded-full hover:bg-gray-900 transition">
                            <i class="fas fa-shield-halved mr-1"></i> Admin
                        </a>
                    @endif
                    <span class="hidden sm:inline text-gray-400">|</span>
                    <span class="hidden sm:inline">Hai, <strong>{{ auth()->user()->name }}</strong></span>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button class="text-gray-500 hover:text-red-600 transition" title="Keluar"><i class="fas fa-sign-out-alt"></i></button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="hover:text-brand-600 transition">Masuk</a>
                    <a href="{{ route('register') }}" class="bg-brand-600 text-white px-4 py-1.5 rounded-full font-semibold hover:bg-brand-700 transition">Daftar</a>
                @endauth
            </div>
        </div>
    </nav>

    <main class="flex-1 w-full">
        <div class="max-w-6xl mx-auto px-4 py-6">
            @if(session('success'))
                <div class="mb-4 bg-green-50 text-green-800 border border-green-200 px-4 py-3 rounded-xl flex items-center gap-2">
                    <i class="fas fa-circle-check"></i> {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="mb-4 bg-red-50 text-red-800 border border-red-200 px-4 py-3 rounded-xl flex items-center gap-2">
                    <i class="fas fa-circle-exclamation"></i> {{ session('error') }}
                </div>
            @endif

            @yield('content')
        </div>
    </main>

    <footer class="bg-gray-900 text-gray-400 text-sm mt-10">
        <div class="max-w-6xl mx-auto px-4 py-6 flex flex-col sm:flex-row justify-between items-center gap-2">
            <span>&copy; {{ date('Y') }} <strong class="text-white">Resto Kita</strong> — Sistem Pemesanan Makanan</span>
            <span class="flex gap-3 text-lg">
                <i class="fab fa-instagram"></i>
                <i class="fab fa-whatsapp"></i>
                <i class="fab fa-facebook"></i>
            </span>
        </div>
    </footer>
</body>
</html>
