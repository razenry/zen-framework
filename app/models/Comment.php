<?php

namespace App\Models;

use App\Core\Model;

class Comment extends Model
{
    protected $table = 'comments';

    public function user()
    {
        return User::find($this->user_id);
    }
}
