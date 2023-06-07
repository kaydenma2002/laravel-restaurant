<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $fillable = [
        'restaurant_id',
        'user_id',
        'item_id',
        'quantity'
    ];
    public function item()
    {
        return $this->belongsTo(Item::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function restaurant(){
        return $this->belongsTo(Restaurant::class,'restaurant_id');
    }
}
