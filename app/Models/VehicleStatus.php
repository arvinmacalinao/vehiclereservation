<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VehicleStatus extends Model
{
    protected $table        = 'vehicle_status';
    protected $primaryKey   = 'id';
    protected $fillable = [
     'name', 'created_at', 'updated_at'
    ];
}
