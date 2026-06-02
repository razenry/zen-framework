<div class="row justify-content-center align-items-center" style="min-height: 65vh;">
    <div class="col-md-5">
        <div class="card card-premium shadow-sm border-0 p-3">
            <div class="card-body">
                <div class="text-center mb-4">
                    <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                        <i class="bi bi-shield-lock-fill fs-3"></i>
                    </div>
                    <h3 class="fw-extrabold m-0" style="font-weight: 800; letter-spacing: -0.5px;">Selamat Datang Kembali</h3>
                    <p class="text-secondary mt-1">Silakan masuk ke akun Anda</p>
                </div>
                
                <form action="<?= route('login.process') ?>" method="POST">
                    <div class="mb-3">
                        <label for="email" class="form-label fw-semibold text-secondary">Alamat Email</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0" style="border-radius: 12px 0 0 12px; border-color: #cbd5e1;"><i class="bi bi-envelope text-muted"></i></span>
                            <input type="email" class="form-control form-control-custom border-start-0" style="border-radius: 0 12px 12px 0;" id="email" name="email" placeholder="nama@email.com" required>
                        </div>
                    </div>
                    <div class="mb-4">
                        <label for="password" class="form-label fw-semibold text-secondary">Kata Sandi</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0" style="border-radius: 12px 0 0 12px; border-color: #cbd5e1;"><i class="bi bi-key text-muted"></i></span>
                            <input type="password" class="form-control form-control-custom border-start-0" style="border-radius: 0 12px 12px 0;" id="password" name="password" placeholder="Masukkan kata sandi" required>
                        </div>
                    </div>
                    <div class="d-grid mb-3">
                        <button type="submit" class="btn btn-primary btn-lg rounded-pill"><i class="bi bi-box-arrow-in-right me-2"></i>Masuk Sekarang</button>
                    </div>
                </form>
                
                <div class="text-center mt-4">
                    <p class="text-secondary mb-0">Belum punya akun? <a href="<?= route('register') ?>" class="text-decoration-none fw-bold hover-primary">Daftar di sini</a></p>
                </div>
            </div>
        </div>
    </div>
</div>
