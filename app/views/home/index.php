<div class="row justify-content-center mt-4">
    <div class="col-md-8">
        <div class="d-flex justify-content-between align-items-center mb-4 pb-2">
            <div>
                <h2 class="fw-extrabold m-0" style="font-weight: 800; letter-spacing: -0.5px;">Global Feed</h2>
                <p class="text-secondary mb-0">Temukan cerita dan ide menarik hari ini</p>
            </div>
            <?php if(isset($_SESSION['user_id'])): ?>
                <a href="<?= route('posts.create') ?>" class="btn btn-primary rounded-pill px-4"><i class="bi bi-pencil-square me-2"></i>Buat Postingan</a>
            <?php endif; ?>
        </div>

        <?php if(empty($posts)): ?>
            <div class="card card-premium p-5 text-center text-muted">
                <div class="bg-light rounded-circle d-inline-flex align-items-center justify-content-center mb-3 mx-auto" style="width: 70px; height: 70px;">
                    <i class="bi bi-inbox fs-2 text-secondary"></i>
                </div>
                <h5 class="fw-bold text-dark">Belum Ada Postingan</h5>
                <p class="mb-0">Jadilah yang pertama untuk berbagi pemikiran dan cerita menarik Anda!</p>
            </div>
        <?php else: ?>
            <div class="d-flex flex-column gap-4">
                <?php foreach($posts as $post): ?>
                    <div class="card card-premium shadow-sm">
                        <div class="card-body p-4">
                            <!-- User metadata -->
                            <div class="d-flex align-items-center mb-3">
                                <div class="profile-avatar text-white rounded-circle d-flex align-items-center justify-content-center fw-bold shadow-sm" style="width: 44px; height: 44px; font-size: 1.1rem;">
                                    <?= strtoupper(substr($post->user()->name, 0, 1)) ?>
                                </div>
                                <div class="ms-3">
                                    <h6 class="mb-0 fw-bold text-dark"><?= htmlspecialchars($post->user()->name) ?></h6>
                                    <small class="text-muted"><i class="bi bi-calendar3 me-1"></i><?= date('d M Y', strtotime($post->created_at ?? 'now')) ?></small>
                                </div>
                            </div>
                            
                            <!-- Post info -->
                            <h4 class="fw-bold mb-2">
                                <a href="<?= route('posts.show', ['id' => $post->id]) ?>" class="text-dark text-decoration-none hover-primary" style="letter-spacing: -0.3px;">
                                    <?= htmlspecialchars($post->title) ?>
                                </a>
                            </h4>
                            
                            <p class="text-secondary mb-3" style="line-height: 1.6;">
                                <?= nl2br(htmlspecialchars(strlen($post->body) > 150 ? substr($post->body, 0, 150) . '...' : $post->body)) ?>
                            </p>
                            
                            <!-- Image gallery -->
                            <?php $images = $post->images(); if(!empty($images)): ?>
                                <div class="mb-3 d-flex gap-2 overflow-auto pb-2 scrollbar-thin">
                                    <?php foreach($images as $img): ?>
                                        <a href="<?= route('posts.show', ['id' => $post->id]) ?>">
                                            <img src="<?= baseUrl($img->image_path) ?>" alt="Post Image" class="img-thumb-custom" style="height: 110px; width: 110px;">
                                        </a>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>
                            
                        </div>
                        <!-- Footer metadata details -->
                        <div class="card-footer bg-light border-0 py-3 px-4 d-flex justify-content-between align-items-center" style="border-top: 1px solid rgba(0,0,0,0.03) !important;">
                            <div class="text-muted small d-flex align-items-center gap-3">
                                <span><i class="bi bi-eye-fill me-1 text-primary"></i> <strong><?= $post->views ?? 0 ?></strong> Tayangan</span>
                            </div>
                            <div>
                                <a href="<?= route('posts.show', ['id' => $post->id]) ?>" class="btn btn-sm btn-outline-custom rounded-pill px-3 py-1 fw-semibold text-primary" style="background: rgba(99, 102, 241, 0.05); border: none;">
                                    <i class="bi bi-chat-text-fill me-1"></i> <?= count($post->comments()) ?> Komentar
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</div>
