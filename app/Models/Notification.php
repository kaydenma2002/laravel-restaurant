<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'type',
        'title',
        'body',
        'data',
        'add_data',
        'admin_read_at',
        'owner_read_at'
    ];
    public function users(){
        return $this->belongsTo(User::class);
    }
    
}
