<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $guarded=[];

    public function category(){
        return $this->belongsTo(Category::class);
    }

    public function carts()
    {
        return $this->belongsToMany(User::class, 'carts')
            ->using(Cart::class)
            ->withPivot(['quantity', 'price','id']);
    }

    public function orders()
    {
        return $this->belongsToMany(User::class, 'orders')
            ->using(Order::class)
            ->withPivot(['quantity', 'price','id','payment_status','delivery_status']);
    }
}
