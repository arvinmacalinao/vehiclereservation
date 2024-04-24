<?php

namespace App\Models;

use App\Models\Reservation;
use App\Models\VehicleType;
use App\Models\VehicleStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Vehicle extends Model
{
    use SoftDeletes;

    protected $table        = 'vehicles';
    protected $primaryKey   = 'v_id';
    protected $fillable = [
     'plate_number', 'equipment_name', 'status_id', 'type_id', 'remarks', 'deleted_at', 'created_at', 'updated_at'
    ];

    public function type()
    {
        return $this->belongsTo(VehicleType::class, 'type_id', 'vtype_id');
    }

    public function status()
    {
        return $this->belongsTo(VehicleStatus::class, 'status_id', 'id');
    }

    public function reservations()
    {
        return $this->belongsTo(Reservation::class, 'v_id', 'v_id');
    }
}
