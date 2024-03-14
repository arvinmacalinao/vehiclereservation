<?php

namespace App\Models;

use App\Models\Approval;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserGroup extends Model
{   
    protected $table = 'user_groups';
    protected $primaryKey = 'id';
    protected $fillable 	= ['u_id', 'g_id', 'created_at', 'updated_at'];
	protected $dates 		= ['created_at', 'updated_at', 'deleted_at'];

    public function user()
    {
        return $this->belongsTo(User::class, 'u_id', 'u_id');
    }

    public function groups()
    {
        return $this->belongsTo(Group::class, 'g_id', 'g_id');
    }

    public function users()
    {
        return $this->hasMany(User::class, 'g_id', 'g_id');
    }
}
