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
        return $this->belongsToMany(Order::class);
    }
    public function category(){
        return $this->belongsTo(Category::class);
    }
    
    
}
