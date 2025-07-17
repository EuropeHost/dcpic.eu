<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Image extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'type', 'filename', 'original_name', 'mime', 'size', 'is_public', 'slug',
    ];

    protected $keyType = 'string';
    public $incrementing = false;

    public function getRouteKeyName()
    {
        return 'slug';
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->id)) {
                $model->id = (string) Str::uuid();
            }

            if (empty($model->slug)) {
                $model->slug = self::generateUniqueSlug();
            }
        });
    }

    protected static function generateUniqueSlug()
    {
        do {
            $slug = Str::random(7);
        } while (self::where('slug', $slug)->exists());
        return $slug;
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
