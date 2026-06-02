<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card card-premium shadow-sm border-0">
            <div class="card-header bg-white pt-4 pb-0 border-0 px-4">
                <h3 class="card-title fw-extrabold text-dark m-0" style="font-weight: 800; letter-spacing: -0.5px;"><i class="bi bi-file-earmark-plus text-primary me-2"></i>Buat Postingan Baru</h3>
                <p class="text-secondary mt-1 mb-0">Bagikan pemikiran, tulisan, atau ide menarik Anda hari ini</p>
            </div>
            <div class="card-body p-4">
                <form action="<?= route('posts.store') ?>" method="POST" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="title" class="form-label fw-semibold text-secondary">Judul Postingan</label>
                        <input type="text" class="form-control form-control-custom" id="title" name="title" required placeholder="Masukkan judul postingan Anda">
                    </div>
                    <div class="mb-3">
                        <label for="images" class="form-label fw-semibold text-secondary">Unggah Foto (Opsional, Bisa Lebih dari Satu)</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light" style="border-radius: 12px 0 0 12px; border-color: #cbd5e1;"><i class="bi bi-camera text-muted"></i></span>
                            <input class="form-control form-control-custom" style="border-radius: 0 12px 12px 0;" type="file" id="images" name="images[]" multiple accept="image/*">
                        </div>
                        <div class="form-text text-muted mt-1" style="font-size: 0.82rem;"><i class="bi bi-info-circle me-1"></i>Anda dapat memilih beberapa foto sekaligus untuk disertakan dalam postingan.</div>
                    </div>
                    <div class="mb-4">
                        <label for="body" class="form-label fw-semibold text-secondary">Konten Postingan</label>
                        <textarea class="form-control form-control-custom" id="body" name="body" rows="6" required placeholder="Tuliskan pemikiran atau isi cerita Anda secara lengkap di sini..."></textarea>
                    </div>
                    <div class="d-flex justify-content-between align-items-center border-top pt-3" style="border-color: #e2e8f0 !important;">
                        <a href="<?= route('posts') ?>" class="btn btn-light-custom rounded-pill px-4">Batal</a>
                        <button type="submit" class="btn btn-primary rounded-pill px-4"><i class="bi bi-check-circle me-1"></i>Simpan Postingan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
