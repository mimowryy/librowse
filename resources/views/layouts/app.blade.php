<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'LiBrowse') }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link href="{{ asset('css/librowse.css') }}" rel="stylesheet">
</head>
<body>

{{-- Navbar --}}
<nav class="navbar-librowse">
    <div class="container d-flex align-items-center justify-content-between">

        {{-- Logo --}}
        <a href="/" class="navbar-brand-custom">Li<span>Browse</span></a>

        {{-- Nav Links --}}
        <div class="d-flex align-items-center gap-1">
            <a href="/" class="nav-link-custom">Home</a>
            <a href="/books" class="nav-link-custom">Browse</a>
            @auth
                @if(auth()->user()->role === 'admin')
                    <a href="/admin/dashboard" class="nav-link-custom">Dashboard</a>
                    <a href="/admin/books" class="nav-link-custom">Books</a>
                    <a href="/admin/borrows" class="nav-link-custom">Borrows</a>
                    <a href="/admin/students" class="nav-link-custom">Students</a>
                @else
                    <a href="/my-borrows" class="nav-link-custom">My Books</a>
                @endif
            @endauth
        </div>

        {{-- Right Side --}}
        <div class="d-flex align-items-center gap-2">
            <button class="theme-toggle" onclick="toggleTheme()" title="Toggle dark/light mode">
                <span id="theme-icon">🌙</span>
            </button>
            @auth
                <form method="POST" action="/logout" class="d-inline">
                    @csrf
                    <button type="submit" class="btn-ghost-custom">Logout</button>
                </form>
            @else
                <a href="/login" class="btn-ghost-custom">Log in</a>
                <a href="/register" class="btn-accent">Register</a>
            @endauth
        </div>

    </div>
</nav>

{{-- Flash Messages --}}
<div class="container mt-3">
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-circle me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
</div>

<main>
    @yield('content')
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    const savedTheme = localStorage.getItem('librowse-theme') || 'light';
    document.documentElement.setAttribute('data-theme', savedTheme);
    document.getElementById('theme-icon').textContent = savedTheme === 'dark' ? '☀️' : '🌙';

    function toggleTheme() {
        const current = document.documentElement.getAttribute('data-theme');
        const next = current === 'dark' ? 'light' : 'dark';
        document.documentElement.setAttribute('data-theme', next);
        localStorage.setItem('librowse-theme', next);
        document.getElementById('theme-icon').textContent = next === 'dark' ? '☀️' : '🌙';
    }
</script>
</body>
</html>