<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $fillable = [
        'first_name',
        'last_name',
        'phone',
        'street',
        'city',
        'zip_code',
        'email',
        'total',
        'company',
        'restaurant_id',
        'user_id',
        'note'
    ];
   
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
    public function restaurant(){
        return $this->belongsTo(Restaurant::class,'restaurant_id');
    }

}
