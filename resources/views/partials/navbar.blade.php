{{-- resources/views/partials/navbar.blade.php --}}
<header class="site-header" id="top">
    <nav class="nav-pill" role="navigation" aria-label="Navigasi utama">
        {{-- Tombol hamburger (mobile) --}}
        <button class="hamburger" id="hamburger" aria-label="Buka menu" aria-controls="drawer" aria-expanded="false">
            <span></span><span></span><span></span>
        </button>

        {{-- Brand / Logo --}}
        <a class="brand" href="#home" data-nav="home">
            <span class="brand-icon" aria-hidden="true">🧭</span>
            <span class="brand-text">Piforrr7</span>
        </a>

        {{-- Link navbar (desktop) --}}
        <div class="nav-links" id="navLinks">
            {{-- Nanti kita bisa ganti target sesuai section Piforrr7 (home, tentang, statistik, sejarah, pulau) --}}
            <button class="nav-btn is-active" data-target="#home">
                <span class="icon">🏠</span><span>Home</span>
            </button>
            <button class="nav-btn" data-target="#about">
                <span class="icon">ℹ️</span><span>Tentang</span>
            </button>
            <button class="nav-btn" data-target="#stats">
                <span class="icon">📊</span><span>Statistik</span>
            </button>
            <button class="nav-btn" data-target="#history">
                <span class="icon">📜</span><span>Sejarah</span>
            </button>
            <button class="nav-btn" data-target="#islands">
                <span class="icon">🗺️</span><span>Pulau</span>
            </button>

            {{-- indikator kapsul aktif (garis/shape bergerak di belakang tombol) --}}
            <span class="active-indicator" aria-hidden="true"></span>
        </div>

        {{-- Tombol ganti tema (light/dark) --}}
        <button class="theme-toggle" id="themeToggle" aria-label="Ubah tema">
            <span class="sun">☀️</span>
            <span class="moon">🌙</span>
        </button>
    </nav>

    {{-- Drawer / sidebar untuk mobile --}}
    <aside class="drawer" id="drawer" aria-hidden="true">
        <div class="drawer-header">
            <div class="drawer-brand">🧭 Piforrr7</div>
            <button id="closeDrawer" class="close-drawer" aria-label="Tutup menu">✕</button>
        </div>

        <div class="drawer-links">
            <a href="#home"    data-target="#home"    class="drawer-link">🏠 Home</a>
            <a href="#about"   data-target="#about"   class="drawer-link">ℹ️ Tentang</a>
            <a href="#stats"   data-target="#stats"   class="drawer-link">📊 Statistik</a>
            <a href="#history" data-target="#history" class="drawer-link">📜 Sejarah</a>
            <a href="#islands" data-target="#islands" class="drawer-link">🗺️ Pulau</a>
        </div>

        <div class="drawer-footer">
            <button class="btn full" id="drawerTheme">Ganti Tema</button>
        </div>
    </aside>

    <div id="drawerOverlay" class="drawer-overlay" aria-hidden="true"></div>
</header>
