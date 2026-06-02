<div class="container d-flex align-items-center justify-content-center" style="min-height: 70vh;">
    <div class="glass-container p-5 text-center max-w-lg shadow-lg border-0" style="max-width: 550px; width: 100%;">
        <!-- SVG Illustration -->
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 240 180" width="180" height="135" class="mb-4">
            <rect x="40" y="30" width="160" height="120" rx="16" fill="rgba(99, 102, 241, 0.05)" stroke="rgba(99, 102, 241, 0.2)" stroke-width="2" />
            <circle cx="120" cy="80" r="32" fill="none" stroke="#6366f1" stroke-width="3" stroke-dasharray="6 4" />
            <line x1="142" y1="102" x2="165" y2="125" stroke="#4f46e5" stroke-width="4" stroke-linecap="round" />
            <!-- Floating particles -->
            <circle cx="65" cy="55" r="4" fill="#a5b4fc" />
            <circle cx="175" cy="50" r="3" fill="#818cf8" />
            <circle cx="70" cy="120" r="3" fill="#c7d2fe" />
        </svg>

        <h1 class="display-3 fw-extrabold text-primary mb-2 font-family" style="font-weight: 800; background: linear-gradient(135deg, #6366f1, #4f46e5); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">404</h1>
        <h3 class="fw-bold mb-3">Halaman Tidak Ditemukan</h3>
        <p class="text-secondary mb-4">Ups! Halaman yang Anda cari tidak tersedia atau telah dipindahkan ke alamat lain.</p>
        <div class="d-grid gap-2 col-8 mx-auto">
            <a href="<?= route('home') ?>" class="btn btn-primary btn-lg rounded-pill px-4"><i class="bi bi-house-door me-2"></i>Kembali ke Beranda</a>
        </div>
    </div>
</div>
