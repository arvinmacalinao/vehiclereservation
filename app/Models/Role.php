<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Role extends Model
{
    protected $table        = 'roles';
	protected $primaryKey   = 'role_id';
    protected $fillable 	= ['name', 'created_at', 'updated_at'];
	protected $dates 		= ['created_at', 'updated_at'];

	public function users()
	{
		return $this->hasMany(User::class, 'role_id', 'u_id')->where('u_enabled', '=', 1);
	}
}