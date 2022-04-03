<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Place extends Model
{
    use HasFactory;

    protected $fillable = [
        'author_id',
        'name',
        'location',
        'description',
        'rating',
    ];

    public function users()
    {
        return $this->belongsTo(User::class, 'author_id', 'id');
    }

    public function place_images()
    {
        return $this->hasMany(PlaceImage::class, 'place_id', 'id');
    }

    public function user_rated_places()
    {
        return $this->hasMany(UserRatedPlace::class, 'place_id', 'id');
    }
}