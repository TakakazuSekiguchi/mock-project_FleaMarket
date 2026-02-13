<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    use HasFactory;

    protected $fillable = [
        'item_id',
        'seller_id',
        'buyer_id',
        'payment_method',
        'postal_code',
        'address',
        'building'
    ];

    public function users(){
        return $this->hasMany(User::class);
    }

    public function item(){
        return $this->belongsTo(Item::class);
    }
}
