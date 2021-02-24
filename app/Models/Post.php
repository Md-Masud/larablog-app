<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Post extends Model
{
    use Notifiable;
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
    public function categories()
    {
        return $this->belongsToMany(Category::class,'category_posts','post_id','categories_id')->withTimestamps();
    }
    public function tags()
    {
         return $this->belongsToMany(Tag::class ,'post_tags','post_id','tag_id')->withTimestamps();
    }

}
