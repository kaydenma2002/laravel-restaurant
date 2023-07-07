<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Claim extends Model
{
    use HasFactory;
    protected $fillable = [
        'ss4',
        'food_license',
        'address',
        'city',
        'zip_code',
        'state',
        'phone',
        'email',
        'restaurant_id',
        'user_id',
        'name',
        
    ];
    public function user(){
        return $this->belongsTo(User::class);
    }
    public function restaurant(){
        return $this->belongsTo(Restaurant::class,'restaurant_id');
    }
}
