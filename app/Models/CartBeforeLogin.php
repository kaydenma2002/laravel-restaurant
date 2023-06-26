<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartBeforeLogin extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $fillable = [
        'restaurant_id',
        'cookie',
        'item_id',
        'quantity'
    ];
    public function item()
    {
        return $this->belongsTo(Item::class);
    }
    
    public function restaurant(){
        return $this->belongsTo(Restaurant::class,'restaurant_id');
    }
}

