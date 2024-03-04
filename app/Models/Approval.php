<?php

namespace App\Models;

use App\Models\Group;
use App\Models\UserGroup;
use App\Models\Reservation;
use App\Models\ApprovalStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Approval extends Model
{
    protected $table        = 'approvals';
    protected $primaryKey   = 'app_id';
    protected $fillable     =  [ 'u_id', 'r_id', 'status_id', 'remarks', 'created_at', 'updated_at' ];

    public function reservation()
    {
        return $this->belongsTo(Reservation::class, 'r_id', 'r_id');
    }

    public function status()
    {
        return $this->belongsTo(ApprovalStatus::class);
    }

    public function group()
    {
        return $this->belongsTo(Group::class, 'group_id');
    }

     public function user()
    {
        return $this->belongsTo(User::class, 'u_id' , 'u_id');
    }
}
