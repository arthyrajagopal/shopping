<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Anvogue - @yield('title')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        .product-card { transition: transform 0.2s; margin-bottom: 20px; }
        .product-card:hover { transform: translateY(-5px); box-shadow: 0 4px 8px rgba(0,0,0,0.1); }
        .discount-badge { position: absolute; top: 10px; left: 10px; background: red; color: white; padding: 5px 10px; border-radius: 5px; }
        .price-old { text-decoration: line-through; color: #999; margin-right: 10px; }
        .price-new { color: #e74c3c; font-weight: bold; }
        .sidebar { background: #f8f9fa; padding: 20px; border-radius: 8px; }
        .color-swatch { width: 25px; height: 25px; border-radius: 50%; display: inline-block; margin-right: 5px; border: 1px solid #ddd; }
        .filter-group { margin-bottom: 20px; }
        .filter-group h5 { margin-bottom: 10px; }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}">Anvogue</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item"><a class="nav-link" href="{{ route('home') }}">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('shop') }}">Shop</a></li>
                </ul>
                <form class="d-flex me-3" action="{{ route('shop') }}" method="GET">
                    <input class="form-control me-2" type="search" name="search" placeholder="Search products..." value="{{ request('search') }}">
                    <button class="btn btn-outline-dark" type="submit"><i class="fas fa-search"></i></button>
                </form>
                <a href="{{ route('cart.index') }}" class="btn btn-outline-dark me-2"><i class="fas fa-shopping-cart"></i> Cart</a>
                <a href="{{ route('compare.index') }}" class="btn btn-outline-dark me-2"><i class="fas fa-exchange-alt"></i> Compare</a>
                <a href="{{ route('wishlist.index') }}" class="btn btn-outline-dark"><i class="fas fa-heart"></i> Wishlist</a>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="container my-4">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif
        @if(session('info'))
            <div class="alert alert-info">{{ session('info') }}</div>
        @endif
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-dark text-white text-center py-3 mt-5">
        <p>&copy; {{ date('Y') }} Anvogue. All rights reserved.</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>