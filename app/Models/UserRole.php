<?php

namespace App\Models;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserRole extends Model
{
    protected $table = 'user_roles';
    protected $primaryKey = 'id';
    protected $fillable 	= ['u_id', 'role_id', 'created_at', 'updated_at'];
	protected $dates 		= ['created_at', 'updated_at'];

    public function user()
    {
        return $this->belongsTo(User::class, 'u_id');
    }
}
