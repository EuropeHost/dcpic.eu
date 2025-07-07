<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Image extends Model
{
    protected $fillable = [
        'user_id', 'filename', 'original_name', 'mime', 'size', 'is_public',
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

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
