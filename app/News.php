<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    protected $fillable
        = [
            'author_id',
            'title',
            'content',
        ];

    public function likes()
    {
        return $this->hasMany(Likes::class, 'object_id', 'id')->where('type', 'news');
    }
}
