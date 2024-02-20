<?php

namespace App\Models;

use App\Models\UserRole;
use App\Models\UserGroup;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    protected $table        = 'users';
    protected $primaryKey   = 'u_id';
    protected $fillable = [
         'username', 'password', 'first_name', 'middle_name', 'last_name', 'name_suffix',
         'designation', 'email', 'signature', 'picture', 'u_enabled', 'remember_token',
          'deleted_at', 'created_at', 'updated_at',
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


    public function getAuthIdentifier(){
		return $this->getKey();
	}

    function getAuthPassword() {
         return $this->attributes['password'];
    }

    function getPasswordAttribute() {
        return $this->attributes['password'];
    }

    function setPasswordAttribute($value) {
        $this->attributes['password'] = bcrypt($value);
    }

	// public function setUpasswordAttribute($value) {
	// 	$this->attributes['u_password'] = Hash::make($value);
	// }

	public function setFnameAttribute($value) {
		$this->attributes['first_name'] 	= ucwords($value);
	}

	public function setMnameAttribute($value) {
		$this->attributes['middle_name'] 	= ucwords($value);
	}

	public function setLnameAttribute($value) {
		$this->attributes['last_name'] 	= ucwords($value);
	}

	public function getFullNameAttribute($value) {		
		return ucfirst($this->first_name).' '.ucfirst(substr($this->middle_name, 0, 1)).'. '.ucfirst($this->last_name);
	}

    public function getOrderByLastNameAttribute($value)
    {
        return ucwords(strtolower($this->last_name)).' '.ucwords($this->first_name).'. '.ucwords(substr($this->middle_name, 0, 1));
    }

    public function groups()
    {
        return $this->belongsToMany(UserGroup::class, 'user_groups', 'u_id', 'g_id');
    }

    public function roles()
    {
        return $this->belongsToMany(UserRole::class, 'user_roles', 'u_id', 'role_id');
    }
}
