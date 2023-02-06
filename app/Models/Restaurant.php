<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;


class Restaurant extends Model
{
    use Searchable;
    use HasFactory;
    

    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }
    public function menu(){
        return $this->hasOne(Menu::class);
    }
}
