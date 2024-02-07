<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Reservation extends Model
{
    use SoftDeletes;

    protected $table        = 'reservations';
    protected $primaryKey   = 'r_id';
    protected $fillable = [
        'u_id', 'v_id', 'driver_name', 'purpose', 'destination', 'start_date', 'end_date', 'time',
        'remarks', 'others', 'requested_by', 'status', 'recommending', 'approval', 'status_by', 'recommending_by',
        'approval_by', 'is_active', 'is_read', 'is_printed', 'deleted_at', 'created_at', 'updated_at'
    ];

    public function passengers()
    {
        return $this->belongsToMany(User::class, 'passengers', 'r_id', 'u_id')->withPivot('tagged', 'approved', 'disapproved');
    }

    public function getReservationDatesAttribute($value)
    {
        return $this->start_date == $this->end_date ? $this->start_date->format('F j, Y') : ($this->start_date->format('F') == $this->end_date->format('F') ? $this->start_date->format('F j')."-".$this->end_date->format('j, Y') : $this->start_date->format('F j, Y')."-".$this->end_date->format('F j, Y'));
    }
}
