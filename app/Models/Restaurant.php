<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;



class Restaurant extends Model
{
    protected $guarded = ['id'];
    protected $fillable = [
        'id',
        'name',
        'phone',
        'status',
        'street',
        'address',
        'city',
        'zip_code',
        'password',
        'status',
        'web_id',
        'restaurant_id'
    ];
    protected $primaryKey = 'restaurant_id';
    use HasFactory;


    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function claims(){
        return $this->hasMany(Claim::class,'restaurant_id');
    }
    public function menu()
    {
        return $this->hasOne(Menu::class);
    }
    public function orders()
    {
        return $this->hasMany(Order::class,'restaurant_id');
    }
    public function carts()
    {
        return $this->hasMany(Cart::class);
    }
    public function cartBeForeLogin()
    {
        return $this->hasMany(CartBeforeLogin::class);
    }
    public function items()
    {
        return $this->hasMany(Item::class);
    }
    public static function updateWebIdForRestaurant()
    {
        $restaurants = self::all();
        if (!$restaurants) {
            return false;
        }
        foreach ($restaurants as $restaurant) {
            $restaurant->web_id = Str::replace(' ', '', preg_replace('/[^\p{L}\p{N}\s]/u', '', $restaurant->name)) . '-' . $restaurant->zip_code;
            $restaurant->save();
        }
        return "Hi";
    }
}
