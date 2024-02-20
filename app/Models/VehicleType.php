<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VehicleType extends Model
{
    protected $table        = 'vehicle_types';
    protected $primaryKey   = 'vtype_id';
    protected $fillable = [
        'name', 'created_at', 'updated_at',
    ];
}
