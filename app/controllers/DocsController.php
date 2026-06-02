<?php

namespace App\Controllers;

use App\Core\Controller;
use Exception;
use Parsedown;

class DocsController extends Controller
{
    public function index()
    {
        // Redirect ke halaman pertama dokumentasi
        $this->redirect(route('docs.show', ['page' => 'installation']));
    }

    public function show($page)
    {
        // Cegah akses directory traversal
        $page = preg_replace('/[^a-zA-Z0-9_-]/', '', $page);
        $filePath = __DIR__ . '/../../resources/docs/' . $page . '.md';

        if (!file_exists($filePath)) {
            // Tampilkan halaman 404 jika dokumen tidak ditemukan
            http_response_code(404);
            return $this->view('errors/404');
        }

        $markdownContent = file_get_contents($filePath);
        
        // Parse markdown ke HTML
        $parsedown = new Parsedown();
        $parsedown->setSafeMode(false); // Dianggap aman karena konten kita yang buat
        $htmlContent = $parsedown->text($markdownContent);

        // Ambil sidebar configuration
        $sidebarPath = __DIR__ . '/../../resources/docs/sidebar.json';
        $sidebarData = [];
        if (file_exists($sidebarPath)) {
            $sidebarData = json_decode(file_get_contents($sidebarPath), true);
        }

        // Tentukan judul dari halaman untuk <title>
        $title = ucfirst(str_replace('-', ' ', $page)) . ' - Zen PHP Documentation';

        // Render view dengan layout khusus docs
        // Karena layout standar mungkin tidak cocok, kita bisa passing custom flag atau buat method `viewLayout`
        // Namun, kita bisa mengirim flag ke view 'docs/show' dan menggunakan 'layouts/docs.php' di sana.
        return \App\Core\App::View('layouts/docs', [
            'content' => $htmlContent,
            'sidebar' => $sidebarData,
            'currentPage' => $page,
            'title' => $title
        ]);
    }
}
