<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserSavedPlace extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'place_id',
        'user_id',
    ];

    public function places()
    {
        return $this->belongsTo(Place::class, 'place_id', 'id');
    }

    public function users()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}