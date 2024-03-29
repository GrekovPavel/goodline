<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'content',
        'expiration_time',
        'link',
        'access',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
