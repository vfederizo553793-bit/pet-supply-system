<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel | Bow & Wow</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root {
            --parchment: #FFF8EC;
            --sand: #DCCCAC;
            --sage: #99AD7A;
            --forest: #546B41;
        }
        body { background-color: var(--parchment); }
        .sidebar {
            min-height: 100vh;
            background-color: var(--forest);
            padding-top: 20px;
            width: 250px;
            position: fixed;
            top: 0;
            left: 0;
        }
        .sidebar a {
            color: var(--parchment);
            display: block;
            padding: 12px 20px;
            text-decoration: none;
        }
        .sidebar a:hover {
            background-color: var(--sage);
            color: white;
        }
        .sidebar .brand {
            font-weight: bold;
            font-size: 1.2rem;
            padding: 15px 20px;
            border-bottom: 1px solid var(--sage);
            margin-bottom: 10px;
        }
        .main-content {
            margin-left: 250px;
            padding: 30px;
        }
        .topbar {
            background-color: var(--parchment);
            border-bottom: 2px solid var(--sand);
            padding: 10px 30px;
            margin-left: 250px;
            display: flex;
            justify-content: flex-end;
            align-items: center;
        }
    </style>
</head>
<body>

    {{-- Sidebar --}}
    <div class="sidebar">
        <div class="brand">🐾 Bow & Wow Admin</div>
        <a href="{{ route('admin.dashboard') }}">📊 Dashboard</a>
        <a href="{{ route('products.create') }}">➕ Add Product</a>
        <a href="{{ route('categories.index') }}">🗂️ Categories</a>
        <a href="{{ route('admin.orders') }}">📦 Orders</a>
        <a href="{{ route('admin.customers') }}">👥 Customers</a>
    </div>

    {{-- Top bar --}}
    <div class="topbar">
        <span style="color: var(--forest);">👤 {{ auth()->user()->name }}</span>
        &nbsp;&nbsp;
        <form method="POST" action="{{ route('logout') }}" class="d-inline">
            @csrf
            <button type="submit" class="btn btn-sm btn-outline-danger">Logout</button>
        </form>
    </div>

    {{-- Main content --}}
    <div class="main-content">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>