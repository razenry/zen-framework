<?php

namespace App\Models;

use App\Core\Model;

class User extends Model
{
    protected $table = 'users';

    public function posts()
    {
        return Post::where('user_id', '=', $this->id)->get();
    }
}
