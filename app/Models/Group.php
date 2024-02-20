<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Group extends Model
{
    use SoftDeletes;

	protected $primaryKey = 'g_id';
    protected $fillable 	= ['name','alias', 'recommending', 'approval', 'deleted_at', 'created_at', 'updated_at'];
	protected $dates 		= ['created_at', 'updated_at', 'deleted_at'];

	public function users()
	{
		return $this->hasMany(User::class, 'g_id', 'u_id')->where('u_enabled', '=', 1);
	}

	// public function signatories()
	// {
	// 	return $this->hasMany('hrmis\Models\SignatoryGroup', 'group_id', 'id');
	// }

	// public function notification_signatory()
	// {
	// 	return $this->hasOne('hrmis\Models\SignatoryGroup', 'group_id', 'id')->whereHas('signatory', function($query) {
	// 		$query->where('module_id', '=', 2)->where('signatory', '=', 'Notification');
	// 	});
	// }

	// public function offset_notification_signatory()
	// {
	// 	return $this->hasOne('hrmis\Models\SignatoryGroup', 'group_id', 'id')->whereHas('signatory', function($query) {
	// 		$query->where('module_id', '=', 3)->where('signatory', '=', 'Notification');
	// 	});
	// }

	// public function scopeSearch($query, $search)
	// {
	// 	return $query->where(function($query) use($search) {
    //              $query->where('name', 'like', "%$search%");
    //          });
	// }

	// public function scopeEmployees($query, $search)
    // {
    //     return $query->where(function($query) use($search) {
    //              $query->whereHas('employees', function($employee) use($search) {
    //              	$employee->where('first_name', 'like', "%$search%")->orWhere('middle_name', 'like', "%$search%")->orWhere('last_name', 'like', "%$search%");
    //              });
    //          })->orWhere(function($query) use($search) {
    //          	$query->where('name', 'like', "%$search%");
    //          });
    // }
}
