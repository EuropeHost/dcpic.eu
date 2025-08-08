<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class LinkView extends Model
{
    use HasFactory;

    protected $table = 'link_views';

    protected $fillable = [
        'link_id',
        'ip_address', 'user_agent', 'viewer_user_id'
    ];

    protected $keyType = 'string';
    public $incrementing = false;

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->id)) {
                $model->id = (string) Str::uuid();
            }
        });
    }

    public function link()
    {
        return $this->belongsTo(Link::class);
    }

    public function viewer()
    {
        return $this->belongsTo(User::class, 'viewer_user_id');
    }
}