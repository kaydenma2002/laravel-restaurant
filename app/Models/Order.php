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
        'item_id'
    ];
    protected $casts = [
        'item_id' => 'array',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function items()
    {
        return $this->hasMany(Item::class);
    }
}
