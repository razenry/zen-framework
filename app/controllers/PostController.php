<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\App;
use App\Models\Post;

class PostController extends Controller
{
    public function index()
    {
        if (!isset($_SESSION['user_id'])) {
            $_SESSION['error'] = 'You must be logged in to view posts.';
            header("Location: " . route('login'));
            exit;
        }

        $userId = $_SESSION['user_id'];
        $posts = Post::where('user_id', '=', $userId)->get();

        $data['title'] = 'My Posts';
        $data['posts'] = $posts;

        App::Layout('main', 'post/index', $data);
    }

    public function create()
    {
        if (!isset($_SESSION['user_id'])) {
            header("Location: " . route('login'));
            exit;
        }

        $data['title'] = 'Create Post';
        App::Layout('main', 'post/create', $data);
    }

    public function show($id)
    {
        $post = Post::find($id);
        if (!$post) {
            header("Location: " . route('home'));
            exit;
        }

        // Increment view count
        $newViews = ($post->views ?? 0) + 1;
        Post::where('id', '=', $id)->update(['views' => $newViews]);
        $post->views = $newViews;

        $data['title'] = $post->title;
        $data['post'] = $post;
        App::Layout('main', 'post/show', $data);
    }

    public function edit($id)
    {
        if (!isset($_SESSION['user_id'])) {
            header("Location: " . route('login'));
            exit;
        }

        $post = Post::find($id);

        if (!$post || $post->user_id != $_SESSION['user_id']) {
            $_SESSION['error'] = 'Post not found or unauthorized.';
            header("Location: " . route('posts'));
            exit;
        }

        $data['title'] = 'Edit Post';
        $data['post'] = $post;
        App::Layout('main', 'post/edit', $data);
    }

    public function store()
    {
        if (!isset($_SESSION['user_id'])) {
            header("Location: " . route('login'));
            exit;
        }

        $title = $_POST['title'] ?? '';
        $body = $_POST['body'] ?? '';

        $post = Post::create([
            'user_id' => $_SESSION['user_id'],
            'title' => $title,
            'body' => $body
        ]);

        $this->handleUploads($post->id);

        $_SESSION['success'] = 'Post created successfully!';
        header("Location: " . route('home'));
        exit;
    }

    public function update($id)
    {
        if (!isset($_SESSION['user_id'])) {
            header("Location: " . route('login'));
            exit;
        }

        $post = Post::find($id);

        if (!$post || $post->user_id != $_SESSION['user_id']) {
            $_SESSION['error'] = 'Post not found or unauthorized.';
            header("Location: " . route('posts'));
            exit;
        }

        $title = $_POST['title'] ?? '';
        $body = $_POST['body'] ?? '';

        Post::where('id', '=', $id)->update([
            'title' => $title,
            'body' => $body
        ]);

        $this->handleUploads($id);

        $_SESSION['success'] = 'Post updated successfully!';
        header("Location: " . route('posts.show', ['id' => $id]));
        exit;
    }

    private function handleUploads($postId)
    {
        if (isset($_FILES['images']) && !empty($_FILES['images']['name'][0])) {
            $uploadDir = dirname(__DIR__, 2) . '/public/uploads/';
            
            foreach ($_FILES['images']['tmp_name'] as $key => $tmp_name) {
                if ($_FILES['images']['error'][$key] == 0) {
                    $fileName = time() . '_' . basename($_FILES['images']['name'][$key]);
                    $targetFilePath = $uploadDir . $fileName;

                    if (move_uploaded_file($tmp_name, $targetFilePath)) {
                        \App\Models\PostImage::create([
                            'post_id' => $postId,
                            'image_path' => 'public/uploads/' . $fileName
                        ]);
                    }
                }
            }
        }
    }

    public function delete($id)
    {
        if (!isset($_SESSION['user_id'])) {
            header("Location: " . route('login'));
            exit;
        }

        $post = Post::find($id);

        if (!$post || $post->user_id != $_SESSION['user_id']) {
            $_SESSION['error'] = 'Post not found or unauthorized.';
            header("Location: " . route('posts'));
            exit;
        }

        Post::where('id', '=', $id)->delete();
        \App\Models\PostImage::where('post_id', '=', $id)->delete();
        \App\Models\Comment::where('post_id', '=', $id)->delete();

        $_SESSION['success'] = 'Post deleted successfully!';
        header("Location: " . route('home'));
        exit;
    }
}
