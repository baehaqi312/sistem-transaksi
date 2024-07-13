<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NewsCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'news_id',
    ];

    public function category()
    {
        return $this->hasOne(Category::class);
    }

    public function news()
    {
        return $this->hasOne(News::class);
    }
}
