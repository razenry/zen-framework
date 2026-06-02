<?php

namespace App\Models;

use App\Core\Model;

class Post extends Model
{
    protected $table = 'posts';

    public function user()
    {
        return User::find($this->user_id); 
    }

    public function images()
    {
        return PostImage::where('post_id', '=', $this->id)->get();
    }

    public function comments()
    {
        return Comment::where('post_id', '=', $this->id)->get();
    }
}
