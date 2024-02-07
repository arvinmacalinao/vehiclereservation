<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Vehicle extends Model
{
    use SoftDeletes;

    protected $table        = 'vehicles';
    protected $primaryKey   = 'v_id';
    protected $fillable = [
        'plate_number', 'equipment_name', 'code_number', 'model_number', 'serial_number',
        'vehicle_type', 'remarks', 'deleted_at', 'created_at', 'updated_at',
    ];

}
