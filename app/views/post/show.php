<div class="row justify-content-center mt-4">
    <div class="col-md-9">
        
        <!-- Post Detail Article -->
        <div class="card card-premium shadow-sm border-0 mb-4 overflow-hidden">
            <div class="card-body p-4 p-md-5">
                <div class="mb-3">
                    <span class="badge bg-primary bg-opacity-10 text-primary rounded-pill px-3 py-1.5" style="font-size: 0.85rem;">
                        <i class="bi bi-eye-fill me-1"></i> <?= $post->views ?> Tayangan
                    </span>
                </div>
                
                <h1 class="fw-extrabold mb-4 text-dark" style="font-weight: 800; letter-spacing: -0.5px; line-height: 1.25;"><?= htmlspecialchars($post->title) ?></h1>
                
                <div class="d-flex justify-content-between align-items-center mb-4 pb-3 border-bottom" style="border-color: #cbd5e1 !important;">
                    <div class="d-flex align-items-center">
                        <div class="profile-avatar text-white rounded-circle d-flex align-items-center justify-content-center fw-bold shadow-sm me-3" style="width: 48px; height: 48px; font-size: 1.2rem;">
                            <?= strtoupper(substr($post->user()->name, 0, 1)) ?>
                        </div>
                        <div>
                            <h6 class="mb-0 fw-bold text-dark"><?= htmlspecialchars($post->user()->name) ?></h6>
                            <small class="text-muted"><i class="bi bi-calendar3 me-1"></i><?= date('d M Y, h:i A', strtotime($post->created_at ?? 'now')) ?></small>
                        </div>
                    </div>
                </div>
                
                <div class="lead text-dark mb-4" style="white-space: pre-line; line-height: 1.8; font-size: 1.1rem; font-weight: 400;">
                    <?= htmlspecialchars($post->body) ?>
                </div>
                
                <!-- Display Images Grid -->
                <?php $images = $post->images(); if(!empty($images)): ?>
                    <div class="mt-4">
                        <h6 class="fw-bold text-secondary mb-3"><i class="bi bi-images me-1"></i> Galeri Foto</h6>
                        <div class="row g-3">
                            <?php foreach($images as $img): ?>
                                <div class="col-sm-6 col-md-4">
                                    <div class="card border-0 shadow-sm overflow-hidden" style="border-radius: 16px;">
                                        <img src="<?= baseUrl($img->image_path) ?>" class="img-fluid object-fit-cover w-100 img-thumb-custom" style="height: 220px;" alt="Post Image">
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
            
            <?php if(isset($_SESSION['user_id']) && $_SESSION['user_id'] == $post->user_id): ?>
                <div class="card-footer bg-light border-0 text-end py-3 px-5" style="border-top: 1px solid rgba(0,0,0,0.03) !important;">
                    <a href="<?= route('posts.edit', ['id' => $post->id]) ?>" class="btn btn-outline-custom rounded-pill btn-sm text-dark"><i class="bi bi-pencil me-1"></i> Edit Postingan</a>
                </div>
            <?php endif; ?>
        </div>

        <!-- Comments Section -->
        <div class="card card-premium shadow-sm border-0">
            <div class="card-body p-4 p-md-5">
                <h4 class="fw-bold text-dark mb-4"><i class="bi bi-chat-left-text me-2 text-primary"></i>Komentar (<?= count($post->comments()) ?>)</h4>
                
                <?php if(isset($_SESSION['user_id'])): ?>
                    <!-- Comment Form -->
                    <form action="<?= route('comments.store', ['id' => $post->id]) ?>" method="POST" class="mb-5">
                        <div class="d-flex gap-3">
                            <div class="profile-avatar text-white rounded-circle d-flex align-items-center justify-content-center fw-bold shadow-sm flex-shrink-0" style="width: 44px; height: 44px;">
                                <?= strtoupper(substr($_SESSION['user_name'], 0, 1)) ?>
                            </div>
                            <div class="flex-grow-1">
                                <textarea name="comment" class="form-control form-control-custom bg-light" rows="3" placeholder="Tulis komentar atau tanggapan Anda..." required></textarea>
                                <div class="text-end mt-3">
                                    <button type="submit" class="btn btn-primary px-4 rounded-pill"><i class="bi bi-send me-1"></i>Kirim Komentar</button>
                                </div>
                            </div>
                        </div>
                    </form>
                <?php else: ?>
                    <div class="alert alert-custom text-center border-0 bg-light shadow-xs mb-5 py-4">
                        <p class="mb-2 text-secondary">Silakan masuk ke akun Anda untuk dapat menulis komentar.</p>
                        <a href="<?= route('login') ?>" class="btn btn-primary btn-sm rounded-pill px-4">Login Sekarang</a>
                    </div>
                <?php endif; ?>

                <!-- List of Comments in Bubble Chat style -->
                <div class="d-flex flex-column gap-4">
                    <?php $comments = $post->comments(); if(empty($comments)): ?>
                        <div class="text-center text-muted py-3">
                            <p class="mb-0" style="font-size: 0.95rem;">Belum ada komentar. Jadilah yang pertama memberikan respon!</p>
                        </div>
                    <?php else: foreach($comments as $comment): ?>
                        <div class="d-flex gap-3">
                            <div class="bg-secondary bg-opacity-25 text-dark rounded-circle d-flex align-items-center justify-content-center fw-bold flex-shrink-0 shadow-xs" style="width: 40px; height: 40px; font-size: 0.95rem;">
                                <?= strtoupper(substr($comment->user()->name, 0, 1)) ?>
                            </div>
                            <div class="flex-grow-1">
                                <div class="p-3 shadow-xs" style="background-color: #f1f5f9; border-radius: 0 16px 16px 16px;">
                                    <h6 class="fw-bold mb-1 text-dark"><?= htmlspecialchars($comment->user()->name) ?></h6>
                                    <p class="mb-0 text-dark-50" style="font-size: 0.98rem; line-height: 1.5;"><?= nl2br(htmlspecialchars($comment->comment)) ?></p>
                                </div>
                                <small class="text-muted ms-2 mt-1 d-inline-block" style="font-size: 0.8rem;"><i class="bi bi-clock me-1"></i><?= date('d M Y, h:i A', strtotime($comment->created_at ?? 'now')) ?></small>
                            </div>
                        </div>
                    <?php endforeach; endif; ?>
                </div>

            </div>
        </div>
        
    </div>
</div>
