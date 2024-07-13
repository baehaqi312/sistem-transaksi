<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    use HasFactory;

    protected $fillable = [
        'creator_id',
        'title',
        'thumbnail',
        'body',
    ];

    public function creator()
    {
        return $this->hasOne(User::class, 'id', 'creator_id');
    }

    public function categories()
    {
        return $this->belongsToMany(
            Category::class,
            'news_categories',
            'category_id',
            'news_id',
        );
    }
}
