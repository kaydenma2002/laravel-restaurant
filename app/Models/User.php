<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Restaurant;
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id',
        'name',
        'email',
        'phone',
        'status',
        'street',
        'city',
        'zip_code',
        'password',
        'status',
        'user_type'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    public function restaurants(){
        return $this->hasMany(Restaurant::class);
    }
    public function orders(){
        return $this->hasMany(Order::class);
    }
    public function carts()
    {
        return $this->hasMany(Cart::class);
    }
    public function claims(){
        return $this->hasMany(Claim::class);
    }
    public function password_reset(){
        return $this->hasOne(PasswordReset::class);
    }
    public function chats()
    {
        return $this->hasMany(Chat::class);
    }
    public function messages(){
        return $this->hasMany(PrivateChat::class);
    }
    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }
    
    
}
