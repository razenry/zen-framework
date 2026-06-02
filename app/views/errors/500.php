<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-9">
            <div class="glass-container p-5 text-center shadow-lg border-0 mb-4">
                <!-- SVG Illustration -->
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 240 180" width="160" height="120" class="mb-4">
                    <rect x="40" y="30" width="160" height="120" rx="16" fill="rgba(239, 68, 68, 0.05)" stroke="rgba(239, 68, 68, 0.2)" stroke-width="2" />
                    <!-- Alert Triangle -->
                    <path d="M120 45 L155 105 L85 105 Z" fill="none" stroke="#ef4444" stroke-width="4" stroke-linejoin="round" />
                    <!-- Exclamation point -->
                    <line x1="120" y1="65" x2="120" y2="85" stroke="#ef4444" stroke-width="4" stroke-linecap="round" />
                    <circle cx="120" cy="95" r="2.5" fill="#ef4444" />
                    <!-- Floating gears/dots -->
                    <circle cx="65" cy="55" r="4" fill="#fca5a5" />
                    <circle cx="175" cy="120" r="3" fill="#f87171" />
                </svg>

                <h1 class="display-4 fw-extrabold text-danger mb-2" style="font-weight: 800; background: linear-gradient(135deg, #ef4444, #dc2626); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">500</h1>
                <h3 class="fw-bold mb-3">Terjadi Kesalahan Server</h3>
                <p class="text-secondary mb-4 mx-auto" style="max-width: 550px;">
                    Sistem kami mendeteksi masalah internal saat memproses permintaan Anda. Jangan khawatir, detail error telah dicatat dan tim kami akan segera menanganinya.
                </p>

                <?php if(isset($exception) && $exception): ?>
                    <div class="text-start mb-4">
                        <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                            <div class="card-header bg-danger bg-opacity-10 border-0 py-3 px-4 d-flex justify-content-between align-items-center">
                                <div>
                                    <span class="badge bg-danger rounded-pill px-3 py-1.5"><?= get_class($exception) ?></span>
                                </div>
                                <button class="btn btn-sm btn-outline-danger" type="button" data-bs-toggle="collapse" data-bs-target="#debugCollapse" aria-expanded="false" aria-controls="debugCollapse">
                                    <i class="bi bi-code-slash me-1"></i> Tampilkan Detail Debug
                                </button>
                            </div>
                            <div class="collapse" id="debugCollapse">
                                <div class="card-body p-4 bg-light border-top" style="border-color: rgba(0,0,0,0.05) !important;">
                                    <div class="mb-3">
                                        <h6 class="fw-bold text-dark mb-1">Pesan Error:</h6>
                                        <p class="text-danger fw-semibold mb-2" style="font-size: 1.05rem;"><?= htmlspecialchars($exception->getMessage()) ?></p>
                                        <small class="text-muted">
                                            <i class="bi bi-file-earmark-code me-1"></i> File: <strong><?= htmlspecialchars($exception->getFile()) ?></strong> pada baris <strong><?= $exception->getLine() ?></strong>
                                        </small>
                                    </div>
                                    <hr class="text-muted my-3">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <h6 class="fw-bold text-dark m-0">Stack Trace:</h6>
                                        <button class="btn btn-xs btn-outline-secondary py-1 px-2.5 rounded-3" style="font-size: 0.8rem;" onclick="copyStackTrace()">
                                            <i class="bi bi-clipboard me-1"></i> Salin Stack Trace
                                        </button>
                                    </div>
                                    <pre class="pre-box"><code id="stackTraceText"><?= htmlspecialchars($exception->getTraceAsString()) ?></code></pre>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>

                <div class="d-flex justify-content-center gap-3">
                    <a href="<?= route('home') ?>" class="btn btn-primary rounded-pill px-4"><i class="bi bi-house-door me-2"></i>Kembali ke Beranda</a>
                    <button onclick="window.location.reload();" class="btn btn-outline-custom rounded-pill px-4"><i class="bi bi-arrow-clockwise me-1"></i>Muat Ulang Halaman</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function copyStackTrace() {
    var copyText = document.getElementById("stackTraceText");
    if(copyText) {
        var range = document.createRange();
        range.selectNode(copyText);
        window.getSelection().removeAllRanges();
        window.getSelection().addRange(range);
        try {
            document.execCommand("copy");
            alert("Stack trace berhasil disalin ke clipboard!");
        } catch(err) {
            console.error("Gagal menyalin text", err);
        }
        window.getSelection().removeAllRanges();
    }
}
</script>
