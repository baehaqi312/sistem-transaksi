<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    use HasFactory, Uuid;

    public $incrementing = false;

    protected $keyType = 'uuid';

    protected $fillable = [
        'cart_id',
        'services_id',
        'quantity'
    ];

    public function product()
    {
        return $this->belongsTo(Service::class, 'services_id', 'id');
    }
}
