<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Demo extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'email',
        'company',
        'zip_code',
        'phone'
    ];
    public function user(){
        return $this->belongsTo(User::class);
    }
}
