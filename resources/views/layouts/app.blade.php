<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Bow & Wow') }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">
    <style>
        :root {
            --parchment: #FFF8EC;
            --sand: #DCCCAC;
            --sage: #99AD7A;
            --forest: #546B41;
            --bark: #7a6a50;
        }
        * { box-sizing: border-box; }
        body {
            font-family: 'DM Sans', sans-serif;
            background-color: var(--parchment);
            color: #2c2c2a;
            margin: 0;
        }
        h1, h2, h3, h4, h5 {
            font-family: 'Playfair Display', serif;
            color: var(--forest);
        }

        /* Navbar */
        .bow-navbar {
            background: var(--parchment);
            border-bottom: 1.5px solid var(--sand);
            padding: 14px 32px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 1000;
        }
        .bow-brand {
            font-family: 'Playfair Display', serif;
            font-size: 22px;
            font-weight: 600;
            color: var(--forest);
            text-decoration: none;
            letter-spacing: -0.3px;
        }
        .bow-brand:hover { color: var(--forest); }
        .bow-nav-links { display: flex; gap: 28px; align-items: center; }
        .bow-nav-link {
            font-size: 13px;
            font-weight: 400;
            color: var(--forest);
            text-decoration: none;
            letter-spacing: 0.3px;
            padding-bottom: 2px;
            border-bottom: 1.5px solid transparent;
            transition: border-color 0.2s;
        }
        .bow-nav-link:hover { border-bottom-color: var(--sage); color: var(--forest); }
        .bow-nav-actions { display: flex; gap: 10px; align-items: center; }
        .bow-icon-btn {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            border: 1px solid var(--sand);
            background: white;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            font-size: 15px;
            text-decoration: none;
            transition: background 0.2s;
        }
        .bow-icon-btn:hover { background: var(--sand); }
        .bow-btn {
            padding: 8px 20px;
            background: var(--forest);
            color: var(--parchment);
            border-radius: 6px;
            font-size: 13px;
            font-weight: 500;
            border: none;
            cursor: pointer;
            text-decoration: none;
            transition: background 0.2s;
            display: inline-block;
        }
        .bow-btn:hover { background: var(--sage); color: white; }
        .bow-btn-outline {
            background: transparent;
            color: var(--forest);
            border: 1px solid var(--forest);
        }
        .bow-btn-outline:hover { background: var(--forest); color: var(--parchment); }

        /* Tab bar */
        .bow-tab-bar {
            display: flex;
            gap: 0;
            border-bottom: 1.5px solid var(--sand);
            padding: 0 32px;
            background: white;
            overflow-x: auto;
        }
        .bow-tab {
            padding: 12px 18px;
            font-size: 13px;
            color: var(--bark);
            cursor: pointer;
            border-bottom: 2px solid transparent;
            margin-bottom: -1.5px;
            white-space: nowrap;
            text-decoration: none;
            font-weight: 400;
        }
        .bow-tab:hover { color: var(--forest); }
        .bow-tab.active {
            color: var(--forest);
            border-bottom-color: var(--forest);
            font-weight: 500;
        }

        /* Cards */
        .bow-card {
            background: white;
            border-radius: 10px;
            border: 1px solid var(--sand);
            overflow: hidden;
            transition: transform 0.2s, box-shadow 0.2s;
        }
        .bow-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 24px rgba(84,107,65,0.1);
        }
        .bow-card-img {
            height: 180px;
            background: var(--sand);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 48px;
            overflow: hidden;
        }
        .bow-card-img img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .bow-card-body { padding: 14px 16px; }
        .bow-card-tag {
            font-size: 10px;
            font-weight: 500;
            color: var(--sage);
            text-transform: uppercase;
            letter-spacing: 0.8px;
            margin-bottom: 4px;
        }
        .bow-card-name {
            font-family: 'Playfair Display', serif;
            font-size: 15px;
            color: var(--forest);
            margin: 0 0 4px;
            font-weight: 500;
        }
        .bow-card-price {
            font-size: 16px;
            font-weight: 500;
            color: var(--forest);
        }
        .bow-card-stock { font-size: 11px; color: var(--sage); margin-top: 2px; }
        .bow-card-footer {
            padding: 10px 16px;
            border-top: 1px solid #f0e8d8;
            display: flex;
            gap: 8px;
        }
        .bow-btn-sm {
            padding: 7px 14px;
            font-size: 12px;
            border-radius: 5px;
            background: var(--forest);
            color: white;
            border: none;
            cursor: pointer;
            flex: 1;
            font-weight: 500;
            transition: background 0.2s;
        }
        .bow-btn-sm:hover { background: var(--sage); }
        .bow-btn-sm-outline {
            background: transparent;
            color: var(--forest);
            border: 1px solid var(--forest);
        }
        .bow-btn-sm-outline:hover { background: var(--forest); color: white; }

        /* Filter chips */
        .bow-chip {
            padding: 6px 14px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 500;
            border: 1px solid var(--sand);
            background: var(--parchment);
            color: var(--forest);
            cursor: pointer;
            text-decoration: none;
            transition: all 0.2s;
            white-space: nowrap;
        }
        .bow-chip:hover, .bow-chip.active {
            background: var(--forest);
            color: var(--parchment);
            border-color: var(--forest);
        }

        /* Alerts */
        .bow-alert {
            padding: 12px 16px;
            border-radius: 8px;
            font-size: 13px;
            margin-bottom: 16px;
            border: 1px solid;
        }
        .bow-alert-success {
            background: #eaf3de;
            border-color: var(--sage);
            color: var(--forest);
        }
        .bow-alert-error {
            background: #fcebeb;
            border-color: #e24b4a;
            color: #a32d2d;
        }

        /* Status badges */
        .bow-badge {
            display: inline-block;
            padding: 3px 10px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 500;
        }
        .bow-badge-pending { background: #FFF3E0; color: #7A4A00; }
        .bow-badge-processing { background: #E3F2FD; color: #0D2F5E; }
        .bow-badge-shipped { background: #E8F5E9; color: #1B5E20; }
        .bow-badge-delivered { background: #E8F5E9; color: #1B5E20; }
        .bow-badge-cancelled { background: #FFEBEE; color: #7F1D1D; }

        /* Section label */
        .bow-section-label {
            font-size: 11px;
            font-weight: 500;
            color: var(--sage);
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 16px;
        }

        /* Footer */
        .bow-footer {
            background: var(--forest);
            color: var(--parchment);
            text-align: center;
            padding: 24px;
            margin-top: 60px;
            font-size: 13px;
        }

        /* Main content */
        .bow-main { padding: 32px; max-width: 1200px; margin: 0 auto; }

        /* Dropdown */
        .dropdown-menu {
            border: 1px solid var(--sand);
            border-radius: 8px;
            box-shadow: 0 8px 24px rgba(84,107,65,0.1);
        }
        .dropdown-item:hover {
            background: var(--parchment);
            color: var(--forest);
        }

        /* Form controls */
        .form-control:focus, .form-select:focus {
            border-color: var(--sage);
            box-shadow: 0 0 0 3px rgba(153,173,122,0.2);
        }

        /* Tables */
        .bow-table { width: 100%; border-collapse: collapse; }
        .bow-table th {
            background: var(--sand);
            color: var(--forest);
            font-family: 'DM Sans', sans-serif;
            font-size: 12px;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            padding: 12px 16px;
            text-align: left;
        }
        .bow-table td {
            padding: 12px 16px;
            border-bottom: 1px solid #f0e8d8;
            font-size: 13px;
            vertical-align: middle;
        }
        .bow-table tr:last-child td { border-bottom: none; }
        .bow-table tr:hover td { background: #fffdf7; }

        /* Panel card */
        .bow-panel {
            background: white;
            border-radius: 10px;
            border: 1px solid var(--sand);
            overflow: hidden;
            margin-bottom: 24px;
        }
        .bow-panel-header {
            padding: 16px 20px;
            border-bottom: 1px solid var(--sand);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .bow-panel-title {
            font-family: 'Playfair Display', serif;
            font-size: 16px;
            color: var(--forest);
            margin: 0;
            font-weight: 500;
        }
        .bow-panel-body { padding: 20px; }

        /* Loyalty card */
        .bow-loyalty-card {
            background: var(--forest);
            border-radius: 12px;
            padding: 24px;
            color: var(--parchment);
            margin-bottom: 24px;
        }
        .bow-loyalty-stat { text-align: center; }
        .bow-loyalty-stat-label {
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            color: var(--sand);
            margin-bottom: 6px;
        }
        .bow-loyalty-stat-value {
            font-family: 'Playfair Display', serif;
            font-size: 28px;
            font-weight: 600;
            color: var(--parchment);
        }
        .bow-loyalty-stat-sub { font-size: 12px; color: var(--sage); margin-top: 2px; }
    </style>
</head>
<body>

{{-- Navbar --}}
<nav class="bow-navbar">
    <a href="{{ route('home') }}" class="bow-brand">🐾 Bow & Wow</a>

    <div class="bow-nav-links">
        <a href="{{ route('home') }}" class="bow-nav-link">Home</a>
        <a href="{{ route('home') }}?pet_type=dog" class="bow-nav-link">Woof</a>
        <a href="{{ route('home') }}?pet_type=cat" class="bow-nav-link">Meow</a>
    </div>

    <div class="bow-nav-actions">
        @auth
            <a href="{{ route('wishlist.index') }}" class="bow-icon-btn" title="Wishlist">♡</a>
            <a href="{{ route('cart.index') }}" class="bow-icon-btn" title="Cart">🛒</a>
            <div class="dropdown">
                <button class="bow-btn dropdown-toggle" data-bs-toggle="dropdown">
                    {{ auth()->user()->name }}
                </button>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li><a class="dropdown-item" href="{{ route('orders.index') }}">My Orders</a></li>
                    <li><a class="dropdown-item" href="{{ route('loyalty.index') }}">Loyalty Points</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="dropdown-item text-danger">Logout</button>
                        </form>
                    </li>
                </ul>
            </div>
        @else
            <a href="{{ route('login') }}" class="bow-nav-link">Log in</a>
            <a href="{{ route('register') }}" class="bow-btn">Register</a>
        @endauth
    </div>
</nav>

{{-- Flash Messages --}}
<div style="max-width: 1200px; margin: 0 auto; padding: 0 32px;">
    @if(session('success'))
        <div class="bow-alert bow-alert-success mt-3">✓ {{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="bow-alert bow-alert-error mt-3">✕ {{ session('error') }}</div>
    @endif
</div>

{{-- Page Content --}}
@yield('content')

{{-- Footer --}}
<footer class="bow-footer">
    <p style="margin:0; font-family: 'Playfair Display', serif; font-size: 15px;">Bow & Wow Pet Supply System</p>
    <p style="margin:4px 0 0; color: var(--sand); font-size: 12px;">© 2024 · Philippines' first all-natural pet store · Davao City</p>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')
</body>
</html>