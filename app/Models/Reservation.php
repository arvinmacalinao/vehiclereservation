<?php

namespace App\Models;

use App\Models\User;
use App\Models\Approval;
use App\Models\VehicleType;
use App\Models\ApprovalStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Reservation extends Model
{
    use SoftDeletes;

    protected $table        = 'reservations';
    protected $primaryKey   = 'r_id';
    protected $fillable = [
        'u_id', 'v_id', 'driver_name', 'purpose', 'destination', 'start_date', 'end_date', 'time', 'vtype_id',
        'remarks', 'others', 'requested_by', 'status', 'recommending', 'approval', 'status_by', 'recommending_by',
        'approval_by', 'is_active', 'is_read', 'is_printed', 'deleted_at', 'created_at', 'updated_at'
    ];

    public function passengers()
    {
        return $this->belongsToMany(User::class, 'passengers', 'r_id', 'u_id')->withPivot('tagged', 'approved', 'disapproved');
    }

    public function getReservationDatesAttribute($value)
    {
        $startDate = new \DateTime($this->start_date);
        $endDate = new \DateTime($this->end_date);
    
        return $startDate->format('F j, Y') == $endDate->format('F j, Y')
            ? $startDate->format('F j, Y')
            : ($startDate->format('F') == $endDate->format('F')
                ? $startDate->format('F j') . "-" . $endDate->format('j, Y')
                : $startDate->format('F j, Y') . " - " . $endDate->format('F j, Y'));
    }
    
    public function approval_status()
    {
        return $this->hasMany(ApprovalStatus::class, 'as_id', 'r_id');
    }

    public function approvals()
    {
        return $this->hasMany(Approval::class, 'r_id', 'r_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'u_id' , 'u_id');
    }

    public function type()
    {
        return $this->belongsTo(VehicleType::class, 'vtype_id', 'vtype_id');
    }
}
