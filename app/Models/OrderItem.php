<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $table = 'order_items';
    protected $primaryKey = 'id';
    protected $fillable = ['restaurant_id', 'order_id','quantity','price','item_id'];
    public function order()
    {
        return $this->belongsTo(Order::class);
    }
    public function item(){
        return $this->belongsTo(Item::class);
    }
}
