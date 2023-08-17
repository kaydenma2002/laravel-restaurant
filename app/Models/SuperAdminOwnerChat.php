<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuperAdminOwnerChat extends Model
{
    use HasFactory;
    protected $fillable = ['super_admin_id','owner_id','message','type'];
    public function superAdmin()
    {
        return $this->belongsTo(User::class, 'super_admin_id', 'id');
    }

    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id', 'id');
    }
}
