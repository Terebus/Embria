<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Likes extends Model
{
    protected $fillable
        = [
            'object_id',
            'type',
            'user_id',
        ];

    public function news()
    {
        return $this->belongsTo(News::class, 'object_id', 'id')->where('type', 'news');
    }
}
