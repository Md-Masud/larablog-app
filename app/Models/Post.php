<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;
    protected $fillable=[
        'name',
        'title',
        'slug',
        'image',
        'body',
        'view_count',
        'status',
        'is_approved'
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
