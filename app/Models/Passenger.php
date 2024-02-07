<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Passenger extends Model
{
    use SoftDeletes;

    protected $table        = 'passengers';
    protected $primaryKey   = 'pass_id';
    protected $fillable = [
        'r_id', 'u_id', 'tagged', 'approved', 'disapproved', 'created_at', 'updated_at'
    ];
}
