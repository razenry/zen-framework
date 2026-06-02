<nav class="navbar navbar-expand-lg navbar-dark navbar-custom shadow-sm mb-4">
    <div class="container">
        <a class="navbar-brand fw-bold d-flex align-items-center" href="<?= route('home') ?>">
            <i class="bi bi-box-seam-fill me-2 fs-4"></i>
            <span>Zen PHP</span>
        </a>
        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link" aria-current="page" href="<?= route('home') ?>">Home</a>
                </li>
                <?php if(isset($_SESSION['user_id'])): ?>
                <li class="nav-item">
                    <a class="nav-link" href="<?= route('posts') ?>">My Posts</a>
                </li>
                <?php endif; ?>
                <li class="nav-item">
                    <a class="nav-link" href="<?= route('about') ?>">About</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link fw-bold text-info" href="<?= route('docs.index') ?>"><i class="bi bi-book me-1"></i>Docs</a>
                </li>
            </ul>
            <ul class="navbar-nav align-items-center">
                <?php if(isset($_SESSION['user_id'])): ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <div class="bg-primary bg-opacity-25 text-white rounded-circle d-flex align-items-center justify-content-center fw-bold me-2" style="width: 28px; height: 28px; font-size: 0.85rem;">
                                <?= strtoupper(substr($_SESSION['user_name'], 0, 1)) ?>
                            </div>
                            <span><?= htmlspecialchars($_SESSION['user_name']) ?></span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end border-0 shadow-lg mt-2 rounded-3" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item py-2 text-danger d-flex align-items-center" href="<?= route('logout') ?>"><i class="bi bi-box-arrow-right me-2"></i> Logout</a></li>
                        </ul>
                    </li>
                <?php else: ?>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= route('login') ?>">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="btn btn-primary btn-sm ms-lg-3 px-3 py-1.5 rounded-pill" href="<?= route('register') ?>">Register</a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>
