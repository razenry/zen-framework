<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Comment;
use App\Models\Post;

class CommentController extends Controller
{
    public function store($id)
    {
        if (!isset($_SESSION['user_id'])) {
            $_SESSION['error'] = 'You must be logged in to comment.';
            header("Location: " . route('login'));
            exit;
        }

        $post = Post::find($id);
        if (!$post) {
            header("Location: " . route('home'));
            exit;
        }

        $commentText = $_POST['comment'] ?? '';
        if (trim($commentText) !== '') {
            Comment::create([
                'post_id' => $id,
                'user_id' => $_SESSION['user_id'],
                'comment' => htmlspecialchars($commentText)
            ]);
            $_SESSION['success'] = 'Comment posted!';
        }

        header("Location: " . route('posts.show', ['id' => $id]));
        exit;
    }
}
