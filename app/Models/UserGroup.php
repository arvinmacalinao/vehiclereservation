<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserGroup extends Model
{   
    protected $table = 'user_groups';
    protected $primaryKey = 'id';
    protected $fillable 	= ['u_id', 'g_id', 'created_at', 'updated_at'];
	protected $dates 		= ['created_at', 'updated_at', 'deleted_at'];

    public function user()
    {
        return $this->belongsTo(User::class, 'u_id');
    }
}
