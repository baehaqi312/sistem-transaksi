<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory, Uuid;

    public $incrementing = false;

    protected $keyType = 'uuid';

    protected $fillable = [
        'category_id',
        'name',
        'description',
        'price',
        // 'duration',
    ];

    public function subservices()
    {
        return $this->hasMany(SubService::class, 'service_id', 'id');
    }

    public function categoryservices()
    {
        return $this->belongsTo(CategoryService::class, 'category_id', 'id');
    }

    public function transactions()
    {
        return $this->belongsToMany(Transaction::class, 'client_id', 'service_id', 'id');
    }
}
