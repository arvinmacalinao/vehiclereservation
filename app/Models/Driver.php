<?php

namespace App\Models;

use App\Models\User;
use App\Models\UserRole;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Driver extends User
{   
    protected $table = 'users';

    public function role()
    {
        return $this->hasOne(UserRole::class, 'u_id', 'u_id');
    }
}
