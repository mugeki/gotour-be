<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlaceImage extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'place_id',
        'img_url',
    ];
}