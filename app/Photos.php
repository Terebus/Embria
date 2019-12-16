<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Photos extends Model
{
    protected $fillable
        = [
            'file_name',
        ];

    public function likes()
    {
        return $this->hasMany(Likes::class, 'object_id', 'id')->where('type', 'photo');
    }
}
