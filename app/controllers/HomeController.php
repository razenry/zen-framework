<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\App;
use App\Models\Post;

class HomeController extends Controller
{
    public function index()
    {
        // Global Feed: Ambil semua post dari terbaru
        $allPosts = array_reverse(Post::all());

        $data['title'] = 'Home Feed';
        $data['posts'] = $allPosts;

        App::Layout('main', 'home/index', $data);
    }

    public function about()
    {
        $data['title'] = 'About Us';
        App::Layout('main', 'home/about', $data);
    }
}
