<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Image;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name',
        'email',
        'discord_id',
        'avatar',
    ];

    protected $hidden = [
        'remember_token',
    ];
	
	public function images()
	{
	    return $this->hasMany(Image::class);
	}
	
	public function getStorageUsedAttribute()
	{
	    return $this->images()->sum('size');
	}
	
	public function getStorageUsedMBAttribute()
	{
	    return round($this->storage_used / 1024 / 1024, 2);
	}
	
	/*
	public function getStorageLimitMBAttribute()
	{
	    return 250;
	}
	
	public function getStoragePercentageAttribute()
	{
	    return min(100, round(($this->storage_used / (250 * 1024 * 1024)) * 100, 2));
	}
	*/
	
	public function getStorageLimitMBAttribute()
	{
	    return 150;
	}
	
	public function getStoragePercentageAttribute()
	{
	    return min(100, round(($this->storage_used / (150 * 1024 * 1024)) * 100, 2));
	}
	
	/*public function storage_limit()
	{
		return $this->getStorageLimitMBAttribute;
	}*/
}
