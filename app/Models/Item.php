<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;
    public function menu(){
        return $this->belongsTo(Menu::class);
    }
    public function orders(){
        return $this->hasMany(Order::class);
    }
    public function category(){
        return $this->belongsTo(Category::class);
    }
    public function cart()
    {
        return $this->belongsTo(Cart::class);
    }
    
}
