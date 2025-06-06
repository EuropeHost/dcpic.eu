<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    protected $fillable = [
        'user_id', 'filename', 'original_name', 'mime', 'size', 'is_public',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
