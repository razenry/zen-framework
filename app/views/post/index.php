<div class="d-flex justify-content-between align-items-center mb-4 pb-2">
    <div>
        <h2 class="fw-extrabold m-0" style="font-weight: 800; letter-spacing: -0.5px;">Postingan Saya</h2>
        <p class="text-secondary mb-0">Kelola dan lihat postingan yang telah Anda buat</p>
    </div>
    <a href="<?= route('posts.create') ?>" class="btn btn-primary rounded-pill px-4"><i class="bi bi-plus-lg me-1"></i> Buat Post Baru</a>
</div>

<?php if (empty($posts)): ?>
    <div class="card card-premium p-5 text-center text-muted">
        <div class="bg-light rounded-circle d-inline-flex align-items-center justify-content-center mb-3 mx-auto" style="width: 70px; height: 70px;">
            <i class="bi bi-folder-x fs-2 text-secondary"></i>
        </div>
        <h5 class="fw-bold text-dark">Tidak Ada Postingan</h5>
        <p class="mb-3">Anda belum menulis postingan apa pun. Mulai bagikan artikel pertama Anda!</p>
        <div>
            <a href="<?= route('posts.create') ?>" class="btn btn-primary rounded-pill px-4">Tulis Post Pertama</a>
        </div>
    </div>
<?php else: ?>
    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
        <?php foreach ($posts as $post): ?>
            <div class="col">
                <div class="card card-premium h-100 shadow-sm border-0 d-flex flex-column justify-content-between">
                    <div class="card-body p-4">
                        <span class="badge bg-primary bg-opacity-10 text-primary rounded-pill px-2.5 py-1.5 mb-3" style="font-size: 0.8rem;">
                            <i class="bi bi-eye-fill me-1"></i> <?= $post->views ?? 0 ?> Tayangan
                        </span>
                        <h5 class="card-title fw-bold text-dark mb-2">
                            <a href="<?= route('posts.show', ['id' => $post->id]) ?>" class="text-dark text-decoration-none hover-primary">
                                <?= htmlspecialchars($post->title) ?>
                            </a>
                        </h5>
                        <p class="card-text text-secondary" style="font-size: 0.95rem; line-height: 1.5;">
                            <?= nl2br(htmlspecialchars(strlen($post->body) > 100 ? substr($post->body, 0, 100) . '...' : $post->body)) ?>
                        </p>
                    </div>
                    <div class="card-footer bg-light border-0 d-flex justify-content-end gap-2 pb-3 px-4" style="border-top: 1px solid rgba(0,0,0,0.03) !important;">
                        <a href="<?= route('posts.edit', ['id' => $post->id]) ?>" class="btn btn-sm btn-outline-custom rounded-pill text-dark"><i class="bi bi-pencil me-1"></i> Edit</a>
                        <form action="<?= route('posts.delete', ['id' => $post->id]) ?>" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus postingan ini?');">
                            <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill"><i class="bi bi-trash me-1"></i> Hapus</button>
                        </form>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>
