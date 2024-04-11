<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReservationStatus extends Model
{
    protected $table        = 'reservation_status';
    protected $primaryKey   = 'id';
    protected $fillable = [
        'name', 'created_at', 'updated_at',
    ];
}
