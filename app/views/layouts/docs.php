<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($title) ? htmlspecialchars($title) : 'Zen PHP Documentation' ?></title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Fira+Code:wght@400;500&display=swap" rel="stylesheet">
    
    <!-- Syntax Highlighting (PrismJS) -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/themes/prism-tomorrow.min.css" rel="stylesheet" />
    
    <style>
        :root {
            --docs-primary: #4f46e5;
            --docs-primary-hover: #4338ca;
            --docs-text: #374151;
            --docs-text-light: #6b7280;
            --docs-bg: #ffffff;
            --docs-bg-alt: #f9fafb;
            --docs-border: #e5e7eb;
            --docs-sidebar-w: 280px;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Inter', sans-serif;
            color: var(--docs-text);
            background-color: var(--docs-bg);
            line-height: 1.6;
            -webkit-font-smoothing: antialiased;
        }

        /* Navbar */
        .docs-nav {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            height: 65px;
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(229, 231, 235, 0.5);
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.02);
            display: flex;
            align-items: center;
            padding: 0 2rem;
            z-index: 50;
            justify-content: space-between;
        }

        .docs-logo {
            font-size: 1.35rem;
            font-weight: 800;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            color: #111827;
            letter-spacing: -0.02em;
        }
        
        .docs-logo span {
            background: linear-gradient(135deg, var(--docs-primary), #ec4899);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .nav-links a {
            text-decoration: none;
            color: var(--docs-text-light);
            font-weight: 600;
            font-size: 0.95rem;
            margin-left: 1.5rem;
            transition: all 0.2s;
            padding: 0.5rem 1rem;
            border-radius: 0.5rem;
        }
        
        .nav-links a:hover {
            color: var(--docs-primary);
            background: #f3f4f6;
        }

        /* Layout */
        .docs-container {
            display: flex;
            margin-top: 65px;
            min-height: calc(100vh - 65px);
        }

        /* Sidebar */
        .docs-sidebar {
            width: var(--docs-sidebar-w);
            position: fixed;
            top: 65px;
            bottom: 0;
            left: 0;
            overflow-y: auto;
            border-right: 1px solid rgba(229, 231, 235, 0.5);
            padding: 2.5rem 1.5rem;
            background: rgba(249, 250, 251, 0.6);
            backdrop-filter: blur(20px);
        }

        /* Custom Scrollbar for Sidebar */
        .docs-sidebar::-webkit-scrollbar {
            width: 6px;
        }
        .docs-sidebar::-webkit-scrollbar-track {
            background: transparent;
        }
        .docs-sidebar::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 10px;
        }
        .docs-sidebar::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }

        .sidebar-section {
            margin-bottom: 2.25rem;
        }

        .sidebar-title {
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            font-weight: 800;
            color: #94a3b8;
            margin-bottom: 1rem;
            padding-left: 0.5rem;
        }

        .sidebar-nav {
            list-style: none;
        }

        .sidebar-nav li {
            margin-bottom: 0.25rem;
        }

        .sidebar-nav a {
            text-decoration: none;
            color: #475569;
            font-size: 0.9rem;
            font-weight: 500;
            display: block;
            padding: 0.4rem 0.75rem;
            border-radius: 0.5rem;
            transition: all 0.2s ease;
        }

        .sidebar-nav a:hover {
            background: #e2e8f0;
            color: #0f172a;
            transform: translateX(3px);
        }

        .sidebar-nav a.active {
            color: var(--docs-primary);
            background: #eef2ff;
            font-weight: 600;
            box-shadow: inset 3px 0 0 var(--docs-primary);
        }

        /* Main Content */
        .docs-main {
            flex: 1;
            margin-left: var(--docs-sidebar-w);
            padding: 4rem 3rem;
            max-width: 850px;
        }

        /* Typography & Markdown Styles */
        .prose h1 {
            font-size: 2.75rem;
            font-weight: 800;
            color: #0f172a;
            margin-bottom: 1.5rem;
            letter-spacing: -0.03em;
            line-height: 1.2;
        }

        .prose h2 {
            font-size: 1.75rem;
            font-weight: 700;
            color: #1e293b;
            margin-top: 3.5rem;
            margin-bottom: 1.25rem;
            padding-bottom: 0.5rem;
            border-bottom: 1px solid var(--docs-border);
            letter-spacing: -0.01em;
        }

        .prose h3 {
            font-size: 1.35rem;
            font-weight: 600;
            margin-top: 2.5rem;
            margin-bottom: 1rem;
            color: #334155;
        }

        .prose p {
            margin-bottom: 1.5rem;
            font-size: 1.05rem;
            color: #475569;
            line-height: 1.7;
        }

        .prose a {
            color: var(--docs-primary);
            text-decoration: none;
            font-weight: 500;
            border-bottom: 1px solid transparent;
            transition: border-color 0.2s;
        }

        .prose a:hover {
            border-color: var(--docs-primary);
        }

        .prose ul, .prose ol {
            margin-bottom: 1.5rem;
            padding-left: 1.75rem;
            font-size: 1.05rem;
            color: #475569;
        }

        .prose li {
            margin-bottom: 0.5rem;
        }

        /* Inline Code */
        .prose code {
            font-family: 'Fira Code', monospace;
            background: #f1f5f9;
            padding: 0.2em 0.4em;
            border-radius: 0.375rem;
            font-size: 0.875em;
            color: #db2777;
            font-weight: 500;
            border: 1px solid #e2e8f0;
        }
        
        /* Prism overrides */
        .prose pre {
            border-radius: 0.75rem;
            margin-bottom: 2rem;
            background: #0f172a !important; /* Sangat gelap, ala terminal modern */
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            border: 1px solid rgba(255,255,255,0.1);
            padding: 1.25rem 1.5rem !important;
            overflow-x: auto;
        }
        
        .prose pre code {
            background: transparent;
            padding: 0;
            color: #f8fafc; /* Warna terang agar terbaca di background gelap */
            font-size: 0.9em;
            border: none;
            font-weight: 400;
        }

        .prose blockquote {
            border-left: 4px solid var(--docs-primary);
            background: linear-gradient(to right, #eef2ff, #f8fafc);
            padding: 1.25rem 1.5rem;
            margin-bottom: 2rem;
            border-radius: 0 0.75rem 0.75rem 0;
            color: #475569;
            font-style: italic;
            box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
        }
        
        .prose blockquote p:last-child {
            margin-bottom: 0;
        }

        /* Mobile Menu */
        .menu-toggle {
            display: none;
            background: none;
            border: none;
            cursor: pointer;
            padding: 0.5rem;
        }

        .menu-toggle svg {
            width: 24px;
            height: 24px;
            color: var(--docs-text);
        }

        @media (max-width: 768px) {
            .docs-sidebar {
                transform: translateX(-100%);
                transition: transform 0.3s ease;
                z-index: 40;
                background: white;
            }

            .docs-sidebar.open {
                transform: translateX(0);
                box-shadow: 4px 0 24px rgba(0,0,0,0.1);
            }

            .docs-main {
                margin-left: 0;
                padding: 2rem 1rem;
            }

            .menu-toggle {
                display: block;
            }
            
            .nav-links {
                display: none;
            }
        }
    </style>
</head>
<body>

    <nav class="docs-nav">
        <a href="<?= route('home') ?>" class="docs-logo">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="color: var(--docs-primary)"><polygon points="12 2 2 7 12 12 22 7 12 2"></polygon><polyline points="2 17 12 22 22 17"></polyline><polyline points="2 12 12 17 22 12"></polyline></svg>
            Zen <span>PHP</span>
        </a>
        <div class="nav-links">
            <a href="<?= route('home') ?>">Kembali ke App</a>
            <a href="https://github.com/razenry/zen-framework" target="_blank">GitHub</a>
        </div>
        <button class="menu-toggle" id="menuToggle">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
            </svg>
        </button>
    </nav>

    <div class="docs-container">
        <!-- Sidebar -->
        <aside class="docs-sidebar" id="sidebar">
            <?php foreach ($sidebar as $section): ?>
                <div class="sidebar-section">
                    <h3 class="sidebar-title"><?= htmlspecialchars($section['title']) ?></h3>
                    <ul class="sidebar-nav">
                        <?php foreach ($section['items'] as $item): ?>
                            <li>
                                <a href="<?= route('docs.show', ['page' => $item['path']]) ?>" 
                                   class="<?= ($currentPage === $item['path']) ? 'active' : '' ?>">
                                    <?= htmlspecialchars($item['title']) ?>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endforeach; ?>
        </aside>

        <!-- Main Content -->
        <main class="docs-main">
            <div class="prose">
                <?= $content ?>
            </div>
            
            <div style="margin-top: 4rem; padding-top: 2rem; border-top: 1px solid var(--docs-border); display: flex; justify-content: space-between; align-items: center;">
                <p style="color: var(--docs-text-light); font-size: 0.875rem;">
                    &copy; <?= date('Y') ?> Zen PHP Framework. MIT License.
                </p>
            </div>
        </main>
    </div>

    <!-- Scripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/prism.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/components/prism-php.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/components/prism-bash.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/components/prism-json.min.js"></script>
    <script>
        // Toggle Sidebar on Mobile
        const menuToggle = document.getElementById('menuToggle');
        const sidebar = document.getElementById('sidebar');

        menuToggle.addEventListener('click', () => {
            sidebar.classList.toggle('open');
        });
    </script>
</body>
</html>
