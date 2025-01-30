<?php

namespace App\Models;

use App\Models\User;
use App\Models\Driver;
use App\Models\Vehicle;
use App\Models\Approval;
use App\Models\VehicleType;
use App\Models\ApprovalStatus;
use App\Models\ReservationStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Reservation extends Model
{
    use SoftDeletes;

    protected $table        = 'reservations';
    protected $primaryKey   = 'r_id';
    protected $fillable = [ 'u_id', 'v_id', 'driver_name', 'purpose', 'destination', 'start_date', 
    'end_date', 'time', 'start_time','end_time', 'vtype_id', 'remarks', 'passenger', 'requested_by', 'status_id', 
    'deleted_at', 'created_at', 'updated_at'
    ];

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

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class, 'v_id', 'v_id');
    }

    public function vehicle_type()
    {
        return $this->belongsTo(VehicleType::class, 'vtype_id', 'vtype_id');
    }

    public function status()
    {
        return $this->belongsTo(ReservationStatus::class, 'status_id', 'id' );
    }

    public function driver()
    {
        return $this->belongsTo(Driver::class, 'u_id' , 'u_id');
    }

    public function drivers()
    {
        return $this->belongsTo(Driver::class, 'driver_id' , 'u_id');
    }
}
