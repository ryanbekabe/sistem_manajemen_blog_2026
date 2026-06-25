<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Blog Kami')</title>

    {{-- Bootstrap 5 --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        :root {
            --navy: #22303f;
            --navy-dark: #1b2733;
            --green: #16a34a;
            --green-dark: #15803d;
            --bg: #eef2f5;
            --muted: #64748b;
        }
        body {
            background: var(--bg);
            color: #1e293b;
            font-family: "Segoe UI", system-ui, -apple-system, sans-serif;
        }
        a { text-decoration: none; }

        /* Header & footer (tema navy konsisten dengan CMS) */
        .site-header { background: var(--navy); color: #fff; }
        .site-header .brand-title { font-weight: 700; font-size: 1.4rem; letter-spacing: .3px; }
        .site-header .brand-sub { color: #9fb0c0; font-size: .8rem; }
        .site-header a.nav-link { color: #cbd5e1; font-size: .9rem; padding: 0; }
        .site-header a.nav-link:hover { color: #fff; }
        .site-footer { background: var(--navy); color: #cbd5e1; font-size: .85rem; }

        /* Kartu artikel */
        .card-artikel { border: none; border-radius: 14px; overflow: hidden; box-shadow: 0 2px 10px rgba(15,23,42,.06); }
        .card-artikel .gambar { height: 230px; width: 100%; object-fit: cover; background: #dfe6ec; }

        .badge-kategori { background: #e7eefc; color: #3b53b5; font-weight: 600; border-radius: 999px; padding: .35em .9em; font-size: .78rem; }

        .btn-baca { background: var(--green); color: #fff; border-radius: 999px; font-weight: 600; font-size: .85rem; padding: .5rem 1.1rem; }
        .btn-baca:hover { background: var(--green-dark); color: #fff; }

        .avatar-inisial {
            width: 34px; height: 34px; border-radius: 50%;
            background: #2563eb; color: #fff;
            display: inline-flex; align-items: center; justify-content: center;
            font-weight: 600; font-size: .85rem; flex-shrink: 0;
        }

        /* Widget kategori / artikel terkait */
        .widget { border: none; border-radius: 14px; box-shadow: 0 2px 10px rgba(15,23,42,.06); }
        .widget .list-group-item {
            border: none; display: flex; justify-content: space-between; align-items: center;
            border-radius: 8px !important; color: #334155; font-size: .92rem;
        }
        .widget .list-group-item:hover { background: #f1f5f9; }
        .widget .list-group-item.active { background: var(--green); color: #fff; }
        .widget .list-group-item .badge { background: #e2e8f0; color: #475569; border-radius: 999px; }
        .widget .list-group-item.active .badge { background: rgba(255,255,255,.25); color: #fff; }

        .terkait-item:hover { background: #f1f5f9; }
    </style>
    @stack('styles')
</head>
<body>

    <header class="site-header">
        <div class="container py-3 d-flex flex-wrap align-items-center justify-content-between">
            <a href="{{ route('pengunjung.index') }}" class="text-white">
                <div class="brand-title">Blog Kami</div>
                <div class="brand-sub">Artikel terbaru seputar teknologi dan pemrograman</div>
            </a>
            <nav class="d-flex gap-3 mt-2 mt-md-0">
                <a class="nav-link" href="{{ route('pengunjung.index') }}">Beranda</a>
                <a class="nav-link" href="{{ route('pengunjung.index') }}">Artikel</a>
                <a class="nav-link" href="{{ route('pengunjung.index') }}#kategori">Kategori</a>
                <a class="nav-link" href="#">Tentang</a>
            </nav>
        </div>
    </header>

    <main class="py-4">
        <div class="container">
            @yield('content')
        </div>
    </main>

    <footer class="site-footer py-3 mt-4">
        <div class="container text-center">
            &copy; {{ date('Y') }} Blog Kami. Seluruh hak cipta dilindungi.
        </div>
    </footer>

</body>
</html>
